// 
//  Visopsys
//  Copyright (C) 1998-2005 J. Andrew McLaughlin
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
//  atoi.c
//

// This is the standard "atoi" function, as found in standard C libraries

#include <stdlib.h>
#include <string.h>
#include <errno.h>


int atoi(const char *theString)
{
  // Here's how the Linux man page describes this function:
  // The  atoi()  function  converts the initial portion of the
  // string pointed to by nptr to int.  The  behaviour  is  the
  // same as
  //          strtol(nptr, (char **)NULL, 10);
  // 
  // except that atoi() does not detect errors.
  //
  // This one detects errors.

  int result = 0;
  int length = 0;
  int count;

  if (theString == NULL)
    {
      errno = ERR_NULLPARAMETER;
      return (0);
    }

  if ((theString[0] < 48) || (theString[0] > 57))
    // Not a number
    return (errno = ERR_INVALID);

  // Get the length of the string
  length = strlen(theString);

  // Do a loop to iteratively add to the value of 'result'.
  for (count = 0; count < length; count ++)
    {
      // Check to make sure input is numeric ascii
      if ((theString[count] < 48) || (theString[count] > 57))
	// Return whatever we have so far
	return (result);

      result *= 10;
      result += (((int) theString[count]) - 48);
    }
  
  return (result);
}
