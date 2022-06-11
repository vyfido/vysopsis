//
//  Visopsys
//  Copyright (C) 1998-2004 J. Andrew McLaughlin
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
//  59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
//
//  kernelDisk.c
//
	
// This file functions for disk access, and routines for managing the array
// of disks in the kernel's data structure for such things.  

#include "kernelDisk.h"
#include "kernelParameters.h"
#include "kernelFilesystem.h"
#include "kernelMalloc.h"
#include "kernelPageManager.h"
#include "kernelMultitasker.h"
#include "kernelLock.h"
#include "kernelMiscFunctions.h"
#include "kernelSysTimer.h"
#include "kernelLog.h"
#include "kernelError.h"
#include <sys/errors.h>
#include <stdio.h>
#include <string.h>

// All the disks
static kernelPhysicalDisk *physicalDisks[DISK_MAXDEVICES];
static volatile int physicalDiskCounter = 0;
static kernelDisk *logicalDisks[DISK_MAXDEVICES];
static volatile int logicalDiskCounter = 0;

// The name of the disk we booted from
static char bootDisk[DISK_MAX_NAMELENGTH];

// Modes for the readWriteSectors routine
#define IOMODE_READ     0x01
#define IOMODE_WRITE    0x02
#define IOMODE_NOCACHE  0x04

// For the disk daemon
static int diskdPID = 0;

// This is a table for keeping known partition type codes and descriptions
static partitionType partitionTypes[] = {
  { 0x01, "FAT12"},
  { 0x02, "XENIX root"},
  { 0x03, "XENIX /usr"},
  { 0x04, "FAT16 (small)"},
  { 0x05, "Extended"},
  { 0x06, "FAT16"},
  { 0x07, "HPFS or NTFS"},
  { 0x08, "OS/2 or AIX boot"},
  { 0x09, "AIX data"},
  { 0x0A, "OS/2 Boot Manager"},
  { 0x0B, "FAT32"},
  { 0x0C, "FAT32 (LBA)"},
  { 0x0E, "FAT16 (LBA)"},
  { 0x0F, "Extended (LBA)"},
  { 0x11, "Hidden FAT12"},
  { 0x12, "FAT diagnostic"},
  { 0x14, "Hidden FAT16 (small)"},
  { 0x16, "Hidden FAT16"},
  { 0x17, "Hidden HPFS or NTFS"},
  { 0x1B, "Hidden FAT32"},
  { 0x1C, "Hidden FAT32 (LBA)"},
  { 0x1E, "Hidden FAT16 (LBA)"},
  { 0x35, "JFS" },
  { 0x39, "Plan 9" },
  { 0x3C, "PartitionMagic" },
  { 0x3D, "Hidden Netware" },
  { 0x4D, "QNX4.x" },
  { 0x4D, "QNX4.x 2nd" },
  { 0x4D, "QNX4.x 3rd" },
  { 0x52, "CP/M" },
  { 0x63, "GNU HURD"},
  { 0x64, "Netware 2"},
  { 0x65, "Netware 3/4"},
  { 0x80, "Minix"},
  { 0x81, "Linux or Minix"},
  { 0x82, "Linux swap or Solaris"},
  { 0x83, "Linux"},
  { 0x84, "Hibernation"},
  { 0x85, "Linux extended"},
  { 0x86, "HPFS or NTFS mirrored"},
  { 0x87, "HPFS or NTFS mirrored"},
  { 0x8E, "Linux LVM"},
  { 0x93, "Hidden Linux"},
  { 0x9F, "BSD/OS"},
  { 0xA0, "Hibernation"},
  { 0xA1, "Hibernation"},
  { 0xA5, "BSD, NetBSD, FreeBSD"},
  { 0xA6, "OpenBSD"},
  { 0xA7, "NeXTSTEP"},
  { 0xA8, "Darwin UFS"},
  { 0xA9, "NetBSD"},
  { 0xAB, "OS-X boot"},
  { 0xB7, "BSDI"},
  { 0xB8, "BSDI swap"},
  { 0xBE, "Solaris boot"},
  { 0xC1, "DR-DOS FAT12"},
  { 0xC4, "DR-DOS FAT16 (small)"},
  { 0xC5, "DR-DOS Extended"},
  { 0xC6, "DR-DOS FAT16"},
  { 0xC7, "HPFS mirrored"},
  { 0xCB, "DR-DOS FAT32"},
  { 0xCC, "DR-DOS FAT32 (LBA)"},
  { 0xCE, "DR-DOS FAT16 (LBA)"},
  { 0xEB, "BeOS BFS"},
  { 0xF2, "DOS 3.3+ second"},
  { 0xFA, "Bochs"},
  { 0xFB, "VmWare"},
  { 0xFC, "VmWare swap"},
  { 0xFD, "Linux RAID"},
  { 0xFE, "NT hidden or Veritas VM"},
  { 0xFF, "Veritas VM"},
  { 0, "" }
};

static int initialized = 0;

// Circular dependency here
static int readWriteSectors(kernelPhysicalDisk *, unsigned, unsigned, void *,
			    int);


#if (DISK_CACHE)
static int getDiskCache(kernelPhysicalDisk *theDisk)
{
  // This routine is called when a physical disk structure is first used
  // by the read/write function.  It initializes the cache memory and
  // control structures..

  int status = 0;
  int count;

  if (!theDisk->cache.initialized)
    {
      // Get some memory for our array of disk cache sector metadata
      theDisk->cache.numSectors = (DISK_MAX_CACHE / theDisk->sectorSize);
  
      theDisk->cache.sectors = kernelMalloc(theDisk->cache.numSectors *
					    sizeof(kernelDiskCacheSector *));
      theDisk->cache.sectorMemory =
	kernelMalloc(theDisk->cache.numSectors *
		     sizeof(kernelDiskCacheSector));
      theDisk->cache.dataMemory = kernelMalloc(DISK_MAX_CACHE);
  
      if ((theDisk->cache.sectors == NULL) ||
	  (theDisk->cache.sectorMemory == NULL) ||
	  (theDisk->cache.dataMemory == NULL))
	{
	  kernelError(kernel_error, "Unable to get disk cache memory");
	  return (status = ERR_MEMORY);
	}

      // Initialize the cache structures
      for (count = 0; count < theDisk->cache.numSectors; count ++)
	{
	  // The pointers to the sector structures
	  theDisk->cache.sectors[count] =
	    &(theDisk->cache.sectorMemory[count]);

	  theDisk->cache.sectors[count]->number = -1;
	  theDisk->cache.sectors[count]->dirty = 0;
	  
	  // The data memory pointers in the sector structures
	  theDisk->cache.sectors[count]->data =
	    (theDisk->cache.dataMemory + (count * theDisk->sectorSize));
	}

      theDisk->cache.initialized = 1;
    }

  // Return success
  return (status = 0);
}


