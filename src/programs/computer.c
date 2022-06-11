//
//  Visopsys
//  Copyright (C) 1998-2006 J. Andrew McLaughlin
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
//  computer.c
//

// This is a graphical program for navigating the resources of the computer.
// It displays the disks, etc., and if they are clicked, mounts them (if
// necessary) and launches a file browser at the mount point.

/* This is the text that appears when a user requests help about this program
<help>

 -- computer --

A graphical program for navigating the resources of the computer.

Usage:
  computer

The computer program is interactive, and may only be used in graphics mode.
It displays a window with icons representing (for the moment, anyway, only)
media resources such as floppy disks, hard disks, and CD-ROMs.  Clicking on
an icon will cause the system to attempt to mount (if necessary) the volume
and open a file browser window for that filesystem.

</help>
*/

#include <stdio.h>
#include <stdlib.h>
#include <errno.h>
#include <sys/window.h>
#include <sys/api.h>
#include <sys/cdefs.h>

#define DEFAULT_WINDOWTITLE  "Computer"
#define DEFAULT_ROWS         4
#define DEFAULT_COLUMNS      5
#define FLOPPYDISK_ICONFILE  "/system/icons/floppyicon.ico"
#define HARDDISK_ICONFILE    "/system/icons/diskicon.bmp"
#define CDROMDISK_ICONFILE   "/system/icons/cdromicon.ico"
#define FILE_BROWSER         "/programs/filebrowse"

static int processId;
static int privilege;
static int numDisks = 0;
static disk *disks = NULL;
static listItemParameters *iconParams = NULL;
static char windowTitle[WINDOW_MAX_TITLE_LENGTH];
static objectKey window = NULL;
static objectKey iconList = NULL;


static void error(const char *format, ...)
{
  // Generic error message code

  va_list list;
  char output[MAXSTRINGLENGTH];
  
  va_start(list, format);
  _expandFormatString(output, format, list);
  va_end(list);

  windowNewErrorDialog(window, "Error", output);
}


static int scanComputer(void)
{
  // This gets the list of disks and/or other hardware we're interested in
  // and creates icon parameters for them

  int status = 0;
  char *iconFile = NULL;
  int count;

  // Call the kernel to give us the number of available disks
  numDisks = diskGetCount();
  if (numDisks <= 0)
    return (status = ERR_NOSUCHENTRY);

  disks = malloc(numDisks * sizeof(disk));
  iconParams = malloc(numDisks * sizeof(listItemParameters));
  if ((disks == NULL) || (iconParams == NULL))
    {
      error("Memory allocation error");
      return (status = ERR_MEMORY);
    }

  // Read disk info
  status = diskGetAll(disks, (numDisks * sizeof(disk)));
  if (status < 0)
    // Eek.  Problem getting disk info
    return (status);

  // Get the text, image, and command for each icon
  for (count = 0; count < numDisks; count ++)
    {
      iconFile = HARDDISK_ICONFILE;

      if (disks[count].flags & DISKFLAG_FLOPPY)
	iconFile = FLOPPYDISK_ICONFILE;
      else if (disks[count].flags & DISKFLAG_CDROM)
	iconFile = CDROMDISK_ICONFILE;

      strcpy(iconParams[count].text, disks[count].name);

      // Load the icon image
      status = imageLoad(iconFile, 0, 0, &(iconParams[count].iconImage));
      if (status < 0)
	{
	  error("Can't load icon image %s", iconFile);
	  return (status);
        }
     }

  return (status = 0);
}


static void execProgram(int argc, char *argv[])
{
  // Exec the command, no block
  if (argc == 2)
    loaderLoadAndExec(argv[1], privilege, 0);
  multitaskerTerminate(0);
}


