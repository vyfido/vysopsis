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
//  kernelPs2MouseDriver.c
//

// Driver for PS2 meeses.

#include "kernelDriver.h" // Contains my prototypes
#include "kernelCpu.h"
#include "kernelDebug.h"
#include "kernelError.h"
#include "kernelGraphic.h"
#include "kernelInterrupt.h"
#include "kernelMalloc.h"
#include "kernelMisc.h"
#include "kernelMouse.h"
#include "kernelPic.h"
#include "kernelProcessorX86.h"
#include <errno.h>
#include <string.h>

#define MOUSETIMEOUT 0xFFFFFFF

typedef enum {
	keyboard_input = 0x01,
	mouse_input = 0x21

} inputType;

static int enabled = 0;
static volatile int gotInterrupt = 0;
static int bytesPerPacket = 3;
static int packetByte = 0;
static unsigned char packet[4];
static unsigned char button1 = 0, button2 = 0, button3 = 0;


static inline int isData(inputType type)
{
	// Return 1 if there's data of the requested type waiting

	unsigned char status = 0;

	kernelProcessorInPort8(0x64, status);

	if ((status & 0x21) == type)
		return (1);
	else
		return (0);
}


static int inPort60(unsigned char *data, inputType type)
{
	// Input a value from the keyboard controller's data port, after checking
	// to make sure that there's some data of the correct type waiting for us
	// (port 0x60).

	unsigned char status = 0;
	unsigned count;

	// Wait until the controller says it's got data of the requested type
	for (count = 0; count < MOUSETIMEOUT; count ++)
	{
		if (isData(type))
		{
			kernelProcessorInPort8(0x60, *data);
			return (0);
		}
		else
			kernelProcessorDelay();
	}

	kernelProcessorInPort8(0x64, status);
	kernelError(kernel_error, "Timeout reading port 60, port 64=%02x", status);
	return (ERR_TIMEOUT);
}


static int waitControllerReady(void)
{
	// Wait for the controller to be ready

	unsigned char status = 0;
	unsigned count;

	for (count = 0; count < MOUSETIMEOUT; count ++)
	{
		kernelProcessorInPort8(0x64, status);

		if (!(status & 0x02))
			return (0);
	}

	kernelError(kernel_error, "Controller not ready timeout, port 64=%02x",
		status);
	return (ERR_TIMEOUT);
}


static int waitCommandReceived(void)
{
	unsigned char status = 0;
	unsigned count;

	for (count = 0; count < MOUSETIMEOUT; count ++)
	{
		kernelProcessorInPort8(0x64, status);

		if (status & 0x08)
			return (0);
	}

	kernelError(kernel_error, "Controller receive command timeout, port "
		"64=%02x", status);
	return (ERR_TIMEOUT);
}


static int outPort60(unsigned char data)
{
	// Output a value to the keyboard controller's data port, after checking
	// that it's able to receive data (port 0x60).

	int status = 0;

	status = waitControllerReady();
	if (status < 0)
		return (status);

	kernelProcessorOutPort8(0x60, data);

	return (status = 0);
}


static int outPort64(unsigned char data)
{
	// Output a value to the keyboard controller's command port, after checking
	// that it's able to receive data (port 0x64).

	int status = 0;

	status = waitControllerReady();
	if (status < 0)
		return (status);

	kernelProcessorOutPort8(0x64, data);

	// Wait until the controller believes it has received it.
	status = waitCommandReceived();
	if (status < 0)
		return (status);

	return (status = 0);
}


static void ackInterrupt(void)
{
	kernelDebug(debug_io, "Ps2Mouse: ack interrupt");
	gotInterrupt -= 1;
	kernelPicEndOfInterrupt(INTERRUPT_NUM_MOUSE);
}