static inline int findCachedSector(kernelPhysicalDisk *theDisk,
				   unsigned sectorNum)
{
  // Just loops through the cache and returns the index of a cached
  // sector, if found
  
  int status = 0;
  int count;

  status = kernelLockGet(&(theDisk->cache.cacheLock));
  if (status < 0)
    return (status);

  for (count = 0; (count < theDisk->cache.usedSectors); count ++)
    if (theDisk->cache.sectors[count]->number == sectorNum)
      {
	kernelLockRelease(&(theDisk->cache.cacheLock));
	return (count);
      }
  kernelLockRelease(&(theDisk->cache.cacheLock));
  return (status = ERR_NOSUCHENTRY);
}


static int countUncachedSectors(kernelPhysicalDisk *theDisk,
				unsigned startSector, int sectorCount)
{
  // This function returns the number of consecutive uncached clusters
  // starting in the range supplied.  For example, if none of the sectors
  // are cached, the return value will be sectorCount.  Conversely, if
  // the first sector is cached, it will return 0.
  
  int status = 0;
  int index;

  status = kernelLockGet(&(theDisk->cache.cacheLock));
  if (status < 0)
    return (status);

  // Loop through the cache until we find a sector number that is >=
  // startSector
  for (index = 0; index < theDisk->cache.usedSectors; index++)
    if (theDisk->cache.sectors[index]->number >= startSector)
      {
	kernelLockRelease(&(theDisk->cache.cacheLock));

	// The sector number of this sector determines the value we return.
	if ((theDisk->cache.sectors[index]->number - startSector) >
	    sectorCount)
	  return (sectorCount);
	else
	  return (theDisk->cache.sectors[index]->number - startSector);
      }

  // There were no sectors with a >= number.  Return sectorCount.
  kernelLockRelease(&(theDisk->cache.cacheLock));
  return (sectorCount);
}


static int writeConsecutiveDirty(kernelPhysicalDisk *physicalDisk,
				 unsigned start)
{
  // Starting at 'start', write any consecutive dirty cache sectors and
  // return the number written.  NB: A lock on the cache must already be
  // held

  int status = 0;
  int consecutive = 0;
  void *data = NULL;
  int count;

  // Get a count of the consecutive dirty sectors
  for (count = start; count < physicalDisk->cache.usedSectors; count ++)
    {
      if (!(physicalDisk->cache.sectors[count]->dirty))
	break;

      consecutive += 1;
      
      if ((count == (physicalDisk->cache.usedSectors - 1)) ||
	  (physicalDisk->cache.sectors[count + 1]->number !=
	   (physicalDisk->cache.sectors[count]->number + 1)))
	break;
    }

  if (consecutive)
    {
      // Get a buffer to hold all the data
      data = kernelMalloc(consecutive * physicalDisk->sectorSize);
      if (data == NULL)
	return (status = ERR_MEMORY);

      // Copy the sectors' data into our buffer
      for (count = 0; count < consecutive; count ++)
	kernelMemCopy(physicalDisk->cache.sectors[start + count]->data,
		      (data + (count * physicalDisk->sectorSize)),
		      physicalDisk->sectorSize);

      // Write the data
      status = readWriteSectors(physicalDisk, physicalDisk->cache
				.sectors[start]->number, consecutive, data,
				(IOMODE_WRITE | IOMODE_NOCACHE));
      // Free the memory
      kernelFree(data);

      if (status < 0)
	return (status);

      // Mark the sectors as clean
      for (count = start; count < (start + consecutive); count ++)
	physicalDisk->cache.sectors[count]->dirty = 0;
    }

  return (consecutive);
}


static int cacheSync(kernelPhysicalDisk *theDisk)
{
  // Write all dirty cached sectors to the disk

  int status = 0;
  int errors = 0;
  int count;

  if (!(theDisk->cache.dirty) || theDisk->readOnly)
    return (0);

  status = kernelLockGet(&(theDisk->cache.cacheLock));
  if (status < 0)
    return (status);

  for (count = 0; count < theDisk->cache.usedSectors; count ++)
    // If the disk sector is dirty, write it and any consecutive ones
    // after it that are dirty
    if (theDisk->cache.sectors[count]->dirty)
      {
	status = writeConsecutiveDirty(theDisk, count);
	if (status < 0)
	  errors = status;
	else
	  count += (status - 1);
      }

  // Reset the dirty flag for the whole cache
  if (!errors)
    theDisk->cache.dirty = 0;

  kernelLockRelease(&(theDisk->cache.cacheLock));
  return (errors);
}


static int cacheInvalidate(kernelPhysicalDisk *theDisk)
{
  // Evacuate the disk cache

  int status = 0;
  int count;

  status = kernelLockGet(&(theDisk->cache.cacheLock));
  if (status < 0)
    return (status);

  for (count = 0; count < theDisk->cache.usedSectors; count ++)
    {
      theDisk->cache.sectors[count]->number = -1;
      theDisk->cache.sectors[count]->dirty = 0;
    }

  theDisk->cache.usedSectors = 0;
  theDisk->cache.dirty = 0;

  kernelLockRelease(&(theDisk->cache.cacheLock));
  return (status);
}


static int uncacheSectors(kernelPhysicalDisk *theDisk, unsigned sectorCount)
{
  // Removes the least recently used sectors from the cache
  
  int status = 0;
  int errors = 0;
  kernelDiskCacheSector *tmpSector = NULL;
  int count1, count2;

  status = kernelLockGet(&(theDisk->cache.cacheLock));
  if (status < 0)
    return (status);

  // If we're supposed to uncache everything, that's easy
  if (sectorCount == theDisk->cache.usedSectors)
    {
      kernelLockRelease(&(theDisk->cache.cacheLock));
      status = cacheSync(theDisk);
      for (count1 = 0; count1 < theDisk->cache.usedSectors; count1 ++)
	{
	  theDisk->cache.sectors[count1]->number = -1;
	  theDisk->cache.sectors[count1]->dirty = 0;
	}
      if (status == 0)
	theDisk->cache.usedSectors = 0;
      return (status);
    }

  // Bubble-sort it by age, most-recently-used first
  for (count1 = 0; count1 < theDisk->cache.usedSectors; count1 ++)
    for (count2 = 0;  count2 < (theDisk->cache.usedSectors - 1); count2 ++)
      if (theDisk->cache.sectors[count2]->lastAccess <
	  theDisk->cache.sectors[count2 + 1]->lastAccess)
	{
	  tmpSector = theDisk->cache.sectors[count2 + 1];
	  theDisk->cache.sectors[count2 + 1] = theDisk->cache.sectors[count2];
	  theDisk->cache.sectors[count2] = tmpSector;
	}

  // Now our list has the youngest sectors at the front.

  // Write any dirty sectors that we are discarding from the end
  for (count1 = (theDisk->cache.usedSectors - sectorCount);
       count1 < theDisk->cache.usedSectors; count1 ++)
    if (theDisk->cache.sectors[count1]->dirty)
      {
	status = writeConsecutiveDirty(theDisk, count1);
	if (status < 0)
	  errors = status;
	else
	  count1 += (status - 1);
      }

  for (count1 = (theDisk->cache.usedSectors - sectorCount);
       count1 < theDisk->cache.usedSectors; count1 ++)
    {
      theDisk->cache.sectors[count1]->number = -1;
      theDisk->cache.sectors[count1]->dirty = 0;
    }
 
  if (!errors)
    theDisk->cache.usedSectors -= sectorCount;

  // Bubble-sort the remaining ones again by sector number
  for (count1 = 0; count1 < theDisk->cache.usedSectors; count1 ++)
    for (count2 = 0;  count2 < (theDisk->cache.usedSectors - 1); count2 ++)
      if (theDisk->cache.sectors[count2]->number >
	  theDisk->cache.sectors[count2 + 1]->number)
	{
	  tmpSector = theDisk->cache.sectors[count2 + 1];
	  theDisk->cache.sectors[count2 + 1] = theDisk->cache.sectors[count2];
	  theDisk->cache.sectors[count2] = tmpSector;
	}

  kernelLockRelease(&(theDisk->cache.cacheLock));
  return (status = errors);
}


