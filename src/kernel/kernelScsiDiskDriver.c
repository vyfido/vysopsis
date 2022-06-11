//
//  Visopsys
//  Copyright (C) 1998-2014 J. Andrew McLaughlin
//
//  This program is free software; you can redistribute it and/or modify it
//  under the terms of the GNU General Public License as published by the Free
//  Software Foundation; either version 2 of the License, or (at your option)
//  any later version.
//
//  This program is distributed in the hope that it will be useful, but
//  WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
//  or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
//  for more details.
//
//  You should have received a copy of the GNU General Public License along
//  with this program; if not, write to the Free Software Foundation, Inc.,
//  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
//
//  kernelScsiDiskDriver.c
//

// Driver for standard and USB SCSI disks

#include "kernelScsiDiskDriver.h"
#include "kernelDebug.h"
#include "kernelDisk.h"
#include "kernelError.h"
#include "kernelFilesystem.h"
#include "kernelMalloc.h"
#include "kernelMisc.h"
#include "kernelProcessorX86.h"
#include "kernelRandom.h"
#include "kernelScsiDriver.h"
#include "kernelVariableList.h"
#include <stdio.h>
#include <string.h>

static kernelPhysicalDisk *disks[SCSI_MAX_DISKS];
static int numDisks = 0;


#ifdef DEBUG
static inline void debugInquiry(scsiInquiryData *inquiryData)
{
	char vendorId[9];
	char productId[17];
	char productRev[17];

	strncpy(vendorId, inquiryData->vendorId, 8);
	vendorId[8] = '\0';
	strncpy(productId, inquiryData->productId, 16);
	productId[16] = '\0';
	strncpy(productRev, inquiryData->productRev, 4);
	productRev[4] = '\0';

	kernelDebug(debug_scsi, "SCSI debug inquiry data:\n"
		"  qual/devType=%02x\n"
		"  removable=%02x\n"
		"  version=%02x\n"
		"  normACA/hiSup/format=%02x\n"
		"  addlLength=%02x\n"
		"  byte5Flags=%02x\n"
		"  byte6Flags=%02x\n"
		"  relAddr=%02x\n"
		"  vendorId=%s\n"
		"  productId=%s\n"
		"  productRev=%s", inquiryData->byte0.periQual,
		inquiryData->byte1.removable, inquiryData->byte2.ansiVersion,
		inquiryData->byte3.dataFormat, inquiryData->byte4.addlLength,
		inquiryData->byte5, inquiryData->byte6,
		inquiryData->byte7.relAdr, vendorId, productId, productRev);
}

static inline void debugSense(scsiSenseData *senseData)
{
	kernelDebug(debug_scsi, "SCSI debug sense data:\n"
		"  validErrCode=0x%02x\n"
		"  segment=%d\n"
		"  flagsKey=0x%02x\n"
		"  info=0x%08x\n"
		"  addlLength=%d\n"
		"  cmdSpecific=0x%08x\n"
		"  addlCode=0x%02x\n"
		"  addlCodeQual=0x%02x", senseData->validErrCode,
		senseData->segment, senseData->flagsKey, senseData->info,
		senseData->addlLength, senseData->cmdSpecific, senseData->addlCode,
		senseData->addlCodeQual);
}
#else
	#define debugInquiry(inquiryData) do { } while (0)
	#define debugSense(senseData) do { } while (0)
#endif // DEBUG


static int usbMassStorageReset(kernelScsiDisk *dsk)
{
	// Send the USB "mass storage reset" command to the first interface of
	// the device

	int status = 0;

	kernelDebug(debug_scsi, "USB MS reset");

	// Do the control transfer to send the reset command
	status = kernelUsbControlTransfer(dsk->usb.usbDev, USB_MASSSTORAGE_RESET,
		0, dsk->usb.usbDev->interDesc[0]->interNum, 0, NULL, NULL);
	if (status < 0)
		kernelDebug(debug_scsi, "USB MS reset failed");

	return (status);
}


static int usbClearHalt(kernelScsiDisk *dsk, unsigned char endpoint)
{
	int status = 0;

	kernelDebug(debug_scsi, "USB MS clear halt, endpoint %d", endpoint);

	// Do the control transfer to send the 'clear (halt) feature' to the
	// endpoint
	status = kernelUsbControlTransfer(dsk->usb.usbDev, USB_CLEAR_FEATURE,
		USB_FEATURE_ENDPOINTHALT, endpoint, 0, NULL, NULL);
	if (status < 0)
		kernelError(kernel_error, "USB MS clear halt failed");

	return (status);
}