static int readData(void)
{
	// Read a standard 3-byte PS/2 mouse packet.

	int status = 0;
	int xChange = 0, yChange = 0, zChange = 0;

	// Disable keyboard output here, because our data reads are not atomic
	status = outPort64(0xAD);
	if (status < 0)
		goto out;

	while (isData(mouse_input))
	{
		status = inPort60(&packet[packetByte], mouse_input);
		if (status < 0)
			goto out;

		kernelDebug(debug_io, "Ps2Mouse: Read byte %02x", packet[packetByte]);

		// Byte 1, bit 3 is always supposed to be on.  Wait until that's true.
		if ((packetByte == 0) && (!(packet[0] & 0x08) || (packet[0] >= 0x40)))
		{
			kernelDebug(debug_io, "Ps2Mouse: Out-of-sync byte %02x",
				packet[0]);
			continue;
		}

		packetByte += 1;

		if (packetByte >= bytesPerPacket)
		{
			kernelDebug(debug_io, "Ps2Mouse: Got packet %02x/%02x/%02x/%02x: ",
				packet[0], packet[1], packet[2], packet[3]);

			if ((packet[0] & 0x01) != button1)
			{
				button1 = (packet[0] & 0x01);
				kernelDebug(debug_io, "Ps2Mouse: Button1");
				kernelMouseButtonChange(1, button1);
			}

			if ((packet[0] & 0x04) != button2)
			{
				button2 = (packet[0] & 0x04);
				kernelDebug(debug_io, "Ps2Mouse: Button2");
				kernelMouseButtonChange(2, button2);
			}

			if ((packet[0] & 0x02) != button3)
			{
				button3 = (packet[0] & 0x02);
				kernelDebug(debug_io, "Ps2Mouse: Button3");
				kernelMouseButtonChange(3, button3);
			}

			if (packet[1] || packet[2])
			{
				// Sign them
				if (packet[0] & 0x10)
					xChange = (int) ((256 - packet[1]) * -1);
				else
					xChange = (int) packet[1];

				if (packet[0] & 0x20)
					yChange = (int) (256 - packet[2]);
				else
					yChange = (int) (packet[2] * -1);

				kernelDebug(debug_io, "Ps2Mouse: Move (%d,%d)", xChange,
					yChange);
				kernelMouseMove(xChange, yChange);
			}

			if (packet[3])
			{
				zChange = (char) packet[3];
				kernelDebug(debug_io, "Ps2Mouse: Scroll (%d)", zChange);
				kernelMouseScroll(zChange);
			}

			packetByte = 0;
		}
	}

	status = 0;

out:
	ackInterrupt();

	// Re-enable keyboard output
	outPort64(0xAE);

	return (status);
}


static void mouseInterrupt(void)
{
	// This is the mouse interrupt handler.  It calls the mouse driver
	// to actually read data from the device.

	void *address = NULL;

	kernelProcessorIsrEnter(address);
	kernelInterruptSetCurrent(INTERRUPT_NUM_MOUSE);

	gotInterrupt += 1;
	kernelDebug(debug_io, "Ps2Mouse: Mouse interrupt");

	if (enabled)
		// Call the routine to read the data
		readData();

	kernelInterruptClearCurrent();
	kernelProcessorIsrExit(address);
}