static int addCacheSectors(kernelPhysicalDisk *theDisk, unsigned startSector,
			   unsigned sectorCount, void *data, int dirty)
{
  // This routine will add disk sectors to the cache.

  int status = 0;
  kernelDiskCacheSector *cacheSector = NULL;
  int index, count;

  // Only cache what will fit
  if (sectorCount > theDisk->cache.numSectors)
    sectorCount = theDisk->cache.numSectors;

  // Make sure the cache isn't full
  if ((theDisk->cache.usedSectors + sectorCount) > theDisk->cache.numSectors)
    {
      // Uncache some sectors
      status =
	uncacheSectors(theDisk, ((theDisk->cache.usedSectors +
				  sectorCount) - theDisk->cache.numSectors)); 
      if (status < 0)
	return (status);
    }

  // Make sure none of these sectors are already cached.  We could do some
  // clever things to take care of such a case, but no, we want to keep
  // it simple here.  It is the caller's responsibility to ensure that we
  // are not 're-caching' things.
  if (countUncachedSectors(theDisk, startSector, sectorCount) != sectorCount)
    {
      kernelError(kernel_error, "Attempt to cache a range of disk sectors "
		  "(%u-%u) that are already (partially) cached", startSector,
		  (startSector + (sectorCount - 1)));
      return (status = ERR_ALREADY);
    }

  status = kernelLockGet(&(theDisk->cache.cacheLock));
  if (status < 0)
    return (status);

  // Find the spot in the cache where these should go.  That will be in the
  // spot where the next sector's number is > startSector
  if ((theDisk->cache.usedSectors == 0) ||
      (theDisk->cache.sectors[theDisk->cache.usedSectors - 1]->number <
       startSector))
    // Put these new ones at the end
    index = theDisk->cache.usedSectors;

  else
    {
      for (index = 0; index < theDisk->cache.usedSectors; index++)
	if (theDisk->cache.sectors[index]->number >= startSector)
	  {
	    // We will have to shift all sectors starting from here to make
	    // room for our new ones.

	    for (count = (theDisk->cache.usedSectors - (index + 1));
		 count >= 0; count --)
	      {
		cacheSector =
		  theDisk->cache.sectors[index + sectorCount + count];
		theDisk->cache.sectors[index + sectorCount + count] =
		  theDisk->cache.sectors[index + count];
		theDisk->cache.sectors[index + count] = cacheSector;
	      }
	    break;
	  }
    }

  theDisk->cache.usedSectors += sectorCount;

  // Now copy our new sectors into the cache
  
  for ( count = 0; count < sectorCount; count ++)
    {
      cacheSector = theDisk->cache.sectors[index + count];

      // Set the number
      cacheSector->number = (startSector + count);

      // Copy the data
      kernelMemCopy((data + (count * theDisk->sectorSize)), cacheSector->data,
		    theDisk->sectorSize);

      // Clean or dirty?
      cacheSector->dirty = dirty;

      // Set the last access time
      cacheSector->lastAccess = kernelSysTimerRead();
    }

  if (dirty)
    theDisk->cache.dirty = 1;

  kernelLockRelease(&(theDisk->cache.cacheLock));
  return (status = sectorCount);
}


static int getCachedSectors(kernelPhysicalDisk *theDisk, unsigned sectorNum,
			    int sectorCount, void *data)
{
  // This function is used to retrieve one or more (consecutive) sectors from
  // the cache.  If sectors are cached, this routine copies the data into the
  // pointer supplied and returns the number it copied.

  int status = 0;
  int index;
  int copied = 0;
  kernelDiskCacheSector *cacheSector = NULL;

  index = findCachedSector(theDisk, sectorNum);
  if (index < 0)
    return (copied = 0);

  status = kernelLockGet(&(theDisk->cache.cacheLock));
  if (status < 0)
    return (status);

  // We've found the starting sector.  Start copying data
  for ( ; (index < theDisk->cache.usedSectors) &&
	  (copied < sectorCount) ; index ++)
    {
      cacheSector = theDisk->cache.sectors[index];
      
      if (cacheSector->number != sectorNum)
	break;
      
      // This sector is cached.  Copy the data.
      kernelMemCopy(cacheSector->data, data, theDisk->sectorSize);
      
      copied++;
      sectorNum++;
      data += theDisk->sectorSize;
	      
      // Set the last access time
      cacheSector->lastAccess = kernelSysTimerRead();
    }

  kernelLockRelease(&(theDisk->cache.cacheLock));
  return (copied);
}


static int writeCachedSectors(kernelPhysicalDisk *theDisk, unsigned sectorNum,
			      int sectorCount, void *data)
{
  // This function is used to change one or more (consecutive) sectors stored
  // in the cache.  If sectors are cached, this routine copies the data from
  // the pointer supplied and returns the number it copied.

  int status = 0;
  int index;
  int copied = 0;
  kernelDiskCacheSector *cacheSector = NULL;

  index = findCachedSector(theDisk, sectorNum);
  if (index < 0)
    return (copied = 0);

  status = kernelLockGet(&(theDisk->cache.cacheLock));
  if (status < 0)
    return (status);

  // We've found the starting sector.  Start copying data
  for ( ; (index < theDisk->cache.usedSectors) &&
	  (copied < sectorCount) ; index ++)
    {
      cacheSector = theDisk->cache.sectors[index];
      
      if (cacheSector->number != sectorNum)
	break;
      
      // This sector is cached.  Copy the data if it's different
      if (kernelMemCmp(data, cacheSector->data, theDisk->sectorSize))
	{
	  kernelMemCopy(data, cacheSector->data, theDisk->sectorSize);
	  
	  // The sector and cache are now dirty
	  cacheSector->dirty = 1;
	  theDisk->cache.dirty = 1;
	}

      copied++;
      sectorNum++;
      data += theDisk->sectorSize;

      // Set the last access time
      cacheSector->lastAccess = kernelSysTimerRead();
    }

  kernelLockRelease(&(theDisk->cache.cacheLock));
  return (copied);
}
#endif // DISK_CACHE