static int usbMassStorageResetRecovery(kernelScsiDisk *dsk)
{
	// Send the USB "mass storage reset" command to the first interface of
	// the device, and clear any halt conditions on the bulk-in and bulk-out
	// endpoints.

	int status = 0;

	kernelDebug(debug_scsi, "USB MS reset recovery");

	status = usbMassStorageReset(dsk);
	if (status < 0)
		goto out;

	status = usbClearHalt(dsk, dsk->usb.bulkInEndpoint);
	if (status < 0)
		goto out;

	status = usbClearHalt(dsk, dsk->usb.bulkOutEndpoint);

out:
	if (status < 0)
		kernelError(kernel_error, "USB MS reset recovery failed");

	return (status);
}


static int usbScsiCommand(kernelScsiDisk *dsk, unsigned char lun,
	unsigned char *cmd, unsigned char cmdLength, void *data,
	unsigned dataLength, unsigned *bytes, int read)
{
	// Wrap a SCSI command in a USB command block wrapper and send it to
	// the device.

	int status = 0;
	usbCmdBlockWrapper cmdWrapper;
	usbCmdStatusWrapper statusWrapper;
	usbTransaction trans[3];
	usbTransaction *cmdTrans = NULL;
	usbTransaction *dataTrans = NULL;
	usbTransaction *statusTrans = NULL;
	int transCount = 0;

	kernelDebug(debug_scsi, "USB MS command 0x%02x datalength %d", cmd[0],
		dataLength);

	kernelMemClear(&cmdWrapper, sizeof(usbCmdBlockWrapper));
	kernelMemClear(&statusWrapper, sizeof(usbCmdStatusWrapper));
	kernelMemClear((void *) trans, (3 * sizeof(usbTransaction)));

	// Set up the command wrapper
	cmdWrapper.signature = USB_CMDBLOCKWRAPPER_SIG;
	cmdWrapper.tag = ++(dsk->usb.tag);
	cmdWrapper.dataLength = dataLength;
	cmdWrapper.flags = (read << 7);
	cmdWrapper.lun = lun;
	cmdWrapper.cmdLength = cmdLength;

	// Copy the command data into the wrapper
	kernelMemCopy(cmd, cmdWrapper.cmd, cmdLength);
	kernelDebug(debug_scsi, "USB MS command length %d", cmdWrapper.cmdLength);

	// Set up the USB transaction to send the command
	cmdTrans = &trans[transCount++];
	cmdTrans->type = usbxfer_bulk;
	cmdTrans->address = dsk->usb.usbDev->address;
	cmdTrans->endpoint = dsk->usb.bulkOutEndpoint;
	cmdTrans->pid = USB_PID_OUT;
	cmdTrans->length = sizeof(usbCmdBlockWrapper);
	cmdTrans->buffer = &cmdWrapper;

	if (dataLength)
	{
		if (bytes)
			*bytes = 0;

		// Set up the USB transaction to read or write the data
		dataTrans = &trans[transCount++];
		dataTrans->type = usbxfer_bulk;
		dataTrans->address = dsk->usb.usbDev->address;
		dataTrans->length = dataLength;
		dataTrans->buffer = data;

		if (read)
		{
			dataTrans->endpoint = dsk->usb.bulkInEndpoint;
			dataTrans->pid = USB_PID_IN;
		}
		else
		{
			dataTrans->endpoint = dsk->usb.bulkOutEndpoint;
			dataTrans->pid = USB_PID_OUT;
		}

		kernelDebug(debug_scsi, "USB MS datalength=%u", dataLength);
	}

	// Set up the USB transaction to read the status
	statusTrans = &trans[transCount++];
	statusTrans->type = usbxfer_bulk;
	statusTrans->address = dsk->usb.usbDev->address;
	statusTrans->endpoint = dsk->usb.bulkInEndpoint;
	statusTrans->pid = USB_PID_IN;
	statusTrans->length = sizeof(usbCmdStatusWrapper);
	statusTrans->buffer = &statusWrapper;
	kernelDebug(debug_scsi, "USB MS status length=%u", statusTrans->length);

	// Write the transactions
	status = kernelBusWrite(dsk->busTarget,
		(transCount * sizeof(usbTransaction)), (void *) &trans);
	if (status < 0)
	{
		kernelError(kernel_error, "USB MS transaction error %d", status);

		// Try to clear the stall
		if (usbClearHalt(dsk, dsk->usb.bulkInEndpoint) < 0)
			// Try a reset
			usbMassStorageResetRecovery(dsk);

		return (status);
	}

	if (dataLength)
	{
		if (!dataTrans->bytes)
		{
			kernelError(kernel_error, "USB MS data transaction - no data "
				"error");
			return (status = ERR_NODATA);
		}

		if (bytes)
			*bytes = (unsigned) dataTrans->bytes;
	}

	if ((statusWrapper.signature != USB_CMDSTATUSWRAPPER_SIG) ||
		(statusWrapper.tag != cmdWrapper.tag))
	{
		// We didn't get the status packet back
		kernelError(kernel_error, "USB MS invalid status packet returned");
		return (status = ERR_IO);
	}

	if (statusWrapper.status != USB_CMDSTATUS_GOOD)
	{
		kernelError(kernel_error, "USB MS command error status %02x",
			statusWrapper.status);
		return (status = ERR_IO);
	}
	else
	{
		kernelDebug(debug_scsi, "USB MS command successful");
		return (status = 0);
	}
}


