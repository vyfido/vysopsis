//
//  Visopsys
//  Copyright (C) 1998-2007 J. Andrew McLaughlin
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
//  loadfont.c
//

// Calls the kernel to switch to the named font.

/* This is the text that appears when a user requests help about this program
<help>

 -- loadfont --

Switch the default font.

Usage:
  loadfont [-f] <font_file> <font_name>

(Only available in graphics mode)

This command will switch the current default font to the one specified.
The first parameter is the name of the file containing the font definition.
The second parameter is a symbolic name to assign to the font.

Example:
  loadfont /system/fonts/arial-bold-12.bmp arial-bold-12

This command is of only marginal usefulness to most users.  It is primarily
intended for testing new font definitions.

Options:
-f  : Display the font in fixed-width mode

</help>
*/

#include <stdio.h>
#include <string.h>
#include <unistd.h>
#include <errno.h>
#include <sys/vsh.h>
#include <sys/api.h>


static void usage(char *name)
{
  printf("usage:\n");
  printf("%s [-f] <font file> <font name>\n", name);
  return;
}


int main(int argc, char *argv[])
{
  int status = 0;
  char *fileName = NULL;
  char *fontName = NULL;
  int fixedWidth = 0;
  objectKey font;

  // Only work in graphics mode
  if (!graphicsAreEnabled())
    {
      printf("\nThe \"%s\" command only works in graphics mode\n", argv[0]);
      errno = ERR_NOTINITIALIZED;
      return (status = errno);
    }

  // Check for -f ('fixed width') option
  if (getopt(argc, argv, "f") == 'f')
    fixedWidth = 1;

  if (argc < 3)
    {
      usage(argv[0]);
      errno = ERR_ARGUMENTCOUNT;
      return (status = errno);
    }
  
  fileName = argv[argc - 2];
  fontName = argv[argc - 1];

  // Call the kernel to load the font
  status = fontLoad(fileName, fontName, &font, fixedWidth);
  if (status < 0)
    {
      errno = status;
      perror(argv[0]);
      return (status);
    }

  // Switch to it
  fontSetDefault(fontName);

  errno = status;
  return (status);
}
