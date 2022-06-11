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
//  strchr.c
//

// This is the standard "strchr" function, as found in standard C libraries

// The strchr() function returns a pointer to the first occurrence of the
// character in the string.

#include <string.h>


char *strchr(const char *string, int character)
{
	// Check params
	if (string == NULL)
		return ((char *) string);

	while (string[0] != '\0')
	{
		if (string[0] == (char) character)
			return ((char *) string);
		string += 1;
	}

	// Return failure
	return (NULL);
}