static int scsiInquiry(kernelScsiDisk *dsk, unsigned char lun,
	scsiInquiryData *inquiryData)
{
	// Do a SCSI 'inquiry' command.

	int status = 0;
	scsiCmd6 cmd6;
	unsigned bytes = 0;

	kernelDebug(debug_scsi, "SCSI inquiry");

	kernelMemClear(&cmd6, sizeof(scsiCmd6));
	cmd6.byte[0] = SCSI_CMD_INQUIRY;
	cmd6.byte[1] = (lun << 5);
	cmd6.byte[4] = sizeof(scsiInquiryData);

	if (dsk->busTarget->bus->type == bus_usb)
	{
		// Set up the USB transaction, with the SCSI 'inquiry' command.
		status = usbScsiCommand(dsk, lun, (unsigned char *) &cmd6,
			sizeof(scsiCmd6), inquiryData, sizeof(scsiInquiryData), &bytes, 1);
		if ((status < 0) || (bytes < 36))
		{
			kernelError(kernel_error, "SCSI inquiry failed");
			return (status);
		}
	}
	else
	{
		kernelDebugError("Non-USB SCSI not supported");
		return (status = ERR_NOTIMPLEMENTED);
	}

	kernelDebug(debug_scsi, "SCSI inquiry successful");
	debugInquiry(inquiryData);
	return (status = 0);
}


static int scsiReadWrite(kernelScsiDisk *dsk, unsigned char lun,
	unsigned logicalSector, unsigned short numSectors, void *buffer, int read)
{
	// Do a SCSI 'read' or 'write' command

	int status = 0;
	unsigned dataLength = 0;
	scsiCmd10 cmd10;
	unsigned bytes = 0;

	dataLength = (numSectors * dsk->sectorSize);

	kernelDebug(debug_scsi, "SCSI %s %u bytes sectorsize %u",
		(read? "read" : "write"), dataLength, dsk->sectorSize);

	kernelMemClear(&cmd10, sizeof(scsiCmd10));
	if (read)
		cmd10.byte[0] = SCSI_CMD_READ10;
	else
		cmd10.byte[0] = SCSI_CMD_WRITE10;
	cmd10.byte[1] = (lun << 5);
	*((unsigned *) &cmd10.byte[2]) = kernelProcessorSwap32(logicalSector);
	*((unsigned short *) &cmd10.byte[7]) = kernelProcessorSwap16(numSectors);

	if (dsk->busTarget->bus->type == bus_usb)
	{
		// Set up the USB transaction, with the SCSI 'read' or 'write' command.
		status = usbScsiCommand(dsk, lun, (unsigned char *) &cmd10,
			sizeof(scsiCmd10), buffer, dataLength, &bytes, read);
		if ((status < 0) || (bytes < dataLength))
		{
			kernelError(kernel_error, "SCSI %s failed",
				(read? "read" : "write"));
			return (status);
		}
	}
	else
	{
		kernelDebugError("Non-USB SCSI not supported");
		return (status = ERR_NOTIMPLEMENTED);
	}

	kernelDebug(debug_scsi, "SCSI %s successful %u bytes",
		(read? "read" : "write"), bytes);
	return (status = 0);
}


