// 
//  Visopsys
//  Copyright (C) 1998-2014 J. Andrew McLaughlin
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
//  Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
//
//  sscanf.c
//

// This is the standard "sscanf" function, as found in standard C libraries

#include <stdarg.h>
#include <stdio.h>
#include <sys/cdefs.h>


int sscanf(const char *input, const char *format, ...)
{
	// This function will scan input using the format string and arguments that
	// are passed.  Returns the number of data items scanned from the input.

	va_list list;
	int inputItems = 0;

	// Initialize the argument list
	va_start(list, format);

	// Fill out the output line based on 
	inputItems = _fmtinpt(input, format, list);

	va_end(list);

	// Return the number of items we scanned.
	return (inputItems);
}
