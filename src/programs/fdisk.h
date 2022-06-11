//
//  Visopsys
//  Copyright (C) 1998-2005 J. Andrew McLaughlin
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
//  fdisk.h
//

// This is the header for the "Disk Manager" program, fdisk.c

#if !defined(_FDISK_H)

#include <sys/disk.h>

#define DISK_MANAGER     "Visopsys Disk Manager"
#define PARTITION_LOGIC  "Partition Logic"
#define TEMP_DIR         "/temp"
#define BOOT_DIR         "/system/boot"
#define BACKUP_MBR       BOOT_DIR"/backup-%s.mbr"
#define SIMPLE_MBR_FILE  BOOT_DIR"/mbr.simple"
#define PERM             "You must be a privileged user to use this " \
                         "command.\n(Try logging in as user \"admin\")"
#define PARTTYPES        "Supported partition types"

#define ENTRYOFFSET_DRV_ACTIVE    0
#define ENTRYOFFSET_START_HEAD    1
#define ENTRYOFFSET_START_CYLSECT 2
#define ENTRYOFFSET_START_CYL     3
#define ENTRYOFFSET_TYPE          4
#define ENTRYOFFSET_END_HEAD      5
#define ENTRYOFFSET_END_CYLSECT   6
#define ENTRYOFFSET_END_CYL       7
#define ENTRYOFFSET_START_LBA     8
#define ENTRYOFFSET_SIZE_LBA      12
#define COPYBUFFER_SIZE           1048576 // 1 Meg
#define MAX_SLICES                ((DISK_MAX_PARTITIONS * 2) + 1)
#define MAX_DESCSTRING_LENGTH     128

#ifdef PARTLOGIC
#define SLICESTRING_DISKFIELD_WIDTH    3
#else
#define SLICESTRING_DISKFIELD_WIDTH    5
#endif
#define SLICESTRING_LABELFIELD_WIDTH   22
#define SLICESTRING_FSTYPEFIELD_WIDTH  6
#define SLICESTRING_CYLSFIELD_WIDTH    12
#define SLICESTRING_SIZEFIELD_WIDTH    9
#define SLICESTRING_ATTRIBFIELD_WIDTH  15
#define SLICESTRING_LENGTH (SLICESTRING_DISKFIELD_WIDTH +   \
			    SLICESTRING_LABELFIELD_WIDTH +  \
			    SLICESTRING_FSTYPEFIELD_WIDTH + \
			    SLICESTRING_CYLSFIELD_WIDTH +   \
			    SLICESTRING_SIZEFIELD_WIDTH +   \
			    SLICESTRING_ATTRIBFIELD_WIDTH)

#define ISLOGICAL(slc) (((slc)->entryType == partition_extended) || \
                        ((slc)->entryType == partition_logical))

typedef enum {
  partition_primary  = 1,
  partition_logical  = 2,
  partition_extended = 3,
  partition_any      = 4
} partEntryType;

// This stucture represents both used partitions and empty spaces.
typedef struct {
  // These fields come directly from the partition table
  int active;
  unsigned startCylinder;
  unsigned startHead;
  unsigned startSector;
  int typeId;
  unsigned endCylinder;
  unsigned endHead;
  unsigned endSector;
  unsigned startLogical;
  unsigned sizeLogical;
  // Below here, the fields are generated internally
  int sliceId;
  partEntryType entryType;
  int partition;
  char name1[6];
  char fsType[FSTYPE_MAX_NAMELENGTH];
  void *extendedTable;
  char string[MAX_DESCSTRING_LENGTH];
  int pixelX;
  int pixelWidth;

} slice;

// This structure represents a partition table
typedef struct {
  unsigned startSector;
  unsigned char sectorData[512];
  slice entries[DISK_MAX_PRIMARY_PARTITIONS];
  int numberEntries;
  int maxEntries;
  // For extended partition tables
  int extended;
  int parentSliceId;

} partitionTable;

// A struct for managing concurrent read/write IO during things like
// disk-to-disk copies
typedef struct {
  struct {
    unsigned char *data;
    int full;
  } buffer[2];
  unsigned bufferSize;

} ioBuffer;

// Arguments for the reader/writer threads during things like disk-to-disk
// copies
typedef struct {
  disk *theDisk;
  unsigned startSector;
  unsigned numSectors;
  ioBuffer *buffer;
  int showProgress;
  objectKey progressBar;
  objectKey statusLabel;

} ioThreadArgs;

#define _FDISK_H
#endif