static int command(unsigned char cmd, int numParams, unsigned char *inParams,
	unsigned char *outParams)
{
	// Send a mouse command to the keyboard controller

	int status = 0;
	unsigned char data = 0;
	int count;

	kernelDebug(debug_io, "Ps2Mouse: Mouse command %02x... ", cmd);

	// Mouse command...
	kernelDebug(debug_io, "Ps2Mouse: MC");
	status = outPort64(0xD4);
	if (status < 0)
	{
		kernelError(kernel_error, "Error writing command");
		goto out;
	}

	while (1)
	{
		// Send command
		kernelDebug(debug_io, "Ps2Mouse: cmd");
		status = outPort60(cmd);
		if (status < 0)
		{
			kernelError(kernel_error, "Error writing command");
			goto out;
		}

		// Read the ack 0xFA
		status = inPort60(&data, mouse_input);
		if (status < 0)
		{
			kernelError(kernel_error, "Error reading ack");
			goto out;
		}

		if (data == 0xFA)
		{
			kernelDebug(debug_io, "Ps2Mouse: ack");
			break;
		}
		else if ((data == 0xFE) && (cmd == 0xFF))
		{
			// Don't resend if we were doing a reset.  I think this is an
			// indication that there's no mouse.
			kernelDebugError("Ps2Mouse: not resending reset");
			status = ERR_IO;
			goto out;
		}
		else if (data == 0xFE)
		{
			// Resend
			kernelDebug(debug_io, "Ps2Mouse: resend");
			continue;
		}
		else
		{
			kernelDebugError("Ps2Mouse: No command ack, response=%02x", data);
			status = ERR_IO;
			goto out;
		}
	}

	// If this is a reset command, wait a little bit for the operation to
	// complete
	if (cmd == 0xFF)
		kernelCpuSpinMs(250);

	// Now, if there are parameters to this command...
	for (count = 0; count < numParams; count ++)
	{
		if (inParams)
		{
			status = inPort60(&data, mouse_input);
			if (status < 0)
			{
				kernelError(kernel_error, "Error reading command parameter %d",
					count);
				goto out;
			}

			inParams[count] = data;
			kernelDebug(debug_io, "Ps2Mouse: in p%d=%02x (%d)", count, data,
				data);
		}

		else if (outParams)
		{
			// Mouse command...
			status = outPort64(0xD4);
			if (status < 0)
			{
				kernelError(kernel_error, "Error writing command");
				goto out;
			}
			kernelDebug(debug_io, "Ps2Mouse: MC");

			while (1)
			{
				status = outPort60(outParams[count]);
				if (status < 0)
				{
					kernelError(kernel_error, "Error writing parameter %d",
						count);
					goto out;
				}
				kernelDebug(debug_io, "Ps2Mouse: out p%d=%02x (%d)", count,
					outParams[count], outParams[count]);

				// Read the ack 0xFA
				status = inPort60(&data, mouse_input);
				if (status < 0)
				{
					kernelError(kernel_error, "Error reading ack");
					goto out;
				}

				if (data == 0xFA)
				{
					kernelDebug(debug_io, "Ps2Mouse: ack, ");
					break;
				}
				else if (data == 0xFE)
				{
					// Resend
					kernelDebug(debug_io, "Ps2Mouse: resend, ");
					continue;
				}
				else
				{
					kernelDebugError("Ps2Mouse: No ack, response=%02x", data);
					status = ERR_IO;
					goto out;
				}
			}
		}
	}

	kernelDebug(debug_io, "Ps2Mouse: done");
	status = 0;

out:
	return (status);
}


static int detect(void)
{
	int status = ERR_IO;
	unsigned char data[2];

	kernelDebug(debug_io, "Ps2Mouse: Mouse detection");

	// Mask off keyboard interrupts
	kernelPicMask(INTERRUPT_NUM_KEYBOARD, 0);

	do {
		// Send the reset command
		if (command(0xFF, 2, data, NULL) < 0)
			break;

		// Should be 'self test passed' 0xAA and device ID 0 for normal
		// PS/2 mouse
		if ((data[0] != 0xAA) || (data[1] != 0))
			break;

		// Read device type.
		if (command(0xF2, 1, data, NULL) < 0)
			break;

		// Should be type 0.
		if (data[0] != 0)
			break;

		status = 0;

	} while (0);

	// Restore keyboard interrupts
	kernelPicMask(INTERRUPT_NUM_KEYBOARD, 1);

	return (status);
}


static int initialize(void)
{
	int status = ERR_IO;
	unsigned char data[2];

	kernelDebug(debug_io, "Ps2Mouse: Mouse intialize");

	kernelMemClear(packet, sizeof(packet));

	// Mask off keyboard interrupts
	kernelPicMask(INTERRUPT_NUM_KEYBOARD, 0);

	do {
		// Set defaults.  Sample rate 100, Scaling 1:1, resolution 4 counts/mm,
		// disable data reporting.
		if (command(0xF6, 0, NULL, NULL) < 0)
			break;

		// Set stream mode.
		if (command(0xEA, 0, NULL, NULL) < 0)
			break;

		// Set scaling to 2:1
		if (command(0xE7, 0, NULL, NULL) < 0)
			break;

		// Set resolution 200 dpi, 8 counts/mm
		data[0] = 3;
		if (command(0xE8, 1, NULL, data) < 0)
			break;

		// Try to determine whether this is a scroll-wheel mouse.  It involves
		// doing a little magic sequence of setting different sample rates and
		// then asking for the device type again
		do {
			data[0] = 200;
			if (command(0xF3, 1, NULL, data) < 0)
				break;

			data[0] = 100;
			if (command(0xF3, 1, NULL, data) < 0)
				break;

			data[0] = 80;
			if (command(0xF3, 1, NULL, data) < 0)
				break;

			if (command(0xF2, 1, data, NULL) < 0)
				break;

			// Should be type 3 now.
			if (data[0] == 3)
			{
				bytesPerPacket = 4;
				kernelDebug(debug_io, "Ps2Mouse: scroll-wheel mouse");
			}

		} while (0);

		// Enable data reporting.
		if (command(0xF4, 0, NULL, NULL) < 0)
			break;

		status = 0;

	} while (0);

	// Restore keyboard interrupts
	kernelPicMask(INTERRUPT_NUM_KEYBOARD, 1);

	return (status);
}


