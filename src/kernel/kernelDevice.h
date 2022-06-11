//
//  Visopsys
//  Copyright (C) 1998-2006 J. Andrew McLaughlin
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
//  kernelDevice.h
//

// Describes the generic description/classification mechanism for hardware
// devices.

#if !defined(_KERNELDEVICE_H)

#include "kernelDriver.h"
#include <sys/device.h>

// A structure for device classes and subclasses, which just allows us to
// associate the different types with string names.
typedef struct {
  int class;
  char *name;

} kernelDeviceClass;

// The generic hardware device structure
typedef struct {
  struct {
    // Device class and subclass.  Subclass optional.
    kernelDeviceClass *class;
    kernelDeviceClass *subClass;

    // Optional, vendor-specific model name
    char *model;

    // Used for maintaining the list of devices as a tree
    void *parent;
    void *firstChild;
    void *previous;
    void *next;

  } device;

  // Driver
  kernelDriver *driver;
  // Device class-specific structure
  void *data;

} kernelDevice;

// Functions exported from kernelDevice.c
int kernelDeviceInitialize(void);
int kernelDeviceDetectDisplay(void);
int kernelDeviceDetect(void);
kernelDeviceClass *kernelDeviceGetClass(int);
int kernelDeviceFindType(kernelDeviceClass *, kernelDeviceClass *,
			 kernelDevice *[], int);
int kernelDeviceHotplug(kernelDevice *, int, int, int, int);
int kernelDeviceAdd(kernelDevice *, kernelDevice *);
int kernelDeviceRemove(kernelDevice *);
// These ones are exported outside the kernel
int kernelDeviceTreeGetCount(void);
int kernelDeviceTreeGetRoot(device *);
int kernelDeviceTreeGetChild(device *, device *);
int kernelDeviceTreeGetNext(device *);

#define _KERNELDEVICE_H
#endif
