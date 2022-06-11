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
//  kernelWindowComponent.c
//

// This code implements a generic window component, including a default
// constructor and default functions that can be overridden.

#include "kernelWindow.h"     // Our prototypes are here
#include "kernelError.h"
#include "kernelMalloc.h"
#include "kernelMisc.h"
#include "kernelWindowEventStream.h"
#include <stdlib.h>

extern color kernelDefaultForeground;
extern color kernelDefaultBackground;


static int drawBorder(kernelWindowComponent *component, int draw)
{
  // Draw or erase a simple little border around the supplied component
  
  if (draw)
    kernelGraphicDrawRect(component->buffer,
			  (color *) &(component->params.foreground),
			  draw_normal, (component->xCoord - 2),
			  (component->yCoord - 2), (component->width + 4),
			  (component->height + 4), 1, 0);
  else
    kernelGraphicDrawRect(component->buffer,
			  (color *) &(component->window->background),
			  draw_normal, (component->xCoord - 2),
			  (component->yCoord - 2), (component->width + 4),
			  (component->height + 4), 1, 0);
  return (0);
}


static int erase(kernelWindowComponent *component)
{
  // Simple erasure of a component, by drawing a filled rectangle of the
  // window's background color over the component's area

  kernelGraphicDrawRect(component->buffer,
			(color *) &(component->window->background),
			draw_normal, component->xCoord, component->yCoord,
			component->width, component->height, 1, 1);
  return (0);
}


static int grey(kernelWindowComponent *component)
{
  // Filter the component with the default background color

  // If the component has a draw function (stored in its 'grey' pointer)
  // call it first.
  if (component->grey)
    component->grey(component);

  kernelGraphicFilter(component->buffer,
		      (color *) &(component->params.background),
		      component->xCoord, component->yCoord, component->width,
		      component->height);
  return (0);
}


/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
//
// Below here, the functions are exported for external use
//
/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////


kernelWindowComponent *kernelWindowComponentNew(objectKey parent,
						componentParameters *params)
{
  // Creates a new component and adds it to the main container of the
  // window.

  int status = 0;
  kernelWindowComponent *parentComponent = NULL;
  kernelWindowComponent *component = NULL;

  // Check params
  if ((parent == NULL) || (params == NULL))
    return (component = NULL);

  // Get memory for the basic component
  component = kernelMalloc(sizeof(kernelWindowComponent));
  if (component == NULL)
    return (component);

  component->type = genericComponentType;
  component->subType = genericComponentType;
  component->window = getWindow(parent);
  
  // Use the window's buffer by default
  if (component->window)
    component->buffer = &(component->window->buffer);

  // Visible and enabled by default
  component->flags |= (WINFLAG_VISIBLE | WINFLAG_ENABLED);

  // If the parameter flags indicate the component should be focusable,
  // set the appropriate component flag
  if (params->flags & WINDOW_COMPFLAG_CANFOCUS)
    component->flags |= WINFLAG_CANFOCUS;

  // Copy the parameters into the component
  kernelMemCopy(params, (void *) &(component->params),
		sizeof(componentParameters));

  // If the default colors are requested, copy them into the component
  // parameters
  if (!(component->params.flags & WINDOW_COMPFLAG_CUSTOMFOREGROUND))
    {
      component->params.foreground.blue = kernelDefaultForeground.blue;
      component->params.foreground.green = kernelDefaultForeground.green;
      component->params.foreground.red = kernelDefaultForeground.red;
    }

  if (!(component->params.flags & WINDOW_COMPFLAG_CUSTOMBACKGROUND))
    {
      component->params.background.blue = kernelDefaultBackground.blue;
      component->params.background.green = kernelDefaultBackground.green;
      component->params.background.red = kernelDefaultBackground.red;
    }

  // Initialize the event stream
  status = kernelWindowEventStreamNew(&(component->events));
  if (status < 0)
    {
      kernelFree((void *) component);
      return (component = NULL);
    }

  // Default functions
  component->drawBorder = &drawBorder;
  component->erase = &erase;
  component->grey = &grey;

  // Now we need to add the component somewhere.

  if (((kernelWindow *) parent)->type == windowType)
    // The parent is a window, so we use the window's main container.
    parentComponent = ((kernelWindow *) parent)->mainContainer;

  else if (((kernelWindowComponent *) parent)->add)
    // Not a window but a component with an 'add' function.
    parentComponent = parent;

  else
    {
      kernelError(kernel_error, "Invalid parent object for new component");
      kernelFree((void *) component);
      return (component = NULL);
    }

  if (parentComponent && parentComponent->add)
    status = parentComponent->add(parentComponent, component);

  if (status < 0)
    {
      kernelFree((void *) component);
      return (component = NULL);
    }
  else
    {
      if (component->container == NULL)
	component->container = parentComponent;
      return (component);
    }
}