static int motorOff(kernelPhysicalDisk *physicalDisk)
{
  // Calls the target disk driver's 'motor off' routine.

  int status = 0;

  // Reset the 'idle since' value.
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // If it's a fixed disk, we don't turn the motor off, for now
  if (physicalDisk->fixedRemovable == fixed)
    return (status = 0);

  // Make sure the motor isn't already off
  if (!(physicalDisk->motorState))
    return (status = 0);

  // Now make sure the device driver motor off routine has been installed
  if (physicalDisk->driver->driverSetMotorState == NULL)
    // Don't make this an error.  It's just not available in some drivers.
    return (status = 0);

  // Lock the disk
  status = kernelLockGet(&(physicalDisk->diskLock));
  if (status < 0)
    return (status = ERR_NOLOCK);

  // Ok, now turn the motor off
  status = physicalDisk->driver
    ->driverSetMotorState(physicalDisk->deviceNumber, 0);
  if (status < 0)
    return (status);
  else
    // Make note of the fact that the motor is off
    physicalDisk->motorState = 0;

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Unlock the disk
  kernelLockRelease(&(physicalDisk->diskLock));

  return (status);
}


static void diskd(void)
{
  // This function will be a thread spawned at inititialization time
  // to do any required ongoing operations on disks, such as shutting off
  // floppy and cdrom motors
  
  kernelPhysicalDisk *physicalDisk = NULL;
  unsigned currentTime;
  int count;

  // Don't try to do anything until we have registered disks
  while (!initialized || (physicalDiskCounter <= 0))
    kernelMultitaskerWait(60);

  while(1)
    {
      // Loop for each physical disk
      for (count = 0; count < physicalDiskCounter; count ++)
	{
	  physicalDisk = physicalDisks[count];

	  currentTime = kernelSysTimerRead();

	  // If the disk is a floppy and has been idle for >= 2 seconds,
	  // turn off the motor.
	  if ((physicalDisk->type == floppy) &&
	      (currentTime > (physicalDisk->idleSince + 40)))
	    motorOff(physicalDisk);
	}

      // Yield the rest of the timeslice and wait for 1 second
      kernelMultitaskerWait(20);
    }
}


static int spawnDiskd(void)
{
  // Launches the disk daemon

  diskdPID = kernelMultitaskerSpawn(diskd, "disk monitor", 0, NULL);
  if (diskdPID < 0)
    return (diskdPID);

  // Re-nice the disk daemon
  kernelMultitaskerSetProcessPriority(diskdPID, (PRIORITY_LEVELS - 2));
 
  // Success
  return (diskdPID);
}


static int readWriteSectors(kernelPhysicalDisk *physicalDisk,
			    unsigned logicalSector, unsigned numSectors,
			    void *dataPointer, int mode)
{
  // This is the combined "read sectors" and "write sectors" routine 
  // which invokes the driver routines designed for those functions.  
  // If an error is encountered, the function returns negative.  
  // Otherwise, it returns the number of sectors it actually read or
  // wrote.  This should not be exported, and should not be called by 
  // users.  Users should call the routines kernelDiskReadSectors
  // and kernelDiskWriteSectors which in turn call this routine.

  int status = 0;
  unsigned doSectors = 0;
  unsigned extraSectors = 0;

  // Make sure the appropriate device driver routine has been installed
  if (((mode & IOMODE_READ) &&
       (physicalDisk->driver->driverReadSectors == NULL)) ||
      ((mode & IOMODE_WRITE) &&
       (physicalDisk->driver->driverWriteSectors == NULL)))
    {
      kernelError(kernel_error, "Driver routine is NULL");
      return (status = ERR_NOSUCHFUNCTION);
    }

  // Don't try to write a read-only disk
  if ((mode & IOMODE_WRITE) && physicalDisk->readOnly)
    return (status = ERR_NOWRITE);

#if (DISK_CACHE)
  // Check disk cache initialization.
  if (!physicalDisk->cache.initialized)
    {
      // Get a cache for the disk
      status = getDiskCache(physicalDisk);
      if (status < 0)
	{
	  kernelError(kernel_error, "Unable to initialize disk cache");
	  return (status);
	}
    }
#endif // DISK_CACHE

  if (physicalDisk->fixedRemovable == removable)
    {
      // Make sure the disk daemon is running
      kernelProcessState tmpState;
      if (kernelMultitaskerGetProcessState(diskdPID, &tmpState) < 0)
	// Re-spawn the disk daemon
	spawnDiskd();
    }

  // Now we start the actual read/write operation

  // This loop deals with contiguous blocks of sectors, either cached
  // or to/from the disk.

  while (numSectors > 0)
    {
      doSectors = numSectors;
      extraSectors = 0;

#if (DISK_CACHE)
      void *savePointer = NULL;
      unsigned cached = 0;

      if (!(mode & IOMODE_NOCACHE))
	{
	  if (mode & IOMODE_READ)
	    // If the data is cached, get it from the cache instead
	    cached = getCachedSectors(physicalDisk, logicalSector,
				      numSectors, dataPointer);
	  else
	    // If the data is cached, write it to the cache instead
	    cached = writeCachedSectors(physicalDisk, logicalSector,
					numSectors, dataPointer);
	  if (cached)
	    {
	      // Some number of sectors was cached.
	      logicalSector += cached;
	      numSectors -= cached;
	  
	      // Increment the place in the buffer we're using
	      dataPointer += (physicalDisk->sectorSize * cached);
	    }

	  // Anything left to do?
	  if (numSectors == 0)
	    continue;

	  // Only attempt to do as many sectors as are not cached.
	  doSectors = countUncachedSectors(physicalDisk, logicalSector,
					   numSectors);

	  // Could we read some extra to possibly speed up future operations?
	  if ((mode & IOMODE_READ) && (doSectors == numSectors) && 
	      (doSectors < DISK_READAHEAD_SECTORS))
	    {
	      // We read extraSectors sectors extra.
	      unsigned tmp = countUncachedSectors(physicalDisk, logicalSector,
						  DISK_READAHEAD_SECTORS);

	      if ((logicalSector + tmp - 1) < physicalDisk->numSectors)
		{
		  extraSectors = (tmp - doSectors);

		  if (extraSectors)
		    {
		      doSectors += extraSectors;
		      savePointer = dataPointer;
		      dataPointer =
			kernelMalloc(doSectors * physicalDisk->sectorSize);
		      if (dataPointer == NULL)
			{
			  // Oops.  Just put everything back.
			  doSectors -= extraSectors;
			  dataPointer = savePointer;
			  extraSectors = 0;
			}
		    }
		}
	    }

	  else if (mode & IOMODE_WRITE)
	    {
	      // Add the remaining sectors to the cache
	      status = addCacheSectors(physicalDisk, logicalSector, doSectors,
				       dataPointer, 1 /* dirty */);
	      if (status > 0)
		{
		  logicalSector += status;
		  numSectors -= status;
		  dataPointer += (physicalDisk->sectorSize * status);
		  continue;
		}

	      // Eek.  No caching.  Better fall through and write the data.
	    }
	}
#endif // DISK_CACHE

      // Call the read or write routine
      if (mode & IOMODE_READ)
	status = physicalDisk->driver
	  ->driverReadSectors(physicalDisk->deviceNumber, logicalSector,
			      doSectors, dataPointer);
      else
	status = physicalDisk->driver
	  ->driverWriteSectors(physicalDisk->deviceNumber, logicalSector,
			       doSectors, dataPointer);
      if (status < 0)
	{
	  // If it is a write-protect error, mark the disk as read only
	  if ((mode & IOMODE_WRITE) && (status == ERR_NOWRITE))
	    {
	      kernelError(kernel_error, "Read-only disk.");
	      physicalDisk->readOnly = 1;
	    }
	  
	  return (status);
	}

#if (DISK_CACHE)
      if ((!(mode & IOMODE_NOCACHE)) && (mode & IOMODE_READ))
	{
	  // If it's a read operation, cache the sectors we read
	  addCacheSectors(physicalDisk, logicalSector,
			  doSectors, dataPointer, 0 /* not dirty */);

	  if (extraSectors)
	    {
	      doSectors -= extraSectors;
	      // Copy the requested sectors into the user's buffer
	      kernelMemCopy(dataPointer, savePointer,
			    (doSectors * physicalDisk->sectorSize));
	      kernelFree(dataPointer);
	      dataPointer = savePointer;
	    }
	}
#endif // DISK_CACHE

      // Update the current logical sector, the remaining number to read,
      // and the buffer pointer
      logicalSector += doSectors;
      numSectors -= doSectors;
      dataPointer += (doSectors * physicalDisk->sectorSize);
      
    } // per-operation loop
  
  // Finished.  Return success
  return (status = 0);
}


