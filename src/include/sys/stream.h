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
//  stream.h
//

// This file contains definitions and structures for using and manipulating
// streams in Visopsys.

#if !defined(_STREAM_H)

#include <sys/file.h>

// An enum for describing the size of each item in the stream
typedef enum { itemsize_char, itemsize_int } streamItemSize;

// This data structure is the generic stream
typedef struct
{
  unsigned char *buffer;
  int size;
  int first;
  int next;
  int count;

  // Stream functions
  int (*clear) (void *);
  int (*intercept) (void *, ...);
  int (*append) (void *, ...);
  int (*appendN) (void *, int, ...);
  int (*push) (void *, ...);
  int (*pushN) (void *, int, ...);
  int (*pop) (void *, ...);
  int (*popN) (void *, int, ...);

} stream;


// Some specialized kinds of streams

// A file stream, for character-based file IO

typedef struct 
{
  file f;
  unsigned int block;
  int dirty;
  stream *s;

} fileStream;

#define _STREAM_H
#endif
