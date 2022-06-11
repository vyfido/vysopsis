//
//  Visopsys
//  Copyright (C) 1998-2011 J. Andrew McLaughlin
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
//  kernelMalloc.c
//
	
// These routines are wrapper functions around the now-external, libc
// malloc functions which also work for the kernel.

#include "kernelDebug.h"
#include "kernelMalloc.h"
#include "kernelLock.h"
#include "kernelMemory.h"
#include "kernelMisc.h"
#include "kernelMultitasker.h"
#include "kernelParameters.h"
#include "kernelError.h"
#include <stdlib.h>
#include <sys/memory.h>

static int initialized = 0;


/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
//
//  Below here, the functions are exported for external use
//
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////


void *_kernelMalloc(unsigned size, const char *function)
{
  // Just like a malloc(), for kernel memory, but the data is cleared like
  // calloc.

  void *address = NULL;

  if (!initialized)
    {
      // Set up malloc()'s kernel operations pointers
      kernelMemClear(&mallocKernOps, sizeof(mallocKernelOps));
      mallocKernOps.multitaskerGetCurrentProcessId =
	&kernelMultitaskerGetCurrentProcessId;
      mallocKernOps.memoryGet = &kernelMemoryGetSystem;
      mallocKernOps.memoryRelease = &kernelMemoryRelease;
      mallocKernOps.lockGet = &kernelLockGet;
      mallocKernOps.lockRelease = &kernelLockRelease;
#if defined(DEBUG)
      mallocKernOps.debug = &kernelDebugOutput;
#endif
      mallocKernOps.error = &kernelErrorOutput;
      mallocHeapMultiple = KERNEL_MEMORY_HEAP_MULTIPLE;
      initialized = 1;
    }

  address = _doMalloc(size, function);

  // If we got the memory, clear it.
  if (address != NULL)
    kernelMemClear(address, size);

  return (address);
}


int _kernelFree(void *start, const char *function)
{
  // Just like free(), for kernel memory

  // Make sure we've been initialized
  if (!initialized)
    return (ERR_NOTINITIALIZED);

  // The start address must be in kernel address space
  if (start < (void *) KERNEL_VIRTUAL_ADDRESS)
    {
      kernelError(kernel_error, "The kernel memory block to release is not "
		  "in the kernel's address space (%s)", function);
      return (ERR_INVALID);
    }

  _doFree(start, function);
  return (0);
}


void *_kernelRealloc(void *oldAddress, size_t size, const char *function)
{
  // Just like realloc(), for kernel memory.

  int status = 0;
  memoryBlock oldBlock;
  void *address = NULL;

  if (oldAddress == NULL)
    return (address = _kernelMalloc(size, function));

  else if (!size)
    {
      _kernelFree(oldAddress, function);
      return (address = NULL);
    }

  // Get stats about the old memory
  status = _mallocBlockInfo(oldAddress, &oldBlock);
  if (status < 0)
    return (address = NULL);
  
  address = _kernelMalloc(size, function);

  if (address)
    {
      size = min(size, ((oldBlock.endLocation - oldBlock.startLocation) + 1));
      kernelMemCopy(oldAddress, address, size);
      _kernelFree(oldAddress, function);
    }

  // Return this value, whether or not we were successful
  return (address);
}


int kernelMallocGetStats(memoryStats *stats)
{
  // Return kernelMalloc memory usage statistics
  
  // Make sure we've been initialized
  if (!initialized)
    return (ERR_NOTINITIALIZED);
  
  return (_mallocGetStats(stats));
}


int kernelMallocGetBlocks(memoryBlock *blocksArray, int doBlocks)
{
  // Fill a memoryBlock array with 'doBlocks' used kernelMalloc blocks
  // information
  
  // Make sure we've been initialized
  if (!initialized)
    return (ERR_NOTINITIALIZED);
  
  return (_mallocGetBlocks(blocksArray, doBlocks));
}