static int scsiReadCapacity(kernelScsiDisk *dsk, unsigned char lun,
	scsiCapacityData *capacityData)
{
	// Do a SCSI 'read capacity' command.

	int status = 0;
	scsiCmd10 cmd10;
	unsigned bytes = 0;

	kernelDebug(debug_scsi, "SCSI read capacity");
	kernelMemClear(&cmd10, sizeof(scsiCmd10));
	cmd10.byte[0] = SCSI_CMD_READCAPACITY;
	cmd10.byte[1] = (lun << 5);

	if (dsk->busTarget->bus->type == bus_usb)
	{
		// Set up the USB transaction, with the SCSI 'read capacity' command.
		status = usbScsiCommand(dsk, lun, (unsigned char *) &cmd10,
			sizeof(scsiCmd10), capacityData, sizeof(scsiCapacityData),
			&bytes, 1);
		if ((status < 0) || (bytes < sizeof(scsiCapacityData)))
		{
			kernelError(kernel_error, "SCSI read capacity failed");
			return (status);
		}
	}
	else
	{
		kernelDebugError("Non-USB SCSI not supported");
		return (status = ERR_NOTIMPLEMENTED);
	}

	// Swap bytes around
	capacityData->blockNumber = kernelProcessorSwap32(capacityData->blockNumber);
	capacityData->blockLength = kernelProcessorSwap32(capacityData->blockLength);

	kernelDebug(debug_scsi, "SCSI read capacity successful");
	return (status = 0);
}


static int scsiRequestSense(kernelScsiDisk *dsk, unsigned char lun,
	scsiSenseData *senseData)
{
	// Do a SCSI 'request sense' command.

	int status = 0;
	scsiCmd6 cmd6;
	unsigned bytes = 0;

	kernelDebug(debug_scsi, "SCSI request sense");
	kernelMemClear(&cmd6, sizeof(scsiCmd6));
	cmd6.byte[0] = SCSI_CMD_REQUESTSENSE;
	cmd6.byte[1] = (lun << 5);
	cmd6.byte[4] = sizeof(scsiSenseData);

	if (dsk->busTarget->bus->type == bus_usb)
	{
		// Set up the USB transaction, with the SCSI 'request sense' command.
		status = usbScsiCommand(dsk, lun, (unsigned char *) &cmd6,
			sizeof(scsiCmd6), senseData, sizeof(scsiSenseData), &bytes, 1);
		if ((status < 0) || (bytes < sizeof(scsiSenseData)))
		{
			kernelError(kernel_error, "SCSI request sense failed");
			return (status);
		}
	}
	else
	{
		kernelDebugError("Non-USB SCSI not supported");
		return (status = ERR_NOTIMPLEMENTED);
	}

	// Swap bytes around
	senseData->info = kernelProcessorSwap32(senseData->info);
	senseData->cmdSpecific = kernelProcessorSwap32(senseData->cmdSpecific);

	kernelDebug(debug_scsi, "SCSI request sense successful");
	debugSense(senseData);
	return (status = 0);
}


static int scsiStartStopUnit(kernelScsiDisk *dsk, unsigned char lun,
	unsigned char start, unsigned char loadEject)
{
	// Do a SCSI 'start/stop unit' command.

	int status = 0;
	scsiCmd6 cmd6;

	kernelDebug(debug_scsi, "SCSI %s unit", (start? "start" : "stop"));
	kernelMemClear(&cmd6, sizeof(scsiCmd6));
	cmd6.byte[0] = SCSI_CMD_STARTSTOPUNIT;
	cmd6.byte[1] = (lun << 5);
	cmd6.byte[4] = (((loadEject & 0x01) << 1) | (start & 0x01));

	if (dsk->busTarget->bus->type == bus_usb)
	{
		// Set up the USB transaction, with the SCSI 'start/stop unit' command.
		status = usbScsiCommand(dsk, lun, (unsigned char *) &cmd6,
			sizeof(scsiCmd6), NULL,	0, NULL, 0);
		if (status < 0)
		{
			kernelError(kernel_error, "SCSI %s unit failed",
				(start? "start" : "stop"));
			return (status);
		}
	}
	else
	{
		kernelDebugError("Non-USB SCSI not supported");
		return (status = ERR_NOTIMPLEMENTED);
	}

	kernelDebug(debug_scsi, "SCSI %s unit successful",
		(start? "start" : "stop"));
	return (status = 0);
}


static int scsiTestUnitReady(kernelScsiDisk *dsk, unsigned char lun)
{
	// Do a SCSI 'test unit ready' command.

	int status = 0;
	scsiCmd6 cmd6;

	kernelDebug(debug_scsi, "SCSI test unit ready");
	kernelMemClear(&cmd6, sizeof(scsiCmd6));
	cmd6.byte[0] = SCSI_CMD_TESTUNITREADY;
	cmd6.byte[1] = (lun << 5);

	if (dsk->busTarget->bus->type == bus_usb)
	{
		// Set up the USB transaction, with the SCSI 'test unit ready' command.
		status = usbScsiCommand(dsk, lun, (unsigned char *) &cmd6,
			sizeof(scsiCmd6), NULL,	0, NULL, 0);
		if (status < 0)
		{
			kernelError(kernel_error, "SCSI test unit ready failed");
			return (status);
		}
	}
	else
	{
		kernelDebugError("Non-USB SCSI not supported");
		return (status = ERR_NOTIMPLEMENTED);
	}

	kernelDebug(debug_scsi, "SCSI test unit ready successful");
	return (status = 0);
}