static int driverDetect(void *parent, kernelDriver *driver)
{
	// This routine is used to detect and initialize each device, as well as
	// registering each one with any higher-level interfaces.  Also talks to
	// the keyboard controller a little bit to initialize the mouse

	int status = 0;
	int interrupts = 0;
	unsigned char data = 0;
	kernelDevice *dev = NULL;

	// Disable keyboard output here, because our data reads are not atomic
	status = outPort64(0xAD);
	if (status < 0)
		goto exit;

	kernelProcessorSuspendInts(interrupts);

	// Make sure the controller is set to issue mouse interrupts and make sure
	// the 'disable mouse' bit is clear
	outPort64(0x20);
	inPort60(&data, keyboard_input);

	if ((data & 0x20) || !(data & 0x02))
	{
		kernelDebug(debug_io, "Ps2Mouse: Turn on mouse interrupts...");
		data &= ~0x20;
		data |= 0x02;
		outPort64(0x60);
		outPort60(data);
	}

	// Clear any pending interrupts
	kernelPicEndOfInterrupt(INTERRUPT_NUM_MOUSE);

	kernelProcessorRestoreInts(interrupts);

	// Don't save any old handler for the dedicated mouse interrupt, but if
	// there is one, we want to know about it.
	if (kernelInterruptGetHandler(INTERRUPT_NUM_MOUSE))
		kernelError(kernel_warn, "Not chaining unexpected existing handler "
			"for mouse int %d", INTERRUPT_NUM_MOUSE);

	// Register our interrupt handler
	kernelDebug(debug_io, "Ps2Mouse: Hook interrupt...");
	status = kernelInterruptHook(INTERRUPT_NUM_MOUSE, &mouseInterrupt);
	if (status < 0)
		goto exit;

	// See whether we've got a mouse response to our queries
	status = detect();
	if (status < 0)
	{
		// Perhaps there is no PS/2 mouse
		status = 0;
		goto exit;
	}

	// Allocate memory for the device
	dev = kernelMalloc(sizeof(kernelDevice));
	if (!dev)
	{
		status = ERR_MEMORY;
		goto exit;
	}

	dev->device.class = kernelDeviceGetClass(DEVICECLASS_MOUSE);
	dev->device.subClass = kernelDeviceGetClass(DEVICESUBCLASS_MOUSE_PS2);
	dev->driver = driver;

	// Add the device
	kernelDebug(debug_io, "Ps2Mouse: Add device...");
	status = kernelDeviceAdd(parent, dev);
	if (status < 0)
		goto exit;

	if (kernelGraphicsAreEnabled())
	{
		// Do the hardware initialization.
		status = initialize();
		if (status < 0)
		{
			// Perhaps there is no PS/2 mouse
			status = 0;
			goto exit;
		}

		enabled = 1;

		// Turn on the interrupt
		kernelDebug(debug_io, "Ps2Mouse: Turn on interrupt...");
		kernelPicMask(INTERRUPT_NUM_MOUSE, 1);
	}

	kernelDebug(debug_io, "Ps2Mouse: Successfully detected mouse");
	status = 0;

exit:
	// Re-enable keyboard output
	outPort64(0xAE);

	if (status < 0)
	{
		kernelDebug(debug_io, "Ps2Mouse: Error %d detecting mouse", status);

		if (dev)
		{
			kernelDeviceRemove(dev);
			kernelFree(dev);
		}
	}

	return (status);
}


/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
//
// Below here, the functions are exported for external use
//
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////


void kernelPs2MouseDriverRegister(kernelDriver *driver)
{
	 // Device driver registration.

	driver->driverDetect = driverDetect;

	return;
}