void kernelWindowComponentDestroy(kernelWindowComponent *component)
{
  extern kernelWindow *consoleWindow;
  extern kernelWindowComponent *consoleTextArea;

  // Check params.  
  if (component == NULL)
    return;

  // Make sure the component is removed from any containers it's in
  removeFromContainer(component);

  // Never destroy the console text area.  If this is the console text area,
  // move it back to our console window
  if (component == consoleTextArea)
    {
      kernelWindowMoveConsoleTextArea(component->window, consoleWindow);
      return;
    }

  // Call the component's own destroy function
  if (component->destroy)
    component->destroy(component);
  component->data = NULL;

  // Deallocate generic things
  if (component->events.s.buffer)
    {
      kernelFree((void *)(component->events.s.buffer));
      component->events.s.buffer = NULL;
    }

  // Free the component itself
  kernelFree((void *) component);

  return;
}


int kernelWindowComponentSetVisible(kernelWindowComponent *component,
				    int visible)
{
  // Set a component visible or not visible

  int status = 0;
  kernelWindow *window = NULL;

  // Check params
  if (component == NULL)
    return (status = ERR_NULLPARAMETER);

  window = component->window;

  if (visible)
    {
      component->flags |= WINFLAG_VISIBLE;
      if (component->draw)
      	component->draw(component);
    }
  else
    {
      if ((window->focusComponent == component) && window->focusNextComponent)
	// Make sure it doesn't have the focus
	window->focusNextComponent(window);

      component->flags &= ~WINFLAG_VISIBLE;
      if (component->erase)
      	component->erase(component);
    }

  // Redraw a clip of that part of the window
  if (window->drawClip)
    window->drawClip(component->window, component->xCoord, component->yCoord,
		     component->width, component->height);

  // Redraw the mouse just in case it was within this area
  kernelMouseDraw();

  return (status = 0);
}


int kernelWindowComponentSetEnabled(kernelWindowComponent *component,
				    int enabled)
{
  // Set a component enabled or not enabled.  What we do is swap the 'draw'
  // and 'grey' functions of the component and any sub-components, if
  // applicable

  int status = 0;
  kernelWindow *window = NULL;
  kernelWindowComponent **array = NULL;
  int numComponents = 0;
  int (*tmpDraw) (kernelWindowComponent *) = NULL;
  kernelWindowComponent *tmpComponent = NULL;
  int count;

  // Check params
  if (component == NULL)
    return (status = ERR_NULLPARAMETER);

  window = component->window;

  if (component->numComps)
    numComponents = component->numComps(component);
  else
    numComponents = 1;

  array = kernelMalloc(numComponents * sizeof(kernelWindowComponent *));
  if (array == NULL)
    return (status = ERR_MEMORY);

  array[0] = component;
  numComponents = 1;

  if (component->flatten)
    component->flatten(component, array, &numComponents, 0);

  for (count = 0; count < numComponents; count ++)
    {
      tmpComponent = array[count];

      if (enabled && !(tmpComponent->flags & WINFLAG_ENABLED))
	{
	  tmpComponent->flags |= WINFLAG_ENABLED;
	  tmpDraw = tmpComponent->grey;
	  tmpComponent->grey = tmpComponent->draw;
	  tmpComponent->draw = tmpDraw;
	}
      else if (!enabled && (tmpComponent->flags & WINFLAG_ENABLED))
	{
	  if ((window->focusComponent == tmpComponent) &&
	      window->focusNextComponent)
	    // Make sure it doesn't have the focus
	    window->focusNextComponent(window);

	  tmpComponent->flags &= ~WINFLAG_ENABLED;
	  tmpDraw = tmpComponent->grey;
	  tmpComponent->grey = tmpComponent->draw;
	  tmpComponent->draw = tmpDraw;
	}
    }

  if (array)
    kernelFree(array);

  // Redraw a clip of that part of the window
  if (window->drawClip)
    window->drawClip(window, component->xCoord, component->yCoord,
		     component->width, component->height);

  // Redraw the mouse just in case it was within this area
  kernelMouseDraw();

  return (status = 0);
}


int kernelWindowComponentGetWidth(kernelWindowComponent *component)
{
  // Return the width parameter of the component
  if (component == NULL)
    return (0);
  else
    return (component->width);
}


