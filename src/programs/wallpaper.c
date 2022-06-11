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
//  wallpaper.c
//

// Calls the kernel's window manager to change the background image

#include <stdio.h>
#include <string.h>
#include <sys/api.h>


static void usage(char *name)
{
  printf("usage:\n");
  printf("%s <image file>\n", name);
  return;
}


static void makeAbsolutePath(const char *orig, char *new)
{
  char cwd[MAX_PATH_LENGTH];

  if ((orig[0] != '/') && (orig[0] != '\\'))
    {
      multitaskerGetCurrentDirectory(cwd, MAX_PATH_LENGTH);

      strcpy(new, cwd);

      if ((new[strlen(new) - 1] != '/') &&
	  (new[strlen(new) - 1] != '\\'))
	strncat(new, "/", 1);

      strcat(new, orig);
    }
  else
    strcpy(new, orig);

  return;
}


int main(int argc, char *argv[])
{
  int status = 0;
  char fileName[MAX_PATH_NAME_LENGTH];

  if (argc != 2)
    {
      usage(argv[0]);
      errno = ERR_ARGUMENTCOUNT;
      return (status = errno);
    }

  // Make sure the file name is complete
  makeAbsolutePath(argv[1], fileName);

  status = windowManagerTileBackground(fileName);

  errno = status;
  return (status);
}
