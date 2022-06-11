<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Visopsys | Visual Operating System | Downloads - Change Log</title>
    <meta id="description" name="description" content="Visopsys | Visual Operating System"/>
    <link rel="icon" href="../favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
    <font face="arial">
    </head><body><div align="center">
      <center>
		<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="main">
		  <tr>
			<td bgcolor="#1C42A7" nowrap align="left">
			  <p align="center">
			  <img border="0" src="../img/visopsys-upper.gif" align="left" width="193" height="35"></td>
			<td bgcolor="#1C42A7" nowrap align="left">
    <font face="arial">
			  <font color="#EEEEFF" size="2">
			  <b>
              &nbsp; <a href="http://visopsys.org/index.php"><img border="0" src="../img/nav_buttons/home.gif"></a>&nbsp; 
              <a href="../about/index.php"><img border="0" src="../img/nav_buttons/about.gif"></a>&nbsp;&nbsp; <a href="../about/news.php"><img border="0" src="../img/nav_buttons/news.gif"></a>&nbsp;&nbsp; <a href="../about/screenshots.php"><img border="0" src="../img/nav_buttons/screenshots.gif"></a>&nbsp;&nbsp; 
              <a href="index.php"><img border="0" src="../img/nav_buttons/download.gif"></a>&nbsp;&nbsp; <a href="../forums/index.php"><img border="0" src="../img/nav_buttons/forum.gif"></a>&nbsp; <a href="../developers/index.php"><img border="0" src="../img/nav_buttons/developers.gif"></a></b></font><font color="#EEEEFF" size="2" face="arial"><b>&nbsp;&nbsp; 
              <a href="../osdev/index.php"><img border="0" src="../img/nav_buttons/osdev.gif"></a>&nbsp;&nbsp; 
              <a href="../search.php"><img border="0" src="../img/nav_buttons/search.gif"></a></b></font></font></td>
		  </tr>
		  <tr>
			<td bgcolor="#1C42A7" nowrap align="left" colspan="3">
				<img border="0" src="../img/visopsys-lower.gif" align="left" width="299" height="15"></td>
		  </tr>
		  <tr>
			<td height="1" colspan="2">
            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111">
              <tr>
                <td align="left" valign="top" bgcolor="#C4D0E0">
                <table border="0" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="AutoNumber1" width="700">
	  <tr>
		<td>

<p><b><font size="4">Download - Change Log</font></b></p>

  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="700">
    <tr>
      <td>VERSION 0.72<br>
      22/08/2013<p>Overview: <span LANG="EN-GB"><font SIZE="3">This release 
      consists of hardware support updates and bug fixes, with particular focus 
      on USB. Support for USB 2 controllers and devices has been added.</font></span></p>
      <span LANG="EN-GB"><font SIZE="3">
      <ul>
        <li>Added initial USB2 (EHCI) support.</li>
        <li>Added a stub USB3 (XHCI) driver.</li>
        <li>Implemented interrupt sharing and chaining, so that USB controllers 
        (for example) can share interrupts with one other, as well as other 
        devices such as disk controllers.</li>
        <li>Improved the output of the Devices program so that it's a little bit 
        more readable.</li>
        <li>Improved the collection and recording of the CPU vendor string.</li>
        <li>Did a bit more development of the simple ACPI driver.</li>
        <li>Added a kernelPause() function, that will wait for the specified 
        number of seconds, or a keypress.</li>
        <li>Added additional error checking and debugging to the 'bus' subsystem 
        and the kernel linked list functions.</li>
        <li>Added some extra PCI structure definitions, needed mostly if we ever 
        get around to doing PCI interrupt routing.</li>
        <li>Made some small improvements to PCI - comments, detection, 
        debugging, iterating and debugging the capabilities list, etc.</li>
        <li>Added functions for interrupt handlers to get and set the current 
        interrupt number (the previous implementation failed when the interrupt 
        number is 0).</li>
        <li>Ensured that all ISRs disable interrupts whilst inside their 
        handlers, and save/restore the flags register too (changing the 
        kernelProcessorIsrEnter and kernelProcessorIsrExit macros).</li>
        <li>Added &quot;interrupt number out of range&quot; debug error messages to the 
        kernelInterrupt code.</li>
        <li>Made build configuration changes for development on newer systems 
        (like Ubuntu 11) and newer GNU tools (like GCC 4.6), and tweaked some 
        ELF loading code in the OS loader. Additional ELF loading changes may 
        need to be make in the kernel.</li>
        <li>Fixed: USB hub detection could happen twice - once during the 
        controller's initial device connection detection, and again when device 
        driver detection happened for hubs.</li>
        <li>Fixed: The first (number 1) USB port didn't work on many systems.</li>
        <li>Fixed: Certain USB hard disks not working, and/or causing boot 
        failure.</li>
        <li>Fixed: The AHCI driver no longer fails to initialize if PCI bus 
        mastering can't be enabled.</li>
        <li>Fixed: ACPI (soft) power off could cause some systems not to boot 
        the operating system on the next attempt.</li>
        <li>Fixed: Removed possible infinite loop condition in the 'real time 
        clock' driver.</li>
        <li>Fixed: When the OS was installed somewhere via the native installer 
        (for example on a USB stick) with a FAT32 filesystem type, the volume 
        label was not being set properly.</li>
        <li>Fixed: The graphical native installer would often skip the password 
        setting box (flashing up and then disappearing).</li>
        <li>Fixed: The TAB key was not working when using a USB keyboard.</li>
        <li>Fixed: GCC compile errors under Ubuntu 11.10<br>
&nbsp;</li>
      </ul>
      </font></span>
<hr>

      <p>VERSION 0.71<br>
      28/10/2011</p>
      <p>Overview: <span LANG="EN-GB"><font SIZE="3">The bulk of this 
      release consists of general bug fixes, and improvements to hardware 
      detection and device drivers, with particular focus on USB. New features 
      include the ability to boot from a USB device (a new USB image is 
      available for download) and the ability to power down the system.</font></span></p>
      <span LANG="EN-GB"><font SIZE="3">
      <ul>
        <li>Implemented USB booting.</li>
        <li>Added a USB blank-image file and a script for installing into it.</li>
        <li>Improved detection of USB devices by always separating hotplug 
        behaviour from coldplug detection at boot time.</li>
        <li>USB 2.0 (EHCI) controllers are detected and disabled (reset) so that 
        they don't interfere with access to the legacy USB 1.1 UHCI ports.</li>
        <li>Search all 255 possible PCI buses, not just the first 10. It's 
        slower to search them all, but some devices have been seen to reside on 
        e.g. the 17th bus.</li>
        <li>Improved recognition of PCI device classes and subclasses.</li>
        <li>Added support for multiple buses of any type (such as PCI and USB)</li>
        <li>Implemented a partial ACPI power management driver, so that the 
        shutdown command can power off the system.</li>
        <li>Added a kernelCpu module to contain the old driver detection code 
        and some new functions for using the CPU timestamp counter.</li>
        <li>CPU timestamp frequency is now measured from within the real time 
        clock initialization.</li>
        <li>The malloc() memory management code has been changed to a best-fit 
        allocation strategy, in order to reduce memory fragmentation and improve 
        heap memory usage. In addition, the memory block list has been separated 
        into 'used' and 'free' lists for faster searches.</li>
        <li>Updated GPT GUIDs for partition types, and moved the definitions and 
        descriptions into the header file src/include/sys/guid.h</li>
        <li>The boot menu installer now shows a warning that Windows 7 (and 
        maybe Vista) will require the installation CD, in order to 'repair' its 
        boot configuration.</li>
        <li>The OS loader now passes a boot sector 'signature' found on the boot 
        device (such as in the MBR) to the kernel in order to help the kernel 
        figure out for itself which device it should mount as the root 
        filesystem.</li>
        <li>We now mark the logical disks of non-partitioned physical disks as 
        being 'primary' partitions.</li>
        <li>Implemented an advisory bus target 'claiming' system, so that 
        multiple drivers won't attempt to control a device (such as the IDE 
        driver trying to operate a supported SATA controller in legacy mode).</li>
        <li>The kernel's symbols are now read from the ELF file itself, and not 
        from the kernelSymbols.txt file, which has been obsoleted.</li>
        <li>Moved general ATA definitions (i.e. those common to PATA, SATA, etc) 
        into a new kernelAtaDriver.h file.</li>
        <li>Moved the UHCI getEndpointDesc() function into the general USB 
        driver as kernelUsbGetEndpointDesc(), and fixed the UHCI global reset 
        timing so that it's closer to being exactly 100ms.</li>
        <li>Added a PCI subclass for SD controllers</li>
        <li>The kernel's linked list iteration has been changed so that it 
        allows simultaneous read-only iteration through the list (not 
        thread-safe per se, but multithread-able).</li>
        <li>Added DEBUG flags to the src/programs Makefiles</li>
        <li>Improved the OS loader, so that it searches for the code and data 
        segments in the kernel's ELF executable, rather than assuming that 
        they're the first and second segments, respectively. Kernels built under 
        Ubuntu, for example, have additional segments.</li>
        <li>The kernel's disk management code now recycles disk numbers, so that 
        for example, inserting a USB stick which gets named sd0, then removing 
        it and reinserting, doesn't result in the disk being named sd1</li>
        <li>Modified the install script to use the install files in the build 
        area, and ignore comment lines that start with '#'</li>
        <li>Reformatted the output of the disks command.</li>
        <li>The kernel's kernelPageMap(), kernelPageMapToFree(), and 
        kernelPageUnmap() functions will now accept non-page-aligned physical 
        and virtual addresses, and adjust requests accordingly for use by the 
        internal map() and unmap() functions.</li>
        <li>The kernel's memory allocation code now makes proper use of the BIOS 
        memory map passed in by the OS loader</li>
        <li>The EXT 2/3 driver can now mount filesystems with variable-sized 
        inode structures.</li>
        <li>The mouse abstraction layer now has a default, simple pointer built 
        in, that it can draw manually into an image, in the case where the mouse 
        pointer image files are missing.</li>
        <li>The filesystem 'resize constraints' call (such as to the kernel or 
        NTFS) now passes a 'progress' parameter just like a real resize, so that 
        error messages, etc., can be presented to the user.</li>
        <li>Implemented libdl.so functionality, providing functions such as 
        dlfcn.h, dlopen(), dlerror(), dlsym(), and dlclose().</li>
        <li>Fixed: USB endpoint enumeration no longer discards the 0x80 bit of 
        the endpoint address, since some devices require it in order for the 
        endpoint address to be unique.</li>
        <li>Fixed: A number of USB sticks would fail to enumerate, because port 
        reset timings/logic were not technically correct.</li>
        <li>Fixed: Pulling a USB stick that hadn't been successfully configured 
        by the SCSI USB code would cause the USB thread to page fault in 
        kernelDeviceHotplug().</li>
        <li>Fixed: An EXT 2/3 symbolic link was showing up as an empty icon in 
        the file browser.</li>
        <li>Fixed: FAT volume label entries stored in the root directory were 
        not being re-created when the directories were written.</li>
        <li>Fixed: The kernel's GPT partition table code was not correctly 
        reading partition table entries; it was failing to correctly calculate 
        the buffer size and number of sectors of the entries.</li>
        <li>Fixed: The Disk Manager program was incorrectly calculating the 
        ending sector of entries in GPT partition tables.</li>
        <li>Fixes and improvements to the kernel's file stream functions, and to 
        the C library fflush(), fread(), fwrite(), and fseek() functions.</li>
        <li>Fixed: Incorrect kernel API parameter definitions for the 
        kernelCrc32() (userspace crc32()) function to allow a NULL 3rd 
        parameter.</li>
        <li>Fixed: The kernel's CRC-32 code was not correctly calculating 
        checksums when an initial/carried-over CRC checksum was supplied.</li>
        <li>Fixed: All of the kernel loader's file detection/classification 
        routines now check for adequate file data length before examining 
        various offsets in the data.</li>
        <li>Fixed: The Bresenham line drawing algorithm in the kernel's 
        framebuffer graphic drover was incorrect/incomplete for diagonal lines 
        going from upper-left to lower-right.</li>
        <li>Fixed: The kernel's random number generator was outputting many more 
        even numbers than odd numbers. Out of 1 million calls, the ratios of 
        even:odd were more than 4:1.</li>
        <li>Fixed: When using the built-in system font, the code that wraps the 
        icon text could discard a letter.</li>
        <li>Fixed: Printing TAB characters with '\t' in printf() was not 
        working.</li>
        <li>Fixed: When doing a screenshot, the &quot;saving...&quot; dialog could appear 
        in the screenshot. The dialog was being created before capturing the 
        screen data.</li>
        <li>Fixed: ISOs compiled/created under Ubuntu 10.10 did not start 
        successfully; the system crashed during kernel initialization.</li>
        <li>Fixed: Some small compilation errors and an install.sh script bug 
        when building under Ubuntu 10.4</font></span><br>
&nbsp;</li>
      </ul>