static int getNewDiskNumber(void)
{
	// Return an unused disk number

	int diskNumber = 0;
	int count;

	for (count = 0; count < numDisks ; count ++)
	{
		if (disks[count]->deviceNumber == diskNumber)
		{
			diskNumber += 1;
			count = -1;
			continue;
		}
	}

	return (diskNumber);
}


static void guessDiskGeom(kernelPhysicalDisk *physicalDisk)
{
	// Given a disk with the number of sectors field set, try to figure out
	// some geometry values that make sense

	struct {
		unsigned heads;
		unsigned sectors;
	} guesses[] = {
		{ 255, 63 },
		{ 16, 63 },
		{ 255, 32 },
		{ 16, 32 },
		{ 0, 0 }
	};
	int count;

	// See if any of our guesses match up with the number of sectors.
	for (count = 0; guesses[count].heads; count ++)
	{
		if (!(physicalDisk->numSectors %
			(guesses[count].heads * guesses[count].sectors)))
		{
			physicalDisk->heads = guesses[count].heads;
			physicalDisk->sectorsPerCylinder = guesses[count].sectors;
			physicalDisk->cylinders =
				(physicalDisk->numSectors /
					(guesses[count].heads * guesses[count].sectors));
			goto out;
		}
	}

	// Nothing yet.  Instead, try to calculate something on the fly.
	physicalDisk->heads = 16;
	physicalDisk->sectorsPerCylinder = 32;
	while (physicalDisk->heads < 256)
	{
		if (!(physicalDisk->numSectors %
			(physicalDisk->heads * physicalDisk->sectorsPerCylinder)))
		{
			physicalDisk->cylinders =
				(physicalDisk->numSectors /
					(physicalDisk->heads * physicalDisk->sectorsPerCylinder));
			goto out;
		}

		physicalDisk->heads += 1;
	}

	kernelError(kernel_warn, "Unable to guess disk geometry");
	return;

out:
	kernelDebug(debug_scsi, "SCSI guess geom %u/%u/%u", physicalDisk->cylinders,
		physicalDisk->heads, physicalDisk->sectorsPerCylinder);
	return;
}


