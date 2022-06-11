//
//  Visopsys
//  Copyright (C) 1998-2004 J. Andrew McLaughlin
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
//  kernelKeyboard.c
//
	
// This is the master code that wraps around the keyboard driver
// functionality

#include "kernelKeyboard.h"
#include "kernelMultitasker.h"
#include "kernelText.h"
#include "kernelWindowManager.h"
#include "kernelError.h"
#include <sys/errors.h>
#include <string.h>


static kernelKeyboard *systemKeyboard = NULL;
static stream *consoleStream = NULL;
static int graphics = 0;
static int initialized = 0;

static kernelKeyMap EN_US = {
  "English (US)",
  // Regular map
  { 27,'1','2','3','4','5','6','7','8','9','0','-','=',8,9,'q',    // 00-0F
    'w','e','r','t','y','u','i','o','p','[',']',10,0,'a','s','d',  // 10=1F
    'f','g','h','j','k','l',';',39,'`',0,'\\','z','x','c','v','b', // 20-2F
    'n','m',',','.','/',0,'*',0,' ',0,0,0,0,0,0,0,                 // 30-3F
    0,0,0,0,0,0,13,17,11,'-',18,'5',19,'+',0,20,                   // 40-4F
    12,0,127,0,0,0                                                 // 50-55
  },
  // Shift map
  { 27,'!','@','#','$','%','^','&','*','(',')','_','+',8,9,'Q',	   // 00-0F
    'W','E','R','T','Y','U','I','O','P','{','}',10,0,'A','S','D',  // 10=1F 
    'F','G','H','J','K','L',':','"','~',0,'|','Z','X','C','V','B', // 20-2F
    'N','M','<','>','?',0,'*',0,' ',0,0,0,0,0,0,0,        	   // 30-3F
    0,0,0,0,0,0,'7','8','9','-','4','5','6','+','1','2',	   // 40-4F
    '3','0','.',0,0,0                				   // 50-55
  },
  // Control map
  { 27, '1','2','3','4','5','6','7','8','9','0','-','=',8,9,17,    // 00-0F
    23,5,18,20,25,21,9,15,16,'[',']',10,0,1,19,4,		   // 10=1F 
    6,7,8,10,11,12,';','"','`',0,0,26,24,3,22,2,    		   // 20-2F
    14,13,',','.','/',0,'*',0,' ',0,0,0,0,0,0,0,		   // 30-3F
    0,0,0,0,0,0,13,17,11,'-',18,'5',19,'+','1',20,		   // 40-4F
    12,'0',127,0,0,0                				   // 50-55
  }
};

static kernelKeyMap EN_UK = {
  "English (UK)",
  // Regular map
  { 27,'1','2','3','4','5','6','7','8','9','0','-','=',8,9,'q',    // 00-0F
    'w','e','r','t','y','u','i','o','p','[',']',10,0,'a','s','d',  // 10=1F
    'f','g','h','j','k','l',';',39,'`',0,'#','z','x','c','v','b',  // 20-2F
    'n','m',',','.','/',0,'*',0,' ',0,0,0,0,0,0,0,                 // 30-3F
    0,0,0,0,0,0,13,17,11,'-',18,'5',19,'+','1',20,                 // 40-4F
    12,'0',127,0,0,'\\'                                            // 50-55
  },
  // Shift map
  { 27,'!','"',156,'$','%','^','&','*','(',')','_','+',8,9,'Q',	   // 00-0F
    'W','E','R','T','Y','U','I','O','P','{','}',10,0,'A','S','D',  // 10=1F 
    'F','G','H','J','K','L',':', '@',170,0,'~','Z','X','C','V','B',// 20-2F
    'N','M','<','>','?',0,'*',0,' ',0,0,0,0,0,0,0,        	   // 30-3F
    0,0,0,0,0,0,'7','8','9','-','4','5','6','+','1','2',	   // 40-4F
    '3','0','.',0,0,'|'                				   // 50-55
  },
  // Control map
  { 27, '1','2','3','4','5','6','7','8','9','0','-','=',8,9,17,	   // 00-0F
    23,5,18,20,25,21,9,15,16,'[',']',10,0,1,19,4,		   // 10=1F 
    6,7,8,10,11,12,';', '@','`',0,0,26,24,3,22,2,    		   // 20-2F
    14,13,',','.','/',0,'*',0,' ',0,0,0,0,0,0,0,		   // 30-3F
    0,0,0,0,0,0,13,17,11,'-',18,'5',19,'+','1',20,		   // 40-4F
    12,'0',127,0,0,0                				   // 50-55
  }
};

static kernelKeyMap *allMaps[] = {
  &EN_US, &EN_UK, NULL
};


/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
//
//  Below here, the functions are exported for external use
//
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////


