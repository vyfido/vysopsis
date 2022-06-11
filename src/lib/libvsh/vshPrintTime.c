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
//  vshPrintTime.c
//

// This contains some useful functions written for the shell

#include <stdio.h>
#include <sys/vsh.h>


_X_ void vshPrintTime(char *buffer, unsigned unformattedTime)
{
  // Desc: Print the packed time value, specified by the unsigned integer 'unformattedTime' -- such as that found in the file.modifiedTime field -- into 'buffer' in a (for now, arbitrary) human-readable format to standard output.

  int seconds = (unformattedTime & 0x0000003F);
  int minutes = ((unformattedTime & 0x00000FC0) >> 6);
  int hours = ((unformattedTime & 0x0003F000) >> 12);

  sprintf(buffer, "%02u:%02u:%02u", hours, minutes, seconds);

  return;
}