/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
//
// Below here, the functions are exported for external use
//
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////


int kernelDiskRegisterDevice(kernelPhysicalDisk *physicalDisk)
{
  // This routine will receive a new physical disk structure, and register
  // all of its logical disks for use by the system.

  int status = 0;
  int count;

  // Check params
  if ((physicalDisk == NULL) || (physicalDisk->driver == NULL))
    {
      kernelError(kernel_error, "Disk structure or driver is NULL");
      return (status = ERR_NULLPARAMETER);
    }

  // Make sure the arrays of disk structures aren't full
  if ((physicalDiskCounter >= DISK_MAXDEVICES) ||
      (logicalDiskCounter >= DISK_MAXDEVICES))
    {
      kernelError(kernel_error, "Max disk structures already registered");
      return (status = ERR_NOFREE);
    }

  // Disk cache initialization is deferred until cache use is attempted.
  // Otherwise we waste memory allocating caches for disks that might
  // never be used.
  
  // Add the physical disk to our list
  physicalDisks[physicalDiskCounter++] = physicalDisk;

  // Loop through the physical device's logical disks
  for (count = 0; count < physicalDisk->numLogical; count ++)
    // Put the device at the end of the list and increment the counter
    logicalDisks[logicalDiskCounter++] = &physicalDisk->logical[count];

  // If the driver has a 'register device' routine, call it now
  if (physicalDisk->driver->driverRegisterDevice)
    {
      status =
	physicalDisk->driver->driverRegisterDevice((void *) physicalDisk);
      if (status < 0)
	return (status);
    }
  
  // If it's a floppy, make sure the motor is off
  if (physicalDisk->type == floppy)
    motorOff(physicalDisk);

  // Reset the 'idle since' and 'last sync' values
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Success
  return (status = 0);
}


int kernelDiskReadPartitions(void)
{
  // Read the partition tables for all the registered physical disks, and
  // (re)build the list of logical disks.  This will be done initially at
  // startup time, but can be re-called during operation if the partitions
  // have been changed.

  int status = 0;
  kernelPhysicalDisk *physicalDisk = NULL;
  kernelDisk *logicalDisk = NULL;
  unsigned char sectBuf[512];
  unsigned char *partitionRecord = NULL;
  int partition = 0;
  unsigned char partTypeCode = 0;
  partitionType partType;
  int count;

  logicalDiskCounter = 0;

  // Loop through all of the registered physical disks
  for (count = 0; count < physicalDiskCounter; count ++)
    {
      physicalDisk = physicalDisks[count];

      // Clear the logical disks
      physicalDisk->numLogical = 0;
      kernelMemClear(&(physicalDisk->logical),
		     (sizeof(kernelDisk) * DISK_MAX_PARTITIONS));

      // Assume UNKNOWN (code 0) partition type for now.
      partType.code = 0;
      strcpy((char *) partType.description, physicalDisk->description);

      // If this is a not a hard disk, make the logical disk be the same as
      // the physical disk
      if ((physicalDisk->type == idedisk) || (physicalDisk->type == scsidisk))
	{
	  // It's a hard disk.  We need to read the partition table

	  // Initialize the sector buffer
	  kernelMemClear(sectBuf, 512);
      
	  // Read the first sector of the disk
	  status = kernelDiskReadAbsoluteSectors((char *) physicalDisk->name,
						 0, 1, sectBuf);
	  if (status < 0)
	    {
	      kernelError(kernel_error, "Can't read partitions: disk %s", 
				  (char *) physicalDisk->name);
	      continue;
	    }

	  // Is this a valid MBR?
	  if ((sectBuf[511] == (unsigned char) 0xAA) ||
	      (sectBuf[510] == (unsigned char) 0x55))
	    {
	      // Set this pointer to the first partition record in the master
	      // boot record
	      partitionRecord = (sectBuf + 0x01BE);

	      // Loop through the partition records, looking for non-zero
	      // entries
	      for (partition = 0; partition < 4; partition ++)
		{
		  logicalDisk = &(physicalDisk->logical[partition]);

		  partTypeCode = partitionRecord[4];
		  if (partTypeCode == 0)
		    // The "rules" say we must be finished with this physical
		    // device.
		    break;

		  kernelDiskGetPartType(partTypeCode, &partType);
	  
		  // We will add a logical disk corresponding to the partition
		  // we've discovered
		  sprintf((char *) logicalDisk->name, "%s%c",
			  physicalDisk->name, ('a' + partition));
		  kernelMemCopy(&partType, (void *) &(logicalDisk->partType),
				sizeof(partitionType));
		  strncpy((char *) logicalDisk->fsType, "unknown",
			  FSTYPE_MAX_NAMELENGTH);
		  logicalDisk->physical = (void *) physicalDisk;
		  logicalDisk->startSector =
		    *((unsigned *)(partitionRecord + 0x08));
		  logicalDisk->numSectors =
		    *((unsigned *)(partitionRecord + 0x0C));
		  physicalDisk->numLogical++;

		  logicalDisks[logicalDiskCounter++] = logicalDisk;

		  // See if we can determine the filesystem types
		  status = kernelFilesystemScan(logicalDisk);
		  if (status < 0)
		    strncpy((char *) logicalDisk->fsType,
			    partType.description, FSTYPE_MAX_NAMELENGTH);

		  kernelLog("Disk %s (hard disk %d, partition %d): %s",
			    logicalDisk->name, count, partition,
			    logicalDisk->fsType);

		  // Move to the next partition record
		  partitionRecord += 16;
		}
	    }
	}
      else
	{
	  physicalDisk->numLogical = 1;
	  logicalDisk = &(physicalDisk->logical[0]);
	  // Logical disk name same as device name
	  strcpy((char *) logicalDisk->name, (char *) physicalDisk->name);
	  kernelMemCopy(&partType, (void *) &(logicalDisk->partType),
			sizeof(partitionType));
	  strncpy((char *) logicalDisk->fsType, "unknown",
		  FSTYPE_MAX_NAMELENGTH);
	  logicalDisk->physical = (void *) physicalDisk;
	  logicalDisk->startSector = 0;
	  logicalDisk->numSectors = physicalDisk->numSectors;

	  logicalDisks[logicalDiskCounter++] = logicalDisk;
	}
    }

  return (status = 0);
}


