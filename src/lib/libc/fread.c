// 
//  Visopsys
//  Copyright (C) 1998-2006 J. Andrew McLaughlin
//  
//  This library is free software; you can redistribute it and/or modify it
//  under the terms of the GNU Lesser General Public License as published by
//  the Free Software Foundation; either version 2.1 of the License, or (at
//  your option) any later version.
//
//  This library is distributed in the hope that it will be useful, but
//  WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser
//  General Public License for more details.
//
//  You should have received a copy of the GNU Lesser General Public License
//  along with this library; if not, write to the Free Software Foundation,
//  Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
//
//  fread.c
//

// This is the standard "fread" function, as found in standard C libraries

#include <stdio.h>
#include <errno.h>
#include <sys/api.h>


size_t fread(void *buf, size_t size, size_t number, FILE *theStream)
{
  // Read 'size' bytes from the stream 'number' times
  
  int status = 0;
  unsigned count;

  if (visopsys_in_kernel)
    return (errno = ERR_BUG);

  for (count = 0 ; count < number; count ++)
    {
      if (theStream == stdin)
	status = textInputStreamReadN(multitaskerGetTextInput(), size,
				      (void *) (buf + (count * size)));
      else
	status =
	  fileStreamRead(theStream, size, (void *) (buf + (count * size)));

      if (status < 0)
	return (errno = status);
    }

  return (count);
}