int kernelWindowComponentSetWidth(kernelWindowComponent *component, int width)
{
  // Set the width parameter of the component

  int status = 0;
  int oldWidth = 0;

  if (component == NULL)
    return (ERR_NULLPARAMETER);

  oldWidth = component->width;

  // If the component wants to know about resize events...
  if (component->resize)
    status = component->resize(component, width, component->height);

  component->width = width;

  // Redraw a clip of that part of the window
  // If the component is visible, redraw the clip of the window
  if (component->window->drawClip)
    component->window->drawClip(component->window, component->xCoord,
				component->yCoord, max(width, oldWidth),
				component->height);

  return (status);
}


int kernelWindowComponentGetHeight(kernelWindowComponent *component)
{
  // Return the height parameter of the component
  if (component == NULL)
    return (0);
  else
    return (component->height);
}


int kernelWindowComponentSetHeight(kernelWindowComponent *component,
				   int height)
{
  // Set the width parameter of the component

  int status = 0;
  int oldHeight = 0;

  if (component == NULL)
    return (ERR_NULLPARAMETER);
  
  oldHeight = component->height;

  // If the component wants to know about resize events...
  if (component->resize)
    status = component->resize(component, component->width, height);

  component->height = height;

  // Redraw a clip of that part of the window
  // If the component is visible, redraw the clip of the window
  if (component->window->drawClip)
    component->window->drawClip(component->window, component->xCoord,
				component->yCoord, component->width,
				max(height, oldHeight));

  return (status);
}


int kernelWindowComponentFocus(kernelWindowComponent *component)
{
  // Gives the supplied component the focus, puts it on top of any other
  // components it intersects, etc.
  
  int status = 0;
  kernelWindow *window = NULL;

  // Check params
  if (component == NULL)
    return (status = ERR_NULLPARAMETER);

  // Get the window
  window = component->window;
  if (window == NULL)
    {
      kernelError(kernel_error, "Component to focus has no window");
      return (status = ERR_NODATA);
    }

  window->changeComponentFocus(window, component);

  return (status = 0);
}


int kernelWindowComponentUnfocus(kernelWindowComponent *component)
{
  // Removes the focus from the supplied component
  
  int status = 0;
  kernelWindow *window = NULL;

  // Check params
  if (component == NULL)
    return (status = ERR_NULLPARAMETER);

  // Get the window
  window = component->window;
  if (window == NULL)
    {
      kernelError(kernel_error, "Component to unfocus has no window");
      return (status = ERR_NODATA);
    }

  if (window->oldFocusComponent)
    window->changeComponentFocus(window, window->oldFocusComponent);
  else
    window->focusNextComponent(window);

  return (status = 0);
}


int kernelWindowComponentDraw(kernelWindowComponent *component)
{
  // Draw  a component
  
  int status = 0;

  // Check params
  if (component == NULL)
    return (status = ERR_NULLPARAMETER);

  if (!component->draw)
    return (status = ERR_NOTIMPLEMENTED);

  return (component->draw(component));
}


int kernelWindowComponentGetData(kernelWindowComponent *component,
				 void *buffer, int size)
{
  // Get (generic) data from a component
  
  int status = 0;

  // Check params
  if ((component == NULL) || (buffer == NULL))
    return (status = ERR_NULLPARAMETER);

  if (!component->getData)
    return (status = ERR_NOTIMPLEMENTED);

  return (component->getData(component, buffer, size));
}


int kernelWindowComponentSetData(kernelWindowComponent *component,
				 void *buffer, int size)
{
  // Set (generic) data in a component
  
  int status = 0;

  // Check params.  buffer can only be NULL if size is NULL
  if ((component == NULL) || ((buffer == NULL) && size))
    return (status = ERR_NULLPARAMETER);

  if (!component->setData)
    return (status = ERR_NOTIMPLEMENTED);

  status = component->setData(component, buffer, size);

  return (status);
}


int kernelWindowComponentGetSelected(kernelWindowComponent *component,
				     int *selection)
{
  // Calls the 'get selected' method of the component, if applicable

  // Check parameters
  if ((component == NULL) || (selection == NULL))
    return (ERR_NULLPARAMETER);

  if (component->getSelected == NULL)
    return (ERR_NOSUCHFUNCTION);

  return (component->getSelected(component, selection));
}


int kernelWindowComponentSetSelected(kernelWindowComponent *component,
				     int selected)
{
  // Calls the 'set selected' method of the component, if applicable

  // Check parameters
  if (component == NULL)
    return (ERR_NULLPARAMETER);

  if (component->setSelected == NULL)
    return (ERR_NOSUCHFUNCTION);

  return (component->setSelected(component, selected));
}