int kernelDiskInitialize(const char *physicalBootDisk, unsigned bootSector)
{
  // This is the "initialize" routine which invokes  the driver routine 
  // designed for that function.  Normally it returns zero, unless there
  // is an error.  If there's an error it returns negative.
  
  int status = 0;
  kernelPhysicalDisk *physicalDisk = NULL;
  kernelDisk *logicalDisk = NULL;
  int found = 0;
  int count1, count2;

  // Check whether any disks have been registered.  If not, that's 
  // an indication that the hardware enumeration has not been done
  // properly.  We'll issue an error in this case
  if (physicalDiskCounter <= 0)
    {
      kernelError(kernel_error, "No disks have been registered");
      return (status = ERR_NOTINITIALIZED);
    }

  // Spawn the disk daemon
  status = spawnDiskd();
  if (status < 0)
    kernelError(kernel_warn, "Unable to start disk monitor");

  // We're initialized
  initialized = 1;

  // Read the partition tables
  status = kernelDiskReadPartitions();
  if (status < 0)
    kernelError(kernel_error, "Unable to read disk partitions");

  // Copy the name of the physical boot disk
  strcpy(bootDisk, physicalBootDisk);

  // If we booted from a hard disk, we need to find out which partition
  // (logical disk) it was.
  if (!strncmp(bootDisk, "hd", 2))
    {
      // Loop through the physical disks and find the one with this name
      for (count1 = 0; count1 < physicalDiskCounter; count1 ++)
	{
	  physicalDisk = physicalDisks[count1];
	  if (!strcmp((char *) physicalDisk->name, bootDisk))
	    {
	      // This is the physical disk we booted from.  Find the
	      // partition
	      for (count2 = 0; count2 < physicalDisk->numLogical; count2 ++)
		{
		  logicalDisk = &(physicalDisk->logical[count2]);
		  // If the boot sector we booted from is in this partition,
		  // save its name as our boot disk.
		  if (logicalDisk->startSector == bootSector)
		    {
		      strcpy(bootDisk, (char *) logicalDisk->name);
		      found = 1;
		      break;
		    }
		}
	      break;
	    }
	}

      // Disk not found?  Perhaps it was really a CD-ROM.  Try that.
      if (!found)
	{
	  kernelError(kernel_warn, "Boot device \"%s\" not found.  Trying cd0 "
		      "instead");
	  strcpy(bootDisk, "cd0");
	}
    }

  return (status = 0);
}


int kernelDiskSync(void)
{
  // Force a synchronization of all disks
  
  int errors = 0;

  if (!initialized)
    return (errors = ERR_NOTINITIALIZED);

#if (DISK_CACHE)
  int status = 0;
  kernelPhysicalDisk *physicalDisk = NULL;
  int count;

  for (count = 0; count < physicalDiskCounter; count ++)
    {
      physicalDisk = physicalDisks[count];

      // Lock the physical disk
      status = kernelLockGet(&(physicalDisk->diskLock));
      if (status < 0)
	{
	  kernelError(kernel_error, "Unable to lock disk \"%s\" for sync",
		      physicalDisk->name);
	  errors = status;
	  continue;
	}

      status = cacheSync(physicalDisk);
      if (status < 0)
	{
	  kernelError(kernel_warn, "Error synchronizing the disk \"%s\"",
		      physicalDisk->name);
	  errors = status;
	}

      kernelLockRelease(&(physicalDisk->diskLock));
    }
#endif // DISK_CACHE

  return (errors);
}


int kernelDiskSyncDisk(const char *diskName)
{
  // Syncronize the named disk

  int status = 0;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if (diskName == NULL)
    return (status = ERR_NULLPARAMETER);

#if (DISK_CACHE)
  kernelDisk *theDisk = NULL;
  kernelPhysicalDisk *physicalDisk = NULL;

  theDisk = kernelGetDiskByName(diskName);
  if (theDisk == NULL)
    {
      kernelError(kernel_error, "No such disk \"%s\"", diskName);
      return (status = ERR_NOSUCHENTRY);
    }

  physicalDisk = theDisk->physical;

  // Lock the physical disk
  status = kernelLockGet(&(physicalDisk->diskLock));
  if (status < 0)
    {
      kernelError(kernel_error, "Unable to lock disk \"%s\" for sync",
		  physicalDisk->name);
      return (status);
    }

  status = cacheSync(physicalDisk);
  
  kernelLockRelease(&(physicalDisk->diskLock));  
  
  if (status < 0)
    kernelError(kernel_warn, "Error synchronizing the disk \"%s\"",
		physicalDisk->name);
#endif // DISK_CACHE

  return (status);
}


int kernelDiskInvalidateCache(const char *diskName)
{
  // Invalidate the cache of the named disk

  int status = 0;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if (diskName == NULL)
    return (status = ERR_NULLPARAMETER);

#if (DISK_CACHE)
  kernelPhysicalDisk *physicalDisk = NULL;

  physicalDisk = kernelGetPhysicalDiskByName(diskName);
  if (physicalDisk == NULL)
    {
      kernelError(kernel_error, "No such disk \"%s\"", diskName);
      return (status = ERR_NOSUCHENTRY);
    }

  // Lock the physical disk
  status = kernelLockGet(&(physicalDisk->diskLock));
  if (status < 0)
    {
      kernelError(kernel_error, "Unable to lock disk \"%s\" for cache "
		  "invalidation", physicalDisk->name);
      return (status);
    }

  if (physicalDisk->cache.dirty)
    kernelError(kernel_warn, "Invalidating dirty disk cache!");

  status = cacheInvalidate(physicalDisk);
  
  kernelLockRelease(&(physicalDisk->diskLock));  
  
  if (status < 0)
    kernelError(kernel_warn, "Error invalidating disk \"%s\" cache",
		physicalDisk->name);
#endif // DISK_CACHE

  return (status);
}


