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
//  _xpndfmt.c
//

// This function does all the work of expanding the format strings used
// by the printf family of functions (and others, if desired)

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <stdarg.h>
#include <errno.h>
#include <sys/api.h>


static int numDigits(unsigned foo, unsigned base)
{
  int digits = 1;
  while (foo >= base)
    {
      digits++;
      foo /= base;
    }
  return (digits);
}


int _expandFormatString(char *output, const char *format, va_list list)
{
  int inCount = 0;
  int outCount = 0;
  int formatlen = 0;
  void *argument = NULL;
  int zeroPad = 0;
  int fieldWidth = 0; 
  int isLong = 0;
  int digits = 0;

  // How long is the format string?
  formatlen = strlen(format);
  if (formatlen > MAXSTRINGLENGTH)
    return (errno = ERR_BOUNDS);

  // The argument list must already have been initialized using va_start

  // Loop through all of the characters in the format string
  for (inCount = 0; ((inCount < formatlen) &&
		     (outCount < (MAXSTRINGLENGTH - 1))); )
    {
      if (format[inCount] != '%')
	{
	  output[outCount++] = format[inCount++];
	  continue;
	}
      else if ((format[inCount] == '%') && (format[inCount + 1] == '%'))
	{
	  // Copy it, but skip the next one
	  output[outCount++] = format[inCount];
	  inCount += 2;
	  continue;
	}

      // Move to the next character
      inCount += 1;

      // We have some format characters.  Get the corresponding argument,
      // move to the next format character.
      argument = va_arg(list, void *);

      // Look for a zero digit, which indicates that any field width argument
      // is to be zero-padded
      if (format[inCount] == '0')
	{
	  zeroPad = 1;
	  inCount++;
	}
      else
	zeroPad = 0;

      // Look for field length indicator
      if ((format[inCount] >= '1') && (format[inCount] <= '9'))
	{
	  fieldWidth = atoi(format + inCount);
	  while ((format[inCount] >= '0') && (format[inCount] <= '9'))   
	    inCount++;
        }
      else
	fieldWidth = 0;

      // If there's a 'l' qualifier for long values, make note of it
      if (format[inCount] == 'l')
	{
	  isLong = 1;
	  inCount += 1;
	}
      else
	isLong = 0;

      // What is it?
      switch(format[inCount])
	{
	case 'd':
	case 'i':
	  // This is an integer.  Put the characters for the integer
	  // into the destination string
          if (fieldWidth)
            {
              digits = numDigits((unsigned) argument, 10);
              while (digits++ < fieldWidth)
                output[outCount++] = (zeroPad? '0' : ' ');
            }
	  itoa((int) argument, (output + outCount));
	  outCount = strlen(output);
	  break;

	case 'u':
	  // This is an unsigned integer.  Put the characters for
	  // the integer into the destination string
	  if (fieldWidth)
	    {
	      digits = numDigits((unsigned) argument, 10);
	      while (digits++ < fieldWidth)
		output[outCount++] = (zeroPad? '0' : ' ');
	    }
	  utoa((unsigned) argument, (output + outCount));
	  outCount = strlen(output);
	  break;

	case 'c':
	  // A character.
	  output[outCount++] = (char) ((unsigned int) argument);
	  break;

	case 's':
	  // This is a string.  Copy the string from the next argument
	  // to the destnation string and increment outCount appropriately
	  if (argument)
	    {
	      strcpy((output + outCount), (char *) argument);
	      outCount += strlen((char *) argument);
	    }
	  else
	    {
	      // Eek.
	      strncpy((output + outCount), "(NULL)", 7);
	      outCount += 6;
	    }
	  break;

	case 'x':
	case 'X':
	  if (fieldWidth)
	    {
	      digits = numDigits((unsigned) argument, 16);
	      while (digits++ < fieldWidth)
		output[outCount++] = (zeroPad? '0' : ' ');
	    }
	  itox((int) argument, (output + outCount));
	  outCount = strlen(output);
	  break;

	default:
	  // Umm, we don't know what this is.  Just copy the '%' and
	  // the format character to the output stream
	  output[outCount++] = format[inCount - 1];
	  output[outCount++] = format[inCount];
	  break;
	}

      inCount += 1;
    }

  output[outCount] = '\0';

  // Return the number of characers we wrote
  return (outCount);
}