static kernelPhysicalDisk *detectTarget(void *parent, int busType,
	int targetId, void *driver)
{
	// Given a bus type and a bus target number, see if the device is a
	// SCSI disk

	int status = 0;
	kernelScsiDisk *dsk = NULL;
	kernelPhysicalDisk *physicalDisk = NULL;
	scsiSenseData senseData;
	scsiInquiryData inquiryData;
	scsiCapacityData capacityData;
	int count;

	kernelDebug(debug_scsi, "SCSI detect target 0x%08x", targetId);

	dsk = kernelMalloc(sizeof(kernelScsiDisk));
	if (dsk == NULL)
		goto err_out;

	dsk->busTarget = kernelBusGetTarget(busType, targetId);
	if (dsk->busTarget == NULL)
		goto err_out;

	physicalDisk = kernelMalloc(sizeof(kernelPhysicalDisk));
	if (physicalDisk == NULL)
		goto err_out;

	if (dsk->busTarget->bus->type == bus_usb)
	{
		// Try to get the USB device for the target
		dsk->usb.usbDev = kernelUsbGetDevice(targetId);
		if (dsk->usb.usbDev == NULL)
			goto err_out;

		// Record the bulk-in and bulk-out endpoints, and any interrupt endpoint
		kernelDebug(debug_scsi, "USB MS search for bulk endpoints");
		for (count = 1; count < dsk->usb.usbDev->numEndpoints; count ++)
		{
			switch (dsk->usb.usbDev->endpointDesc[count]->attributes &
				USB_ENDP_ATTR_MASK)
			{
				case USB_ENDP_ATTR_BULK:
				{
					if (!dsk->usb.bulkInDesc &&
						(dsk->usb.usbDev->endpointDesc[count]->endpntAddress &
							0x80))
					{
						dsk->usb.bulkInDesc =
							dsk->usb.usbDev->endpointDesc[count];
						dsk->usb.bulkInEndpoint =
							dsk->usb.bulkInDesc->endpntAddress;
						kernelDebug(debug_scsi, "USB MS bulk in endpoint %d",
							dsk->usb.bulkInEndpoint);
					}
					if (!dsk->usb.bulkOutDesc &&
						!(dsk->usb.usbDev->endpointDesc[count]->endpntAddress &
							0x80))
					{
						dsk->usb.bulkOutDesc =
							dsk->usb.usbDev->endpointDesc[count];
						dsk->usb.bulkOutEndpoint =
							dsk->usb.bulkOutDesc->endpntAddress;
						kernelDebug(debug_scsi, "USB MS bulk out endpoint %d",
							dsk->usb.bulkOutEndpoint);
					}
					break;
				}

				case USB_ENDP_ATTR_INTERRUPT:
				{
					kernelDebug(debug_scsi, "USB MS interrupt endpoint %d",
						dsk->usb.usbDev->endpointDesc[count]->endpntAddress);
					break;
				}
			}
		}

		kernelDebug(debug_scsi, "USB MS mass storage device detected");
		physicalDisk->type |= DISKTYPE_FLASHDISK;
	}
	else
	{
		kernelDebugError("Non-USB SCSI not supported");
		goto err_out;
	}

	// Send a 'request sense' command
	status = scsiRequestSense(dsk, 0, &senseData);
	if (status < 0)
		goto err_out;

	if ((senseData.flagsKey & 0x0F) != SCSI_SENSE_NOSENSE)
	{
		kernelError(kernel_error, "SCSI sense error - sense key=0x%02x "
			"asc=0x%02x ascq=0x%02x", (senseData.flagsKey & 0x0F),
			senseData.addlCode, senseData.addlCodeQual);
		status = ERR_IO;
		goto err_out;
	}

	// Send an 'inquiry' command
	status = scsiInquiry(dsk, 0, &inquiryData);
	if (status < 0)
		goto err_out;

	if (inquiryData.byte1.removable & 0x80)
		physicalDisk->type |= DISKTYPE_REMOVABLE;
	else
		physicalDisk->type |= DISKTYPE_FIXED;

	// Set up the vendor and product ID strings

	strncpy(dsk->vendorId, inquiryData.vendorId, 8);
	dsk->vendorId[8] = '\0';
	for (count = 7; count >= 0; count --)
	{
		if (dsk->vendorId[count] != ' ')
		{
			dsk->vendorId[count + 1] = '\0';
			break;
		}
		else if (count == 0)
			dsk->vendorId[0] = '\0';
	}

	strncpy(dsk->productId, inquiryData.productId, 16);
	dsk->productId[16] = '\0';
	for (count = 15; count >= 0; count --)
	{
		if (dsk->productId[count] != ' ')
		{
			dsk->productId[count + 1] = '\0';
			break;
		}
		else if (count == 0)
			dsk->productId[0] = '\0';
	}
	snprintf(dsk->vendorProductId, 26, "%s%s%s", dsk->vendorId,
		(dsk->vendorId[0]? " " : ""), dsk->productId);

	// Spin up the new target by sending 'start unit' command
	status = scsiStartStopUnit(dsk, 0, 1, 0);
	if (status < 0)
		goto err_out;

	// Send a 'test unit ready' command
	status = scsiTestUnitReady(dsk, 0);
	if (status < 0)
		goto err_out;

	// Send a 'read capacity' command
	status = scsiReadCapacity(dsk, 0, &capacityData);
	if (status < 0)
		goto err_out;

	dsk->numSectors = (capacityData.blockNumber + 1);
	dsk->sectorSize = capacityData.blockLength;

	if ((dsk->sectorSize <= 0) || (dsk->sectorSize > 4096))
	{
		kernelError(kernel_error, "Unsupported sector size %u",
			dsk->sectorSize);
		goto err_out;
	}

	kernelDebug(debug_scsi, "SCSI disk \"%s\" sectors %u sectorsize %u",
		dsk->vendorProductId, dsk->numSectors, dsk->sectorSize);

	physicalDisk->deviceNumber = getNewDiskNumber();
	kernelDebug(debug_scsi, "SCSI disk %d detected",
		physicalDisk->deviceNumber);
	physicalDisk->description = dsk->vendorProductId;
	physicalDisk->type |= (DISKTYPE_PHYSICAL | DISKTYPE_SCSIDISK);
	physicalDisk->flags = DISKFLAG_MOTORON;
	physicalDisk->numSectors = dsk->numSectors;
	guessDiskGeom(physicalDisk);
	physicalDisk->sectorSize = dsk->sectorSize;
	physicalDisk->driverData = (void *) dsk;
	physicalDisk->driver = driver;
	disks[numDisks++] = physicalDisk;

	if (dsk->busTarget->bus->type == bus_usb)
	{
		// Set up the kernelDevice
		dsk->usb.usbDev->dev.device.class =
			kernelDeviceGetClass(DEVICECLASS_DISK);
		dsk->usb.usbDev->dev.device.subClass =
			kernelDeviceGetClass(DEVICESUBCLASS_DISK_SCSI);
		kernelVariableListSet((variableList *)
			&dsk->usb.usbDev->dev.device.attrs,
			DEVICEATTRNAME_VENDOR, dsk->vendorId);
		kernelVariableListSet((variableList *)
			&dsk->usb.usbDev->dev.device.attrs,
			DEVICEATTRNAME_MODEL, dsk->productId);
		dsk->usb.usbDev->dev.driver = driver;
		dsk->usb.usbDev->dev.data = (void *) physicalDisk;

		// Tell USB that we're claiming this device.
		kernelBusDeviceClaim(dsk->busTarget, driver);

		// Register the disk
		status = kernelDiskRegisterDevice((kernelDevice *)
			&dsk->usb.usbDev->dev);
		if (status < 0)
			goto err_out;

		// Register the device
		status = kernelDeviceAdd(parent, (kernelDevice *)
			&dsk->usb.usbDev->dev);
		if (status < 0)
			goto err_out;
	}

	return (physicalDisk);

err_out:

	kernelError(kernel_error, "Error detecting %sSCSI disk",
		((dsk && dsk->busTarget && dsk->busTarget->bus &&
			dsk->busTarget->bus->type == bus_usb)? "USB " : ""));

	if (physicalDisk)
		kernelFree((void *) physicalDisk);

	if (dsk)
	{
		if (dsk->busTarget)
			kernelFree(dsk->busTarget);
		kernelFree(dsk);
	}

	return (physicalDisk = NULL);
}