int kernelDiskShutdown(void)
{
  // Shut down.

  int status = 0;
  kernelPhysicalDisk *physicalDisk = NULL;
  int count;
  
  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Synchronize all disks
  status = kernelDiskSync();

  for (count = 0; count < physicalDiskCounter; count ++)
    {
      physicalDisk = physicalDisks[count];

      if ((physicalDisk->fixedRemovable == removable) &&
	  physicalDisk->motorState)
	motorOff(physicalDisk);
    }

  return (status);
}


int kernelDiskGetBoot(char *boot)
{
  // Returns the disk name of the boot device

  int status = 0;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if (boot == NULL)
    return (status = ERR_NULLPARAMETER);
  
  strncpy(boot, bootDisk, DISK_MAX_NAMELENGTH);
  return (status = 0);
}


int kernelDiskGetCount(void)
{
  // Returns the number of registered logical disk structures.  Useful for
  // iterating through calls to kernelGetDiskByName or kernelDiskGetInfo

  if (!initialized)
    return (ERR_NOTINITIALIZED);

  return (logicalDiskCounter);
}


int kernelDiskGetPhysicalCount(void)
{
  // Returns the number of registered physical disk structures.  Useful for
  // iterating through calls to kernelGetDiskByName or kernelDiskGetInfo

  if (!initialized)
    return (ERR_NOTINITIALIZED);

  return (physicalDiskCounter);
}


int kernelDiskFromLogical(kernelDisk *logical, disk *userDisk)
{
  // Takes our logical disk kernel structure and turns it into a user space
  // 'disk' object

  int status = 0;
  kernelPhysicalDisk *physical = NULL;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if ((logical == NULL) || (userDisk == NULL))
    return (status = ERR_NULLPARAMETER);

  physical = (kernelPhysicalDisk *) logical->physical;

  // Get the physical disk info
  status = kernelDiskFromPhysical(physical, userDisk);
  if (status < 0)
    return (status);

  // Add/override some things specific to logical disks
  strncpy(userDisk->name, (char *) logical->name, DISK_MAX_NAMELENGTH);
  kernelMemCopy((void *) &(logical->partType), &(userDisk->partType),
	sizeof(partitionType));
  strncpy(userDisk->fsType, (char *) logical->fsType, FSTYPE_MAX_NAMELENGTH);
  userDisk->opFlags = logical->opFlags;
  userDisk->startSector = logical->startSector;
  userDisk->numSectors = logical->numSectors;

  return (status = 0);
}


int kernelDiskGetInfo(disk *array)
{
  // Fills a simplified disk info structure of all the logical disks

  int status = 0;
  int count;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if (array == NULL)
    return (status = ERR_NULLPARAMETER);
 
  // Loop through the disks, filling the array supplied
  for (count = 0; count < logicalDiskCounter; count ++)
    kernelDiskFromLogical(logicalDisks[count], &array[count]);

  return (status = 0);
}


int kernelDiskFromPhysical(kernelPhysicalDisk *physical, disk *userDisk)
{
  // Takes our physical disk kernel structure and turns it into a user space
  // 'disk' object

  int status = 0;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if ((physical == NULL) || (userDisk == NULL))
    return (status = ERR_NULLPARAMETER);

  strncpy(userDisk->name, (char *) physical->name, DISK_MAX_NAMELENGTH);
  userDisk->deviceNumber = physical->deviceNumber;
  userDisk->type = physical->type;
  userDisk->fixedRemovable = physical->fixedRemovable;
  userDisk->readOnly = physical->readOnly;
  userDisk->heads = physical->heads;
  userDisk->cylinders = physical->cylinders;
  userDisk->sectorsPerCylinder = physical->sectorsPerCylinder;
  userDisk->startSector = 0;
  userDisk->numSectors = physical->numSectors;
  userDisk->sectorSize = physical->sectorSize;

  return (status = 0);
}


int kernelDiskGetPhysicalInfo(disk *array)
{
  // Fills a simplified disk info structure of all the physical disks

  int status = 0;
  int count;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if (array == NULL)
    return (status = ERR_NULLPARAMETER);
 
  // Loop through the physical disks, filling the array supplied
  for (count = 0; count < physicalDiskCounter; count ++)
    kernelDiskFromPhysical(physicalDisks[count], &array[count]);

  return (status = 0);
}


int kernelDiskGetPartType(int code, partitionType *partType)
{
  // This function takes the supplied code and returns a corresponding
  // partition type structure in the memory provided.

  int status = 0;
  int count;

  // We don't check for initialization; the table is static.

  if (partType == NULL)
    return (status = ERR_NULLPARAMETER);

  for (count = 0; (partitionTypes[count].code != 0); count ++)
    if (partitionTypes[count].code == code)
      {
	kernelMemCopy(&(partitionTypes[count]), partType,
		      sizeof(partitionType));
	break;
      }

  return (status = 0);
}


partitionType *kernelDiskGetPartTypes(void)
{
  // Just returns a pointer to our table of known partition types

  // We don't check for initialization; the table is static.
  return (partitionTypes);
}


kernelDisk *kernelGetDiskByName(const char *name)
{
  // This routine takes the name of a logical disk and finds it in the
  // array, returning a pointer to the disk.  If the disk doesn't exist,
  // the function returns NULL

  kernelDisk *theDisk = NULL;
  int count;

  if (!initialized)
    return (theDisk = NULL);

  // Check params
  if (name == NULL)
    {
      kernelError(kernel_error, "Disk name is NULL");
      return (theDisk = NULL);
    }

  for (count = 0; count < logicalDiskCounter; count ++)
    if (!strcmp(name, (char *) logicalDisks[count]->name))
      {
	theDisk = logicalDisks[count];
	break;
      }

  return (theDisk);
}


kernelPhysicalDisk *kernelGetPhysicalDiskByName(const char *name)
{
  // This routine takes the name of a physical disk and finds it in the
  // array, returning a pointer to the disk.  If the disk doesn't exist,
  // the function returns NULL

  kernelPhysicalDisk *physicalDisk = NULL;
  int count;

  if (!initialized)
    return (physicalDisk = NULL);

  // Check params
  if (name == NULL)
    {
      kernelError(kernel_error, "Disk name is NULL");
      return (physicalDisk = NULL);
    }

  for (count = 0; count < physicalDiskCounter; count ++)
    if (!strcmp(name, (char *) physicalDisks[count]->name))
      {
	physicalDisk = physicalDisks[count];
	break;
      }

  return (physicalDisk);
}


