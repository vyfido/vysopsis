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
//  snprintf.c
//

// This is the standard "snprintf" function, as found in standard C libraries

#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <stdarg.h>
#include <sys/cdefs.h>


int snprintf(char *output, size_t size, const char *format, ...)
{
  // This function will construct a single string out of the format
  // string and arguments that are passed, up to 'size' bytes.  Returns the
  // number of characters copied to the output string.

  va_list list;
  char tmpOutput[MAXSTRINGLENGTH];
  int outputLen = 0;

  bzero(tmpOutput, MAXSTRINGLENGTH);

  // Initialize the argument list
  va_start(list, format);

  // Fill out the output line based on 
  outputLen = _expandFormatString(tmpOutput, format, list);

  va_end(list);

  strncpy(output, tmpOutput, size);

  // Return the number of characters we wrote to the string
  return (min(outputLen, (int) size));
}
