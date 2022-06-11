//
//  Visopsys
//  Copyright (C) 1998-2005 J. Andrew McLaughlin
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
//  kernelKeyboardDriver.c
//

// Driver for standard PC keyboards

#include "kernelDriverManagement.h" // Contains my prototypes
#include "kernelProcessorX86.h"
#include "kernelMultitasker.h"
#include "kernelWindow.h"
#include "kernelShutdown.h"
#include "kernelFile.h"
#include "kernelMiscFunctions.h"
#include "kernelError.h"
#include <string.h>
#include <stdio.h>
#include <sys/window.h>
#include <sys/stream.h>

int kernelKeyboardDriverRegisterDevice(void *);
int kernelKeyboardDriverSetStream(stream *);
void kernelKeyboardDriverReadData(void);

// Some special scan values that we care about
#define KEY_RELEASE      128
#define EXTENDED         224
#define LEFT_SHIFT       42
#define RIGHT_SHIFT      54
#define LEFT_CTRL        29
#define LEFT_ALT         56
#define ASTERISK_KEY     55
#define F1_KEY           59
#define F2_KEY           60
#define F3_KEY           61
#define PAGEUP_KEY       73
#define PAGEDOWN_KEY     81
#define DEL_KEY          83
#define CAPSLOCK         58
#define NUMLOCK          69
#define SCROLLLOCK       70

#define INSERT_FLAG      0x80
#define CAPSLOCK_FLAG    0x40
#define NUMLOCK_FLAG     0x20
#define SCROLLLOCK_FLAG  0x10
#define ALT_FLAG         0x08
#define CONTROL_FLAG     0x04
#define SHIFT_FLAG       0x03

#define SCROLLLOCK_LIGHT 0
#define NUMLOCK_LIGHT    1
#define CAPSLOCK_LIGHT   2

static kernelKeyboardDriver defaultKeyboardDriver =
{
  kernelKeyboardDriverInitialize,
  kernelKeyboardDriverRegisterDevice,
  kernelKeyboardDriverReadData
};

static kernelKeyboard *theKeyboard = NULL;
static int initialized = 0;


static void setLight(int whichLight, int onOff)
{
  // Turns the keyboard lights on/off

  unsigned char data = 0;
  static unsigned char lights = 0x00;

  // Wait for port 60h to be ready for a command.  We know it's
  // ready when port 0x64 bit 1 is 0
  data = 0x02;
  while (data & 0x02)
    kernelProcessorInPort8(0x64, data);

  // Tell the keyboard we want to change the light status
  kernelProcessorOutPort8(0x60, 0xED);

  if (onOff)
    lights |= (0x01 << whichLight);
  else
    lights &= (0xFF ^ (0x01 << whichLight));

  // Wait for port 60h to be ready for a command.  We know it's
  // ready when port 0x64 bit 1 is 0
  data = 0x02;
  while (data & 0x02)
    kernelProcessorInPort8(0x64, data);

  // Tell the keyboard to change the lights
  kernelProcessorOutPort8(0x60, lights);

  // Read the ACK
  data = 0;
  while (!(data & 0x01))
    kernelProcessorInPort8(0x64, data);
  kernelProcessorInPort8(0x60, data);
  
  return;
}


static void rebootThread(void)
{
  // This gets called when the user presses CTRL-ALT-DEL.

  // Reboot, force
  kernelShutdown(1, 1);
  while(1);
}


static void screenshotThread(void)
{
  // This gets called when the user presses the 'print screen' key

  char fileName[32];
  file theFile;
  int count = 1;

  // Determine the file name we want to use

  strcpy(fileName, "/screenshot1.bmp");

  // Loop until we get a filename that doesn't already exist
  while (!kernelFileFind(fileName, &theFile))
    {
      count += 1;
      sprintf(fileName, "/screenshot%d.bmp", count);
    }

  kernelMultitaskerTerminate(kernelWindowSaveScreenShot(fileName));
}


/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
//
// Below here, the functions are exported for external use
//
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////


int kernelKeyboardDriverInitialize(void)
{
  // This routine issues the appropriate commands to the keyboard controller
  // to set keyboard settings.

  unsigned char data;

  // Wait for port 64h to be ready for a command.  We know it's ready when
  // port 64 bit 1 is 0
  data = 0x02;
  while (data & 0x02)
    kernelProcessorInPort8(0x64, data);

  // Tell the keyboard to enable
  kernelProcessorOutPort8(0x64, 0xAE);

  initialized = 1;
  return (kernelDriverRegister(keyboardDriver, &defaultKeyboardDriver));
}


int kernelKeyboardDriverRegisterDevice(void *keyboardPointer)
{
  // Just save a pointer to the device structure

  // Check params
  if (keyboardPointer == NULL)
    {
      kernelError(kernel_error, "NULL keyboard pointer");
      return (ERR_NULLPARAMETER);
    }

  theKeyboard = (kernelKeyboard *) keyboardPointer;
  return (0);
}