<hr>

      <p>VERSION 0.7<br>
      16/02/2011</p>
      <p>Overview: More than four years in the making, this is a major
      
      new release offering an updated look and a number of new
  features, including JPEG image support, image resizing, 64-bit disk
  support, UDF (DVD) filesystem support, and GPT partition table support,
  as well as lots of new icons, wallpaper images, and file browsing
  functionality.  New administrative applications and functionality have
  been added, and the ATA/IDE driver has been enhanced, including the
  ability to better support backwards-compatible SATA controllers.  FPU
  context saving has been improved, and a number of tweaks and bug fixes
  are also included.</p>
      <ul>
        <li>Updated the appearance of windows and several types of widgets.</li>
        <li>Added JPEG image format support.</li>
        <li>Added image resizing code.</li>
        <li>Added 64-bit disk support.</li>
        <li>Added UDF (DVD-ROM) filesystem support.</li>
        <li>Added GPT disk label support to the kernel and to the Disk Manager
      program.</li>
        <li>Included a quantity of new icons based on contributions provided by
      Leency &lt;leency@mail.ru&gt;, including the folder icon, and all of the
      file browser icons for different file types.</li>
        <li>Implemented keyboard navigation of the GUI menus using 'Alt' to activate
      them, and the cursor and 'Enter' keys to navigate and select.</li>
        <li>Alt-Tab now raises the root window's 'window' menu for keyboard
      navigation between open windows, in a way somewhat analogous to the way
      Windows and other GUIs do it.</li>
        <li>Created new icons for the 'cal' (Calendar), 'mines', and 'snake' 
      programs,
      as well as for the 'lsdev' (Devices), 'install', and 'users' (User 
      Manager)
      administration programs.</li>
        <li>Added loader file class support for the ability to recognise GIF and PNG
      images, Zip, Gzip, and Ar archives, and PDF and HTML documents. Also added
      file browser icons for PDF, HTML and archive files.</li>
        <li>Designed and implemented a new proprietary font file format that enables
      sparsely-mapped, bitmapped fonts. Added a 'fontutil' utility program for
      editing and managing the new format.</li>
        <li>New splash image for the 0.7x series.</li>
        <li>New default background pattern wallpaper image, and three additional,
      full-sized ones.</li>
        <li>Redesigned the 'bangicon', 'infoicon', and 'questicon' images.</li>
        <li>Changed the visual effect which clicking on, or dragging icons. Instead
      of reverse-video (xor), the icons now tint yellow. Additionally, when
      dragging icons, the icon image now appears instead of a box outline.</li>
        <li>Changed the way icon text is drawn, so that it no longer has a solid box
      behind it, but instead has a little drop shadow. Icon components are now optionally focus-able, enabling keyboard
      navigation of (for example) the desktop icons, or the icons in the 
      shutdown
      program</li>
        <li>Implemented image alpha channels and blending, with support for 
        resizing</li>
        <li>Added support for reading monochrome windows bitmap (.bmp) images.</li>
        <li>Added support for some new (non-4:3 aspect) graphics modes.</li>
        <li>Implemented horizontal window scroll bars.</li>
        <li>Added a 'divider' window component, for placing simple little lines in
      a window. Useful for separating sections of components.</li>
        <li>Window components can now be created with a flag to suppress the use of
      scroll bars.</li>
        <li>Improved the IDE driver so that it can detect and operate multiple
      controllers, correctly use PCI I/O port remappings, and PCI interrupts,
      as well as adding improved support for things like backwards-compatible
      SATA disks/controllers.</li>
        <li>Added initial, very basic detection of AHCI SATA controllers (operating
      in native AHCI mode) and their disks.</li>
        <li>Reimplemented the kernel API interface. It now supports variable-sized
      arguments and return values, and does checking on argument types and 
      values
      (for example user vs. kernel pointers, NULL values, etc).</li>
        <li>Reimplemented the kernel's file stream subsystem for character-based 
      file
      I/O as a simple buffered mechanism with a file pointer, instead of using
      the kernel's streams.</li>
        <li>Added an 'I/O ready' state to the multitasker, so that processes waiting
      for (for example) disk I/O can go into a 'waiting' state and be awoken as
      soon as possible when the I/O arrives, rather than polling for interrupts
      as they had been doing previously. The 'idle thread' now loops through the
      process list, looking for any I/O-ready processes and yields its timeslice
      when it finds one. The scheduler gives such processes high priority.</li>
        <li>Added more efficient power management, idling the processor during spare
      cycles.</li>
        <li>Moved common keyboard functionality out of the drivers and into the
      abstraction layer, with an interface for handling of specific keyboard
      'special' events such as PrtScn or Ctrl-Alt-Del.</li>
        <li>Added basic internationalization library support (libintl), modeled on
      the GNU gettext system.</li>
        <li>Added 32-bit CRC calculation to the kernel.</li>
        <li>Added RAM disk support, courtesy of contributions from Davide Airaghi
      &lt;<a href="mailto:davide.airaghi@gmail.com">davide.airaghi@gmail.com</a>&gt;.</li>
        <li>Implemented 'lazy' FPU context saving; the context is only saved or
      restored if a different process tries to use it.</li>
        <li>Added new keyboard mappings: French, Belgian, and Spanish.</li>
        <li>Keyboard mappings are now stored in files, rather than hardcoded in the
      kernel. The 'keymap' (Keyboard Mapping) program has been enhanced to
      facilitate the editing and saving of new keymaps. In addition, the file
      browser will now use it to open keymap files when they're clicked.</li>
        <li>Added a new configuration file /system/config/mount.conf containing
      variables for specifying mount points of filesystems (like Unix fstab) and
      whether or not to auto-mount them. The 'mount' and 'computer' programs use
      the file (as well as the kernel's automounting), and there is also a new
      'filesys' program in the Administration window for editing it.</li>
        <li>Added some extra error checking in the filesystem detection code.</li>
        <li>The FAT boot sector now copies the partition table entry pointed to by
      the SI register, so that it is in a known/safe location for passing off
      in turn to the OS loader.</li>
        <li>Added right-click context menus to the disk icons in the computer 
      browser.</li>
        <li>The menu currently contains 'Browse', 'Mount as...', 'Unmount', and
      'Properties' choices.</li>
        <li>The computer browser now shows the filesystem label, if applicable, in
      its icon text.</li>
        <li>When a wallpaper image is chosen, it is now automatically resized to fit
      the the client area of the window.</li>
        <li>When displaying an image, the 'view' program now scales large images 
      down
      by default so that they use no more than 2/3 of the screen. </li>
        <li>The 'view' program now has a right-click context menu to zoom in and out
      on images, or show them actual size. </li>
        <li>The 'disprops' (Display Settings) program has been reorganized, and now
      shows a thumbnail preview of the selected background wallpaper image.</li>
        <li>Added an option to the windowFileDialog to show image file thumbnail
      previews.</li>
        <li>The 'imgboot' program now has 'run' as the default selection, instead of 
        'install'</li>
        <li>Added locking to the kernel's stream functions.</li>
        <li>Added kernel logging of the OS loader's hardware info structure.</li>
        <li>Added a 'model' string field to the kernel and user disk structures.</li>
        <li>Window components now receive mouse enter/exit events.</li>
        <li>Window components can now have custom mouse pointers, as windows do.</li>
        <li>Added mouse pointers that indicate window resizing, and they are now
      switched to automatically when passing over window borders.</li>
        <li>New default desktop color that goes better with the splash image</li>
        <li>The window shell now uses the foreground color for the root window menu,
      instead of the desktop color (this way there's a contrast).</li>
        <li>The foreground, background, and desktop colors are no longer specified
      exclusively in the kernel's configuration file. They are still there as
      default values for boot time, but additional color settings are specified
      in the window configuration file, and those override the kernel ones when
      they're available.</li>
        <li>Added windowNewThumbImage() and windowThumbImageUpdate() functions to
      the window library. These can be used to create a thumbnail-sized window
      image object from an image file name.</li>
        <li>Added a kernelFileGetFullPath() function (userspace fileGetFullPath) 
      that
      will return the full path+name of a file referenced by a file structure.</li>
        <li>The kernelFontLoad() (userspace fontLoad) function will now search the
      system's font directory (/system/fonts) for a font file, so it's not
      necessary to pass a complete pathname.</li>
        <li>Removed /system/mount directory, as it wasn't being used.</li>
        <li>The kernelFileFind() (userspace fileFind) function now acccepts a NULL
      file structure pointer, for instances in which the caller is really only
      interested in whether the file exists.</li>
        <li>The windowFileDialog window library code now interprets a non-empty
      fileName argument as a value to show by default in the file name field.
      Additionally, the file name field no longer shows the fully-qualified
      names of files, just the short names.</li>
        <li>Added a windowNumberDialog to the userspace window library, for
      requesting the user to enter a number value, and providing a graphical
      slider widged for setting the value with the mouse.</li>
        <li>The boot menu installer program 'bootmenu' now checks for previous
      installations and remembers the old entries.</li>
        <li>The 'imgboot' program now checks for the presense of the 'install
      program before querying about whether to install.</li>
        <li>The 'iconwin' program now skips any entry whose icon is missing.</li>
        <li>Reduced the padding values of the text area in the 'lsdev' (Devices)
      program. Also fixed it so that it doesn't scroll down and then back up
      again while it's visible.</li>
        <li>The kernel configuration reader/writer functions have been augmented
      with get/set/unset convenience functions for quickly getting or changing
      individual configuration values from files.</li>
        <li>Removed the title bar from the 'clock' program.</li>
        <li>The 'window' (Command Window) program has been renamed 'cmdwin'.</li>
        <li>Changed the runtime program name of the 'fdisk' program from &quot;Visopsys
      Disk Manager&quot; to just &quot;Disk Manager&quot;.</li>
        <li>Implemented proper stack backtraces for help with debugging. Walks the
      stack frame, uses the process symbol table, etc. Used by the exception
      handler and by calling kernelStackTrace().</li>
        <li>Added a kernelDebugHexDwords() function for doing simple hex dumps of
      dword-oriented memory such as stacks.</li>
        <li>Added a stack debugging output function kernelDebugStack().</li>
        <li>Added a 'hexdump' command for examining the contents of binary files.</li>
        <li>Added a 'Details' button to the kernel error dialog window, which brings
      up a dialog showing process debugging info and a stack trace.</li>
        <li>Added a kernelRealloc() function like the C library realloc().</li>
        <li>Added a generic kernelImageCopy() function which is exported to 
      userspace
      as imageCopy().</li>
        <li>The window canvas component now resizes itself properly, using the image
      resizing function.</li>
        <li>Added a kernelDebugBinary() function for doing simple binary dumps.</li>
        <li>Added the -fno-stack-protector argument to Makefile.include so we can
      link using gcc 4.1.3 (Ubuntu 7.10, etc).</li>
        <li>Added tests for since and cosine calculation to the 'test' program, and
      made both do 'double' calculations, and some random ones also.</li>
        <li>Added an fabsf() function to the C library.</li>
        <li>Added a getenv() function to the C library.</li>
        <li>Added _dbl2str() and _flt2str() C library functions for converting
      doubles and floats to strings, respectively, and added %f format specifier
      support to the _xpndfmt() function (used by the printf family of
      functions).</li>
        <li>Added an fls() C library function and fixed up ffs().</li>
        <li>Added a kernel API function kernelFileSetSize(), a driverSetBlocks()
      filesystem driver function for the back end, and ftruncate() and 
      truncate()
      C library functions for the front end.</li>
        <li>Added a sleep() C library function.</li>
        <li>Added a strtok() C library function.</li>
        <li>Added and exported a kernel API function randomBytes() for filling a
      buffer with random data.</li>
        <li>Exported the kernelWindowComponentUnfocus() function via the kernel API.</li>
        <li>Added a kernelDebugError() macro that reports errors only when debugging
      is turned on on. Replaces several locally-defined debugError() macros in
      drivers, etc.</li>
        <li>Added a new 'label' field to the kernel's generic logical disk 
      filesystem
      structure. The filesystem drivers fill it in, where applicable.</li>
        <li>Added mouse support for scroll wheels.</li>
        <li>Window event streams are now just plan kernel streams with wrapper
      functions that read or write only complete events -- the way they were
      originally intended to be.</li>
        <li>The 'mines' game map now stays on the screen after the game, so you can
      have a look at it.</li>
        <li>Fixed the cos(), cosf(), sin(), and sinf() functions so that they work
      periodically (i.e. for larger radians values that are greater than
      (PI * 2).</li>
        <li>Exported the kernelPageGetPhysical() function to userspace programs as
      pageGetPhysical()</li>
        <li>The multitasker now uses system timer mode 3</li>
        <li>Added a sys/ascii.h include file to include definitions of commonly-used
      character codes.</li>
        <li>Fixed: The OS loader could hang during disk detection (divide by zero
      error) if the BIOS 'get drive parameters' function returned success 
      despite
      there being no such drive.</li>
        <li>Fixed: The PS/2 mouse driver has been reworked to deal properly with
      mouse interrupts from various types of mouse hardware.</li>
        <li>Fixed: Clicking outside of a context menu could fail to erase the menu
      if there were no other focusable components.</li>
        <li>Fixed: After a window relayout, the mouse pointer was not being properly
      redrawn.</li>
        <li>Fixed: Resizing any window to a larger size in a vertical direction
      caused the window thread to generate a divide-by-zero exception</li>
        <li>Fixed: The C library's dirname() function didn't work correctly for
      items in the root directory.</li>
        <li>Fixed: The C library's fread() and fwrite() functions were returning
      negative error codes as return values. They now return a size_t of the
      number of items read/written, and any error is in errno.</li>
        <li>Fixed: The C library's strcmp() and strncmp() functions were not dealing
      gracefully with NULL pointers, and the strncmp() function was returning
      nonstandard result codes.</li>
        <li>Fixed: The kernel's kernelFileStreamRead function was overwriting
      properly-sized buffers by 1 byte, causing buffer overflows.</li>
        <li>Fixed: Opening an existing file stream in read/write mode (using fopen()
      or kernelFileStreamOpen()) would cause the kernel to seek to the end of
      the file for writing, but begin reading at the beginning of the last file
      block. Now all opens begin at offset 0 unless they're write-only.</li>
        <li>Fixed: The FAT filesystem driver no longer sets the size of the file to
      a multiple of the block (cluster) size on every write. Only if the number
      of blocks changed.</li>
        <li>Fixed: The access mode flags in unistd.h were not bitwise-exclusive.</li>
        <li>Fixed: open.c did not handle access mode flags correctly and was
      returning errno rather than -1 on error.</li>
        <li>Fixed: Before multitasking was enabled, printing debug messages could
      crash because it printed the current process name without checking to see
      whether there *is* a current process.</li>
        <li>Fixed: When a windowTextArea was being detroyed, it was not resetting
      the text input and output streams of the process in the multitasker.</li>
        <li>Fixed: Intensive floating point operations (for example when displaying
      JPEGs or resizing images) could cause a system crash. The exception entry
      end exit macros were incorrect.</li>
        <li>Fixed: The _xpndfmt() code used for printf-style format strings was
      initializing a 'double' type unnecessarily, causing any attempt to print
      things inside the FPU exception handler to blow up.</li>
        <li>Fixed: The sliders of the color choosers (e.g. in the display settings
      program) were 'backwards' in the sense that they should decrease to the
      left and increase to the right, intuitively.</li>
        <li>Fixed: Clicking on a filename with embedded spaces failed to open the
      file in the file browser, because it wasn't quoting the name.</li>
        <li>Fixed: The kernelWindowLayout() function now properly lays out and
      resizes the window, particularly if it's already been laid out previously.</li>
        <li>Fixed: A bug with mixing types in the sinf() and cosf() functions could
      cause floating point operations to get into an endless loop of &quot;device not
      available&quot; exceptions.</li>
        <li>Fixed: Booting was failing on Virtual PC. VPC does not properly support
      the IA-32 architecture's &quot;nested task&quot; concept. The multitasker no longer
      uses interrupt returns and nested tasks -- all task switches are done with
      far calls. Mouse and keyboard still don't work properly in VPC.</li>
        <li>Fixed: Text console error messages about not being able to find mouse
      pointer images.</li>
        <li>Fixed: The 'cdrom' program was crashing with a page fault during device
      scanning.</li>
        <li>Fixed: A kernel error message was showing in the console log when there
      was no boot splash image (a la Partition Logic) and the initialization
      code was trying to free the unallocated memory.</li>
        <li>Fixed: The parititon diagram in the Disk Manager was showing extra
      border lines when clicked, that didn't appear until moused over and
      made stranger-looking by the phantom redrawing of invisible menu items at
      the same theoretical coordinates that caused them to be discontiguous.
      The superclass image component was unhelpfully drawing its border when
      focused.</li>
        <li>Fixed: Detecting USB mice and keyboards at boot time could fail and
      prevent other devices such as PS/2 mice and keyboards from working
      properly.</li>
        <li>Fixed: When using the 'disprops' program to enable the clock on the
      desktop, clicking OK after checking the box caused a page fault.</li>
        <li>Fixed: When closing the console window opened from the command line,
      the following error message appeared:<br>
      &quot;Error:console:kernelWindowContainer.c:remove(401): No such component in
      container&quot;</li>
        <li>Fixed: The setData() function of the kernelWindowTextArea component was
      inserting a NULL 1 byte past the end of the supplied data buffer</li>
        <li>Fixed: Opening the edit program when running from a read-only filesystem
      produced the following error in the window:<br>
      &quot;Error:edit:kernelFile.c:kernelFileGetTemp(3304) Filesystem is read-only&quot;</li>
        <li>Fixed: When running the edit program from a read-only filesystem,
      specifying a non-existent file would close the program without any 
      message.</li>
        <li>Fixed: The windowTextField widget now scrolls properly horizontally.</li>
        <li>Fixed: Recursive copying of a directory into another directory using the
      'cp -R' command did not create the destination top-level directory, but
      instead merely copied the contents of the source directory.</li>
        <li>Fixed: Added a NULL-parameter check to the strlen() C library function.</li>
        <li>Fixed: the multitasker's createNewProcess() no longer crashes when the
      caller passes a NULL parameter in the argv[] array.</li>
        <li>Fixed: The native installer program created an unbootable installation
      when using a FAT32 filesystem type.</li>
        <li>Fixed: A disk caching bug wherein the cachePrune() function could be 
      called
      in the middle of a mult-part cache read or write operation.</li>
        <li>Fixed: A NULL-parameter kernel API call in the 'cal' Calendar program.</li>
        <li>Fixed: A page fault exception that could occur when starting the
      'filebrowse' File Browser program.</li>
        <li>Fixed: A bug in the C library 'memmove' function could cause a page 
      fault
      when called to move 0 bytes.</li>
        <li>Fixed: In the generic C library malloc() code, there was a bug that was
      causing partially-allocated blocks to not be split correctly. Also added a
      consistency-checking function.</li>
        <li>Fixed: The 'edit' program was creating temporary files that weren't 
      being
      deleted on exit.</li>
        <li>Fixed: A number of components were creating error messages and/or 
      crashing
      when certain files (such as mouse pointer images and icons) aren't 
      present.</li>
        <li>Fixed: When using a FAT12 filesystem, writing any FAT sector after the
      first one was causing 2 sectors to be written - resulting in a write of 
      the
      last FAT sector overwriting the first root directory sector.</li>
        <li>Fixed: The kernelConfigRead() function could overrun its line buffer if
      the line was longer then 255 bytes.</li>
        <li>Fixed: The FAT filesystem driver was under-calculating the correct size
      for the free-cluster bitmap in the case where the data clusters were not a
      multiple of 8.</li>
        <li>Fixed: Assorted compiler and script errors when working with the source 
      on
      an Ubuntu 10.10 system.</li>
        <li>Fixed: Passing an empty string to the kernelFilesystemMount() command 
      was
      resulting in the new filesystem being mounted over top of the current
      directory.</li>
        <li>Fixed: The windowIcon initializer now error checks for NULL image data.<br>
&nbsp;</li>
      </ul>
<hr>

      <p>VERSION 0.69<br>
      24/09/2007</p>
      <p>Overview: Four months in the making, this is a maintenance 
release comprising the final round of tweaks and bug fixes to the 0.6x series of 
Visopsys, featuring lots of work on the USB subsystem including support for USB 
mice/keyboards and hubs, tuning of the FAT filesystem driver, usability fixes 
for various user programs, and loads of OS kernel and C library improvements and 
bug fixes.</p>
<ul>
  <li>Lots of improvements to the USB subsystem, the UHCI 
  controller driver, and the USB SCSI disk driver.</li>
  <li>Added support for USB mice and keyboards</li>
  <li>Implemented a driver for USB hubs.</li>
  <li>Extensive tuning of the FAT filesystem driver, and the 
  scanning of the FAT at mount time is much faster. Also fixed a small 
  fragmentation bug, and turned a bunch of extraneous error messages into debug 
  messages.</li>
  <li>The FAT filesystem driver no longer stores the entire FAT 
  in memory.</li>
  <li>Added basic hardware detection for OpenHCI (OHCI) USB 
  controllers so that they're at least indicated correctly at boot time.</li>
  <li>Improved checks for removable (CD, floppy, flash, etc.) 
  media changes, invalidating the disk cache when the media changes.</li>
  <li>The 'filebrowse' program now shows the name of the current 
  directory, and remembers any selection from the parent directory so that it's 
  still selected if the user goes back up.</li>
  <li>Re-wrote much of the PS/2 mouse driver, primarily to deal 
  with out-of-sync situations that could cause the mouse pointer to jump around.</li>
  <li>Re-added the 'logout' program to the basic installation -- without it there's no 'logout' option in the shutdown menu.</li>
  <li>Added a &quot;linked list&quot; implementation to the kernel for 
  generic management of lists of pointers.</li>
  <li>Replaced bzero() calls in the kernel with kernelMemClear() 
  calls.</li>
  <li>Updated the kernel's exception handler so that it will 
  print exception address/symbol information even if multitasking isn't yet 
  enabled.</li>
  <li>Added a '-n' option to the 'format' program, for specifying 
  the volume name (label).</li>
  <li>Added a kernelDebugHex() function for doing simple hex 
  dumps.</li>
  <li>Renamed the kernelKeyBoardDriver to the 
  kernelPs2KeyboardDriver and the kernelPS2MouseDriver to the 
  kernelPs2MouseDriver</li>
  <li>Got rid of the kernelMemoryReleaseSystem() function -- the 
  regular kernelMemoryRelease() function can now handle releasing system memory 
  blocks.</li>
  <li>The printf() and family %x format specifiers now print only 
  unsigned values.</li>
  <li>Fixed: The Disk Manager showed partitions with the starting 
  and ending cylinders determined from information in the partition table. This 
  could be inconsistent (particularly in the case where geometries are guessed) 
  with the geometry of the disk as seen by the kernel.</li>
  <li>Fixed: Using the Disk Manager with a hotplugged USB disk 
  caused a divide-by-zero exception because the geometry values were zeros. The 
  kernel SCSI disk driver now determines/guesses a geometry, and the Disk 
  Manager now ensures that the values are non-zero.</li>
  <li>Fixed: Using the Configuration Editor to open a config file 
  with no predefined variables resulted in a window with no 'list' component.</li>
  <li>Fixed: The text editor couldn't create a new file.</li>
  <li>Fixed: The 'filebrowse' program could crash when you using 
  the 'del' key to delete files.</li>
  <li>Fixed: An occasional problem with ejecting ATAPI (CD-ROM, 
  etc) devices in the kernelIdeDriver code.</li>
  <li>Fixed: Spurious interrupts could cause the 
  kernelPicGetActive() function call to hang in the driver.</li>
  <li>Fixed: Command line option processing for the 'format' and 
  'rm' commands.</li>
  <li>Fixed: Calling the component 'set visible' function didn't 
  work for containers.</li>
  <li>Fixed: USB &quot;can't enable port&quot; messages.</li>
  <li>Fixed: Error messages were being double-printed on the 
  screen when console logging was in effect.</li>
  <li>Fixed: The USB UHCI driver was not returning the number of 
  bytes transferred for transactions with a data phase.</li>
  <li>Fixed: Some window ops were generating error messages 
  because they were trying to malloc() 0 bytes when the root window contained no 
  components.</li>
  <li>Fixed: The _xpndfmt() function was causing an exception 
  when printing pointers in hex using the %p format specifier.</li>
  <li>Fixed: The _xpndfmt() function was causing a divide-by-zero 
  fault when printing GUIDs in the Disk Manager.</li>
  <li>Fixed: The kernelDiskGetMediaState() function wasn't 
  locking the disk before accessing the disk structure.</li>
</ul>
<hr>

<p>VERSION 0.68<br>
10/05/2007</p>

<p>Overview: This is a maintenance release, with a focus on disk 
I/O performance (fixed the kernel's disk cache, and added IDE lookahead and 
write caching), secure deletion (shredding) of files/partitions/disks, and bug 
fixes, including important changes to the OS loader resulting in more reliable 
booting on more systems.</p>
<ul>
  <li>Re-implemented the kernel's disk caching. Previously, 
  performance was generally bad but could be horrendous under heavy I/O, as well 
  as evidence that it was buggy and could occasionally cause data corruption.</li>
  <li>Added read caching (lookahead) and write caching ability to 
  the IDE disk driver. Write caching necessitated a flush() disk driver function 
  to be called from the higher-level sync() function.</li>
  <li>In the Disk Manager, turned off software disk caching when 
  doing a disk copy operation; vastly improves I/O throughput for faster copies.</li>
  <li>Implemented new A20 address line code in the 'vloader' OS 
  loader, for successful booting on more systems. New A20 enabling methods 
  include a BIOS call and a write to port 92h.</li>
  <li>Implemented secure deletion of disk data with a 
  kernelDiskEraseSectors() function that does passes of overwriting the raw disk 
  sectors. Added an 'erase' operation to the Disk Manager to enable this for 
  partitions and whole disks.</li>
  <li>Implemented secure deletion for files, which does passes of 
  overwriting the file data. Added a command line option to the 'rm' command to 
  invoke it.</li>
  <li>Reorganized some of the malloc() code and added debugging 
  output.</li>
  <li>Added logic to the malloc() code (used both the kernel and 
  user programs) for deallocating heap memory when it is no longer being used, 
  rather than keeping it all indefinitely. Each block now keeps a record of its 
  allocation, and when the whole allocation is unused it is freed.</li>
  <li>Updated some partition tag descriptions in the kernel disk 
  code (will show up primarily in the Disk Manager).</li>
  <li>Added a '-R' option to the 'cp' program for recursive 
  directory copying.</li>
  <li>Added regular write-protect checking to the floppy driver, 
  so that by the time a filesystem is mounted we should already know if we can't 
  write to it.</li>
  <li>The kernelDevice for system memory now contains an 
  attribute with the memory size. Viewable from the 'lsdev' (Devices) program.</li>
  <li>Removed the kernelDiskSyncDisk() function, made 
  kernelDiskSync() a call for specific disks, and added a kernelDiskSyncAll() 
  function for syncing all the disks.</li>
  <li>Add a kernelDiskGetStats() function for getting disk 
  performance data, and add that info to the Program Manager's display.</li>
  <li>Added a set of software flags to the 'disk' and 
  'kernelDisk' structures to indicate changeable things like media state, door 
  state, read-only, 'sync' flag, etc. The previous 'flags' fields was really an 
  indication of the hardware type, so was changed to a 'type' field.</li>
  <li>Added a kernelDiskSetFlags() function to allow changing 
  user-settable values in the new flags field, and added a DISKFLAG_NOCACHE flag 
  to disable the software cache for the disk.</li>
  <li>Added the optional-argument-option support to the getopt() 
  C library function.</li>
  <li>Added a &quot;file ops&quot; test to the test program.</li>
  <li>Added a basic &quot;disk I/O&quot; test to the test program.</li>
  <li>Removed the redundant vshCopyFile() function from the vsh 
  library.</li>
  <li>Fixed: The floppy disk version was too full, crashed during 
  boot when it subsequently couldn't write log files, etc., and otherwise spewed 
  too many error messages.</li>
  <li>Fixed: When an IDE disk had a small multi-sector value like 
  16, reading large files could fail with an error message about too many PRD 
  entries.</li>
  <li>Fixed: In the Disk Manager, when NTFS resizing failed (for 
  example with the unclean journal message) control didn't return - it just 
  hung. </li>
  <li>Fixed: With large IDE disks, on some systems, the kernel 
  seemed to be getting 28-bit-limited geometry and size values from the BIOS. 
  The IDE driver replaces BIOS values with ones from the device/controller 
  wherever the BIOS values make more sense. </li>
  <li>Fixed: Doing a 'full' Visopsys install on a ~80mb 
  partition, after choosing to format as FAT16, could totally crash/hang the 
  system.</li>
  <li>Fixed: The mouse was leaving tracers at the rightmost and 
  bottommost edges of the screen (1 pixel width).</li>
  <li>Fixed: The kernelFileCopy() function now allocates memory 
  for its copy buffer using kernelMemoryGet() rather then kernelMalloc().</li>
  <li>Fixed: Most of the file system data allocated in the FAT 
  filesystem driver was not deallocated, simply discarded.</li>
  <li>Fixed: The kernelFileCopyRecursive() function caused a page 
  fault when it encountered an empty directory.</li>
  <li>Fixed: Though the Disk Manager's 'move partition' and 'copy 
  disk/partition' progress indicators would show the correct time, but the 
  percentage could overflow. going back to a smaller number and then climbing 
  again.</li>
</ul>
<hr>

<p>VERSION 0.67<br>
03/04/2007</p>

<p>Overview: This is a maintenance release, including a number of 
bug fixes and the addition of new capabilities to the IDE disk driver including 
PCI, DMA, and 48-bit addressing support; a significant re-engineering of the 
Disk Manager program to modularize it for new disk label types, plus support for 
moving logical partitions and creating 'preceding' logical partitions.</p>
<ul>
  <li>Added PCI, DMA, and 48-bit addressing support to the IDE 
  disk driver.</li>
  <li>Did some touchups and corrections to the Visopsys IO code 
  in the libntfs library.</li>
  <li>Implemented the ability to move logical partitions in the 
  Disk Manager.</li>
  <li>Implemented the ability to create 'preceding' logical 
  partitions in the Disk Manager.</li>
  <li>Modularized the Disk Manager so that it will be better 
  suited for working with different types of disk labels.</li>
  <li>Added a debug_io category to the kernelDebug.c functions.</li>
  <li>Added itoux() and lltoux() pseudo- C library functions for 
  printing unsigned hexadecimal strings.</li>
  <li>Commands specified for menu items in the desktop 
  configuration file are now checked to make sure they exist.</li>
  <li>Corrected the '%p' specifier printf() and family format 
  strings, so that it is printed as an unsigned value.</li>
  <li>Cleaned up new compilation warnings generated by GCC 4.1.1.</li>
  <li>Fixed: Lines of only whitespace in configuration files used 
  by the kernel configuration reader/writer functions halted processing.</li>
  <li>Fixed: Launching a new window failed to reset the global 
  &quot;focused component&quot; until the mouse was moved.</li>
  <li>Fixed: When a process was killed, the text input stream's 
  'echo' attribute was not being reset.</li>
  <li>Fixed: The FAT filesystem driver's &quot;get unused clusters&quot; 
  function was not properly returning an error if no free clusters were found.</li>
  <li>Fixed: In the Disk Manager, using the cursor keys in the 
  disk list or partition list did not change the selection.</li>
  <li>Fixed: The kernel's GUID generation routine could hang 
  because it was using an uninitialized lock structure.</li>
  <li>Fixed: When creating a new logical partition in between two 
  others, the Disk Manager didn't set the disk order correctly.</li>
  <li>Fixed: IDE disk driver now properly checks for sector 
  number overflow.&nbsp; Previously it could fail to detect attempts at &gt;28-bit 
  addressing, causing overflow at the ~130GB mark.</li>
  <li>Fixed: A bug in the 'lsdev' program printing devices when 
  the number of attributes was less than 2.</li>
  <li>Fixed: The progress dialog didn't layout properly when 
  resized, and also fixed the layout of a few dialogs and windows vis. resizing.</li>
  <li>The Disk Manager's progress dialogs that show time 
  remaining no longer zero-pad the values, and specify the time in &quot;X hours X 
  minutes&quot; format.</li>
</ul>
<hr>

<p>VERSION 0.66<br>
01/02/2007</p>

<p>Overview: This is a maintenance release, featuring the ability 
to resize Windows Vista partitions, more reliable loading on various systems, 
better exception handling, color text in graphics mode, improvements to the C 
library, and a number of bug fixes.</p>
<ul>
  <li>Ported ntfsprogs 1.13.1 (including ntfsresize 1.13.1.1) so 
  that the Disk Manager can successfully resize Windows Vista NTFS partitions.</li>
  <li>Modified the vloader OS loader so that it only uses int 15 
  to move data into high memory. Improves reliability of loading on more 
  systems.</li>
  <li>The exception handler is now a separate task, for proper 
  debugging and better reliability (in case of stack corruption, etc)</li>
  <li>Implemented proper color text output in both text and 
  graphics modes.</li>
  <li>The boot sector code was further groomed and streamlined, 
  though the work highlighted a bug in the GRUB bootloader that will always 
  prevent chain-loading Visopsys from the second hard disk.</li>
  <li>The MBR bootmenu code no longer has the number of sectors 
  to load hardcoded into it. It now reads a tracks' worth. Also changed some of 
  the memory locations used, since there might have been conflicts there.</li>
  <li>Improved the Disk Manager's confirmation/warning message 
  before resizing a partition.</li>
  <li>When the progress dialog's 'Cancel' button is disabled, the 
  mouse cursor shows 'busy'.</li>
  <li>In the Disk Manager, progress indicator more accurately 
  represents the actual times of the different stages of an NTFS resize.</li>
  <li>In the Disk Manager, the &quot;Resetting $Logfile&quot; portion of an 
  NTFS resize shows progress indication.</li>
  <li>The kernel now accepts relative pathnames to file-related 
  API functions.&nbsp; Removed all the absolute path hand-waving from programs, 
  libs, etc.</li>
  <li>Implemented the family of scanf() C library functions, 
  including fscanf(), sscanf(), vfscanf(), vscanf(), and vsscanf().</li>
  <li>Added the C library functions_num2str(), _numdgts(), and 
  _str2num().&nbsp; Removed the custom atoi(), itoa(), itob(), itox(), lltoa(), 
  lltob(), lltox(), ulltoa(), utoa(), and xtoi() functions and made them all 
  macros in &lt;stdlib.h&gt; using the 3 new functions, above.</li>
  <li>Added realpath() and strnlen() C library functions.</li>
  <li>Added the C library functions basename() and dirname(), and 
  removed the kernel API function fileSeparateLast().</li>
  <li>Removed the custom C library functions _div64(), 
  _divdi3(),_moddi3(), _udivdi3(), and_umoddi3(). We now use the libgcc 
  versions.</li>
  <li>The GUI &quot;menu bar&quot; component is no longer a container. It 
  now *has* a container, so that it can also have state information about which 
  menu is visible. Previously, raising a right-click menu in the Disk Manager 
  could cause the corresponding menu bar title to draw itself raised when it 
  shouldn't.</li>
  <li>It is now possible to 'focus' the root window (without it 
  going over top of the other windows, obviously).</li>
  <li>Fixed: FAT32 bug in which the vloader OS loader was looking 
  for the wrong terminating cluster number.</li>
  <li>Fixed: When a window was bigger than the screen dimensions, 
  moving the left side of it off the screen, then moving the mouse around the 
  right side of the window caused mouse tracers (and perhaps a GUI crash).</li>
  <li>Fixed: Dragging the 'imgboot' window off the left side of 
  the screen caused a system crash.</li>
  <li>Fixed: When a list component is disabled, the list items no 
  longer appear greyed-out.</li>
  <li>Fixed: If the 'iconwin' program can't find the icon, it 
  will try to use the standard 'executable' one instead of the generic visopsys 
  one.</li>
  <li>Fixed: The 'iconwin' program could still show an icon for a 
  program that wasn't available. Also changed the config file format so that a 
  list of icon names is not required to be specified before the individual specs</li>
  <li>Fixed: In text mode, the 'more' command could leave its 
  reverse characters on the last line if you're scrolling with any other key 
  than [space].</li>
  <li>Fixed: Printing a legitimately-escaped format sequence such 
  as %%d in user space using printf() and friends didn't work, as the kernel's 
  print routines would try to format their input again. </li>
  <li>Fixed: The C library memcmp function was comparing one too 
  many bytes.</li>
  <li>Fixed: When the text was a different color (such as an 
  error) and the screen scrolled, the cursor could remain the color of the 
  previous line.</li>
  <li>Fixed: When booting from a CD there was an error message:<br>
  Error:kernel process:kernelFile.c:fileCreate(614):<br>
  Filesystem is read-only.</li>
  <li>Fixed: Broken CD-ROM emulation was not recognized on some 
  systems.</li>
</ul>
<hr>

<p>VERSION 0.65<br>
17/12/2006</p>

<p>Overview: This is a maintenance release, with particular focus 
on the Disk Manager program, the USB subsystem, and the GUI. The Disk Manager 
can now copy and paste partitions, cancel partition move operations, format 
user-specified FAT subtypes, and has more user-friendly partition type 
selection.</p>
<ul>
  <li>Re-engineered the kernel's USB subsystem and UHCI host 
  controller driver and re-enabled basic USB support by default.</li>
  <li>Implemented per-window mouse pointers, so that applications 
  can set them appropriately according to whatever they're doing without 
  affecting anything else.</li>
  <li>The Disk Manager can now copy and paste partitions, on the 
  same disk or disk-to-disk.</li>
  <li>The Disk Manager's &quot;move partition&quot; operation now allows 
  the user to press the 'Cancel' button as long as no data from the original 
  partition location has (yet) been overwritten.</li>
  <li>Formatting FAT filesystems using the Install or Disk 
  Manager programs now allows the user to specify a FAT filesystem subtype 
  (default, FAT12, FAT16, FAT32).</li>
  <li>The Disk Manager's &quot;list types&quot; and &quot;set type&quot; dialogs now 
  display the partition types in a clickable list box selection; The user no 
  longer has to type a hex code to set the type.</li>
  <li>Added the ability to do FPU state saves and restores (with 
  help from Davide Airaghi &lt;davide.airaghi@gmail.com&gt; and Greg &lt;reqst@o2.pl&gt;).</li>
  <li>Added a global window manager variable list.</li>
  <li>Added &quot;mouse enter&quot; and &quot;mouse exit&quot; events for windows.</li>
  <li>Added fopen(), fclose(), and strcasestr() C library 
  functions.</li>
  <li>Created a proper test suite harness program. Initial tests 
  implemented are for text output, port I/O protection, floating-point, and some 
  GUI operations.</li>
  <li>Code improvements to the implementation of window component 
  levels.</li>
  <li>The generic window component now has some container 
  functions built in, such as layout(), numComps(), flatten(), and setBuffer(), 
  so that all 'composite' components that contain others can have their 
  sub-components participate in various actions.</li>
  <li>The processing of window events no longer tries to 
  determine the precise component the event happened to -- instead events are 
  now cascaded down through any/all applicable containers, components, 
  subcomponents, etc. Added an eventComp() function to window components so that 
  they can specify whether they want some sub-component to receive a particular 
  event, otherwise it goes to the component itself by default.</li>
  <li>Added a little removeFromContainer() inline function for 
  removing components from their parent container.</li>
  <li>The floppy disk driver now does better memory management of 
  its list of disks, devices, driver data, etc.</li>
  <li>Fixed: Divide-by-zero fault in the kernel's random number 
  code, caused by any call to the rand() C library function.</li>
  <li>Fixed: The 'cat' and 'more' commands were crashy.</li>
  <li>Fixed: Closing the Command Window program could 
  occasionally cause system crashes.</li>
  <li>Fixed: Booting could fail (system crash) when the (FAT) 
  root filesystem was nearly full.</li>
  <li>Fixed: A bug in the Disk Manager's format() function was 
  preventing it from offering the choice 'none' (clobber).</li>
  <li>Fixed: Creating logical partitions in the Disk Manager 
  could cause page fault exceptions when writing the changes.</li>
  <li>Fixed: Formatting a too-large disk as FAT12 caused a 
  divide-by-zero fault.</li>
  <li>Fixed: Clicking on a context menu item that didn't fall 
  within the bounds of its parent window had no effect.</li>
  <li>Fixed: When resizing the Disk Manager window, the partition 
  diagram didn't completely redraw its entire width.</li>
  <li>Fixed: When the Display Settings program was used to set 
  the global colors, there were some window components whose colors were 
  changing incorrectly including icons, lists, and menu items/list items.</li>
  <li>Fixed: When changing a variable in the Configuration 
  Editor, clicking OK caused remnants of the selected item to be erroneously 
  drawn at the top of the window.</li>
</ul>
<hr>

<p>VERSION 0.64<br>
25/10/2006</p>

<p>Overview: This is a maintenance release, with extensive code 
grooming and bug fixes. There has been a particular focus on the GUI code, 
kernel debugging, the kernel API, gcc 4.x warnings, and compiler optimization 
problems. New user-visible features include the addition of right-click context 
menus and support for 32-bit bitmaps and icons.</p>
<ul>
  <li>Booting now works under the Bochs 2.3 emulator (failed in 
  graphics mode under earlier versions)</li>
  <li>Implemented right-click context menus.</li>
  <li>Added support for 32-bit .bmp bitmap images and .ico icons</li>
  <li>The Disk Manager's canvas now responds to keyboard cursor 
  inputs.</li>
  <li>Did general, large-scale GUI re-engineering. </li>
  <li>Fixed compilation errors under gcc 4.x</li>
  <li>Added some API debugging</li>
  <li>Moved the sysCall() inline function into a _syscall.c file 
  to avoid problems with gcc (optimization) function inlining.</li>
  <li>Dialog windows no longer appear in the window shell's 
  window list.</li>
  <li>Multitasking/scheduling changes: Separated out the 
  scheduler's code for choosing the next program to run (into a subroutine), 
  corrected the big comment that describes the scheduling algorithm, fixed a bug 
  that might have resulted in a NULL pointer dereference, made it so the 
  exception handler is never interrupted by another process, and added a 
  kernelProcessingException variable that exports the exception number being 
  processed.</li>
  <li>Implemented a generic kernel debugging functionality that 
  can be compiled in conditionally, and that can filter messages by categories 
  (for example, there is a category for GUI debugging and a category for USB 
  debugging), as well as filtering by source file.</li>
  <li>Disabled USB support for now, since it's broken and can 
  cause some boots to hang</li>
  <li>The window border component only ever drew when it was 
  called to draw the top border, since it could only draw the entire border. Now 
  the 'draw gradient border' function can draw individual lines of a border and 
  the border component draws the parts individually.</li>
  <li>Did some cleanup of the vloader OS loader code</li>
  <li>Added a function to redraw all the windows, and another one 
  that resets all of the (non-custom) colors of all the windows' components. 
  Setting the colors in the 'Display Settings' program uses this to change all 
  of the window colors immediately.</li>
  <li>Added more debugging info to errors in the malloc() code.</li>
  <li>Added a userspace flag for components that aren't focusable 
  by default. Subsequently, 'canvas' components are no longer focusable by 
  default.</li>
  <li>Creating window menus is now done more simply by passing a 
  structure with the list of menu items, then calling the getSelected() function 
  to find out which one was clicked. Also implemented the more-useful getData() 
  function, which returns the objectKey of the selected item.</li>
  <li>Implemented a window 'slider' component to wrap the scroll 
  bar component, so that it can be focusable and accept keyboard input. (And 
  adapted the window library color chooser dialog to use it).</li>
  <li>Window canvas components now show a visual change when they 
  are focused.</li>
  <li>GUI menu components now have their own graphic buffers, so 
  that regardless of what window they come from they can stay on top, extend 
  outside the window, etc.</li>
  <li>The install.sh script now copies any /bootinfo or /grphmode 
  files into the CD-ROM boot floppy images.</li>
  <li>The install/imaging scripts no longer redirect useful error 
  output to /dev/null -- they now redirect to temporary log files, check exit 
  codes, and direct the user to the log files if applicable.</li>
  <li>The window manager code now has more efficient memory 
  management, so that it isn't allocating memory for the entire array of 
  possible window structures at initialization time.</li>
  <li>Created a top-level Makefile.include file for all the code 
  Makefiles, added some more warning flags to it, and fixed the resulting 
  warnings.</li>
  <li>Made gcc optimization args (-00, -02, etc) a global 
  Makefile variable</li>
  <li>The objectKey type is now a 'volatile void *'</li>
  <li>Made data structures throughout properly self-referential 
  (instead of using void * pointers) and removed all of the unnecessary casting, 
  for (hopefully) fewer coding errors.</li>
  <li>Fixed: The vloader OS loader was being written to the 
  *second* free cluster by the Fedora VFAT driver when not using FAT32. Made a 
  hack to adjust it when installing from Fedora, and generally streamlined the 
  copy-boot program.</li>
  <li>Fixed: A slight bug in the FAT code in that it relied too 
  strictly on the Microsoft definition of FAT-type detection. Now it takes into 
  account a couple of extra hints.</li>
  <li>Fixed: The 'view' program wasn't showing tab characters 
  properly in text files.</li>
  <li>Fixed: The 'vsh' shell would crash if the user entered a 
  line containing only whitespace.</li>
  <li>Fixed: A bug in the copyArea() function of the framebuffer 
  graphic driver in that it wasn't checking to see whether the areas were 
  outside the buffer.</li>
</ul>
<hr>

<p>VERSION 0.63<br>
15/08/2006</p>

<p>Overview: This is a maintenance and bugfix release, with 
numerous small tweaks throughout the entire system. New features include the 
ability to format and resize Linux swap partitions, more reliable OS loading, 
more detailed CPU detection, and a simple text editor.</p>
<ul>
  <li>Added formatting and resizing support for Linux swap 
  partitions.</li>
  <li>Added a basic, simple text editor (currently only works in 
  graphics mode).</li>
  <li>The OS loader now does improved memory moves to high memory 
  for better reliability on more systems.</li>
  <li>Added improved CPU detection to the kernel 'system' driver.</li>
  <li>Added the beginnings of a 32-bit BIOS driver.</li>
  <li>The file list widget and the file dialog have been reworked 
  so that they don't use a separate GUI thread, since that was unreliable and 
  crashy.</li>
  <li>GUI applications can now enable click-driven cursor 
  movements in text areas.</li>
  <li>Removed the hard limit on the maximum number of window 
  components.</li>
  <li>The kernel now records and uses a network domain name, both 
  via DHCP and via the kernel's config file.</li>
  <li>There are now kernel functions to get and set the host and 
  domain names, as well as UNIX-style command line functions.</li>
  <li>Added a kernelSystemInfo() function, similar to the UNIX 'uname' 
  syscall.</li>
  <li>Added a variable list of text-string attributes to all 
  hardware device structures.</li>
  <li>The window 'component parameters' structure now has a 
  'flags' field to be used for all boolean values.</li>
  <li>Added getWidth() and getHeight() functions for fonts.</li>
  <li>Text screen saving and restoring now uses caller-supplied 
  pointers instead of storing a single instance in kernel memory.</li>
  <li>Added a text API function to enable or disable screen 
  scrolling.</li>
  <li>Window resize events now go into the window's event stream 
  so that applications can catch them.</li>
  <li>The scrollbar slider now has a minimum size, so that it's 
  clickable even when there's lots of data to scroll through.</li>
  <li>The makefile variables for $CC, etc., are now settable from 
  the top-level makefile.</li>
  <li>The 'ldd' program was really more like an 'nm' program, so 
  it was renamed.</li>
  <li>Fixed: PS/2 mouse driver synchronization problems on some 
  systems.</li>
  <li>Fixed: The Disk Manager's 'set type' menu item was failing 
  to bring up the dialog.</li>
  <li>Fixed: After resizing a filesystem, the Disk Manager no 
  longer shows the warning &quot;Can't write partition table backup in read-only 
  mode&quot; (if booted from a CD, for example). This just scared people.</li>
  <li>Fixed: When entering the filesystem resizing value in the 
  Disk Manager's text mode, it didn't allow you to append 'c' or 'm' for size in 
  cylinders or megabytes.</li>
  <li>Fixed: The Disk Manager no longer continually pesters users 
  about incorrect CHS values in partition entries; one 'no' answer now turns it 
  off.</li>
  <li>Fixed: The FAT filesystem driver now ensures that items 
  it's processing (when it's constructing short filenames, or writing 
  directories) belong to its own filesystem (as opposed to mount points for 
  other filesystems, for example).</li>
  <li>Fixed: If the 'imgboot' program's config files contained 
  commands with arguments, the icons weren't shown because the program didn't 
  separate off the arguments and therefore couldn't locate the commands.</li>
  <li>Fixed: Using the 'view' program to view a really small or 
  really large image caused GUI crashiness.</li>
</ul>
<hr>

<p>VERSION 0.62<br>
24/04/2006<br>
<br>
Overview: This is a maintenance release.&nbsp; Some new features include basic 
USB controller support, a USB mass-storage driver, device hotplugging, Qemu 
support, loading of RLE encoded bitmaps, a 'programs' icon, and 'minesweeper' 
and 'snake' games.</p>
<ul>
  <li>Implemented basic USB support for UHCI controllers.</li>
  <li>Implemented a SCSI driver that can support USB mass storage 
  devices.</li>
  <li>Added basic hot-plugging support for devices.</li>
  <li>Added support in the image functions for loading RLE 
  encoded bitmaps.</li>
  <li>Added a 'programs' icon.</li>
  <li>Added 'minesweeper' and 'snake' games.</li>
  <li>Added an icon for Bauer Vladislav's calendar program.</li>
  <li>Implemented a proper kernelBus top-level infrastructure for 
  use by the PCI driver, USB driver, etc.</li>
  <li>The display devices and text console drivers are now 
  initialized separately and before other hardware, so that hardware detection 
  messages can be shown while detection is going on.</li>
  <li>The 'computer' program now continuously scans for new 
  disks.</li>
  <li>The 'shutdown' command now has a command-line flag for 
  rebooting, and the 'shutdown' and 'reboot' commands now have command-line 
  flags for ejecting the boot media, if applicable.</li>
  <li>The 'iconwin' and 'filebrowse' programs now change the 
  mouse pointer when they're busy loading up a file or program.</li>
  <li>The 'iconwin' program now continues silently when programs 
  or icons specified in the config file are missing.</li>
  <li>The boot menu now has a default selection and timeout 
  period (settable by the 'bootmenu' program).</li>
  <li>There is now an 'active menu' global window system variable 
  so that the focused menu can always be on top, and always go away then it 
  loses focus.</li>
  <li>Fixed: Booting failed on Qemu due to a PS/2 mouse driver 
  hang.</li>
  <li>Fixed: The 'bootmenu' program failed to run from a 
  read-only media.</li>
  <li>Fixed: The boot menu timer was counting down too quickly.</li>
  <li>Fixed: The 'install' program failed if a directory it 
  wanted to create already existed.</li>
  <li>Fixed: The 'defrag' program was giving &quot;can't defrag 
  filesystem type 'unknown'&quot; messages for things like floppies that hadn't been 
  mounted.</li>
  <li>Fixed: The kernelDiskGetMediaState() function was returning 
  0 for flash disks</li>
</ul>
<hr>

<p>VERSION 0.61<br>
26/01/2006<br>
<br>
Overview: This is a maintenance release. Some new features include Disk Manager 
support for resizing NTFS filesystems and arbitrary partitions, purely 
unprivileged user-space processes, I/O port permissions and protection, IDE 
block mode I/O, Linux swap detection and clobber, improved atomic kernel locks, 
many C library additions, and a calendar program, in addition to assorted bug 
fixes.</p>
<ul>
  <li>The Disk Manager can now resize Windows XP (NTFS) 
  partitions, as a result of porting Linux ntfsprogs NTFS resizing code.</li>
  <li>The Disk Manager will now allow partition-only resizing 
  regardless of the filesystem type (with appropriate warnings).</li>
  <li>All userspace programs now run in unprivileged CPU mode, 
  regardless of actual privilege level, and I/O privilege maps have been 
  implemented by Davide Airaghi.</li>
  <li>Improved IDE/ATA hard disk driver performance by 
  implementing block-mode I/O.</li>
  <li>Added basic 'stub' NTFS filesystem support (detection and 
  clobber).</li>
  <li>Added basic 'stub' Linux swap filesystem support (detection 
  and clobber).</li>
  <li>The kernel's locking code now implements real atomic 
  locking.</li>
  <li>Added Bauer Vladislav's calendar program.</li>
  <li>All threads now use the same page directory control data as 
  their process parents for better synchronization.</li>
  <li>Process stacks now have guard pages at the top which are 
  privileged, so that user process stack overflows cause protection faults.</li>
  <li>The C library now has a proper suite of malloc() 
  functionality -- taken from the kernel's implementation -- which is now used 
  by the kernel instead so it can be used for user space without code 
  duplication.</li>
  <li>Added a kernelMemoryBlockInfo() function to return 
  information about an allocated memory block. Useful for the realloc() libc 
  function.</li>
  <li>Added a kernel disk function for rescanning the partitions 
  of a single disk.</li>
  <li>Added a lock to the 'progress' data structure.</li>
  <li>Implemented 'confirmation' capability in the progress 
  structure and the libvsh and libwindow progress bar/dialog functions.</li>
  <li>Add a kernel filesystem function for getting statistics 
  about a filesystem (whether it's mounted or not, or indeed, properly supported 
  or not).</li>
  <li>Added a kernel filesystem function for getting resizing 
  constraints.</li>
  <li>Added a kernel filesystem function for requesting specific 
  detection of filesystem type (useful for removable media and such).</li>
  <li>The text-mode installer now offers to let you partition 
  first.</li>
  <li>The text mode Disk Manager now show the operations/commands 
  in two columns.</li>
  <li>Added a window library 'radio dialog' for presenting 
  choices in a radio button format.</li>
  <li>The Disk Manager's 'move partition' and 'copy disk' 
  functions now uses standard progress dialogs and show time estimates.</li>
  <li>The kernel logging thread now has a lock on the log, so 
  that the log doesn't get garbled by different processes logging at the same 
  time.</li>
  <li>The OS loader's screen output is now saved in a file 
  (/system/vloader.log) so that it can be examined afterwards.</li>
  <li>Removed the source code from the ISO distribution.</li>
  <li>Printf()-style C library functions now support 
  left-justification ('-') format specifiers.</li>
  <li>Added C library functions lltoa(), lltob(), lltox(), and 
  ulltoa() to support 'long' format specifiers and arguments.</li>
  <li>Added C library functions mbstowcs(), mbtowc(), and wctomb() 
  for wide-character support.</li>
  <li>Added C library functions fflush(), ffs(), fgets(), realloc(), 
  strdup(), strerror(), vfprintf(), vprintf(), vsnprintf(), and vsprintf().</li>
  <li>Added C library functions for 64-bit divisions such as 
  __div64(), __divdi3(), __moddi3(), etc.</li>
  <li>Enabled the C library functions such as fgetpos(), fread(), 
  fsetpos(), fflush(), fgets(), ftell(), fprintf(), fseek() and fwrite() (as 
  applicable) to behave correctly when the FILE* stream is 'stdin', 'stdout', or 
  'stderr'.</li>
  <li>Added C library header files endian.h, stdint.h, and &lt;sys/cdefs.h&gt;.</li>
  <li>Fixed: After formatting FAT32, Linux and older Windows 
  installers would show the filesystem as 100% full.</li>
  <li>Fixed: Errors with IDE/ATA hard disks as secondary masters.</li>
  <li>Fixed: Unformatting (clobbering) a partition in the disk 
  manager didn't seem to convince the kernel to un-detect the previous 
  filesystem until reboot.</li>
  <li>Fixed: The graphical 'ifconfig' program wasn't updating the 
  device text after starting/stopping networking.</li>
  <li>Fixed: The wallpaper program was not properly shutting down 
  its window thread.</li>
  <li>Fixed: The imgboot program failed to exit after calling the 
  login program.</li>
  <li>Fixed: There was a (harmless) error message when running 
  the 'ldd' program against an executable program because it always tried to 
  load the file as a library.</li>
</ul>
<hr>

<p>VERSION 0.6<br>
30/11/2005<br>
<br>
Overview: This release introduces a host of new functionality including a 
cleaned up desktop with icons for browsing the computer, file systems, and 
administrative tasks, FAT defragmenting, ELF dynamic linking, a built in 
chain-boot loader and simple MBR formatting, file browsing widgets and dialogs, 
Windows .ico icon file support, a generic file viewing program, Italian keyboard 
support, new icons and a new splash screen.</p>
<ul>
  <li>Added a 'Computer' icon, equivalent to the one in Linux or 
  'My Computer' in Windows.&nbsp; It shows the different disks, auto-mounts them 
  (if applicable) when clicked, and launches a file browser.</li>
  <li>Added a 'File Browser' icon.</li>
  <li>Added an 'Administration' icon which brings up a window for 
  various other programs that were previously on the default desktop.</li>
  <li>The 'view' program is now a more generic program for 
  default viewing of various sorts of files.</li>
  <li>Added defragmenting capability to the FAT filesystem 
  driver.</li>
  <li>Implemented shared libraries and dynamically linked 
  executables.&nbsp; All included libraries and programs are now dynamic.</li>
  <li>Implemented a simple, chain-loading MBR boot menu for 
  loading from different partitions and operating systems.&nbsp; The 'bootmenu' 
  program lets the user edit the menu strings and set parameters.&nbsp; Also 
  accessible from the Disk Manager.&nbsp; ** Note that this will NOT load any 
  Linux installation<br>
  that uses an initrd.</li>
  <li>Implemented simple MBR code, so that for example the Disk 
  Manager can be used to rescue a system from a deleted or corrupt GRUB 
  installation.</li>
  <li>Added .ico icon file format support and converted many 
  existing icons to that format.</li>
  <li>Created file browsing widgets/dialogs.</li>
  <li>There is a new splash screen image and a number of new 
  icons.</li>
  <li>Text areas now use white background and blue text as the 
  default colors.</li>
  <li>Added Davide Airaghi's Italian keyboard mapping.</li>
  <li>Some preliminary networking support has been added, but for 
  the moment it is disabled by default.&nbsp; The only network device driver 
  provided is for the &quot;Lance&quot; (AMD PC-NET) card, which can be simulated under 
  VMWare.&nbsp; In the 'Administration' window, there is now a 'Network' icon 
  that proves access to a simple 'Network Devices' program which, for now, just 
  shows devices, status, settings, dynamic (via DHCP) IP address, etc.&nbsp; 
  There is also a 'ping' command.</li>
  <li>The new exception handler prints out more diagnostic 
  information (exception type, and more)</li>
  <li>There is now a vsh library function for a text mode 
  progress bar.</li>
  <li>The format program now shows a progress bar in text mode.</li>
  <li>The Disk Manager will refuse outright, or warn/confirm 
  before moving, formatting, or deleting mounted partitions. </li>
  <li>The 'disks' command now shows mount points.</li>
  <li>Created an 'iconwin' program that uses config files to 
  create custom windows with icons, and user-specified actions associated with 
  them.</li>
  <li>Added a /CREDITS.txt file for listing others' 
  contributions.</li>
  <li>There is now a /system/mouse/ directory for mouse pointer 
  images, a /system/config/ directory for .conf files of all programs and the 
  kernel, a /system/mount directory for automatic mounting, and a 
  /system/wallpaper directory for background images.</li>
  <li>Created a 'progress dialog' window library feature that 
  utilizes the 'progress' structure and shows a progress bar and status 
  messages.</li>
  <li>The exception handler is no longer a standalone task, in 
  order to do FPU state saves/restores without setting the CR0[TS] bit.</li>
  <li>Handles exceptions generated when a process attempts to do 
  floating point operations after a task switch.</li>
  <li>The filesystem structure is now contained within the logical 
  disk structure.</li>
  <li>The user-space 'disk' object now indicates whether a 
  partition is mounted, and if so, the mount point.</li>
  <li>Exported a portion of the kernelDevice structure as a new 
  'device' structure, and created API functions to export the hardware device 
  tree.</li>
  <li>'Atomized' some of the ASM macros in kernelProcessorX86.h 
  so that they can be reused in other more complex macros</li>
  <li>Added floorf(), sin(), cos(), and tan() functions to the C 
  lib.</li>
  <li>Added support for %b format specifiers in the _xpndfmt.c 
  functions by adding another bogus C library routine (itob).</li>
  <li>File changes: Changed 'kernelMiscFunctions.*' to 'kernelMisc.*', 
  and the kernelPageManager and kernelMemoryManager have had the 'Manager' bit 
  taken out of their file/function names.</li>
  <li>Added window library functions to clear an event handler 
  and to get the window thread PID</li>
  <li>Implemented a 'progress' data structure that can be passed 
  to (for example) long filesystem operations such as format, check, resize.</li>
  <li>The 'map to free' functionality of the paging code no 
  longer, by default, allocates the first page in the address space.&nbsp; This 
  makes it easier to detect/guide against NULL pointer dereferences.</li>
  <li>Got rid of the 'diskType' and 'mediaType' enums from the 
  various disk structures, and instead use a set of logical flags to describe 
  disks.</li>
  <li>Removed the deprecated windowPack() and windowSetPacked() 
  API functions.</li>
  <li>Fixed: In the Disk Manager, canceling a new partition 
  creation at the label type stage caused 2 changes to show as pending.</li>
  <li>Fixed: The Disk Manager's partition reordering menu didn't 
  display changes properly in text mode.&nbsp; It worked but the changes weren't 
  reflected in the menu.</li>
  <li>Fixed: The lost+found directory created by the EXT2 
  formatting code was not readable when we mounted the filesystem.&nbsp; Also, 
  the permissions are now set to the same values as Linux mke2fs.</li>
  <li>Fixed: Using the 'gcc version 3.4.2' and 'ld version 
  2.15.92.0.2' combo (Fedora Core 3), generated programs had a new, unexpected 
  number (3) of ELF program header entries.</li>
  <li>Fixed: Selecting partition/list types in the Disk Manager 
  could crash the program.</li>
  <li>Fixed: The Program Manager was associating some child 
  threads with the wrong parents in the process list.</li>
</ul>

<hr>

<p>VERSION 0.58<br>
03/10/2005</p>
<p>Overview: This is a maintenance and bugfix release. Some new 
features include support for EXT2 filesystem formatting, German keyboard 
layouts, GUID (Globally-Unique Identifier) generation, and filesystem clobber.&nbsp; 
Also includes a number of important bugfixes to the Disk Manager program.</p>
<ul>
  <li>Implemented EXT2 formatting.</li>
  <li>Added Jonas Zaddach's German keyboard layout</li>
  <li>Added GUID-generating capability to the kernel.</li>
  <li>Filesystem drivers that support 'format' functionality now 
  also support 'clobber' functions, so that for example when a format is done, 
  the filesystem doesn't still get detected as the previous type. </li>
  <li>The filesystems code now has a proper array of all the 
  different filesystem drivers, that can be iterated through (for example, when 
  doing filesystem detection).</li>
  <li>Implemented a &quot;multi choice dialog&quot; that shows buttons with 
  user-specified text strings and returns the index of the specified choice.</li>
  <li>Fixed: In the Disk Manager, when creating partitions, it 
  wasn't possible to create logical partitions. When choosing primary, no 
  primary/logical attribute was shown.</li>
  <li>Fixed: The EXT filesystem code would fail to mount small 
  filesystems with only a single block group, where the number of blocks was 
  less than the maximum blocks per group.</li>
  <li>Fixed: In the graphics mode Disk Manager, after specifying 
  start and end values for a new partition, pressing 'Cancel' in the tag type 
  dialog didn't stop the partition from being created.</li>
  <li>Fixed: The Disk Manager's 'move' function check for empty 
  space on either side of a partition could produce a false error</li>
  <li>Fixed: The Disk Manager was telling the kernel to reread 
  the partitions too frivolously (especially in between writing the main and 
  extended partition tables).</li>
  <li>Fixed: The vsh shell's code for marshalling quoted 
  arguments was broken (e.g. 'touch &quot;foo bar&quot;' created 2 files, foo and bar)</li>
  <li>Fixed: The libc time() function is producing dates off 
  (slow) by 1 year.</li>
</ul>

<hr>

<p>

VERSION 0.57<br>
24/08/2005</p>

<p>Overview: This is a maintenance and bugfix release.&nbsp; 
There are various GUI touch-ups, the Disk Manager now updates disk geometry 
information in FAT partitions after disk copy operations, the window 'list' 
component has been reimplemented, and a number of kernel improvements have been 
back-ported from the 0.6 development branch.</p>
<ul>
  <li>When the disk manager does disk-to-disk copies, it now 
  ensures that the disk geometries stored in any FAT partitions are correct.</li>
  <li>Window lists components now have multi-column mode 
  implemented, are now capable of showing various combinations of icons, text, 
  or both, and they are now able to resize successfully, so that more rows can 
  become visible and multi-column lists get extra columns.</li>
  <li>Added a window 'selection event' that widgets (such as the 
  window list) can use to differentiate between a pointless click or scrollbar 
  event and a real user selection.</li>
  <li>Moved command line parsing code into the kernel's loader so 
  that it will parse a raw command line.</li>
  <li>The window text area component now has an 'update' function 
  that is called by the text area subcomponent to let it know when it has 
  updated (so the window component can update the scroll bar, for example)</li>
  <li>Added API functions to export the hardware device tree. </li>
  <li>Exported a portion of the kernelDevice structure as a new 
  'device' structure.</li>
  <li>A bunch of the buttons from various windows have had their 
  'fixed width' parameters set.</li>
  <li>Added a 'delete recursive' convenience file function.</li>
  <li>There is now a loaderClassifyFile function that just 
  temporarily reads in the first few sectors of a file in order to classify it.</li>
  <li>Added loader file class functions for generic text and 
  binary files, and boot sectors.</li>
  <li>Added an snprintf C library function.</li>
  <li>The vshFileList (the 'ls' command) function now prints more 
  efficiently.&nbsp; Previously made millions of print calls.</li>
  <li>Added a kernelFileCount function to the file functions, so 
  that it's easy to preallocate memory for file entries, etc.</li>
  <li>The windowGuiThread library function now returns the PID of 
  the GUI thread process so that calling programs can monitor its survival.</li>
  <li>Updated the help file documentation for the program files.</li>
  <li>Fixed: If the user doesn't have administrator privileges, 
  the 'disprops' program now grays out the list of screen resolutions because 
  the kernel won't allow it to be changed.&nbsp; Also, the API functions to 
  get/set the window manager colors have been made into user-privilege 
  functions.</li>
  <li>Fixed: After &quot;user authentication failed&quot;, the login 
  program stopped responding.</li>
  <li>Fixed: Depending on screen contents, the icon layout in the 
  kernel window shell could allow the text of the bottom-most icon to wrap off 
  the screen.</li>
  <li>Fixed: The console text area's scroll bar was not being 
  added to windows when the rest of the text area was added; thus the scroll bar 
  did not appear.</li>
  <li>Fixed: The 'wallpaper' program failed to set the wallpaper 
  if the file name supplied in the file dialog was an absolute path.</li>
  <li>Fixed: The window list item code had an error in which it 
  undercalculated the length of the text string.</li>
</ul>

<hr>

<p>VERSION 0.56<br>
22/07/2005</p>
<p>Overview: This is a maintenance and bugfix release. Important 
fixes include the elimination of boot hangs due to faulty mouse initialization 
and full kernel variable lists, a fix to the detection of secondary hard disks, 
and a fix to faulty mounting of EXT2/3 filesystems.&nbsp; In addition, important 
multitasker improvements related to process initialization have been back-ported 
from the 0.6 development branch.</p>
<ul>
  <li>Fixed: The system could fail to boot in graphics mode due 
  to faulty mouse initialization</li>
  <li>Fixed: The kernel's symbol variable list was becoming full 
  and causing various boot initializations to fail. The kernel's variableList 
  code has been changed so that it automatically manages list memory.</li>
  <li>Fixed: &quot;ID or target sector not found&quot; messages during boot 
  when a second (slave, for example) hard disk was present.</li>
  <li>Fixed: EXT2 mounting had become generally broken</li>
  <li>Back-ported the 0.6 branch multitasker changes (to do with 
  processImage structures and argument passing).</li>
  <li>The exception handler process now displays a dialog box 
  when a program crashes, so that they don't simply disappear (requiring the 
  user to look at the console output for the reason)</li>
  <li>Added a system to generate the programs' help file text 
  from comments within the source code, so that it's easier to keep up to date.</li>
  <li>Fixed: When a mount attempt failed, it was possible to end 
  up with a rogue '/' entry added to the root directory, which could render the 
  whole directory tree useless until reboot.</li>
  <li>&quot;Genericized&quot; the image loading functions so that they 
  first identify the format, then call the appropriate routines to interpret it.</li>
  <li>Fixed: When calling kernelWindowDestroy() with a window 
  that had user containers, there were a number of &quot;Container data is NULL&quot; 
  error messages.</li>
  <li>The kernelError code no longer prints the current process 
  name if the error occurs inside an interrupt handler; it prints the interrupt 
  handler number instead.</li>
  <li>Any window components that contain other components now 
  remove them from the parent container, if applicable. (windowTextArea and 
  windowTitleBar, for example).</li>
  <li>Fixed: After choosing the destination disk in the install 
  program, there was an error message from kernelMemoryManager.c:838:The memory 
  pointer is not mapped.</li>
  <li>The ELF loader code now marks executable code pages as 
  read-only, ELF headers are now processed more correctly (side effect: 
  eliminating various messages about unexpected number of ELF headers)</li>
  <li>Changed the FAT, EXT, and ISO filesystem drivers to take 
  more advantage of packed structures for better efficiency.</li>
  <li>Fixed: The 'format' program was inadvertently ignoring the 
  '-t' filesystem type option.</li>
  <li>Fixed: If the default background color was not used, the 
  text area widget's scroll bar would use that background color rather than the 
  normal grey.</li>
  <li>Un-exported the filesystem functions in the FAT, ISO, and 
  EXT drivers.</li>
  <li>The 'imgboot' program now shows the OS version in the 
  title.</li>
</ul>

<hr>

<p>VERSION 0.55<br>
18/05/2005</p>
<p>Overview: This is a maintenance and bugfix release, with some 
additional capabilities including installation support for all FAT filesystems, 
primitive PCI driver support, and a better organised device driver 
infrastructure. In addition, GUI window layout and resizing has been 
reimplemented and generally fixed.</p>
<ul>
  <li>The system can now install to and boot from any kind of FAT 
  filesystem (FAT12, FAT16, and FAT32/VFAT).</li>
  <li>Fixed window relayout when windows are sized.</li>
  <li>Implemented a better-organised hardware device &quot;tree&quot; and a 
  new, more generic device driver interface.</li>
  <li>Added a basic PCI bus driver, the initial implementation of 
  which was provided by Jonas Zaddach. Only logs a bus device scan, for the 
  moment.</li>
  <li>Implemented a basic a signalling infrastructure, which 
  initially fixes the problem of CTRL-C crashing the system in text mode.</li>
  <li>Back-ported a number of changes and improvements from the 
  0.6 branch to the kernel's disk layer.</li>
  <li>Added a 'debug window layout' function that displays the 
  layout grid alongside the components; makes it much easier to do program 
  window design and to debug the kernel's layout code.</li>
  <li>The window manager's event handler thread now dynamically 
  allocates the memory it uses for storing event hooks.</li>
  <li>Implemented the 'swab' libc function. Useful for 
  networking.</li>
  <li>The page manager's 'get physical address' function has been 
  modified so that it works with addresses that aren't page-aligned.</li>
  <li>The interrupt controller functions now have a function that 
  returns the active interrupt number, and synchronized the kernel's hardware 
  interrupt number codes with the 'normal' PC interrupt numbers (e.g. 0-F).</li>
  <li>Fixed: Interrupts are now disabled during the pause before 
  reboot, so that for example the kernel is not still processing I/O interrupts 
  and such.</li>
  <li>Fixed: A number of small issues with the kernelWindowStream 
  code.</li>
  <li>Fixed: In the install program, installing on a 
  freshly-inserted floppy. could produce the error message &quot;can't install a boot 
  sector for filesystem type 'unknown'&quot;.</li>
  <li>Fixed: When installing from a 'basic' install, there was a 
  spurious error message resulting from attempting to look for the 'full' 
  install file.</li>
</ul>
<hr>

<p>VERSION 0.54<br>
22/03/2005</p>
<p>Overview: This is a maintenance release, with numerous small 
improvements and bug fixes including some general back-porting from the 0.6 
development branch.&nbsp; In addition, IDE disk-to-disk operations have been 
improved so that they can happen in parallel, the kernel hardware drivers' 
interrupt handing has been given a new interface, and there is some improved 
efficiency in a performance-critical section of the multitasker.</p>
<ul>
  <li>Updated the IDE disk controller locking, so that each now 
  have their own locks; thus I/O can be done in parallel between disks on 
  different controllers.</li>
  <li>Back-ported large numbers small changes and improvements 
  from the 0.6 development branch.</li>
  <li>Cleaned up the kernelInterrupt code, got rid of all the 
  'default' handlers, added an interface for getting/hooking the vectors, and 
  changed all the built-in drivers to use the interface. All interrupts are now 
  initially masked off, and the hardware driver code for each kind of device has 
  to turn them on after hooking the handler.</li>
  <li>The bootable floppy image for the ISO distribution now 
  contains only the OS loader and the kernel, because only these are used. This 
  shrinks the (zipped) ISO image size.</li>
  <li>The calculation of CPU percentage in the multitasker's 
  scheduler is now done more efficiently, inside the loop that evaluates the 
  process queue.</li>
  <li>Added text 'save screen' and 'restore screen' functions for 
  use by programs such as 'fdisk' and 'install' which clear the screen.</li>
  <li>Added convenience functions to the kernelUser code for 
  working with arbitrary password files, so that for example the installer can 
  set up the destination password file without doing it all manually.</li>
  <li>Added kernelDiskGet() (single logical or physical), 
  kernelDiskGetAll(), and kernelDiskGetAllPhysical() functions.</li>
  <li>The kernel's page manager now includes a method for setting 
  flags on pages (such as writable, present, cache disable, etc), and a function 
  that allows memory to be mapped at a particular address.</li>
  <li>Created a user-space 'process image' structure that can 
  describe details such as memory page mapping, virtual addresses, entry points, 
  arguments, and so on.</li>
  <li>kernelError.h now contains the include for &lt;sys/errors.h&gt;</li>
  <li>Fixed: Copying a big file such as an .iso image could fail 
  because the copy code tried to allocate enough memory for the whole file. Now 
  it allocates as much as possible and does multiple reads/writes</li>
  <li>Fixed: Typing and using the mouse at the same time was 
  causing funny things to go on. The interrupt handlers for the two devices 
  needed to be better synchronized.</li>
  <li>Fixed: When dragging an icon, one pixel-width of the icon 
  title wasn't being erased properly.</li>
  <li>Fixed: The FAT12 boot sector source code shipped with 
  version 0.53 didn't work for floppy disks</li>
  <li>Fixed: In the libc's _xpndfmt.c function (used by printf, 
  sprintf, etc), the numDigits() function was returning the wrong value for 
  large signed numbers, resulting in double-width numbers for format strings 
  such as %08x.</li>
  <li>Fixed: The graphics mode text driver was not recognizing 
  'longest lines' if the cursor had been moved around using the textSetRow 
  function.</li>
  <li>Fixed: Doing a second kernel make without changing anything 
  resulted in an empty kernelSymbols.txt file, since the previous make stripped 
  the kernel.</li>
