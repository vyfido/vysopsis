//
//  Visopsys
//  Copyright (C) 1998-2003 J. Andrew McLaughlin
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
//  printf.c
//

// This is the standard "printf" function, as found in standard C libraries

#include <stdio.h>
#include <stdarg.h>
#include <string.h>
#include <errno.h>
#include <sys/api.h>


int printf(const char *format, ...)
{
  va_list list;
  int outputlen = 0;
  char output[MAXSTRINGLENGTH];
  
  // We don't set errno in this function
  errno = 0;

  // Initialize the argument list
  va_start(list, format);

  // Fill out the output line based on 
  outputlen = _expandFormatString(output, format, list);

  va_end(list);

  if (!errno)
    textPrint(output);
  
  return (outputlen);
}