static kernelPhysicalDisk *findBusTarget(kernelBusType busType, int target)
{
	// Try to find a disk in our list.

	kernelScsiDisk *dsk = NULL;
	int count;

	for (count = 0; count < numDisks; count ++)
	{
		if (disks[count] && disks[count]->driverData)
		{
			dsk = (kernelScsiDisk *) disks[count]->driverData;

			if (dsk->busTarget && dsk->busTarget->bus &&
				(dsk->busTarget->bus->type == busType) &&
				(dsk->busTarget->id == target))
			{
				return (disks[count]);
			}
		}
	}

	// Not found
	return (NULL);
}


static void removeDisk(kernelPhysicalDisk *physicalDisk)
{
	// Remove a disk from our list.

	int position = -1;
	int count;

	// Find its position
	for (count = 0; count < numDisks; count ++)
	{
		if (disks[count] == physicalDisk)
		{
			position = count;
			break;
		}
	}

	if (position >= 0)
	{
		if ((numDisks > 1) && (position < (numDisks - 1)))
		{
			for (count = position; count < (numDisks - 1); count ++)
				disks[count] = disks[count + 1];
		}

		numDisks -= 1;
	}
}


static kernelScsiDisk *findDiskByNumber(int driveNum)
{
	int count = 0;

	for (count = 0; count < numDisks; count ++)
	{
		if (disks[count]->deviceNumber == driveNum)
			return ((kernelScsiDisk *) disks[count]->driverData);
	}

	// Not found
	return (NULL);
}


static int readWriteSectors(int driveNum, uquad_t logicalSector,
	uquad_t numSectors, void *buffer, int read)
{
	// Read or write sectors.

	int status = 0;
	kernelScsiDisk *dsk = NULL;

	// Check params
	if (!buffer)
	{
		kernelError(kernel_error, "NULL parameter");
		return (status = ERR_NULLPARAMETER);
	}

	if (numSectors == 0)
		// Not an error we guess, but nothing to do
		return (status = 0);

	// Find the disk based on the disk number
	dsk = findDiskByNumber(driveNum);
	if (dsk == NULL)
	{
		kernelError(kernel_error, "No such disk, device number %d", driveNum);
		return (status = ERR_NOSUCHENTRY);
	}

	// Send a 'test unit ready' command
	status = scsiTestUnitReady(dsk, 0);
	if (status < 0)
		return (status);

	kernelDebug(debug_scsi, "SCSI %s %llu sectors on \"%s\" at %llu sectorsize "
		"%u", (read? "read" : "write"), numSectors, dsk->vendorProductId,
		logicalSector, dsk->sectorSize);

	status = scsiReadWrite(dsk, 0, logicalSector, numSectors, buffer, read);

	return (status);
}


static int driverReadSectors(int driveNum, uquad_t logicalSector,
	uquad_t numSectors, void *buffer)
{
	// This routine is a wrapper for the readWriteSectors routine.
	return (readWriteSectors(driveNum, logicalSector, numSectors, buffer,
		1));  // Read operation
}