static void eventHandler(objectKey key, windowEvent *event)
{
  int status = 0;
  int clickedIcon = -1;
  char mountPoint[MAX_PATH_LENGTH];
  char command[MAXSTRINGLENGTH];

  // Check for the window being closed by a GUI event.
  if ((key == window) && (event->type == EVENT_WINDOW_CLOSE))
    windowGuiStop();

  // Check for events in our icon list.  We consider the icon 'clicked'
  // if it is a mouse click selection, or an ENTER key selection
  else if ((key == iconList) && (event->type & EVENT_SELECTION) &&
      ((event->type & EVENT_MOUSE_LEFTUP) ||
      ((event->type & EVENT_KEY_DOWN) && (event->key == 10))))
    {
      // Get the selected item
      windowComponentGetSelected(iconList, &clickedIcon);
      if (clickedIcon < 0)
	return;

      mouseSwitchPointer("busy");

      // If it's removable, see if there is any media present
      if (disks[clickedIcon].flags & DISKFLAG_REMOVABLE &&
	  !diskGetMediaState(disks[clickedIcon].name))
	{
	  mouseSwitchPointer("default");
	  error("No media in disk %s", disks[clickedIcon].name);
	  return;
	}

      // Re-scan disk info
      status = diskGet(disks[clickedIcon].name, &disks[clickedIcon]);
      if (status < 0)
	{
	  mouseSwitchPointer("default");
	  error("Error re-reading disk info");
	  return;
	}

      // See whether we have to mount the corresponding disk, and launch
      // an appropriate file browser

      // Disk mounted?
      if (!(disks[clickedIcon].mounted))
	{
	  snprintf(mountPoint, MAX_PATH_LENGTH, "/%s",
		   disks[clickedIcon].name);

	  status = filesystemMount(disks[clickedIcon].name, mountPoint);
	  
	  mouseSwitchPointer("default");
	  
	  if (status < 0)
	    {
	      if (status == ERR_NOTIMPLEMENTED)
		error("Filesystem on %s is not supported",
		      disks[clickedIcon].name);
	      else
		error("Can't mount %s on %s", disks[clickedIcon].name,
		      mountPoint);
	      return;
	    }

	  // Reread disk info
	  status = diskGet(disks[clickedIcon].name, &disks[clickedIcon]);
	  if (status < 0)
	    {
	      error("Error re-reading disk info");
	      return;
	    }
	}
      else
	mouseSwitchPointer("default");

      // Launch a file browser
      snprintf(command, MAXSTRINGLENGTH, "%s %s", FILE_BROWSER,
	       disks[clickedIcon].mountPoint);

      if (multitaskerSpawn(&execProgram, "exec program", 1,
			   (void *[]){ command }) < 0)
	error("Error launching file browser");
    }
}


static int constructWindow(void)
{
  int status = 0;
  componentParameters params;

  strncpy(windowTitle, DEFAULT_WINDOWTITLE, WINDOW_MAX_TITLE_LENGTH);

  // Create a new window, with small, arbitrary size and location
  window = windowNew(processId, windowTitle);
  if (window == NULL)
    return (status = ERR_NOTINITIALIZED);

  bzero(&params, sizeof(componentParameters));
  params.gridWidth = 1;
  params.gridHeight = 1;
  params.padTop = 5;
  params.padBottom = 5;
  params.padLeft = 5;
  params.padRight = 5;
  params.orientationX = orient_center;
  params.orientationY = orient_middle;
  params.useDefaultForeground = 1;
  params.useDefaultBackground = 1;

  // Create a window list to hold the icons
  iconList = windowNewList(window, windowlist_icononly, DEFAULT_ROWS,
			   DEFAULT_COLUMNS, 0, iconParams, numDisks, &params);
  windowRegisterEventHandler(iconList, &eventHandler);

  // Register an event handler to catch window close events
  windowRegisterEventHandler(window, &eventHandler);

  windowSetVisible(window, 1);

  return (status = 0);
}


static void deallocateMemory(void)
{
  if (disks)
    free(disks);
  if (iconParams)
    free(iconParams);
}


int main(int argc, char *argv[])
{
  int status = 0;

  // Only work in graphics mode
  if (!graphicsAreEnabled())
    {
      printf("\nThe \"%s\" command only works in graphics mode\n",
	     (argc? argv[0] : ""));
      return (errno = ERR_NOTINITIALIZED);
    }

  // What is my process id?
  processId = multitaskerGetCurrentProcessId();
  
  // What is my privilege level?
  privilege = multitaskerGetProcessPrivilege(processId);

  // Get information about all the disks, and make icon parameters for them.
  status = scanComputer();
  if (status < 0)
    {
      deallocateMemory();
      return (errno = status);
    }

  status = constructWindow();
  if (status < 0)
    {
      deallocateMemory();
      return (errno = status);
    }

  // Run the GUI
  windowGuiRun();

  // We're back.
  windowGuiStop();
  windowDestroy(window);

  // Deallocate memory
  deallocateMemory();

  return (status = 0);
}
