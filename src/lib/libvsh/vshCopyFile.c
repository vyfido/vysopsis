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
//  vshCopyFile.c
//

// This contains some useful functions written for the shell

#include <errno.h>
#include <sys/vsh.h>
#include <sys/api.h>


_X_ int vshCopyFile(const char *srcFile, const char *destFile)
{
  // Desc: Copy the file specified by the name 'srcFile' to the filename 'destFile'.  Both filenames must be absolute pathnames, beginning with '/'.
  
  int status = 0;
 
  // Make sure filenames aren't NULL
  if ((srcFile == NULL) || (destFile == NULL))
    return (errno = ERR_NULLPARAMETER);
  
  // Attempt to copy the file
  status = fileCopy(srcFile, destFile);
  if (status < 0)
    return (errno = status);
 
  // Return success
  return (status = 0);
}