void kernelKeyboardDriverReadData(void)
{
  // This routine reads the keyboard data and returns it to the keyboard
  // console text input stream

  unsigned char data = 0;
  int release = 0;
  static int extended = 0;

  if (!initialized)
    return;

  // Wait for keyboard data to be available
  while (!(data & 0x01))
    kernelProcessorInPort8(0x64, data);

  // Read the data from port 60h
  kernelProcessorInPort8(0x60, data);

  // If an extended scan code is coming next...
  if (data == EXTENDED)
    {
      // The next thing coming is an extended scan code.  Set the flag
      // so it can be collected next time
      extended = 1;
      return;
    }

  // Key press or key release?
  if (data >= KEY_RELEASE)
    {
      // This is a key release.  We only care about a couple of cases if
      // it's a key release.

      switch (data)
	{
	case (KEY_RELEASE + LEFT_SHIFT):
	case (KEY_RELEASE + RIGHT_SHIFT):
	  // Left or right shift release.
	  theKeyboard->flags &= ~SHIFT_FLAG;
	  return;
	case (KEY_RELEASE + LEFT_CTRL):
	  // Left control release.
	  theKeyboard->flags &= ~CONTROL_FLAG;
	  return;
	case (KEY_RELEASE + LEFT_ALT):
	  // Left Alt release.
	  theKeyboard->flags &= ~ALT_FLAG;
	  return;
	default:
	  data -= KEY_RELEASE;
	  release = 1;
	  break;
	}
    }

  else
    {
      // Regular key.

      switch (data)
	{
	case LEFT_SHIFT:
	case RIGHT_SHIFT:
	  // Left shift or right shift press.
	  theKeyboard->flags |= SHIFT_FLAG;
	  return;
	case LEFT_CTRL:
	  // Left control press.
	  theKeyboard->flags |= CONTROL_FLAG;
	  return;
	case LEFT_ALT:
	  // Left alt press.
	  theKeyboard->flags |= ALT_FLAG;
	  return;
	case CAPSLOCK:
	  if (theKeyboard->flags & CAPSLOCK_FLAG)
	    // Capslock off
	    theKeyboard->flags ^= CAPSLOCK_FLAG;
	  else
	    // Capslock on
	    theKeyboard->flags |= CAPSLOCK_FLAG;
	  setLight(CAPSLOCK_LIGHT, (theKeyboard->flags & CAPSLOCK_FLAG));
	  return;
	case NUMLOCK:
	  if (theKeyboard->flags & NUMLOCK_FLAG)
	    // Numlock off
	    theKeyboard->flags ^= NUMLOCK_FLAG;
	  else
	    // Numlock on
	    theKeyboard->flags |= NUMLOCK_FLAG;
	  setLight(NUMLOCK_LIGHT, (theKeyboard->flags & NUMLOCK_FLAG));
	  return;
	case SCROLLLOCK:
	  if (theKeyboard->flags & SCROLLLOCK_FLAG)
	    // Scroll lock off
	    theKeyboard->flags ^= SCROLLLOCK_FLAG;
	  else
	    // Scroll lock on
	    theKeyboard->flags |= SCROLLLOCK_FLAG;
	  setLight(SCROLLLOCK_LIGHT, (theKeyboard->flags & SCROLLLOCK_FLAG));
	  return;
	case F1_KEY:
	  kernelConsoleLogin();
	  return;
	case F2_KEY:
	  kernelMultitaskerDumpProcessList();
	  return;
	case F3_KEY:
	  kernelWindowDumpList();
	  return;
	default:
	  break;
	}
    }
     
  // If this is an 'extended' asterisk (*), we probably have a 'print screen'
  // or 'sys req'.
  if (extended && (data == ASTERISK_KEY) && !release)
    {
      kernelMultitaskerSpawn(screenshotThread, "screenshot", 0, NULL);
      // Clear the extended flag
      extended = 0;
      return;
    }

  // Check whether the control or shift keys are pressed.  Shift
  // overrides control.
  if (!extended && ((theKeyboard->flags & SHIFT_FLAG) ||
		    ((theKeyboard->flags & NUMLOCK_FLAG) &&
		     (data >= 0x47) && (data <= 0x53))))
    data = theKeyboard->keyMap->shiftMap[data - 1];
  
  else if (theKeyboard->flags & CONTROL_FLAG)
    {
      // CTRL-ALT-DEL?
      if ((theKeyboard->flags & ALT_FLAG) && (data == DEL_KEY) && release)
	{
	  // CTRL-ALT-DEL means reboot
	  kernelMultitaskerSpawn(rebootThread, "reboot", 0, NULL);
	  return;
	}
      else
	data = theKeyboard->keyMap->controlMap[data - 1];
    }
  
  else
    data = theKeyboard->keyMap->regMap[data - 1];
      
  // If capslock is on, uppercase any alphabetic characters
  if ((theKeyboard->flags & CAPSLOCK_FLAG) &&
      ((data >= 'a') && (data <= 'z')))
    data -= 32;
  
  // Notify the keyboard function of the event
  if (release)
    kernelKeyboardInput((int) data, EVENT_KEY_UP);
  else
    kernelKeyboardInput((int) data, EVENT_KEY_DOWN);
  
  // Clear the extended flag
  extended = 0;
  return;
}