</ul>
      <hr>

<p>VERSION 0.53<br>
01/02/2005</p>
<p>Overview: This is a maintenance release, with numerous small 
improvements and bug fixes.&nbsp; A number of unnecessary files and programs 
have been removed.</p>
<ul>
  <li>Re-engineered the kernel's file handling code so that it 
  uses less stack memory, has less code redundancy, and exports different 
  functions to the rest of the kernel than it does to user space.</li>
  <li>The format operation causes the kernel to re-scan the 
  partitions, so that the new filesystem type is recorded in the disk structure</li>
  <li>The Program Manager now shows overall memory usage totals.</li>
  <li>The 'mem' command now prints totals in kilobytes, and uses 
  a structure from the kernel (a new API function) describing the memory blocks, 
  rather than the kernel printing out the information directly. Subsequently, 
  deprecated the kernelMemoryPrintUsage() function.</li>
  <li>The shutdown program now attempts to eject the CD-ROM a 
  second time if required, since it seems that some drives will fail on the 
  first attempt but succeed on the second.</li>
  <li>The FAT boot sectors no longer rely on the disk geometry 
  they get from the DOS BPB block. They get it from the BIOS instead.</li>
  <li>Removed the 'move' command (there's already a 'mv' command)</li>
  <li>Removed a large number of unimplemented libc function 
  files.</li>
  <li>Moved the libc global data into crt0.c</li>
  <li>The boot sectors/OS loader that capture key presses (&quot;press 
  any key...&quot;) now use the BIOS' int 16h function instead of trapping the 
  hardware interrupt.</li>
  <li>Deprecated the kernelDisk{Read|Write}Absolute functions. 
  Instead, the normal kernelDisk{Read|Write} functions are now able to figure 
  out whether the supplied disk name is physical or logical.</li>
  <li>The libvsh functions no longer call perror(). They still 
  set errno, and then leave perror() up to the caller.</li>
  <li>Added the -W and -Wshadow options to Makefiles.</li>
  <li>Added -ffreestanding to Makefiles, to ensure that the 
  compiler isn't including built-in functions we're not expecting.</li>
  <li>Got rid of the &quot;unsigned int&quot; terminology everywhere and 
  replaced it with simple &quot;unsigned&quot;</li>
  <li>Fixed: The Disk Manager was showing 1MB total size for all 
  disks</li>
  <li>Fixed: In the Disk Manager's 'create partition' function, 
  if you supplied bad start/end values, the logical/primary choice would be 
  disabled when the dialog box came back.</li>
  <li>Fixed: When copying a file, if the destination was a 
  directory (rather than a fully-specified file name), there was a 
  kernelFileDelete error message</li>
  <li>Fixed: when the vshCursorMenu scrolled the screen, it 
  looked funny.</li>
  <li>Fixed: 'ls' an unknown file, hang!</li>
</ul>
      <hr>

<p>VERSION 0.52<br>
14/01/2005</p>
<p>Overview: This is a maintenance and bugfix release, with some 
additional features, such as improved disk-to-disk copies and partition table 
reordering in the Disk Manager, and additional C library functions.</p>
<ul>
  <li>Implemented threaded, double-buffered disk IO for the 'copy 
  disk' functionality of the disk manager.</li>
  <li>The disk manager's slice list now indicates the disk name 
  and file system type (if available), and it is now possible to change the 
  partition table ordering - i.e., changing drive names/letters.</li>
  <li>The vsh history is bigger, and there is now a 'history' 
  command.</li>
  <li>Added open(), lseek(), read(), write(), close(), fprintf, 
  fread(), fwrite(), and stat() C library functions.</li>
  <li>The kernelError messages now indicate the name of the 
  process that caused the error.</li>
  <li>The 'disks' command now reports the filesystem type, if 
  known, and not just the partition label.</li>
  <li>Exported the kernelMultitaskerProcessIsAlive() function.</li>
  <li>The 'vsh' and 'ls' commands have been updated to improve 
  their stack/data memory usages.</li>
  <li>The kernelConfigurationWriter has been reworked so that if 
  the file already exists, it writes the new one to a temp location first, then 
  moves the new one over top.</li>
  <li>Fixed up the Makefiles a bit and we now make sure that 
  we're building with the correct CPU specified.</li>
  <li>Fixed up 'errno' implementation in the C library.</li>
  <li>Fixed: The disk manager 'copy disk' failure was leaving the 
  dialog box on the screen.</li>
  <li>Fixed: The format command could hang when doing a large 
  FAT32 filesystem.</li>
  <li>Fixed: The 'rmdir' functionality was broken, because the 
  '.' and '..' entries were not being removed correctly.</li>
  <li>Fixed: In the disk manager's 'create partition' function, 
  specifying a megabyte size value overflowed at 4096m.</li>
  <li>Fixed: The windowList component has been changed to stop 
  implementing its own idea of 'container', and use the standard container 
  component.</li>
  <li>Fixed: Deleting the old menu list items in 
  kernelWindowShellUpdateList() was causing crashes; it was disabled in the 0.5 
  release, and it was a pretty serious memory leak.</li>
  <li>Fixed: The 'umount' command failed when a following / was 
  after the mount point name.</li>
</ul>
      <hr>

<p>VERSION 0.51<br>
30/12/2004</p>
<p>Overview: This is a maintenance and bugfix release, with some 
additional features, such as the Disk Manager's ability to fix small partition 
table consistency errors.</p>
<ul>
  <li>Enhanced the bootstrap code so that it is possible to boot 
  on some trickier hardware platforms, such as Toshiba laptops.</li>
  <li>The disk manager now offers to fix errors turned up by the 
  partition table check.</li>
  <li>The disk thread now respawns when it is killed [ thanks 
  Thomas Kreitner ].</li>
  <li>The 'install' program now show a progress meter in text 
  mode while copying files.</li>
  <li>When the shutdown program is attempting to eject the disk, 
  it now shows a banner dialog since sometimes it takes a couple of seconds.</li>
  <li>In the text area code, when the screen is cleared, the 
  existing screen contents are no longer rolled back into the buffer -- they are 
  discarded.</li>
  <li>Deprecated the windowPack() and windowSetPacked() API 
  functions.</li>
  <li>While attempting builds with gcc version 3.4.2, fixed a 
  number of bugs and details that the newer compiler found.</li>
  <li>Fixed: The program manager wasn't really putting threads 
  under their correct process parents; it merely put them in order as received 
  from the kernel.</li>
  <li>Fixed: The getopt() library function was being used 
  incorrectly by a number of the user applications.</li>
  <li>Fixed: It was possible to kill the exception handler 
  thread, which caused an immediate triple fault [ thanks Thomas Kreitner ].</li>
  <li>Fixed: Broken CD-ROM floppy disk emulations no longer trick 
  the loader into detecting nonexistent floppies.</li>
  <li>Fixed: On some hardware, the kernel's hardware detection 
  could be tricked into detecting nonexistent fixed disks with NULL geometry.</li>
  <li>Fixed: The 'megabytes' value being printed for hard disks 
  by the loader was severely wrong.</li>
</ul>
<hr>

<p>VERSION 0.5<br>
12/12/2004</p>
<p>Overview: This release adds logical partition capabilities to 
both the kernel and the Disk Manager (which has been substantially rewritten), 
window minimizing, a GUI taskbar for managing windows, new icons and cleaner 
desktop layout, a 'Program Manager' application, and a temporary file interface 
-- as well as lots of bug fixes and smaller tweaks.</p>
<ul>
  <li>Added support for hard disk logical partitions</li>
  <li>Added a 'taskbar' menu to the top of the root window.</li>
  <li>Added 'minimize' functionality to windows.</li>
  <li>Made a 'program manager' program that allows a user to 
  manage running processes, etc.</li>
  <li>Enlarged the disk manager window and its canvas, and added 
  a more action buttons. </li>
  <li>Added a 'show info' action to the disk manager.</li>
  <li>Implemented the ability to 'hide' partitions in the disk 
  manager</li>
  <li>The disk manager now includes an option for writing a fresh 
  partition table to a disk.</li>
  <li>The disk manager now allows the disk to be specified as a 
  command line argument.</li>
  <li>The disk manager now has a better GUI interface for 
  creating a new partition.</li>
  <li>Implemented a temporary file interface</li>
  <li>The install program now shows which install disk is 
  selected when in graphics mode.</li>
  <li>Made a new 'shell' icon for the command window, added icons 
  for the program manager and configuration editor, and removed the 'logout' and 
  'shutdown' icons from the desktop.</li>
  <li>Programs that can run in both graphics and text modes (such 
  as the disk manager and the installer) now have a standard -T argument that 
  causes them to run in text mode.</li>
  <li>Added a libvsh 'cursor menu'. Converted imgboot, fdisk, 
  etc. to use it.</li>
  <li>Added the ability to have comment lines in the install 
  files</li>
  <li>Created a libvsh function for parsing a command line into 
  command and args, suitable for passing to the loaderLoadAndExec function.</li>
  <li>Added a user-space 'process' struct, and converted the 'ps' 
  command to use it.</li>
  <li>The date/time printing library functions have been cleaned 
  up and fixed so that they don't print superfluous spaces</li>
  <li>Restored the 'ownership' attributes of input streams, and 
  restored the CTRL-C functionality.</li>
  <li>Moved the 'dist' directory out of the 'utils' area and into 
  the top level directory</li>
  <li>Added strchr and strrchr C library functions</li>
  <li>Added a kernelStreamDestroy() function to complement 
  kernelStreamNew()</li>
  <li>Attempting to mount a CD will now close the tray before the 
  attempt, if it's open.</li>
  <li>Removed the icons= line from windowmanager.conf. The window 
  shell will now figure out the list of icons dynamically based on which ones 
  are actually specified in the file</li>
  <li>The 'format' now has 2 additional modes: a graphical mode, 
  and a non- interactive 'silent' mode.</li>
  <li>(Re)-implemented the ability to get a screen shot from a 
  key press.&nbsp; The 'instant screenshot' is triggered by [PRINT SCRN] key, 
  and multiple shots can be taken this way without overwriting one another.</li>
  <li>The vsh prompt is no longer the whole directory path; just 
  the current directory name.</li>
  <li>The window checkbox widget now ignores the user-specified 
  foreground color for the 'x', since we always use white for the background 
  behind it, and if the foreground was white, no 'x' would be visible.</li>
  <li>The graphical shutdown program now offers an 'eject CD-ROM' 
  checkbox when booted from CD-ROM, since otherwise the door stays locked and 
  getting the CD out during the BIOS POST can be tricky.</li>
  <li>CTRL-ALT-DEL now does a proper shutdown, so that the disks 
  are synced before rebooting.</li>
  <li>Removed the exception handler's 'core dump' code, since it 
  wasn't all that useful without tracing/debugging facilities.</li>
  <li>Clicking outside of all of a window's components now 
  removes the focus from any focused component.</li>
  <li>Fixed: The 'cdrom' program's help page claimed that it will 
  attempt to guess the name of the device is not specified, but that hadn't been 
  implemented. It always picked the first cdrom.</li>
  <li>Fixed: The ATAPI driver was not reliably ejecting CD-ROMs.</li>
  <li>Fixed: The window manager screenshot code was crashy</li>
  <li>Fixed: The 'display settings' program's 'show clock on the 
  desktop' thing was very crashy.</li>
  <li>Fixed: The kernelFileStreamClose() function now destroys 
  the stream.&nbsp; Previously it didn't do so and was a memory leak.</li>
  <li>Fixed: The installation program now calculates the required 
  space more accurately, and verifies adequate disk space *before* starting the 
  installation.</li>
  <li>Fixed: Extra (second) floppy disks were showing up where 
  they didn't exist</li>
  <li>Fixed: The disk manager's formatting functionality was 
  crashy </li>
  <li>Fixed: In graphics mode, the disk manager's action buttons 
  were not being laid out properly.</li>
  <li>Fixed: In graphics mode, the disk name argument of the disk 
  manager didn't properly select the disk in the disk list.</li>
  <li>Fixed: The kernel logger was inserting random characters 
  into the log at 512-byte boundaries.</li>
  <li>Fixed: The return value of the library memcmp function. If 
  comparison failed on the first byte, it was returning success (0).</li>
  <li>Fixed: Partition Magic was complaining about the disk 
  manager's CHS values being incorrect.&nbsp; In particular it wasn't liking our 
  'maxed out' head and sector values when a partition started or ended at a 
  cylinder &gt; 1024.</li>
  <li>Fixed: When creating new partitions in the disk manager, 
  Partition Magic was showing multiple ones as active.</li>
  <li>Fixed: Dragging an icon was executing the program, as if 
  the icon were simply clicked</li>
  <li>Fixed: Seeking/writing to the end of a file stream was 
  broken.</li>
  <li>Fixed: Typing during a graphics mode screen scroll left 
  stray cursors on the screen and could cause crashes</li>
  <li>Fixed: When snapping the icons in the root window, the 
  window layout was being redone too many times (once for *every* icon that 
  moved).</li>
  <li>Fixed: The menu bar component was ignoring any 
  user-specified font.</li>
  <li>Fixed: Window title bar menus are no longer drawn if there 
  are no items in them.</li>
  <li>Fixed: The window canvas component was generating a 
  kernelMemoryRelease message about a pointer not being mapped.</li>
  <li>Fixed: Causing the console text area to scroll while it 
  wasn't visible caused a triple-fault.</li>
  <li>Fixed: The status messages in the graphical install program 
  were wrapping off the window.</li>
  <li>Fixed: If a CD-ROM was a master with a slave, that CD-ROM 
  was not detected.&nbsp; If the slave was also a CD-ROM, neither was detected.</li>
  <li>Fixed: The system was unable to boot from the second CD-ROM 
  device.</li>
  <li>Fixed: Running the 'install' program with a disk name 
  argument was not working</li>
</ul>
<hr>

<p>VERSION 0.42<br>
11/09/2004</p>
<p>Overview: This is primarily a bugfix release, with some added 
features including the ability to format partitions from the Disk Manager, plus 
vertical scroll bars on text areas and visual reimplementation of &quot;grayed out&quot; 
window components.</p>
<ul>
  <li>Enabled filesystem formatting functionality in the disk 
  manager.</li>
  <li>Implemented vertical scroll bars and extended buffers on 
  window text area components</li>
  <li>Improved the 'graying out' functionality in the window 
  manager; it didn't look great with the default colors and looked positively 
  silly with some other color schemes.</li>
  <li>Reimplemented the 'hidden' functionality of window text 
  areas so that the buffer contains the real content, and the visible area 
  contains the asterisks. The 'get data' function returns the data from the 
  buffer.</li>
  <li>The window manager now makes more use of the busy mouse 
  pointer</li>
  <li>Restored window list locking, now that interrupt handlers 
  don't need access.</li>
  <li>Created a new logo for the splash image</li>
  <li>In the disk manager, there is now a confirmation dialog 
  before moving partitions</li>
  <li>Added a 'get disk by file' function.</li>
  <li>The 'disk' structures now contain a set of flags to 
  indicate which filesystem functions are available from the appropriate driver, 
  if applicable.</li>
  <li>Moved the window event processing out of the execution path 
  of interrupt handlers and into the window manager thread</li>
  <li>Added 'new' and 'destroy' functions for kernelTextAreas</li>
  <li>Moved icons and fonts into subdirectories under /system</li>
  <li>Added a way to specify whether a loadable font should be 
  fixed-width</li>
  <li>Removed instances of 'bzero' calls in the kernel. We have a 
  much better kernelMemClear() function.</li>
  <li>Added a 'strncasecmp' C library function</li>
  <li>Simplified the management of 'kernelFilesystem' structures 
  in the filesystem code.</li>
  <li>The graphics code (main, framebuffer driver, and window 
  manager and friends) now uses ints instead of unsigneds for widths and heights</li>
  <li>Moved the font argument from some window components into 
  the componentParameters structure</li>
  <li>Fixed: Setting the widest item in a GUI menu to not enabled 
  caused a bit of the menu border to get grayed out as well.</li>
  <li>Fixed: State changes in the disk manager's disk and 
  partition lists caused by key events were not being handled properly.</li>
  <li>Fixed: In the User Manager, when adding a new user, if the 
  user already existed the program would still prompt for a password.</li>
  <li>Fixed: In 16-bit video mode, window titles were not 
  displaying proper transparency</li>
  <li>Fixed: The size/drawing of the items in list components was 
  slightly off.</li>
  <li>Fixed: If fonts or icons are missing, there's a panic</li>
  <li>Fixed: The text mode console driver was not scrolling 
  properly when printing long lines. The next line would overwrite the wrapped 
  part of the previous one.</li>
</ul>
<hr>

<p>VERSION 0.41<br>
09/08/2004</p>
<p>Overview: This is primarily a bugfix release, with some added 
features, including the ability to move partitions, a configuration editor, and 
a keymap editor.&nbsp; There are also a number of small tweaks to graphical 
components and GUI user settings.</p>
<ul>
  <li>The disk manager can now move partitions in contiguous 
  space (i.e. it can 'slide' them from side to side)</li>
  <li>Created a 'configuration editor' for editing configuration 
  files</li>
  <li>Created a 'keymap editor' for choosing keyboard layout.</li>
  <li>In the Disk Manager, clicking on a colored slice in the 
  canvas area now selects the partition</li>
  <li>Added a 'color chooser' window library dialog box</li>
  <li>The window shell thread now loads programs automatically 
  based on things specified in the window manager config file.</li>
  <li>Added a pretty xterm font (modified from the xterm program 
  under Linux).</li>
  <li>Made it possible to set the default foreground, background, 
  and desktop colors for all graphics operations in the kernel.conf file.</li>
  <li>Added a 'show clock on desktop' checkbox to the display 
  properties app with an accompanying clock app.</li>
  <li>Implemented right and middle mouse click events.</li>
  <li>The radio button GUI widget will now accept focus and allow 
  keyboard control</li>
  <li>In the Disk Manager, when a new partition is created, it is 
  now selected afterward.</li>
  <li>When copying disks in the disk manager, added a better 
  prompt dialog to ask which disk to copy to, with a clickable list instead of a 
  typing prompt, and it doesn't prompt about which disk to copy to if there's 
  only one other choice</li>
  <li>Made the 'scroll bar' GUI widget available from user space</li>
  <li>Calling 'set selected' with GUI list widgets now scrolls 
  the list if necessary so that the selected one is visible.</li>
  <li>The window manager no longer re-saves its config file at 
  shutdown</li>
  <li>Added a 'cancel' button to the 'copy disk' dialog of the 
  disk manager</li>
  <li>Mouse dragging events now filter down to the user space via 
  the event stream.</li>
  <li>Added a 'kill by name' function to the multitasker.</li>
  <li>Added a 'focus' routine to the menu widget, so that when 
  the menu will disappear itself if it loses the focus</li>
  <li>Made a more friendly error message for the help command 
  when there is not a help file for the topic.</li>
  <li>Fixed: In 15-bit graphics modes, the colors were all wrong.</li>
  <li>Fixed: The window list component was not responding very 
  accurately to movements of the vertical slider, the slider was picking up both 
  up-and-down mouse clicks, and dragging wasn't all that perfect either.</li>
  <li>Fixed: It was possible to resize a window down to nothing 
  (or less than nothing!!).</li>
  <li>Fixed: The mouse pointer was leaving tracers when dragging 
  or resizing windows, or dragging icons</li>
  <li>Fixed: Compilation failed on SuSE 9, with gcc 3.3.3 and 
  (more importantly) whatever GNU ld comes with it.</li>
  <li>Fixed: It wasn't possible to hide a GUI component if they 
  had the focus.</li>
  <li>Fixed: The format command stopped accepting a lone disk 
  name argument</li>
  <li>Fixed: The framebuffer graphic driver was not drawing any 
  part of outlined rectangles if part of the rectangle was off the screen.</li>
  <li>Fixed: Resizing list components was not resizing the 
  subcomponent list items</li>
  <li>Fixed: Multiple buttons inside a container component were 
  not picking up window events.</li>
  <li>Fixed: The arial bold 10 font's equals ('=') sign was a 
  plus ('+')</li>
  <li>Fixed: Pressing CTRL-ALT-DELETE in graphics mode produced a 
  panic with 'can't yield() in interrupt handler'</li>
</ul>
<hr>

<p>VERSION 0.4<br>
19/07/2004</p>
<p>Overview: This release features a number of graphical 
interface improvements, including several new GUI widgets and &quot;newbie&quot; usability 
tweaks. The 'install' and 'disk manager' programs have been properly 
GUI-enabled, and this release also adds user authentication with MD5 password 
encryption.</p>
<ul>
  <li>Implemented the following GUI widgets: checkbox, radio 
  button, menu bar (plus menu, and menu item), progress bar, canvas, scroll bar, 
  list (plus list item), and password field</li>
  <li>Implemented 'container' components which can be nested 
  arbitrarily, and have their layout done individually. Added a top level 
  'container' component to the window structure and removed the simple list of 
  components.</li>
  <li>When running from a CD-ROM or other read-only filesystem, 
  there is now a general warning that the user can't modify settings or change 
  anything generally.</li>
  <li>The OS loader now gives the kernel a list of supported 
  graphics resolutions/depths that are supported, and there is user preference 
  for choosing the mode, which the OS loader now reads from a file.</li>
  <li>Improved the hardware structure in the OS loader so that it 
  makes use of NASM's STRUCT directive</li>
  <li>Added text-mode password prompting code to the vsh library</li>
  <li>Exported locking and variable list functionality to user 
  space.</li>
  <li>The 'configuration reader/writer' code is more 
  sophisticated, so that it preserves comment lines (if replacing an existing 
  config file)</li>
  <li>Updated the install image generation scripts, and fixed the 
  naming of the generated images</li>
  <li>Created a new background image that isn't so 'busy'. 
  Removed the old ones.</li>
  <li>The 'start program' loaded by the kernel is now specified 
  dynamically in a file, and added an 'image boot' program to be loaded first 
  when booting from an ISO or floppy image distribution that will prompt the 
  user whether they want to install, or simply run from that image.</li>
  <li>In the vsh, you no longer need to put a space between the 
  last command argument and any ampersand</li>
  <li>Implemented Bresenham's lines and circles algorithms in the 
  framebuffer graphic driver.</li>
  <li>Both the native installer and the UNIX installation scripts 
  now use file lists and include options to do a 'basic' versus 'full' install.</li>
  <li>The FAT filesystem driver no longer calculates the 
  filesystem free space asynchronously. Previously, this meant that an 
  application could not know</li>
  <li>how long to wait before it could begin writing to a 
  freshly-mounted filesystem.</li>
  <li>Graphicized both the 'install' and 'disk manager' programs</li>
  <li>After copying a larger disk to a smaller one in the disk 
  manager, we now go through the entries in the partition table and adjust them 
  so that none have illegal values. That means, for example, deleting or 
  truncating partitions that don't fit on the smaller disk.</li>
  <li>Added a 'cursoring' effect to the text mode disk manager, 
  since it makes the flow better (not required to type partition numbers, etc.), 
  and which means that a partition or empty space is always selected, which fits 
  better with the graphics mode use model.</li>
  <li>The disk manager program now saves disk-specific backup 
  MBRs in the /system/boot directory</li>
  <li>The window manager thread now checks that windows' 
  processes are still alive, so that it doesn't require a mouse click to dispose 
  of the window. Also, if the window manager thread dies it is now restarted</li>
  <li>'Visopsys blue' is now the default foreground color for 
  most GUI components (rather than black).</li>
  <li>Removed the start window and replaced it with a simple 
  splash image</li>
  <li>Changed remaining 'csh' scripts to 'sh' and removed the 
  unused stuff from the /utils/src-mgmt directory</li>
  <li>Rearranges the source code directory structure and build 
  system a little bit, so that there is a top-level 'build' directory which 
  contains all the installable stuff in the correct places. This allowed the 
  installer to be a lot simpler and facilitated the implementation of 
  installation file lists.</li>
  <li>Implemented a 'getopt' library function and converted the 
  contents of the 'programs' directory to use it.</li>
  <li>Added a 'window shell' thread which is the new user login 
  process in graphics mode, and which handles events on components in the root 
  window.</li>
  <li>Added 'delete user' functionality to both the kernelUser 
  code and the 'user manager' program.</li>
  <li>Added a 'passwd' command that shows as a 'user manager' in 
  the GUI, that can be used to change passwords and create/delete accounts.</li>
  <li>Separated the source files for the different libraries into 
  subdirectories, and broke out the libvsh and libwindow code into separate 
  source files to reduce executable sizes.</li>
  <li>Added a 'file selection' dialog box into the window lib.</li>
  <li>Font printing by default draws the background color under 
  the character.&nbsp; Transparent images are still an option.</li>
  <li>Added a 'flags' field to the kernelWindow structure, since 
  there were a few booleans and it's a waste of space to make them all ints.</li>
  <li>Vsh file completion now works like bash when there's only 
  one 'real' item in a directory - complete it with just a [tab]</li>
  <li>Made it possible to click between multiple text areas in 
  window</li>
  <li>Added user authentication to the login program</li>
  <li>Improved handling of width specifiers for 'printf' number 
  parameters.</li>
  <li>Added an MD5 encryption implementation</li>
  <li>A commands is no longer added to the vsh history if it's 
  the same as the previous one</li>
  <li>The keyboard code now reads the lights status at startup so 
  that it doesn't reset them improperly. Also, numlock works.</li>
  <li>Implemented enable/disable functionality for GUI 
  components.</li>
  <li>Implemented a 'set visible' function for components</li>
  <li>Implemented 'set disabled' functionality for window menu 
  items</li>
  <li>Added 'resizable X' and 'resizable Y' fields in the 
  component parameter structure, and only resize components appropriately</li>
  <li>Simplified the process of adding components to windows, so 
  that you only have to call the 'new' function, with the component parameters, 
  and it will be added to the window automatically.</li>
  <li>Removed the 'size' parameters from the 'button' component 
  constructor</li>
  <li>Implemented the 'get data' and 'set data' methods of text 
  label components, so that the label contents can be dynamic.</li>
  <li>Added a window component flag that will prevent a [tab] 
  from unfocusing certain components.</li>
  <li>Removed the coordinate and size parameters from the &quot;new 
  window&quot; function of the window manager. The window size is determined 
  automatically unless the &quot;set size&quot; function is called.</li>
  <li>Window layout happens automatically. The programmer no 
  longer has to do this explicitly.</li>
  <li>Added resizing capability to the windows in the window 
  manager.</li>
  <li>Window buttons are now focusable and can handle various 
  keyboard events</li>
  <li>Implemented proper 'focusing' of window components</li>
  <li>Added a function for getting the contents of a text field 
  or text area component in the window manager</li>
  <li>The window close button no longer uses the little 'X' image 
  file, but rather draws its own 'X' using the new bresenham line drawing 
  abilities.</li>
  <li>Changed the 'shutdown' program so that in graphics mode it 
  prompts for a reboot or shutdown</li>
  <li>Added a better 'install' icon.</li>
  <li>Added a GPL banner to the image boot program</li>
  <li>Disabled the left-right cursor keys in the vsh, as they 
  tend to make people think they can do line editing (which they can't, yet).</li>
  <li>Fixed: If the screen dimensions are too small to 
  accommodate a window, it doesn't appear at all.</li>
  <li>Fixed: Pressing CTRL-ALT-DELETE in graphics mode produces a 
  panic with 'can't yield() in interrupt handler'</li>
  <li>Fixed: The 'screenshot' program was crashing when 
  attempting to write to read-only filesystems.</li>
  <li>Fixed: If the floppy was removed while the boot loader was 
  loading the kernel, it was going into long retry loops</li>
  <li>Fixed: File input streams were horribly broken in the 
  ISO9660 filesystem driver. Before the fix they would only read the first 
  sector.</li>
  <li>Fixed: argv[0] was not being set by the loader code. It was 
  only being set explicitly by the vsh when programs are executed, which it 
  shouldn't do at all.</li>
  <li>Fixed: The arrangement of icons in the root window so that 
  they wrap into the next column when they hit the bottom of the screen</li>
  <li>Fixed: There was trouble (triple-fault) drawing outline 
  (non-filled) rectangles in the framebuffer graphic driver, if they were 
  partially off the edges of the screen</li>
  <li>Fixed: The ELF loader was not allocating enough memory for 
  the uninitialized data that executables might require.</li>
  <li>Fixed: The free spaces calculation in the disk manager was 
  incorrect, particularly when there was only one partition that didn't start at 
  zero</li>
  <li>Fixed: &quot;component cannot focus&quot; error messages when 
  clicking on icon components</li>
  <li>Fixed: When booting from the hard disk , the opening of the 
  kernel log file often failed with a &quot;not enough space&quot; message.</li>
  <li>Fixed: In text mode, the login process was not properly 
  setting supervisor privilege for the 'admin' user</li>
  <li>Fixed: When windows were dragged, the focus was lost from 
  the focused component.</li>
  <li>Fixed: Text fields were coming up with their cursors on by 
  default.</li>
  <li>Fixed: The kernel.log file was not being updated/written 
  correctly.</li>
  <li>Fixed: The fileWrite routine was not behaving as expected 
  when writing a single-block file. The file size was zero, even though the file 
  was written and closed properly</li>
  <li>Fixed: When writing a file using the file stream functions, 
  there was a newline inserted at the beginning of a file.</li>
</ul>
<hr>

<p>VERSION 0.33<br>
11/01/2004</p>
<p>Overview: This is primarily a bugfix release, with bootable 
CD-ROM support added as a new feature.</p>
<ul>
  <li>Added bootable ISO9660 (el-torito) CD-ROM support.</li>
  <li>The 'no boot' boot sector code no longer reboots the 
  system, but instead properly calls the next boot option</li>
  <li>Fixed: Spurious error messages when booting from a 
  read-only file system.</li>
  <li>Fixed the kernel heap allocation code, which was losing and 
  corrupting blocks of memory, and leaving small, odd-sized gaps of unused 
  memory.</li>
  <li>Polished up the scripts for creating floppy &amp; CD-ROM images</li>
  <li>Fixed: No longer attempt to recalibrate ATAPI disks.</li>
  <li>If a CD-ROM read fails because there is no disk, the driver 
  no longer leaves the number of sectors at zero, since that will stop all 
  subsequent read attempts</li>
  <li>The CD-ROM driver code can determine more elegantly whether 
  there is a data CD in the drive and if not, print a friendly error message.</li>
</ul>
<hr>
<p>VERSION 0.32<br>
04/01/2004</p>
<p>Overview: This is primarily a bugfix release, with CD-ROM and 
ISO9660 filesystem support added as new (alpha) features.</p>
<ul>
  <li>Added (multi-session capable) CD-ROM driver code</li>
  <li>Fixed: The 'date' command day of the week was wrong.</li>
  <li>Created a set of help text files for all of the commands, in 
a /programs/helpfiles subdirectory. The 'help' command is now an 
executable which can provide command-specific help.</li>
  <li>The 'vsh' shell now has a '-c' option so that it can be used 
to execute commands, non-interactively.</li>
  <li>Added a 'system' Visopsys C library function</li>
  <li>Added a 'driver data' field in the physical disk object, so 
that the different drivers can store device-specific data there. 
Implemented the floppy driver's 'detect' and 'register device' routines to 
remove some of the floppy-specific stuff from the hardware detection code.</li>
  <li>The 'mount' and 'umount' commands will now accept relative 
pathnames</li>
  <li>Added an ISO9660 filesystem driver</li>
  <li>Eliminated spurious floppy timeout error messages when 
booting from hard disks.</li>
  <li>Fixed: Unknown floppy drive types were causing hardware 
  detection (and therefore the whole startup) to fail.</li>
</ul>
<hr>
<p>VERSION 0.31<br>
12/12/2003</p>
<p>Overview: This is primarily a bugfix release, with EXT2 
filesystem support added as a new (alpha) feature.</p>
<ul>
  <li>Implemented a preliminary, alpha, read-only EXT2 filesystem 
  driver</li>
  <li>The libraries and (non-kernel) include files have been relicensed under the GNU LGPL to permit use by proprietary programs</li>
  <li>The IDE/ATA/ATAPI driver was not responding to disks on the 
  secondary controller.</li>
  <li>Fixed: The 'cat' program wasn't printing tabs properly the 
  way the 'more' program does.</li>
  <li>Fixed: kernelMalloc allocations were not necessarily being 
done on any boundaries. It is now done on sizeof(unsigned) (dword) 
boundaries.</li>
  <li>Added a *very* basic 'find' program which only traverses 
  whole directory trees. Initially to aid in development of new filesystems</li>
</ul>
<hr>
<p>VERSION 0.3<br>
24/11/2003</p>
<p>Overview: This release is very much an &quot;under the hood&quot; 
release. The user interaction is similar to that of 0.2, but a great deal 
of work has gone into improving the structure, performance, and 
stability of the underlying code -- particularly the disk subsystem. However, 
some eye candy has been added, and the GUI is more functional and 
consistent.</p>
<ul>
  <li>A thread of a process can now kill the parent process.</li>
  <li>Created a multitasker 'detach' function for daemons or 
  other programs to use to detach themselves from any programs that might be 
blocking on them.</li>
  <li>Fixed: Windows wasn't entirely happy with our FAT short 
  filename aliases.&nbsp; Complained about the format of the short name of &quot;/system/boot/bootsect.fatnoboot&quot;</li>
  <li>Changed the naming of the kernel window components (removed 
  the 'component' bit from the names)</li>
  <li>Fixed: File completions were completing things they 
  shouldn't; i.e. when you &quot;cd system; ls b[tab]&quot; it completed &quot;background&quot; but 
there's a &quot;boot&quot; directory as well.</li>
  <li>The window manager thread is now the login process for a 
  user when in graphics mode, rather than a text shell running in a console 
window.</li>
  <li>Reduced the stack sizes of processes. They shouldn't need 
  nearly as much (260K) as they were being given.</li>
  <li>Removed all the 'binary distribution' stuff (the Java 
  installer, shell scripts, readmes, etc). We will only do binary 
distributions as floppy or ISO images from now on.</li>
  <li>The console window is no longer shown by default. Added a 
  program and icon ('console') to display it and handle the window events, 
etc. Added external API functions to put a console widget into a user 
program.</li>
  <li>Changed the error reporting interface for the disk drivers. 
  Removed the 'last error message' and 'last error code' functions -- 
these were leftovers from the days of ASM drivers that couldn't use the 
normal error reporting mechanisms.</li>
  <li>Fixed: The mouse was not being redrawn when windows close 
  themselves.</li>
  <li>Implemented 'levels' for GUI components within a window, in 
  the same manner as windows have levels. This way if components overlap, 
we can only send windowEvents to the uppermost one.</li>
  <li>Sped up the scrolling of graphics text areas. Now only 
  scroll as much of the width of the area as the longest line of contents.</li>
  <li>Fixed up the framebuffer graphic driver a little bit more so 
that it draws most efficiently for the bit depth it's using.</li>
  <li>Implemented kernel versions of malloc() and free() so that 
we're not always wasting whole pages of memory for small things.</li>
  <li>Added shutdown and reboot buttons to the login screen in 
  graphics mode.</li>
  <li>Implemented text labels on kernelWindowButton components, 
with selectable font.</li>
  <li>Fixed: Window layout problems. Attempting to add reboot and 
  shutdown buttons to the login screen, I discovered that setting the 
component's gridWidth parameters to 2 causes a crash. In addition, when I 
incorrectly left the gridWidth at 1 and attempted to add the 2 buttons 
below (using 2 grid places) they were erroneously placed on the line above, 
and the other widgets got squashed together.</li>
  <li>Added an event notification callback mechanism for user 
programs that use the GUI. When a user performs a GUI action, such as 
clicking a button, the user application can now read that event from the 
component.</li>
  <li>As a supplement to this, implemented user-mode library code 
for monitoring window component event queues. It includes a &quot;GUI run&quot; 
function that signals the application is ready to begin monitoring its 
widgets for events, after all its setup is done. The rest of the flow can 
be driven by callbacks from events. All of the included programs have 
been converted to use these features.</li>
  <li>Added a logout procedure for the window manager (rather 
  than having to log out by hand from the console window)</li>
  <li>Implemented a better &quot;kernel panic&quot; routine that displays 
  something useful in either text or graphics mode and shuts things down 
quickly.</li>
  <li>Interrupt handlers and their actions are no longer allowed 
  to yield(), wait(), block(), etc.</li>
  <li>Fixed: Moving the mouse in text mode is disrupting keyboard 
  input</li>
  <li>The fdisk program will save a backup copy of the MBR before 
writing changes, and provides an option to restore it.</li>
  <li>The graphic/text console drivers, as well as the FAT 
  filesystem driver, have abstracted driver registration procedures like the 
hardware drivers do.</li>
  <li>The API calls in kernelApi.c are now 'hashed' according to 
their function number, for faster API throughput.</li>
  <li>Added a routine to the generic disk code for reading the 
  disks' partition tables (instead of in the hardware enumeration 
code). It is be re-callable anytime so that programs like fdisk can 
create/delete partitions and have the change be reflected immediately in the 
list of logical disks.</li>
  <li>Cleaned up the management of the kernel's built-in drivers. 
  The drivers now have an 'init' that registers the driver structure with 
the kernel, so that the kernelDriverManagement code doesn't have to have all 
the functions hard-coded in there.</li>
  <li>Disk caches are invalidated when removable media is 
  unmounted.</li>
  <li>The boot sector and the OS loader can now boot from a 
  cylinder &gt; 1024.</li>
  <li>Large disk geometries are now correctly evaluated by the 
  hardware detection code and by the fdisk program.</li>
  <li>Created a 'non-bootable' FAT boot sector, that the 
  formatting code uses to make non-system FAT volumes</li>
  <li>When files are copied, the sizes are now being set 
  correctly.</li>
  <li>The new floppy driver C code no longer freezes up the 
  computer if you remove the media unexpectedly.</li>
  <li>Hardware enumeration and fdisk no longer fail when there is 
no partition table on the hard disk</li>
  <li>FAT filesystem root directories now have '.' entries (and 
  '..' entries when they're not '/')</li>
  <li>Removing the last file in a directory (for example, in the 
  root of a filesystem) no longer produces an error message.</li>
  <li>Fixed up the filesystem driver stuff, so that there is only 
  one instance of each driver of each known type </li>
  <li>In the FAT filesystem driver, file names that start with 
  '.' were listed, but could not be created or accessed. This is fixed.</li>
  <li>Implemented FAT filesystem driver formatting functionality</li>
  <li>Improved the fdisk program so that it can do most common 
operations</li>
  <li>When there are no files in a directory, 'ls' no longer 
  prints an error message.</li>
  <li>When doing disk reads, we now do read-ahead caching</li>
  <li>The kernel is now able to handle operation from a read-only 
or write-protected media without spewing errors and getting panicky.</li>
  <li>kernelLocks are now exclusive even to the same process. i.e. 
If a process owns a lock, calling kernelLockGet() a second time 
fails.</li>
  <li>Added a UK English keyboard mapping</li>
  <li>The disk code should launches a new 'synchronizer' thread 
  if the existing one dies.</li>
  <li>The exception handler tries to do a stack dump when an 
  exception occurs.</li>
  <li>The filesystem code is now correctly updating FAT short 
  filename aliases when files are moved.</li>
  <li>Updated the loader code that searches for a valid video 
  mode. It now searches for *any* LFB video mode first, and reports an error 
to that effect if it finds none. That is a different scenario than not 
finding a 'desired' video mode.</li>
  <li>Added LFB graphic driver support for bit depths of 32, 16, 
and 15 BPP.</li>
  <li>Remove the FAT sector caching from the FAT filesystem 
  driver.</li>
  <li>Changed the filesystem synchronizer so that it is now a 
  *disk* daemon that simply turns removable drives' motors off.</li>
  <li>Implemented proper asynchronous disk caching.</li>
  <li>Kernel symbols to aid debugging, in the /system/kernelSymbols.txt 
file, which is read at startup and used for stack traces and 
whatnot.</li>
  <li>Converted all built-in drivers from ASM to C, with inline 
ASM in a processor-specific header file. This makes it easier for them 
to use the C data structures, etc., for better integration with the rest of 
the kernel.</li>
  <li>THERE IS NO LONGER ANY NASM ASSEMBLY CODE IN THE KERNEL. Woo!</li>
  <li>Changed 'root' user to 'admin' user -- something less geeky/UNIXy.</li>
  <li>The kernelDisk structure is broken up into physical objects 
and logical disks (volumes, i.e. hard disk partitions, but every physical 
disk has at least one logical disk). The disk cache, 'idle since' value, 
physical characteristics, etc., are in the physical disk. Things like 
starting sector, number of sectors, etc., are in the logical disk 
structure. The physical disk structure contains the logical ones.</li>
  <li>Added some memory manager macros so that each memory block 
  request doesn't require an alignment specification (only where 
desired)</li>
  <li>Fixed: rm system/windowmanager.conf ; sync ...Errors in the 
filesystem.</li>
  <li>The window icon code is better able to deal with long icon 
  names. Previously it printed the whole name on one long line.</li>
  <li>When a user logs out of the window manager, all windows 
  belonging to that user are destroyed</li>
  <li>Fixed: Mouse driver initialization was sometimes causing 
  the boot sequence to 'hang' a little bit -- wiggling the mouse or pressing keys 
was required to continue</li>
  <li>The kernel log utility was losing some log messages that 
  come early in the boot process, before the root filesystem is mounted.</li>
  <li>Change start.o (.c) to crt0.o for more UNIX C compatibility.</li>
  <li>Fixed: When running a command window, all the shell 
  processes suddenly start hogging CPU. Was a case of 2 'ready' processes 
constantly yield()ing to one another. Changed the scheduler so that a process will 
get a low weight if it has yielded that timeslice before (a little 
different from the previous algorithm)</li>
</ul>
<hr>
<p>VERSION 0.2<br>
03/06/2003</p>
<p>Overview: This release was a huge leap ahead from version 0.1 
(and it took a long time, too). This release added a basic GUI, 
whereas version 0.1 was text-mode only. Really, the list of changes 
below is very incomplete -- Especially in listing new features.</p>
<ul>
  <li>Fixed: When rebooting from other operating systems such as 
  Windows or Linux, Visopsys would triple-fault. Clearing the page cache 
seems to do the trick. Also changed the way page caching is done. Turned 
off write-through which improved the performance of the graphics as 
well.</li>
  <li>Updated the shell 'help' text.</li>
  <li>Fixed: Can't move/copy a file over top of another by the 
  same name in a different location unless you specify the destination filename 
explicitly (i.e. if you just specify the directory, it fails)</li>
  <li>When using the 'more' program, pressing [enter] to list a 
  new line no longer leaves the &quot;--More--(xx%)--&quot; message on the screen</li>
  <li>When a process has finished but is waiting for its child 
  threads to terminate (i.e. mount), any process that is blocking on that 
process now stops waiting.</li>
  <li>Fixed: Crashes when running the 'install' program, and 
  other types of long disk writes. When this happened under the old exception 
handler, the handler used to go into an endless loop complaining about an 
exception in the idle process. This was the fault of the 'timed event 
scheduler'.&nbsp; Got rid of that.</li>
  <li>Fixed: The floppy motor was staying on all the time on many 
  machines</li>
  <li>Fixed: The FAT filesystem code was not properly filling all 
  long filenames. They were cut off after some number of characters.</li>
  <li>Fixed: When in the multitasker the killing of a process is 
  delayed because of child threads, the process never seems to be killed when 
the children have all terminated. For example, when you mount a large FAT 
filesystem (C:), the thread that reads the FAT keeps the &quot;mount&quot; process 
alive, waiting, forever.</li>
  <li>Fixed: When pushing some of the &quot;non-printable&quot; keys such 
  as 'num lock' and then doing command history, the shell was backing up by 
one character before completing the filename.</li>
  <li>Added support for non-fixed-width fonts in the kernelFont 
functions.</li>
  <li>Added support for loading fonts. The system font looks lame 
  on titles and whatnot, particularly on the login screen.</li>
  <li>The login is now a little more meaningful in graphics mode. 
  Previously, a console window would open with a login: prompt, but the user 
could happily start opening other command windows and such, and 
ignore the login (unless they wanted root permissions).</li>
  <li>Added loading support for 24-bit bitmaps. We already saved 
  in that format.</li>
  <li>Fixed: Umounting a filesystem was not properly dereferencing 
either the filesystem or the disk. Couldn't mount-&gt;unmount-&gt;mount the 
same disk.</li>
  <li>Changed the shell to do filename completions on the same 
  line as the current line, rather than starting on the next line.</li>
  <li>Implemented multiple text output streams, with the text 
  input stream changing to the active window, so that we can have multiple 
text windows open at the same time</li>
  <li>Implemented the FAT filesystem driver checking functionality 
[It's very primitive, but it does detect and fix some errors]</li>
  <li>Moved the exception handler code into the multitasker. It 
  really needs to interact with the multitasker quite a bit.</li>
  <li>The new exception handler thread was hanging the terminal 
  (breakable with CTRL-C) when the exception message happened at the bottom of 
the text area and caused the screen to scroll</li>
  <li>The kernel's exception handler is now a spawned thread with 
  its own stack, etc., so that it doesn't run as part of whatever process 
caused the exception in the first place. This helps to prevent the 
exception handler itself from crashing if things have gone seriously wrong with 
a process.</li>
  <li>Adding permission checking to the kernel functions that are 
  be exported to the rest of the world.</li>
  <li>Fixed: The boot progress indicator was progressing beyond 
  the end of the indicator</li>
  <li>The 'getchar' routine now does the work of polling/yielding, 
rather than the programs that call it.</li>
  <li>Added a basic 'fdisk' program that can do things like swap 
the active partition on hard disks</li>
  <li>Fixed: The hard disk enumeration routine was crashing when 
  there was more than one physical disk</li>
  <li>Added the ability to copy directory trees in the filesystem 
  functions, one level up from the filesystem driver. Could be a library 
routine instead someday.</li>
  <li>Fixed: The 'cp' command was crashing when copying files 
  involving the hard disk</li>
  <li>Implemented the 'write' function in the IDE disk driver. 
Previously it was left out since the filesystem driver is still imperfect.</li>
  <li>Fixed: Mounting hard disk partitions on my 30GB hard disk 
  was not working.&nbsp; LBA versus CHS issue</li>
  <li>Fixed: The mouse driver initialization sometimes hung, 
  waiting for a response from the mouse to a command</li>
  <li>Added ELF executable capability and moved the programs to 
  ELF format</li>
  <li>Fixed: Incomplete filenames were still having an / appended 
  to them by the shell.</li>
  <li>The PS2 mouse driver and the keyboard driver now share a 
  lock on the device, since they both deal with the same registers, etc.</li>
  <li>Fixed: Sometimes an error in another program could cause a 
  fault in the idle process (?!?), then the exception handler routines would 
get into an endless loop </li>
  <li>Fixed: When a process created a new process, the unmapping 
of the new process' memory from the parent process space would sometimes 
cause a page fault.</li>
  <li>Fixed: The 'log file updater' thread was been crashing 
frequently, most often when another process crashed</li>
  <li>The scheduler no longer spawns a new idle thread while the 
  multitasker is in the process of shutting down.</li>
  <li>Fixed: The 'date' command was producing wrong results. The 
year, dotm, hour, minute, etc., were correct, but the month and dotw were 
wrong. </li>
  <li>Fixed: When shortening a filename, one extra character from 
  the old filename got left on the end of the new name. This was because 
of strncpy changes.</li>
  <li>Fixed: There was a little sequencing error in the kernelMemoryManager's share memory routine -- it was deallocating the memory from 
the sharer process before allocating it to the sharee.</li>
  <li>Simplified the default driver management. It was 
  ridiculously overcomplicated.</li>
  <li>Fixed: The FAT code that lowercases short filenames wasn't 
  lowercasing the file extensions</li>
  <li>Fixed: Most of the device driver initialization routines 
  were being called twice; once in kernelDriverManagement.c and once in the 
abstraction layer initialization</li>
</ul>
<hr>
<p>VERSION 0.1<br>
02/08/2001</p>
<p>Initial public release.</p>

      </td>
    </tr>
  </table>
        </td>
	  </tr>
	</table>
  </td>
                <td rowspan="2" width="10">
				  &nbsp;</td>
                <td align="left" valign="top" rowspan="2">
				  <script type="text/javascript"><!--
					google_ad_client = "ca-pub-2784580927617241";
					/* orig */
					google_ad_slot = "8342665437";
					google_ad_width = 160;
					google_ad_height = 600;
					//-->
				  </script>
				  <script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				  </script>
                </td>
              </tr>
              <tr>
                <td nowrap align="left" valign="bottom">
			  <font size="1">Copyright &#169; 1999-2013 J. Andrew McLaughlin | 
              Visopsys and Visopsys.org are trademarks of J. Andrew McLaughlin.&nbsp;&nbsp;&nbsp
              <a href="mailto:andy@visopsys.org">Contact</a></font></td>
              </tr>
            </table>
	        </td>
		  </tr>
		  </table>
	  </center>
	</font>
	</div>
  </body>
</html>