int kernelKeyboardRegisterDevice(kernelKeyboard *theKeyboard)
{
  // This routine will register a new keyboard.  It takes a 
  // kernelKeyboard structure and returns 0 if successful.

  int status = 0;

  if (theKeyboard == NULL)
    {
      kernelError(kernel_error, "The keyboard is NULL");
      return (status = ERR_NULLPARAMETER);
    }

  // Make sure that the device has a non-NULL driver
  if (theKeyboard->driver == NULL)
    {
      kernelError(kernel_error, "The driver is NULL");
      return (status = ERR_NOSUCHDRIVER);
    }

  // If the driver has a 'register device' function, call it
  if (theKeyboard->driver->driverRegisterDevice)
    status = theKeyboard->driver->driverRegisterDevice(theKeyboard);

  // Alright.  We'll save the pointer to the device
  systemKeyboard = theKeyboard;

  return (status);
}


int kernelKeyboardInitialize(void)
{
  // This function initializes the keyboard code, and sets the default
  // keyboard mapping

  int status = 0;

  // Check the keyboard device before proceeding
  if (systemKeyboard == NULL)
    {
      kernelError(kernel_error, "The keyboard is NULL");
      return (status = ERR_NULLPARAMETER);
    }

  // We use US English as default, because, well, Americans would be so
  // confused if it wasn't.  Everyone else understands the concept of
  // setting it.
  systemKeyboard->keyMap = &EN_US;

  initialized = 1;

  return (status = 0);
}


int kernelKeyboardGetMaps(char *buffer, unsigned size)
{
  // Get the names of the different available keyboard mappings
  
  int status = 0;
  int buffCount = 0;
  int bytes = 0;
  int names = 1;
  int count;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if (buffer == NULL)
    return (status = ERR_NULLPARAMETER);

  // First, copy the name of the current map
  bytes = strlen(systemKeyboard->keyMap->name) + 1;
  strncpy(buffer, systemKeyboard->keyMap->name, size);
  buffer += bytes;
  buffCount += bytes;

  // Loop through our allMaps structure, copying the rest of the names into
  // the buffer
  for (count = 0; allMaps[count] != NULL; count ++)
    {
      bytes = strlen(allMaps[count]->name) + 1;

      if ((allMaps[count] != systemKeyboard->keyMap) &&
	  ((buffCount + bytes) < size))
	{
	  strcpy(buffer, allMaps[count]->name);
	  buffer += bytes;
	  buffCount += bytes;
	  names += 1;
	}
    }

  // Return the number of names
  return (names);
}


int kernelKeyboardSetMap(const char *name)
{
  // Set the current keyboard mapping by name.
  
  int status = 0;
  int count;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Check params
  if (name == NULL)
    return (status = ERR_NULLPARAMETER);

  // Loop through our allMaps structure, looking for the one whose name
  // matches the supplied one
  for (count = 0; allMaps[count] != NULL; count ++)
    {
      if (!strcmp(allMaps[count]->name, name))
	{
	  // Found it.  Set the mapping.
	  systemKeyboard->keyMap = allMaps[count];
	  return (status = 0);
	}
    }

  // If we fall through to here, it wasn't found
  kernelError(kernel_error, "No such keyboard map \"%s\"", name);
  return (status = ERR_INVALID);
}


int kernelKeyboardSetStream(stream *newStream)
{
  // Set the current stream used by the keyboard driver
  
  int status = 0;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Are graphics enabled?
  graphics = kernelGraphicsAreEnabled();

  // Save the address of the kernelStream we were passed to use for
  // keyboard data
  consoleStream = newStream;

  return (status = 0);
}


int kernelKeyboardReadData(void)
{
  // This function calls the keyboard driver to read data from the
  // device.  It pretty much just calls the associated driver routine.

  int status = 0;

  if (!initialized)
    return (status = ERR_NOTINITIALIZED);

  // Now make sure the device driver 'read data' routine has been installed
  if (systemKeyboard->driver->driverReadData == NULL)
    {
      kernelError(kernel_error, "The driver function is NULL");
      return (status = ERR_NOSUCHFUNCTION);
    }

  // Ok, now we can call the routine.
  systemKeyboard->driver->driverReadData();

  return (status = 0);
}


int kernelKeyboardInput(int ascii, int eventType)
{
  // This gets called by the keyboard driver to tell us that a key has been
  // pressed.
  windowEvent event;

  if (graphics)
    {
      // Fill out our event
      event.type = eventType;
      event.xPosition = 0;
      event.yPosition = 0;
      event.key = ascii;

      // Notify the window manager of the event
      kernelWindowProcessEvent(&event);
    }
  else
    {
      if (consoleStream && (eventType & EVENT_KEY_DOWN))
	consoleStream->append(consoleStream, (char) ascii);
    }

  return (0);
}