static int driverWriteSectors(int driveNum, uquad_t logicalSector,
	uquad_t numSectors, const void *buffer)
{
	// This routine is a wrapper for the readWriteSectors routine.
	return (readWriteSectors(driveNum, logicalSector, numSectors,
		(void *) buffer, 0));  // Write operation
}


static int driverDetect(void *parent __attribute__((unused)),
	kernelDriver *driver)
{
	// Try to detect SCSI disks.

	int status = 0;
	kernelBusTarget *busTargets = NULL;
	int numBusTargets = 0;
	int deviceCount = 0;
	usbDevice usbDev;

	kernelDebug(debug_scsi, "SCSI search for devices");

	// Search the USB bus(es) for devices
	numBusTargets = kernelBusGetTargets(bus_usb, &busTargets);
	if (numBusTargets > 0)
	{
		// Search the bus targets for SCSI disk devices
		for (deviceCount = 0; deviceCount < numBusTargets; deviceCount ++)
		{
			// Try to get the USB information about the target
			status = kernelBusGetTargetInfo(&busTargets[deviceCount],
				(void *) &usbDev);
			if (status < 0)
				continue;

			// If the USB class is 0x08 and the subclass is 0x06 then we
			// believe we have a SCSI device
			if ((usbDev.classCode != 0x08) || (usbDev.subClassCode != 0x06) ||
				(usbDev.protocol != 0x50))
			{
				continue;
			}

			kernelDebug(debug_scsi, "SCSI found USB mass storage device");
			detectTarget(usbDev.controller->dev, bus_usb,
				busTargets[deviceCount].id, driver);
		}

		kernelFree(busTargets);
	}

	return (status = 0);
}


static int driverHotplug(void *parent, int busType, int target, int connected,
	kernelDriver *driver)
{
	// This routine is used to detect whether a newly-connected, hotplugged
	// device is supported by this driver during runtime, and if so to do the
	// appropriate device setup and registration.  Alternatively if the device
	// is disconnected a call to this function lets us know to stop trying
	// to communicate with it.

	int status = 0;
	kernelPhysicalDisk *physicalDisk = NULL;
	kernelScsiDisk *dsk = NULL;
	int count;

	kernelDebug(debug_scsi, "SCSI device hotplug %sconnection",
		(connected? "" : "dis"));

	if (connected)
	{
		// Determine whether any new SCSI disks have appeared on the USB bus
		physicalDisk = detectTarget(parent, busType, target, driver);
		if (physicalDisk != NULL)
			kernelDiskReadPartitions((char *) physicalDisk->name);
	}
	else
	{
		// Try to find the disk in our list
		physicalDisk = findBusTarget(busType, target);
		if (physicalDisk == NULL)
		{
			// This can happen if SCSI initialization did not complete
			// successfully.  In that case, it could be that we're still the
			// registered driver for the device, but we never added it to our
			// list.
			kernelDebugError("No such SCSI device 0x%08x", target);
			return (status = ERR_NOSUCHENTRY);
		}

		// Found it.
		kernelDebug(debug_scsi, "SCSI device removed");

		// If there are filesystems mounted on this disk, try to unmount them
		for (count = 0; count < physicalDisk->numLogical; count ++)
		{
			if (physicalDisk->logical[count].filesystem.mounted)
				kernelFilesystemUnmount((char *) physicalDisk->logical[count]
					.filesystem.mountPoint);
		}

		dsk = (kernelScsiDisk *) physicalDisk->driverData;

		if (dsk->busTarget->bus->type == bus_usb)
		{
			// Remove it from the system's disks
			kernelDiskRemoveDevice((kernelDevice *) &dsk->usb.usbDev->dev);

			// Remove it from the device tree
			kernelDeviceRemove((kernelDevice *) &dsk->usb.usbDev->dev);
		}

		// Delete.
		removeDisk(physicalDisk);
		if (dsk->busTarget)
			kernelFree(dsk->busTarget);
	}

	return (status = 0);
}


static kernelDiskOps scsiOps = {
	NULL,	// driverSetMotorState
	NULL,	// driverSetLockState
	NULL,	// driverSetDoorState
	NULL,	// driverMediaPresent
	NULL,	// driverMediaChanged
	driverReadSectors,
	driverWriteSectors,
	NULL	// driverFlush
};


/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
//
// Below here, the functions are exported for external use
//
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////


void kernelScsiDiskDriverRegister(kernelDriver *driver)
{
	// Device driver registration.

	driver->driverDetect = driverDetect;
	driver->driverHotplug = driverHotplug;
	driver->ops = &scsiOps;

	return;
}