int kernelDiskSetDoorState(const char *diskName, int state)
{
  // This routine is the user-accessible interface for opening or closing
  // a removable disk device.

  int status = 0;
  kernelPhysicalDisk *physicalDisk = NULL;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if (diskName == NULL)
    return (status = ERR_NULLPARAMETER);

  // Get the disk structure
  physicalDisk = kernelGetPhysicalDiskByName(diskName);
  if (physicalDisk == NULL)
    return (status = ERR_NOSUCHENTRY);

  // Make sure it's a removable disk
  if (physicalDisk->fixedRemovable != removable)
    {
      kernelError(kernel_error, "Cannot open/close a non-removable disk");
      return (status = ERR_INVALID);
    }

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Make sure the operation is supported
  if (physicalDisk->driver->driverSetDoorState == NULL)
    {
      kernelError(kernel_error, "Driver routine is NULL");
      return (status = ERR_NOSUCHFUNCTION);
    }
  
  // Lock the disk
  status = kernelLockGet(&(physicalDisk->diskLock));
  if (status < 0)
    return (status = ERR_NOLOCK);

#if (DISK_CACHE)
  // Make sure the cache is invalidated
  cacheInvalidate(physicalDisk);
#endif

  // Call the door control operation
  status = physicalDisk->driver
    ->driverSetDoorState(physicalDisk->deviceNumber, state);

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();

  // Unlock the disk
  kernelLockRelease(&(physicalDisk->diskLock));

  return (status);
}


int kernelDiskReadSectors(const char *diskName, unsigned logicalSector,
			  unsigned numSectors, void *dataPointer)
{
  // This routine is the user-accessible interface to reading data using
  // the various disk routines in this file.  Basically, it is a gatekeeper
  // that helps ensure correct use of the "read-write" method.  

  int status = 0;
  kernelDisk *theDisk = NULL;
  kernelPhysicalDisk *physicalDisk = NULL;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if ((diskName == NULL) || (dataPointer == NULL))
    return (status = ERR_NULLPARAMETER);

  // Get the disk structure
  theDisk = kernelGetDiskByName(diskName);
  if (theDisk == NULL)
    return (status = ERR_NOSUCHENTRY);

  // Start at the beginning of the logical volume.
  logicalSector += theDisk->startSector;

  // Make sure the logical sector number does not exceed the number
  // of logical sectors on this volume
  if ((logicalSector >= (theDisk->startSector + theDisk->numSectors)) ||
      ((logicalSector + numSectors) >
       (theDisk->startSector + theDisk->numSectors)))
    {
      // Make a kernelError.
      kernelError(kernel_error, "Sector range %u-%u exceeds volume boundary "
		  "of %u", logicalSector, (logicalSector + numSectors - 1),
		  (theDisk->startSector + theDisk->numSectors));
      return (status = ERR_BOUNDS);
    }

  physicalDisk = (kernelPhysicalDisk *) theDisk->physical;

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Lock the disk
  status = kernelLockGet(&(physicalDisk->diskLock));
  if (status < 0)
    return (status = ERR_NOLOCK);

  // Call the read-write routine for a read operation
  status = readWriteSectors(physicalDisk, logicalSector, numSectors,
			    dataPointer, IOMODE_READ);

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Unlock the disk
  kernelLockRelease(&(physicalDisk->diskLock));
  
  return (status);
}


int kernelDiskWriteSectors(const char *diskName, unsigned logicalSector, 
			   unsigned numSectors, void *dataPointer)
{
  // This routine is the user-accessible interface to writing data using
  // the various disk routines in this file.  Basically, it is a gatekeeper
  // that helps ensure correct use of the "read-write" method.  
  
  int status = 0;
  kernelDisk *theDisk = NULL;
  kernelPhysicalDisk *physicalDisk = NULL;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if ((diskName == NULL) || (dataPointer == NULL))
    return (status = ERR_NULLPARAMETER);

  // Get the disk structure
  theDisk = kernelGetDiskByName(diskName);

  if (theDisk == NULL)
    return (status = ERR_NOSUCHENTRY);

  // Start at the beginning of the logical volume.
  logicalSector += theDisk->startSector;

  // Make sure the logical sector number does not exceed the number
  // of logical sectors on this volume
  if ((logicalSector >= (theDisk->startSector + theDisk->numSectors)) ||
      ((logicalSector + numSectors) >
       (theDisk->startSector + theDisk->numSectors)))
    {
      // Make a kernelError.
      kernelError(kernel_error, "Exceeding volume boundary");
      return (status = ERR_BOUNDS);
    }

  physicalDisk = (kernelPhysicalDisk *) theDisk->physical;

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Lock the disk
  status = kernelLockGet(&(physicalDisk->diskLock));
  if (status < 0)
    return (status = ERR_NOLOCK);

  // Call the read-write routine for a write operation
  status = readWriteSectors(physicalDisk, logicalSector, numSectors,
			    dataPointer, IOMODE_WRITE);

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Unlock the disk
  kernelLockRelease(&(physicalDisk->diskLock));

  return (status);
}
 

int kernelDiskReadAbsoluteSectors(const char *diskName,
				  unsigned absoluteSector, 
				  unsigned numSectors, void *dataPointer)
{
  // This routine is the user-accessible interface to reading absolute sectors
  // from a physical hard disk.  Basically, it is a gatekeeper that helps
  // ensure correct use of the "read-write" method.  

  int status = 0;
  kernelPhysicalDisk *physicalDisk = NULL;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if ((diskName == NULL) || (dataPointer == NULL))
    return (status = ERR_NULLPARAMETER);

  // Get the disk structure
  physicalDisk = kernelGetPhysicalDiskByName(diskName);
  if (physicalDisk == NULL)
    return (status = ERR_NOSUCHENTRY);

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Lock the disk
  status = kernelLockGet(&(physicalDisk->diskLock));
  if (status < 0)
    return (status = ERR_NOLOCK);

  // Call the read-write routine for a read operation
  status = readWriteSectors(physicalDisk, absoluteSector, numSectors,
			    dataPointer, IOMODE_READ);

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Unlock the disk
  kernelLockRelease(&(physicalDisk->diskLock));

  return (status);
}


int kernelDiskWriteAbsoluteSectors(const char *diskName,
				   unsigned absoluteSector,
				   unsigned numSectors, void *dataPointer)
{
  // This routine is the user-accessible interface to writing absolute sectors
  // from a physical hard disk.  Basically, it is a gatekeeper that helps
  // ensure correct use of the "read-write" method.  

  int status = 0;
  kernelPhysicalDisk *physicalDisk = NULL;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if ((diskName == NULL) || (dataPointer == NULL))
    return (status = ERR_NULLPARAMETER);

  // Get the disk structure
  physicalDisk = kernelGetPhysicalDiskByName(diskName);
  if (physicalDisk == NULL)
    return (status = ERR_NOSUCHENTRY);

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Lock the disk
  status = kernelLockGet(&(physicalDisk->diskLock));
  if (status < 0)
    return (status = ERR_NOLOCK);

  // Call the read-write routine for a read operation
  status = readWriteSectors(physicalDisk, absoluteSector, numSectors,
			    dataPointer, IOMODE_WRITE);

  // Reset the 'idle since' value
  physicalDisk->idleSince = kernelSysTimerRead();
  
  // Unlock the disk
  kernelLockRelease(&(physicalDisk->diskLock));

  return (status);
}
