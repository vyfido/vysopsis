<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Visopsys | Visual Operating System | Kernel API 0.7</title>
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
              <a href="../download/index.php"><img border="0" src="../img/nav_buttons/download.gif"></a>&nbsp;&nbsp; <a href="../forums/index.php"><img border="0" src="../img/nav_buttons/forum.gif"></a>&nbsp; <a href="index.php"><img border="0" src="../img/nav_buttons/developers.gif"></a></b></font><font color="#EEEEFF" size="2" face="arial"><b>&nbsp;&nbsp; 
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

<p align="left"><b><font face="Arial" size="4">Developers</font></b></p>

<div align="center">
  <center>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="700">
    <tr>
      <td><b>THE VISOPSYS KERNEL API (Version 0.7)<br>
      </b>(version 0.6 is <a href="kernel_API_0.6.php">here</a>)<p>
      All of the kernel's functions are defined in the file 
/system/headers/sys/api.h. In future, this file may be split into smaller 
chunks, by functional area. Data structures referred to in these function 
definitions are found in header files in the /system/headers/sys directory. For 
example, a 'disk' object is defined in /system/headers/sys/disk.h.</p>
<blockquote>
  <p><i>One note on the 'objectKey' type used by many of these functions: This is used to refer to 
  data structures in kernel memory that are not accessible (in a practical sense) to external programs. Users of the 
  kernel API should treat these as opaque reference handles.</i></p>
</blockquote>
<p>Here is the breakdown of functions divided by functional area:</p>
<p><a href="kernel_API.php#text">Text input/output functions</a><br>
<a href="kernel_API.php#disk">Disk functions</a><br>
<a href="kernel_API.php#filesystem">Filesystem functions</a><br>
<a href="kernel_API.php#file">File functions</a><br>
<a href="kernel_API.php#memory">Memory functions</a><br>
<a href="kernel_API.php#multitasker">Multitasker functions</a><br>
<a href="kernel_API.php#loader">Loader functions</a><br>
<a href="kernel_API.php#rtc">Real-time clock functions</a><br>
<a href="kernel_API.php#random">Random number functions</a><br>
<a href="kernel_API.php#environment">Environment functions</a><br>
<a href="kernel_API.php#graphics">Raw graphics functions</a><br>
<a href="kernel_API.php#window">Window system functions</a><br>
<a href="kernel_API.php#user">User functions</a><br>
<a href="kernel_API.php#network">Network functions</a><br>
<a href="kernel_API.php#miscellaneous">Miscellaneous functions</a></p>
<p>&nbsp;</p>

<p><b><a name="text"></a>Text input/output functions</b></p>
<p>
<p><font face="Courier New">objectKey textGetConsoleInput(void)
</font></p>
<blockquote>
  <p>Returns a reference to the console input stream.  This is where keyboard input goes by default.
</p></blockquote>
<p><font face="Courier New">int textSetConsoleInput(objectKey newStream)
</font></p>
<blockquote>
  <p>Changes the console input stream.  GUI programs can use this function to redirect input to a text area or text field, for example.
</p></blockquote>
<p><font face="Courier New">objectKey textGetConsoleOutput(void)
</font></p>
<blockquote>
  <p>Returns a reference to the console output stream.  This is where kernel logging output goes by default.
</p></blockquote>
<p><font face="Courier New">int textSetConsoleOutput(objectKey newStream)
</font></p>
<blockquote>
  <p>Changes the console output stream.  GUI programs can use this function to redirect output to a text area or text field, for example.
</p></blockquote>
<p><font face="Courier New">objectKey textGetCurrentInput(void)
</font></p>
<blockquote>
  <p>Returns a reference to the input stream of the current process.  This is where standard input (for example, from a getc() call) is received.
</p></blockquote>
<p><font face="Courier New">int textSetCurrentInput(objectKey newStream)
</font></p>
<blockquote>
  <p>Changes the current input stream.  GUI programs can use this function to redirect input to a text area or text field, for example.
</p></blockquote>
<p><font face="Courier New">objectKey textGetCurrentOutput(void)
</font></p>
<blockquote>
  <p>Returns a reference to the console output stream.
</p></blockquote>
<p><font face="Courier New">int textSetCurrentOutput(objectKey newStream)
</font></p>
<blockquote>
  <p>Changes the current output stream.  This is where standard output (for example, from a putc() call) goes.
</p></blockquote>
<p><font face="Courier New">int textGetForeground(color *foreground)
</font></p>
<blockquote>
  <p>Return the current foreground color in the color structure 'foreground'.
</p></blockquote>
<p><font face="Courier New">int textSetForeground(color *foreground)
</font></p>
<blockquote>
  <p>Set the current foreground color to the one represented in the color structure 'foreground'.  Some standard color values (as in PC text-mode values) can be found in <sys/color.h>.
</p></blockquote>
<p><font face="Courier New">int textGetBackground(color *background)
</font></p>
<blockquote>
  <p>Return the current background color in the color structure 'background'.
</p></blockquote>
<p><font face="Courier New">int textSetBackground(color *background)
</font></p>
<blockquote>
  <p>Set the current background color to the one represented in the color structure 'background'.  Some standard color values (as in PC text-mode values) can be found in <sys/color.h>.
</p></blockquote>
<p><font face="Courier New">int textPutc(int ascii)
</font></p>
<blockquote>
  <p>Print a single character
</p></blockquote>
<p><font face="Courier New">int textPrint(const char *str)
</font></p>
<blockquote>
  <p>Print a string
</p></blockquote>
<p><font face="Courier New">int textPrintAttrs(textAttrs *attrs, const char *str)
</font></p>
<blockquote>
  <p>Print a string, with attributes.  See <sys/text.h> for the definition of the textAttrs structure.
</p></blockquote>
<p><font face="Courier New">int textPrintLine(const char *str)
</font></p>
<blockquote>
  <p>Print a string with a newline at the end
</p></blockquote>
<p><font face="Courier New">void textNewline(void)
</font></p>
<blockquote>
  <p>Print a newline
</p></blockquote>
<p><font face="Courier New">int textBackSpace(void)
</font></p>
<blockquote>
  <p>Backspace the cursor, deleting any character there
</p></blockquote>
<p><font face="Courier New">int textTab(void)
</font></p>
<blockquote>
  <p>Print a tab
</p></blockquote>
<p><font face="Courier New">int textCursorUp(void)
</font></p>
<blockquote>
  <p>Move the cursor up one row.  Doesn't affect any characters there.
</p></blockquote>
<p><font face="Courier New">int textCursorDown(void)
</font></p>
<blockquote>
  <p>Move the cursor down one row.  Doesn't affect any characters there.
</p></blockquote>
<p><font face="Courier New">int textCursorLeft(void)
</font></p>
<blockquote>
  <p>Move the cursor left one column.  Doesn't affect any characters there.
</p></blockquote>
<p><font face="Courier New">int textCursorRight(void)
</font></p>
<blockquote>
  <p>Move the cursor right one column.  Doesn't affect any characters there.
</p></blockquote>
<p><font face="Courier New">int textEnableScroll(int enable)
</font></p>
<blockquote>
  <p>Enable or disable screen scrolling for the current text output stream
</p></blockquote>
<p><font face="Courier New">void textScroll(int upDown)
</font></p>
<blockquote>
  <p>Scroll the current text area up 'upDown' screenfulls, if negative, or down 'upDown' screenfulls, if positive.
</p></blockquote>
<p><font face="Courier New">int textGetNumColumns(void)
</font></p>
<blockquote>
  <p>Get the total number of columns in the text area.
</p></blockquote>
<p><font face="Courier New">int textGetNumRows(void)
</font></p>
<blockquote>
  <p>Get the total number of rows in the text area.
</p></blockquote>
<p><font face="Courier New">int textGetColumn(void)
</font></p>
<blockquote>
  <p>Get the number of the current column.  Zero-based.
</p></blockquote>
<p><font face="Courier New">void textSetColumn(int c)
</font></p>
<blockquote>
  <p>Set the number of the current column.  Zero-based.  Doesn't affect any characters there.
</p></blockquote>
<p><font face="Courier New">int textGetRow(void)
</font></p>
<blockquote>
  <p>Get the number of the current row.  Zero-based.
</p></blockquote>
<p><font face="Courier New">void textSetRow(int r)
</font></p>
<blockquote>
  <p>Set the number of the current row.  Zero-based.  Doesn't affect any characters there.
</p></blockquote>
<p><font face="Courier New">void textSetCursor(int on)
</font></p>
<blockquote>
  <p>Turn the cursor on (1) or off (0)
</p></blockquote>
<p><font face="Courier New">int textScreenClear(void)
</font></p>
<blockquote>
  <p>Erase all characters in the text area and set the row and column to (0, 0)
</p></blockquote>
<p><font face="Courier New">int textScreenSave(textScreen *screen)
</font></p>
<blockquote>
  <p>Save the current screen in the supplied structure.  Use with the textScreenRestore function.
</p></blockquote>
<p><font face="Courier New">int textScreenRestore(textScreen *screen)
</font></p>
<blockquote>
  <p>Restore the screen previously saved in the structure with the textScreenSave function
</p></blockquote>
<p><font face="Courier New">int textInputStreamCount(objectKey strm)
</font></p>
<blockquote>
  <p>Get the number of characters currently waiting in the specified input stream
</p></blockquote>
<p><font face="Courier New">int textInputCount(void)
</font></p>
<blockquote>
  <p>Get the number of characters currently waiting in the current input stream
</p></blockquote>
<p><font face="Courier New">int textInputStreamGetc(objectKey strm, char *cp)
</font></p>
<blockquote>
  <p>Get one character from the specified input stream (as an integer value).
</p></blockquote>
<p><font face="Courier New">int textInputGetc(char *cp)
</font></p>
<blockquote>
  <p>Get one character from the default input stream (as an integer value).
</p></blockquote>
<p><font face="Courier New">int textInputStreamReadN(objectKey strm, int num, char *buff)
</font></p>
<blockquote>
  <p>Read up to 'num' characters from the specified input stream into 'buff'
</p></blockquote>
<p><font face="Courier New">int textInputReadN(int num, char *buff)
</font></p>
<blockquote>
  <p>Read up to 'num' characters from the default input stream into 'buff'
</p></blockquote>
<p><font face="Courier New">int textInputStreamReadAll(objectKey strm, char *buff)
</font></p>
<blockquote>
  <p>Read all of the characters from the specified input stream into 'buff'
</p></blockquote>
<p><font face="Courier New">int textInputReadAll(char *buff)
</font></p>
<blockquote>
  <p>Read all of the characters from the default input stream into 'buff'
</p></blockquote>
<p><font face="Courier New">int textInputStreamAppend(objectKey strm, int ascii)
</font></p>
<blockquote>
  <p>Append a character (as an integer value) to the end of the specified input stream.
</p></blockquote>
<p><font face="Courier New">int textInputAppend(int ascii)
</font></p>
<blockquote>
  <p>Append a character (as an integer value) to the end of the default input stream.
</p></blockquote>
<p><font face="Courier New">int textInputStreamAppendN(objectKey strm, int num, char *str)
</font></p>
<blockquote>
  <p>Append 'num' characters to the end of the specified input stream from 'str'
</p></blockquote>
<p><font face="Courier New">int textInputAppendN(int num, char *str)
</font></p>
<blockquote>
  <p>Append 'num' characters to the end of the default input stream from 'str'
</p></blockquote>
<p><font face="Courier New">int textInputStreamRemove(objectKey strm)
</font></p>
<blockquote>
  <p>Remove one character from the start of the specified input stream.
</p></blockquote>
<p><font face="Courier New">int textInputRemove(void)
</font></p>
<blockquote>
  <p>Remove one character from the start of the default input stream.
</p></blockquote>
<p><font face="Courier New">int textInputStreamRemoveN(objectKey strm, int num)
</font></p>
<blockquote>
  <p>Remove 'num' characters from the start of the specified input stream.
</p></blockquote>
<p><font face="Courier New">int textInputRemoveN(int num)
</font></p>
<blockquote>
  <p>Remove 'num' characters from the start of the default input stream.
</p></blockquote>
<p><font face="Courier New">int textInputStreamRemoveAll(objectKey strm)
</font></p>
<blockquote>
  <p>Empty the specified input stream.
</p></blockquote>
<p><font face="Courier New">int textInputRemoveAll(void)
</font></p>
<blockquote>
  <p>Empty the default input stream.
</p></blockquote>
<p><font face="Courier New">void textInputStreamSetEcho(objectKey strm, int onOff)
</font></p>
<blockquote>
  <p>Set echo on (1) or off (0) for the specified input stream.  When on, any characters typed will be automatically printed to the text area.  When off, they won't.
</p></blockquote>
<p><font face="Courier New">void textInputSetEcho(int onOff)
</font></p>
<blockquote>
  <p>Set echo on (1) or off (0) for the default input stream.  When on, any characters typed will be automatically printed to the text area.  When off, they won't.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="disk"></a>Disk functions</b></p>
<p>
<p><font face="Courier New">int diskReadPartitions(const char *name)
</font></p>
<blockquote>
  <p>Tells the kernel to (re)read the partition table of disk 'name'.
</p></blockquote>
<p><font face="Courier New">int diskReadPartitionsAll(void)
</font></p>
<blockquote>
  <p>Tells the kernel to (re)read all the disks' partition tables.
</p></blockquote>
<p><font face="Courier New">int diskSync(const char *name)
</font></p>
<blockquote>
  <p>Tells the kernel to synchronize the named disk, flushing any output.
</p></blockquote>
<p><font face="Courier New">int diskSyncAll(void)
</font></p>
<blockquote>
  <p>Tells the kernel to synchronize all the disks, flushing any output.
</p></blockquote>
<p><font face="Courier New">int diskGetBoot(char *name)
</font></p>
<blockquote>
  <p>Get the disk name of the boot device.  Normally this will contain the root filesystem.
</p></blockquote>
<p><font face="Courier New">int diskGetCount(void)
</font></p>
<blockquote>
  <p>Get the number of logical disk volumes recognized by the system
</p></blockquote>
<p><font face="Courier New">int diskGetPhysicalCount(void)
</font></p>
<blockquote>
  <p>Get the number of physical disk devices recognized by the system
</p></blockquote>
<p><font face="Courier New">int diskGet(const char *name, disk *userDisk)
</font></p>
<blockquote>
  <p>Given a disk name string 'name', fill in the corresponding user space disk structure 'userDisk.
</p></blockquote>
<p><font face="Courier New">int diskGetAll(disk *userDiskArray, unsigned buffSize)
</font></p>
<blockquote>
  <p>Return user space disk structures in 'userDiskArray' for each logical disk, up to 'buffSize' bytes.
</p></blockquote>
<p><font face="Courier New">int diskGetAllPhysical(disk *userDiskArray, unsigned buffSize)
</font></p>
<blockquote>
  <p>Return user space disk structures in 'userDiskArray' for each physical disk, up to 'buffSize' bytes.
</p></blockquote>
<p><font face="Courier New">int diskGetFilesystemType(const char *name, char *buf, unsigned bufSize)
</font></p>
<blockquote>
  <p>This function attempts to explicitly detect the filesystem type on disk 'name', and copy up to 'bufSize' bytes of the filesystem type name into 'buf'.  Particularly useful for things like removable media where the correct info may not be automatically provided in the disk structure.
</p></blockquote>
<p><font face="Courier New">int diskGetMsdosPartType(int tag, msdosPartType *p)
</font></p>
<blockquote>
  <p>Gets the MS-DOS partition type description for the corresponding tag.  This function was added specifically for use by programs such as 'fdisk' to get descriptions of different MS-DOS types known to the kernel.
</p></blockquote>
<p><font face="Courier New">msdosPartType *diskGetMsdosPartTypes(void)
</font></p>
<blockquote>
  <p>Like diskGetMsdosPartType(), but returns a pointer to a list of all known MS-DOS types.  The memory is allocated dynamically and should be deallocated with a call to memoryRelease()
</p></blockquote>
<p><font face="Courier New">int diskGetGptPartType(guid *g, gptPartType *p)
</font></p>
<blockquote>
  <p>Gets the GPT partition type description for the corresponding GUID.  This function was added specifically for use by programs such as 'fdisk' to get descriptions of different GPT types known to the kernel.
</p></blockquote>
<p><font face="Courier New">gptPartType *diskGetGptPartTypes(void)
</font></p>
<blockquote>
  <p>Like diskGetGptPartType(), but returns a pointer to a list of all known GPT types.  The memory is allocated dynamically and should be deallocated with a call to memoryRelease()
</p></blockquote>
<p><font face="Courier New">int diskSetFlags(const char *name, unsigned flags, int set)
</font></p>
<blockquote>
  <p>Set or clear the (user-settable) disk flags bits in 'flags' of the disk 'name'.
</p></blockquote>
<p><font face="Courier New">int diskSetLockState(const char *name, int state)
</font></p>
<blockquote>
  <p>Set the locked state of the disk 'name' to either unlocked (0) or locked (1)
</p></blockquote>
<p><font face="Courier New">int diskSetDoorState(const char *name, int state)
</font></p>
<blockquote>
  <p>Open (1) or close (0) the disk 'name'.  May require a unlocking the door first, see diskSetLockState().
</p></blockquote>
<p><font face="Courier New">int diskGetMediaState(const char *diskName)
</font></p>
<blockquote>
  <p>Returns 1 if the removable disk 'diskName' is known to have media present.
</p></blockquote>
<p><font face="Courier New">int diskReadSectors(const char *name, uquad_t sect, uquad_t count, void *buf)
</font></p>
<blockquote>
  <p>Read 'count' sectors from disk 'name', starting at (zero-based) logical sector number 'sect'.  Put the data in memory area 'buf'.  This function requires supervisor privilege.
</p></blockquote>
<p><font face="Courier New">int diskWriteSectors(const char *name, uquad_t sect, uquad_t count, const void *buf)
</font></p>
<blockquote>
  <p>Write 'count' sectors to disk 'name', starting at (zero-based) logical sector number 'sect'.  Get the data from memory area 'buf'.  This function requires supervisor privilege.
</p></blockquote>
<p><font face="Courier New">int diskEraseSectors(const char *name, uquad_t sect, uquad_t count, int passes)
</font></p>
<blockquote>
  <p>Synchronously and securely erases disk sectors.  It writes ('passes' - 1) successive passes of random data followed by a final pass of NULLs, to disk 'name' starting at (zero-based) logical sector number 'sect'.  This function requires supervisor privilege.
</p></blockquote>
<p><font face="Courier New">int diskGetStats(const char *name, diskStats *stats)
</font></p>
<blockquote>
  <p>Return performance stats about the disk 'name' (if non-NULL,
</p></blockquote>
<p><font face="Courier New">int diskRamDiskCreate(unsigned size, char *name)
</font></p>
<blockquote>
  <p>Given a size in bytes, and a pointer to a buffer 'name', create a RAM disk.  If 'name' is non-NULL, place the name of the new disk in the buffer.
</p></blockquote>
<p><font face="Courier New">int diskRamDiskDestroy(const char *name)
</font></p>
<blockquote>
  <p>Given the name of an existing RAM disk 'name', destroy and deallocate it.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="filesystem"></a>Filesystem functions</b></p>
<p>
<p><font face="Courier New">int filesystemFormat(const char *theDisk, const char *type, const char *label, int longFormat, progress *prog)
</font></p>
<blockquote>
  <p>Format the logical volume 'theDisk', with a string 'type' representing the preferred filesystem type (for example, "fat", "fat16", "fat32, etc).  Label it with 'label'.  'longFormat' will do a sector-by-sector format, if supported, and progress can optionally be monitored by passing a non-NULL progress structure pointer 'prog'.  It is optional for filesystem drivers to implement this function.
</p></blockquote>
<p><font face="Courier New">int filesystemClobber(const char *theDisk)
</font></p>
<blockquote>
  <p>Clobber all known filesystem types on the logical volume 'theDisk'.  It is optional for filesystem drivers to implement this function.
</p></blockquote>
<p><font face="Courier New">int filesystemCheck(const char *name, int force, int repair, progress *prog)
</font></p>
<blockquote>
  <p>Check the filesystem on disk 'name'.  If 'force' is non-zero, the filesystem will be checked regardless of whether the filesystem driver thinks it needs to be.  If 'repair' is non-zero, the filesystem driver will attempt to repair any errors found.  If 'repair' is zero, a non-zero return value may indicate that errors were found.  If 'repair' is non-zero, a non-zero return value may indicate that errors were found but could not be fixed.  Progress can optionally be monitored by passing a non-NULL progress structure pointer 'prog'.  It is optional for filesystem drivers to implement this function.
</p></blockquote>
<p><font face="Courier New">int filesystemDefragment(const char *name, progress *prog)
</font></p>
<blockquote>
  <p>Defragment the filesystem on disk 'name'.  Progress can optionally be monitored by passing a non-NULL progress structure pointer 'prog'.  It is optional for filesystem drivers to implement this function.
</p></blockquote>
<p><font face="Courier New">int filesystemResizeConstraints(const char *name, uquad_t *minBlocks, uquad_t *maxBlocks)
</font></p>
<blockquote>
  <p>Get the minimum ('minBlocks') and maximum ('maxBlocks') number of blocks for a filesystem resize on disk 'name'.  It is optional for filesystem drivers to implement this function.
</p></blockquote>
<p><font face="Courier New">int filesystemResize(const char *name, uquad_t blocks, progress *prog)
</font></p>
<blockquote>
  <p>Resize the filesystem on disk 'name' to the given number of blocks 'blocks'.  Progress can optionally be monitored by passing a non-NULL progress structure pointer 'prog'.  It is optional for filesystem drivers to implement this function.
</p></blockquote>
<p><font face="Courier New">int filesystemMount(const char *name, const char *mp)
</font></p>
<blockquote>
  <p>Mount the filesystem on disk 'name', using the mount point specified by the absolute pathname 'mp'.  Note that no file or directory called 'mp' should exist, as the mount function will expect to be able to create it.
</p></blockquote>
<p><font face="Courier New">int filesystemUnmount(const char *mp)
</font></p>
<blockquote>
  <p>Unmount the filesystem mounted represented by the mount point 'fs'.
</p></blockquote>
<p><font face="Courier New">uquad_t filesystemGetFreeBytes(const char *fs)
</font></p>
<blockquote>
  <p>Returns the amount of free space, in bytes, on the filesystem represented by the mount point 'fs'.
</p></blockquote>
<p><font face="Courier New">unsigned filesystemGetBlockSize(const char *fs)
</font></p>
<blockquote>
  <p>Returns the block size (for example, 512 or 1024) of the filesystem represented by the mount point 'fs'.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="file"></a>File functions</b></p>
<p>Note that in all of the functions of this section, any 
reference to pathnames means absolute pathnames, from root. E.g. '/files/myfile', 
not simply 'myfile'. From the kernel's point of view, 'myfile' might be 
ambiguous.</p>
<p>
<p><font face="Courier New">int fileFixupPath(const char *origPath, char *newPath)
</font></p>
<blockquote>
  <p>Take the absolute pathname in 'origPath' and fix it up.  This means eliminating extra file separator characters (for example) and resolving links or '.' or '..' components in the pathname.
</p></blockquote>
<p><font face="Courier New">int fileGetDisk(const char *path, disk *d)
</font></p>
<blockquote>
  <p>Given the file name 'path', return the user space structure for the logical disk that the file resides on.
</p></blockquote>
<p><font face="Courier New">int fileCount(const char *path)
</font></p>
<blockquote>
  <p>Get the count of file entries from the directory referenced by 'path'.
</p></blockquote>
<p><font face="Courier New">int fileFirst(const char *path, file *f)
</font></p>
<blockquote>
  <p>Get the first file from the directory referenced by 'path'.  Put the information in the file structure 'f'.
</p></blockquote>
<p><font face="Courier New">int fileNext(const char *path, file *f)
</font></p>
<blockquote>
  <p>Get the next file from the directory referenced by 'path'.  'f' should be a file structure previously filled by a call to either fileFirst() or fileNext().
</p></blockquote>
<p><font face="Courier New">int fileFind(const char *name, file *f)
</font></p>
<blockquote>
  <p>Find the file referenced by 'name', and fill the file data structure 'f' with the results if successful.
</p></blockquote>
<p><font face="Courier New">int fileOpen(const char *name, int mode, file *f)
</font></p>
<blockquote>
  <p>Open the file referenced by 'name' using the file open mode 'mode' (defined in <sys/file.h>).  Update the file data structure 'f' if successful.
</p></blockquote>
<p><font face="Courier New">int fileClose(file *f)
</font></p>
<blockquote>
  <p>Close the previously opened file 'f'.
</p></blockquote>
<p><font face="Courier New">int fileRead(file *f, unsigned blocknum, unsigned blocks, void *buff)
</font></p>
<blockquote>
  <p>Read data from the previously opened file 'f'.  'f' should have been opened in a read or read/write mode.  Read 'blocks' blocks (see the filesystem functions for information about getting the block size of a given filesystem) and put them in buffer 'buff'.
</p></blockquote>
<p><font face="Courier New">int fileWrite(file *f, unsigned blocknum, unsigned blocks, void *buff)
</font></p>
<blockquote>
  <p>Write data to the previously opened file 'f'.  'f' should have been opened in a write or read/write mode.  Write 'blocks' blocks (see the filesystem functions for information about getting the block size of a given filesystem) from the buffer 'buff'.
</p></blockquote>
<p><font face="Courier New">int fileDelete(const char *name)
</font></p>
<blockquote>
  <p>Delete the file referenced by the pathname 'name'.
</p></blockquote>
<p><font face="Courier New">int fileDeleteRecursive(const char *name)
</font></p>
<blockquote>
  <p>Recursively delete filesystem items, starting with the one referenced by the pathname 'name'.
</p></blockquote>
<p><font face="Courier New">int fileDeleteSecure(const char *name, int passes)
</font></p>
<blockquote>
  <p>Securely delete the file referenced by the pathname 'name'.  'passes' indicates the number of times to overwrite the file.  The file is overwritten (number - 1) times with random data, and then NULLs.  A larger number of passes is more secure but takes longer.
</p></blockquote>
<p><font face="Courier New">int fileMakeDir(const char *name)
</font></p>
<blockquote>
  <p>Create a directory to be referenced by the pathname 'name'.
</p></blockquote>
<p><font face="Courier New">int fileRemoveDir(const char *name)
</font></p>
<blockquote>
  <p>Remove the directory referenced by the pathname 'name'.
</p></blockquote>
<p><font face="Courier New">int fileCopy(const char *src, const char *dest)
</font></p>
<blockquote>
  <p>Copy the file referenced by the pathname 'src' to the pathname 'dest'.  This will overwrite 'dest' if it already exists.
</p></blockquote>
<p><font face="Courier New">int fileCopyRecursive(const char *src, const char *dest)
</font></p>
<blockquote>
  <p>Recursively copy the file referenced by the pathname 'src' to the pathname 'dest'.  If 'src' is a regular file, the result will be the same as using the non-recursive call.  However if it is a directory, all contents of the directory and its subdirectories will be copied.  This will overwrite any files in the 'dest' tree if they already exist.
</p></blockquote>
<p><font face="Courier New">int fileMove(const char *src, const char *dest)
</font></p>
<blockquote>
  <p>Move (rename) a file referenced by the pathname 'src' to the pathname 'dest'.
</p></blockquote>
<p><font face="Courier New">int fileTimestamp(const char *name)
</font></p>
<blockquote>
  <p>Update the time stamp on the file referenced by the pathname 'name'
</p></blockquote>
<p><font face="Courier New">int fileSetSize(file *f, unsigned size)
</font></p>
<blockquote>
  <p>Change the length of the file 'file' to the new length 'length'
</p></blockquote>
<p><font face="Courier New">int fileGetTemp(file *f)
</font></p>
<blockquote>
  <p>Create and open a temporary file in write mode.
</p></blockquote>
<p><font face="Courier New">int fileGetFullPath(file *f, char *buff, int len)
</font></p>
<blockquote>
  <p>Given a file structure, return up to 'len' bytes of the fully-qualified file name in the buffer 'buff'.
</p></blockquote>
<p><font face="Courier New">int fileStreamOpen(const char *name, int mode, fileStream *f)
</font></p>
<blockquote>
  <p>Open the file referenced by the pathname 'name' for streaming operations, using the open mode 'mode' (defined in <sys/file.h>).  Fills the fileStream data structure 'f' with information needed for subsequent filestream operations.
</p></blockquote>
<p><font face="Courier New">int fileStreamSeek(fileStream *f, unsigned offset)
</font></p>
<blockquote>
  <p>Seek the filestream 'f' to the absolute position 'offset'
</p></blockquote>
<p><font face="Courier New">int fileStreamRead(fileStream *f, unsigned bytes, char *buff)
</font></p>
<blockquote>
  <p>Read 'bytes' bytes from the filestream 'f' and put them into 'buff'.
</p></blockquote>
<p><font face="Courier New">int fileStreamReadLine(fileStream *f, unsigned bytes, char *buff)
</font></p>
<blockquote>
  <p>Read a complete line of text from the filestream 'f', and put up to 'bytes' characters into 'buff'
</p></blockquote>
<p><font face="Courier New">int fileStreamWrite(fileStream *f, unsigned bytes, char *buff)
</font></p>
<blockquote>
  <p>Write 'bytes' bytes from the buffer 'buff' to the filestream 'f'.
</p></blockquote>
<p><font face="Courier New">int fileStreamWriteStr(fileStream *f, char *buff)
</font></p>
<blockquote>
  <p>Write the string in 'buff' to the filestream 'f'
</p></blockquote>
<p><font face="Courier New">int fileStreamWriteLine(fileStream *f, char *buff)
</font></p>
<blockquote>
  <p>Write the string in 'buff' to the filestream 'f', and add a newline at the end
</p></blockquote>
<p><font face="Courier New">int fileStreamFlush(fileStream *f)
</font></p>
<blockquote>
  <p>Flush filestream 'f'.
</p></blockquote>
<p><font face="Courier New">int fileStreamClose(fileStream *f)
</font></p>
<blockquote>
  <p>[Flush and] close the filestream 'f'.
</p></blockquote>
<p><font face="Courier New">int fileStreamGetTemp(fileStream *f)
</font></p>
<blockquote>
  <p>Open a temporary filestream 'f'.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="memory"></a>Memory functions</b></p>
<p>
<p><font face="Courier New">void *memoryGet(unsigned size, const char *desc)
</font></p>
<blockquote>
  <p>Return a pointer to a new block of memory of size 'size' and (optional) physical alignment 'align', adding the (optional) description 'desc'.  If no specific alignment is required, use '0'.  Memory allocated using this function is automatically cleared (like 'calloc').
</p></blockquote>
<p><font face="Courier New">int memoryRelease(void *p)
</font></p>
<blockquote>
  <p>Release the memory block starting at the address 'p'.  Must have been previously allocated using the memoryRequestBlock() function.
</p></blockquote>
<p><font face="Courier New">int memoryReleaseAllByProcId(int pid)
</font></p>
<blockquote>
  <p>Release all memory allocated to/by the process referenced by process ID 'pid'.  Only privileged functions can release memory owned by other processes.
</p></blockquote>
<p><font face="Courier New">int memoryGetStats(memoryStats *stats, int kernel)
</font></p>
<blockquote>
  <p>Returns the current memory totals and usage values to the current output stream.  If non-zero, the flag 'kernel' will return kernel heap statistics instead of overall system statistics.
</p></blockquote>
<p><font face="Courier New">int memoryGetBlocks(memoryBlock *blocksArray, unsigned buffSize, int kernel)
</font></p>
<blockquote>
  <p>Returns a copy of the array of used memory blocks in 'blocksArray', up to 'buffSize' bytes.  If non-zero, the flag 'kernel' will return kernel heap blocks instead of overall heap allocations.
</p></blockquote>
<p><font face="Courier New">int memoryBlockInfo(void *p, memoryBlock *block)
</font></p>
<blockquote>
  <p>Fills in the structure 'block' with information about the allocated memory block starting at virtual address 'p'
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="multitasker"></a>Multitasker functions</b></p>
<p>
<p><font face="Courier New">int multitaskerCreateProcess(const char *name, int privilege, processImage *execImage)
</font></p>
<blockquote>
  <p>Create a new process.  'name' will be the new process' name.  'privilege' is the privilege level.  'execImage' is a processImage structure that describes the loaded location of the file, the program's desired virtual address, entry point, size, etc.  If the value returned by the call is a positive integer, the call was successful and the value is the new process' process ID.  New processes are created and left in a stopped state, so if you want it to run you will need to set it to a running state ('ready', actually) using the function call multitaskerSetProcessState().
</p></blockquote>
<p><font face="Courier New">int multitaskerSpawn(void *addr, const char *name, int numargs, void *args[])
</font></p>
<blockquote>
  <p>Spawn a thread from the current process.  The starting point of the code (for example, a function address) should be specified as 'addr'.  'name' will be the new thread's name.  'numargs' and 'args' will be passed as the "int argc, char *argv[]) parameters of the new thread.  If there are no arguments, these should be 0 and NULL, respectively.  If the value returned by the call is a positive integer, the call was successful and the value is the new thread's process ID.  New threads are created and made runnable, so there is no need to change its state to activate it.
</p></blockquote>
<p><font face="Courier New">int multitaskerGetCurrentProcessId(void)
</font></p>
<blockquote>
  <p>Returns the process ID of the calling program.
</p></blockquote>
<p><font face="Courier New">int multitaskerGetProcess(int pid, process *proc)
</font></p>
<blockquote>
  <p>Returns the process structure for the supplied process ID.
</p></blockquote>
<p><font face="Courier New">int multitaskerGetProcessByName(const char *name, process *proc)
</font></p>
<blockquote>
  <p>Returns the process structure for the supplied process name
</p></blockquote>
<p><font face="Courier New">int multitaskerGetProcesses(void *buffer, unsigned buffSize)
</font></p>
<blockquote>
  <p>Fills 'buffer' with up to 'buffSize' bytes' worth of process structures, and returns the number of structures copied.
</p></blockquote>
<p><font face="Courier New">int multitaskerSetProcessState(int pid, int state)
</font></p>
<blockquote>
  <p>Sets the state of the process referenced by process ID 'pid' to the new state 'state'.
</p></blockquote>
<p><font face="Courier New">int multitaskerProcessIsAlive(int pid)
</font></p>
<blockquote>
  <p>Returns 1 if the process with the id 'pid' still exists and is in a 'runnable' (viable) state.  Returns 0 if the process does not exist or is in a 'finished' state.
</p></blockquote>
<p><font face="Courier New">int multitaskerSetProcessPriority(int pid, int priority)
</font></p>
<blockquote>
  <p>Sets the priority of the process referenced by process ID 'pid' to 'priority'.
</p></blockquote>
<p><font face="Courier New">int multitaskerGetProcessPrivilege(int pid)
</font></p>
<blockquote>
  <p>Gets the privilege level of the process referenced by process ID 'pid'.
</p></blockquote>
<p><font face="Courier New">int multitaskerGetCurrentDirectory(char *buff, int buffsz)
</font></p>
<blockquote>
  <p>Returns the absolute pathname of the calling process' current directory.  Puts the value in the buffer 'buff' which is of size 'buffsz'.
</p></blockquote>
<p><font face="Courier New">int multitaskerSetCurrentDirectory(const char *buff)
</font></p>
<blockquote>
  <p>Sets the current directory of the calling process to the absolute pathname 'buff'.
</p></blockquote>
<p><font face="Courier New">objectKey multitaskerGetTextInput(void)
</font></p>
<blockquote>
  <p>Get an object key to refer to the current text input stream of the calling process.
</p></blockquote>
<p><font face="Courier New">int multitaskerSetTextInput(int processId, objectKey key)
</font></p>
<blockquote>
  <p>Set the text input stream of the process referenced by process ID 'processId' to a text stream referenced by the object key 'key'.
</p></blockquote>
<p><font face="Courier New">objectKey multitaskerGetTextOutput(void)
</font></p>
<blockquote>
  <p>Get an object key to refer to the current text output stream of the calling process.
</p></blockquote>
<p><font face="Courier New">int multitaskerSetTextOutput(int processId, objectKey key)
</font></p>
<blockquote>
  <p>Set the text output stream of the process referenced by process ID 'processId' to a text stream referenced by the object key 'key'.
</p></blockquote>
<p><font face="Courier New">int multitaskerDuplicateIO(int pid1, int pid2, int clear)
</font></p>
<blockquote>
  <p>Set 'pid2' to use the same input and output streams as 'pid1', and if 'clear' is non-zero, clear any pending input or output.
</p></blockquote>
<p><font face="Courier New">int multitaskerGetProcessorTime(clock_t *clk)
</font></p>
<blockquote>
  <p>Fill the clock_t structure with the amount of processor time consumed by the calling process.
</p></blockquote>
<p><font face="Courier New">void multitaskerYield(void)
</font></p>
<blockquote>
  <p>Yield the remainder of the current processor timeslice back to the multitasker's scheduler.  It's nice to do this when you are waiting for some event, so that your process is not 'hungry' (i.e. hogging processor cycles unnecessarily).
</p></blockquote>
<p><font face="Courier New">void multitaskerWait(unsigned ticks)
</font></p>
<blockquote>
  <p>Yield the remainder of the current processor timeslice back to the multitasker's scheduler, and wait at least 'ticks' timer ticks before running the calling process again.  On the PC, one second is approximately 20 system timer ticks.
</p></blockquote>
<p><font face="Courier New">int multitaskerBlock(int pid)
</font></p>
<blockquote>
  <p>Yield the remainder of the current processor timeslice back to the multitasker's scheduler, and block on the process referenced by process ID 'pid'.  This means that the calling process will not run again until process 'pid' has terminated.  The return value of this function is the return value of process 'pid'.
</p></blockquote>
<p><font face="Courier New">int multitaskerDetach(void)
</font></p>
<blockquote>
  <p>This allows a program to 'daemonize', detaching from the IO streams of its parent and, if applicable, the parent stops blocking.  Useful for a process that want to operate in the background, or that doesn't want to be killed if its parent is killed.
</p></blockquote>
<p><font face="Courier New">int multitaskerKillProcess(int pid, int force)
</font></p>
<blockquote>
  <p>Terminate the process referenced by process ID 'pid'.  If 'force' is non-zero, the multitasker will attempt to ignore any errors and dismantle the process with extreme prejudice.  The 'force' flag also has the necessary side effect of killing any child threads spawned by process 'pid'.  (Otherwise, 'pid' is left in a stopped state until its threads have terminated normally).
</p></blockquote>
<p><font face="Courier New">int multitaskerKillByName(const char *name, int force)
</font></p>
<blockquote>
  <p>Like multitaskerKillProcess, except that it attempts to kill all instances of processes whose names match 'name'
</p></blockquote>
<p><font face="Courier New">int multitaskerTerminate(int code)
</font></p>
<blockquote>
  <p>Terminate the calling process, returning the exit code 'code'
</p></blockquote>
<p><font face="Courier New">int multitaskerSignalSet(int processId, int sig, int on)
</font></p>
<blockquote>
  <p>Set the current process' signal handling enabled (on) or disabled for the specified signal number 'sig'
</p></blockquote>
<p><font face="Courier New">int multitaskerSignal(int processId, int sig)
</font></p>
<blockquote>
  <p>Send the requested signal 'sig' to the process 'processId'
</p></blockquote>
<p><font face="Courier New">int multitaskerSignalRead(int processId)
</font></p>
<blockquote>
  <p>Returns the number code of the next pending signal for the current process, or 0 if no signals are pending.
</p></blockquote>
<p><font face="Courier New">int multitaskerGetIOPerm(int processId, int portNum)
</font></p>
<blockquote>
  <p>Returns 1 if the process with process ID 'processId' can do I/O on port 'portNum'
</p></blockquote>
<p><font face="Courier New">int multitaskerSetIOPerm(int processId, int portNum, int yesNo)
</font></p>
<blockquote>
  <p>Set I/O permission port 'portNum' for the process with process ID 'processId'.  If 'yesNo' is non-zero, permission will be granted.
</p></blockquote>
<p><font face="Courier New">int multitaskerStackTrace(int processId)
</font></p>
<blockquote>
  <p>Print a stack trace for the process with process ID 'processId'.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="loader"></a>Loader functions</b></p>
<p>
<p><font face="Courier New">void *loaderLoad(const char *filename, file *theFile)
</font></p>
<blockquote>
  <p>Load a file referenced by the pathname 'filename', and fill the file data structure 'theFile' with the details.  The pointer returned points to the resulting file data.
</p></blockquote>
<p><font face="Courier New">objectKey loaderClassify(const char *fileName, void *fileData, int size, loaderFileClass *fileClass)
</font></p>
<blockquote>
  <p>Given a file by the name 'fileName', the contents 'fileData', of size 'size', get the kernel loader's idea of the file type.  If successful, the return  value is non-NULL and the loaderFileClass structure 'fileClass' is filled out with the known information.
</p></blockquote>
<p><font face="Courier New">objectKey loaderClassifyFile(const char *fileName, loaderFileClass *fileClass)
</font></p>
<blockquote>
  <p>Like loaderClassify(), except the first argument 'fileName' is a file name to classify.  Returns the kernel loader's idea of the file type.  If successful, the return value is non-NULL and the loaderFileClass structure 'fileClass' is filled out with the known information.
</p></blockquote>
<p><font face="Courier New">loaderSymbolTable *loaderGetSymbols(const char *fileName)
</font></p>
<blockquote>
  <p>Given a binary executable, library, or object file 'fileName', return a loaderSymbolTable structure filled out with the loader symbols from the file.
</p></blockquote>
<p><font face="Courier New">int loaderCheckCommand(const char *command)
</font></p>
<blockquote>
  <p>Takes a command line string 'command' and ensures that the program (the first part of the string) exists.
</p></blockquote>
<p><font face="Courier New">int loaderLoadProgram(const char *command, int privilege)
</font></p>
<blockquote>
  <p>Run 'command' as a process with the privilege level 'privilege'.  If successful, the call's return value is the process ID of the new process.  The process is left in a stopped state and must be set to a running state explicitly using the multitasker function multitaskerSetProcessState() or the loader function loaderExecProgram().
</p></blockquote>
<p><font face="Courier New">int loaderLoadLibrary(const char *libraryName)
</font></p>
<blockquote>
  <p>This takes the name of a library file 'libraryName' to load and creates a shared library in the kernel.  This function is not especially useful to user programs, since normal shared library loading happens automatically as part of the 'loaderLoadProgram' process.
</p></blockquote>
<p><font face="Courier New">void *loaderGetLibrary(const char *libraryName)
</font></p>
<blockquote>
  <p>Takes the name of a library file 'libraryName' and if necessary, loads the shared library into the kernel.  Returns an (kernel-only) reference to the library.  This function is not especially useful to user programs, since normal shared library loading happens automatically as part of the 'loaderLoadProgram' process.
</p></blockquote>
<p><font face="Courier New">void *loaderLinkLibrary(const char *libraryName)
</font></p>
<blockquote>
  <p>Takes the name of a library file 'libraryName' and if necessary, loads the shared library into the kernel.  Next, the library is linked into the current process.  Returns an (kernel-only) reference to the library.  This function is not especially useful to user programs, since normal shared library loading happens automatically as part of the 'loaderLoadProgram' process.  Used by the dlopen() and friends library functions.
</p></blockquote>
<p><font face="Courier New">void *loaderGetSymbol(const char *symbolName)
</font></p>
<blockquote>
  <p>Takes a symbol name, and returns the address of the symbol in the current process.  This function is not especially useful to user programs, since normal shared library loading happens automatically as part of the 'loaderLoadProgram' process.  Used by the dlopen() and friends library functions.
</p></blockquote>
<p><font face="Courier New">int loaderExecProgram(int processId, int block)
</font></p>
<blockquote>
  <p>Execute the process referenced by process ID 'processId'.  If 'block' is non-zero, the calling process will block until process 'pid' has terminated, and the return value of the call is the return value of process 'pid'.
</p></blockquote>
<p><font face="Courier New">int loaderLoadAndExec(const char *command, int privilege, int block)
</font></p>
<blockquote>
  <p>This function is just for convenience, and is an amalgamation of the loader functions loaderLoadProgram() and  loaderExecProgram().
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="rtc"></a>Real-time clock functions</b></p>
<p>
<p><font face="Courier New">int rtcReadSeconds(void)
</font></p>
<blockquote>
  <p>Get the current seconds value.
</p></blockquote>
<p><font face="Courier New">int rtcReadMinutes(void)
</font></p>
<blockquote>
  <p>Get the current minutes value.
</p></blockquote>
<p><font face="Courier New">int rtcReadHours(void)
</font></p>
<blockquote>
  <p>Get the current hours value.
</p></blockquote>
<p><font face="Courier New">int rtcDayOfWeek(unsigned day, unsigned month, unsigned year)
</font></p>
<blockquote>
  <p>Get the current day of the week value.
</p></blockquote>
<p><font face="Courier New">int rtcReadDayOfMonth(void)
</font></p>
<blockquote>
  <p>Get the current day of the month value.
</p></blockquote>
<p><font face="Courier New">int rtcReadMonth(void)
</font></p>
<blockquote>
  <p>Get the current month value.
</p></blockquote>
<p><font face="Courier New">int rtcReadYear(void)
</font></p>
<blockquote>
  <p>Get the current year value.
</p></blockquote>
<p><font face="Courier New">unsigned rtcUptimeSeconds(void)
</font></p>
<blockquote>
  <p>Get the number of seconds the system has been running.
</p></blockquote>
<p><font face="Courier New">int rtcDateTime(struct tm *theTime)
</font></p>
<blockquote>
  <p>Get the current data and time as a tm data structure in 'theTime'.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="random"></a>Random number functions</b></p>
<p>
<p><font face="Courier New">unsigned randomUnformatted(void)
</font></p>
<blockquote>
  <p>Get an unformatted random unsigned number.  Just any unsigned number.
</p></blockquote>
<p><font face="Courier New">unsigned randomFormatted(unsigned start, unsigned end)
</font></p>
<blockquote>
  <p>Get a random unsigned number between the start value 'start' and the end value 'end', inclusive.
</p></blockquote>
<p><font face="Courier New">unsigned randomSeededUnformatted(unsigned seed)
</font></p>
<blockquote>
  <p>Get an unformatted random unsigned number, using the random seed 'seed' instead of the kernel's default random seed.
</p></blockquote>
<p><font face="Courier New">unsigned randomSeededFormatted(unsigned seed, unsigned start, unsigned end)
</font></p>
<blockquote>
  <p>Get a random unsigned number between the start value 'start' and the end value 'end', inclusive, using the random seed 'seed' instead of the kernel's default random seed.
</p></blockquote>
<p><font face="Courier New">void randomBytes(unsigned char *buffer, unsigned size)
</font></p>
<blockquote>
  <p>Given the supplied buffer and size, fill the buffer with random bytes.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="environment"></a>Environment functions</b></p>
<p>
<p><font face="Courier New">int environmentGet(const char *var, char *buf, unsigned bufsz)
</font></p>
<blockquote>
  <p>Get the value of the environment variable named 'var', and put it into the buffer 'buf' of size 'bufsz' if successful.
</p></blockquote>
<p><font face="Courier New">int environmentSet(const char *var, const char *val)
</font></p>
<blockquote>
  <p>Set the environment variable 'var' to the value 'val', overwriting any old value that might have been previously set.
</p></blockquote>
<p><font face="Courier New">int environmentUnset(const char *var)
</font></p>
<blockquote>
  <p>Delete the environment variable 'var'.
</p></blockquote>
<p><font face="Courier New">void environmentDump(void)
</font></p>
<blockquote>
  <p>Print a listing of all the currently set environment variables in the calling process' environment space to the current text output stream.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="graphics"></a>Raw graphics functions</b></p>
<p>
<p><font face="Courier New">int graphicsAreEnabled(void)
</font></p>
<blockquote>
  <p>Returns 1 if the kernel is operating in graphics mode.
</p></blockquote>
<p><font face="Courier New">int graphicGetModes(videoMode *buffer, unsigned size)
</font></p>
<blockquote>
  <p>Get up to 'size' bytes worth of videoMode structures in 'buffer' for the supported video modes of the current hardware.
</p></blockquote>
<p><font face="Courier New">int graphicGetMode(videoMode *mode)
</font></p>
<blockquote>
  <p>Get the current video mode in 'mode'
</p></blockquote>
<p><font face="Courier New">int graphicSetMode(videoMode *mode)
</font></p>
<blockquote>
  <p>Set the video mode in 'mode'.  Generally this will require a reboot in order to take effect.
</p></blockquote>
<p><font face="Courier New">int graphicGetScreenWidth(void)
</font></p>
<blockquote>
  <p>Returns the width of the graphics screen.
</p></blockquote>
<p><font face="Courier New">int graphicGetScreenHeight(void)
</font></p>
<blockquote>
  <p>Returns the height of the graphics screen.
</p></blockquote>
<p><font face="Courier New">int graphicCalculateAreaBytes(int width, int height)
</font></p>
<blockquote>
  <p>Returns the number of bytes required to allocate a graphic buffer of width 'width' and height 'height'.  This is a function of the screen resolution, etc.
</p></blockquote>
<p><font face="Courier New">int graphicClearScreen(color *background)
</font></p>
<blockquote>
  <p>Clear the screen to the background color 'background'.
</p></blockquote>
<p><font face="Courier New">int graphicDrawPixel(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord)
</font></p>
<blockquote>
  <p>Draw a single pixel into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the X coordinate 'xCoord' and the Y coordinate 'yCoord'.  If 'buffer' is NULL, draw directly onto the screen.
</p></blockquote>
<p><font face="Courier New">int graphicDrawLine(objectKey buffer, color *foreground, drawMode mode, int startX, int startY, int endX, int endY)
</font></p>
<blockquote>
  <p>Draw a line into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'startX', the starting Y coordinate 'startY', the ending X coordinate 'endX' and the ending Y coordinate 'endY'.  At the time of writing, only horizontal and vertical lines are supported by the linear framebuffer graphic driver.  If 'buffer' is NULL, draw directly onto the screen.
</p></blockquote>
<p><font face="Courier New">int graphicDrawRect(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord, int width, int height, int thickness, int fill)
</font></p>
<blockquote>
  <p>Draw a rectangle into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width', the height 'height', the line thickness 'thickness' and the fill value 'fill'.  Non-zero fill value means fill the rectangle.   If 'buffer' is NULL, draw directly onto the screen.
</p></blockquote>
<p><font face="Courier New">int graphicDrawOval(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord, int width, int height, int thickness, int fill)
</font></p>
<blockquote>
  <p>Draw an oval (circle, whatever) into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width', the height 'height', the line thickness 'thickness' and the fill value 'fill'.  Non-zero fill value means fill the oval.   If 'buffer' is NULL, draw directly onto the screen.  Currently not supported by the linear framebuffer graphic driver.
</p></blockquote>
<p><font face="Courier New">int graphicGetImage(objectKey buffer, image *getImage, int xCoord, int yCoord, int width, int height)
</font></p>
<blockquote>
  <p>Grab a new image 'getImage' from the graphic buffer 'buffer', using the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width' and the height 'height'.   If 'buffer' is NULL, grab the image directly from the screen.
</p></blockquote>
<p><font face="Courier New">int graphicDrawImage(objectKey buffer, image *drawImage, drawMode mode, int xCoord, int yCoord, int xOffset, int yOffset, int width, int height)
</font></p>
<blockquote>
  <p>Draw the image 'drawImage' into the graphic buffer 'buffer', using the drawing mode 'mode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord' and the starting Y coordinate 'yCoord'.   The 'xOffset' and 'yOffset' parameters specify an offset into the image to start the drawing (0, 0 to draw the whole image).  Similarly the 'width' and 'height' parameters allow you to specify a portion of the image (0, 0 to draw the whole image -- minus any X or Y offsets from the previous parameters).  So, for example, to draw only the middle pixel of a 3x3 image, you would specify xOffset=1, yOffset=1, width=1, height=1.  If 'buffer' is NULL, draw directly onto the screen.
</p></blockquote>
<p><font face="Courier New">int graphicDrawText(objectKey buffer, color *foreground, color *background, objectKey font, const char *text, drawMode mode, int xCoord, int yCoord)
</font></p>
<blockquote>
  <p>Draw the text string 'text' into the graphic buffer 'buffer', using the colors 'foreground' and 'background', the font 'font', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord'.   If 'buffer' is NULL, draw directly onto the screen.  If 'font' is NULL, use the default font.
</p></blockquote>
<p><font face="Courier New">int graphicCopyArea(objectKey buffer, int xCoord1, int yCoord1, int width, int height, int xCoord2, int yCoord2)
</font></p>
<blockquote>
  <p>Within the graphic buffer 'buffer', copy the area bounded by ('xCoord1', 'yCoord1'), width 'width' and height 'height' to the starting X coordinate 'xCoord2' and the starting Y coordinate 'yCoord2'.  If 'buffer' is NULL, copy directly to and from the screen.
</p></blockquote>
<p><font face="Courier New">int graphicClearArea(objectKey buffer, color *background, int xCoord, int yCoord, int width, int height)
</font></p>
<blockquote>
  <p>Clear the area of the graphic buffer 'buffer' using the background color 'background', using the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width' and the height 'height'.  If 'buffer' is NULL, clear the area directly on the screen.
</p></blockquote>
<p><font face="Courier New">int graphicRenderBuffer(objectKey buffer, int drawX, int drawY, int clipX, int clipY, int clipWidth, int clipHeight)
</font></p>
<blockquote>
  <p>Draw the clip of the buffer 'buffer' onto the screen.  Draw it on the screen at starting X coordinate 'drawX' and starting Y coordinate 'drawY'.  The buffer clip is bounded by the starting X coordinate 'clipX', the starting Y coordinate 'clipY', the width 'clipWidth' and the height 'clipHeight'.  It is not legal for 'buffer' to be NULL in this case.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="window"></a>Window system functions</b></p>
<p>
<p><font face="Courier New">int windowLogin(const char *userName)
</font></p>
<blockquote>
  <p>Log the user into the window environment with 'userName'.  The return value is the PID of the window shell for this session.  The calling program must have supervisor privilege in order to use this function.
</p></blockquote>
<p><font face="Courier New">int windowLogout(void)
</font></p>
<blockquote>
  <p>Log the current user out of the windowing system.  This kills the window shell process returned by windowLogin() call.
</p></blockquote>
<p><font face="Courier New">objectKey windowNew(int processId, const char *title)
</font></p>
<blockquote>
  <p>Create a new window, owned by the process 'processId', and with the title 'title'.  Returns an object key to reference the window, needed by most other window functions below (such as adding components to the window)
</p></blockquote>
<p><font face="Courier New">objectKey windowNewDialog(objectKey parent, const char *title)
</font></p>
<blockquote>
  <p>Create a dialog window to associate with the parent window 'parent', using the supplied title.  In the current implementation, dialog windows are modal, which is the main characteristic distinguishing them from regular windows.
</p></blockquote>
<p><font face="Courier New">int windowDestroy(objectKey window)
</font></p>
<blockquote>
  <p>Destroy the window referenced by the object key 'window'
</p></blockquote>
<p><font face="Courier New">int windowUpdateBuffer(void *buffer, int xCoord, int yCoord, int width, int height)
</font></p>
<blockquote>
  <p>Tells the windowing system to redraw the visible portions of the graphic buffer 'buffer', using the given clip coordinates/size.
</p></blockquote>
<p><font face="Courier New">int windowSetTitle(objectKey window, const char *title)
</font></p>
<blockquote>
  <p>Set the new title of window 'window' to be 'title'.
</p></blockquote>
<p><font face="Courier New">int windowGetSize(objectKey window, int *width, int *height)
</font></p>
<blockquote>
  <p>Get the size of the window 'window', and put the results in 'width' and 'height'.
</p></blockquote>
<p><font face="Courier New">int windowSetSize(objectKey window, int width, int height)
</font></p>
<blockquote>
  <p>Resize the window 'window' to the width 'width' and the height 'height'.
</p></blockquote>
<p><font face="Courier New">int windowGetLocation(objectKey window, int *xCoord, int *yCoord)
</font></p>
<blockquote>
  <p>Get the current screen location of the window 'window' and put it into the coordinate variables 'xCoord' and 'yCoord'.
</p></blockquote>
<p><font face="Courier New">int windowSetLocation(objectKey window, int xCoord, int yCoord)
</font></p>
<blockquote>
  <p>Set the screen location of the window 'window' using the coordinate variables 'xCoord' and 'yCoord'.
</p></blockquote>
<p><font face="Courier New">int windowCenter(objectKey window)
</font></p>
<blockquote>
  <p>Center 'window' on the screen.
</p></blockquote>
<p><font face="Courier New">int windowSnapIcons(objectKey parent)
</font></p>
<blockquote>
  <p>If 'parent' (either a window or a windowContainer) has icon components inside it, this will snap them to a grid.
</p></blockquote>
<p><font face="Courier New">int windowSetHasBorder(objectKey window, int trueFalse)
</font></p>
<blockquote>
  <p>Tells the windowing system whether to draw a border around the window 'window'.  'trueFalse' being non-zero means draw a border.  Windows have borders by default.
</p></blockquote>
<p><font face="Courier New">int windowSetHasTitleBar(objectKey window, int trueFalse)
</font></p>
<blockquote>
  <p>Tells the windowing system whether to draw a title bar on the window 'window'.  'trueFalse' being non-zero means draw a title bar.  Windows have title bars by default.
</p></blockquote>
<p><font face="Courier New">int windowSetMovable(objectKey window, int trueFalse)
</font></p>
<blockquote>
  <p>Tells the windowing system whether the window 'window' should be movable by the user (i.e. clicking and dragging it).  'trueFalse' being non-zero means the window is movable.  Windows are movable by default.
</p></blockquote>
<p><font face="Courier New">int windowSetResizable(objectKey window, int trueFalse)
</font></p>
<blockquote>
  <p>Tells the windowing system whether to allow 'window' to be resized by the user.  'trueFalse' being non-zero means the window is resizable.  Windows are resizable by default.
</p></blockquote>
<p><font face="Courier New">int windowRemoveMinimizeButton(objectKey window)
</font></p>
<blockquote>
  <p>Tells the windowing system not to draw a minimize button on the title bar of the window 'window'.  Windows have minimize buttons by default, as long as they have a title bar.  If there is no title bar, then this function has no effect.
</p></blockquote>
<p><font face="Courier New">int windowRemoveCloseButton(objectKey window)
</font></p>
<blockquote>
  <p>Tells the windowing system not to draw a close button on the title bar of the window 'window'.  Windows have close buttons by default, as long as they have a title bar.  If there is no title bar, then this function has no effect.
</p></blockquote>
<p><font face="Courier New">int windowSetVisible(objectKey window, int visible)
</font></p>
<blockquote>
  <p>Tell the windowing system whether to make 'window' visible or not.  Non-zero 'visible' means make the window visible.  When windows are created, they are not visible by default so you can add components, do layout, set the size, etc.
</p></blockquote>
<p><font face="Courier New">void windowSetMinimized(objectKey window, int minimized)
</font></p>
<blockquote>
  <p>Tell the windowing system whether to make 'window' minimized or not.  Non-zero 'minimized' means make the window non-visible, but accessible via the task bar.  Zero 'minimized' means restore a minimized window to its normal, visible size.
</p></blockquote>
<p><font face="Courier New">int windowAddConsoleTextArea(objectKey window)
</font></p>
<blockquote>
  <p>Add a console text area component to 'window'.  The console text area is where most kernel logging and error messages are sent, particularly at boot time.  Note that there is only one instance of the console text area, and thus it can only exist in one window at a time.  Destroying the window is one way to free the console area to be used in another window.
</p></blockquote>
<p><font face="Courier New">void windowRedrawArea(int xCoord, int yCoord, int width, int height)
</font></p>
<blockquote>
  <p>Tells the windowing system to redraw whatever is supposed to be in the screen area bounded by the supplied coordinates.  This might be useful if you were drawing non-window-based things (i.e., things without their own independent graphics buffer) directly onto the screen and you wanted to restore an area to its original contents.  For example, the mouse driver uses this method to erase the pointer from its previous position.
</p></blockquote>
<p><font face="Courier New">void windowDrawAll(void)
</font></p>
<blockquote>
  <p>Tells the windowing system to (re)draw all the windows.
</p></blockquote>
<p><font face="Courier New">int windowGetColor(const char *colorName, color *getColor)
</font></p>
<blockquote>
  <p>Get the window system color 'colorName' and place its values in the color structure 'getColor'.  Examples of system color names include 'foreground', 'background', and 'desktop'.
</p></blockquote>
<p><font face="Courier New">int windowSetColor(const char *colorName, color *setColor)
</font></p>
<blockquote>
  <p>Set the window system color 'colorName' to the values in the color structure 'getColor'.  Examples of system color names include 'foreground', 'background', and 'desktop'.
</p></blockquote>
<p><font face="Courier New">void windowResetColors(void)
</font></p>
<blockquote>
  <p>Tells the windowing system to reset the colors of all the windows and their components, and then re-draw all the windows.  Useful for example when the user has changed the color scheme.
</p></blockquote>
<p><font face="Courier New">void windowProcessEvent(objectKey event)
</font></p>
<blockquote>
  <p>Creates a window event using the supplied event structure.  This function is most often used within the kernel, particularly in the mouse and keyboard functions, to signify clicks or key presses.  It can, however, be used by external programs to create 'artificial' events.  The windowEvent structure specifies the target component and event type.
</p></blockquote>
<p><font face="Courier New">int windowComponentEventGet(objectKey key, windowEvent *event)
</font></p>
<blockquote>
  <p>Gets a pending window event, if any, applicable to component 'key', and puts the data into the windowEvent structure 'event'.  If an event was received, the function returns a positive, non-zero value (the actual value reflects the amount of raw data read from the component's event stream -- not particularly useful to an application).  If the return value is zero, no event was pending.
</p></blockquote>
<p><font face="Courier New">int windowSetBackgroundColor(objectKey window, color *background)
</font></p>
<blockquote>
  <p>Set the background color of 'window'.  If 'color' is NULL, use the default.
</p></blockquote>
<p><font face="Courier New">int windowTileBackground(const char *theFile)
</font></p>
<blockquote>
  <p>Load the image file specified by the pathname 'theFile', and if successful, tile the image on the background root window.
</p></blockquote>
<p><font face="Courier New">int windowCenterBackground(const char *theFile)
</font></p>
<blockquote>
  <p>Load the image file specified by the pathname 'theFile', and if successful, center the image on the background root window.
</p></blockquote>
<p><font face="Courier New">int windowScreenShot(image *saveImage)
</font></p>
<blockquote>
  <p>Get an image representation of the entire screen in the image data structure 'saveImage'.  Note that it is not necessary to allocate memory for the data pointer of the image structure beforehand, as this is done automatically.  You should, however, deallocate the data field of the image structure when you are finished with it.
</p></blockquote>
<p><font face="Courier New">int windowSaveScreenShot(const char *filename)
</font></p>
<blockquote>
  <p>Save a screenshot of the entire screen to the file specified by the pathname 'filename'.
</p></blockquote>
<p><font face="Courier New">int windowSetTextOutput(objectKey key)
</font></p>
<blockquote>
  <p>Set the text output (and input) of the calling process to the object key of some window component, such as a TextArea or TextField component.  You'll need to use this if you want to output text to one of these components or receive input from one.
</p></blockquote>
<p><font face="Courier New">int windowLayout(objectKey window)
</font></p>
<blockquote>
  <p>Layout, or re-layout, the requested window 'window'.  This function can be used when components are added to or removed from and already laid-out window.
</p></blockquote>
<p><font face="Courier New">void windowDebugLayout(objectKey window)
</font></p>
<blockquote>
  <p>This function draws grid boxes around all the grid cells containing components (or parts thereof).
</p></blockquote>
<p><font face="Courier New">int windowContextAdd(objectKey parent, windowMenuContents *contents)
</font></p>
<blockquote>
  <p>This function allows the caller to add context menu items in the 'content' structure to the supplied parent object 'parent' (can be a window or a component).  The function supplies the pointers to the new menu items in the caller's structure, which can then be manipulated to some extent (enable/disable, destroy, etc) using regular component functions.
</p></blockquote>
<p><font face="Courier New">int windowContextSet(objectKey parent, objectKey menu)
</font></p>
<blockquote>
  <p>This function allows the caller to set the context menu of the the supplied parent object 'parent' (can be a window or a component).
</p></blockquote>
<p><font face="Courier New">int windowSwitchPointer(objectKey parent, const char *pointerName)
</font></p>
<blockquote>
  <p>Switch the mouse pointer for the parent window or component object 'parent' to the pointer represented by the name 'pointerName'.  Examples of pointer names are "default" and "busy".
</p></blockquote>
<p><font face="Courier New">void windowComponentDestroy(objectKey component)
</font></p>
<blockquote>
  <p>Deallocate and destroy a window component.
</p></blockquote>
<p><font face="Courier New">int windowComponentSetVisible(objectKey component, int visible)
</font></p>
<blockquote>
  <p>Set 'component' visible or non-visible.
</p></blockquote>
<p><font face="Courier New">int windowComponentSetEnabled(objectKey component, int enabled)
</font></p>
<blockquote>
  <p>Set 'component' enabled or non-enabled; non-enabled components appear greyed-out.
</p></blockquote>
<p><font face="Courier New">int windowComponentGetWidth(objectKey component)
</font></p>
<blockquote>
  <p>Get the pixel width of the window component 'component'.
</p></blockquote>
<p><font face="Courier New">int windowComponentSetWidth(objectKey component, int width)
</font></p>
<blockquote>
  <p>Set the pixel width of the window component 'component'
</p></blockquote>
<p><font face="Courier New">int windowComponentGetHeight(objectKey component)
</font></p>
<blockquote>
  <p>Get the pixel height of the window component 'component'.
</p></blockquote>
<p><font face="Courier New">int windowComponentSetHeight(objectKey component, int height)
</font></p>
<blockquote>
  <p>Set the pixel height of the window component 'component'.
</p></blockquote>
<p><font face="Courier New">int windowComponentFocus(objectKey component)
</font></p>
<blockquote>
  <p>Give window component 'component' the focus of its window.
</p></blockquote>
<p><font face="Courier New">int windowComponentUnfocus(objectKey component)
</font></p>
<blockquote>
  <p>Removes the focus from window component 'component' in its window.
</p></blockquote>
<p><font face="Courier New">int windowComponentDraw(objectKey component)
</font></p>
<blockquote>
  <p>Calls the window component 'component' to redraw itself.
</p></blockquote>
<p><font face="Courier New">int windowComponentGetData(objectKey component, void *buffer, int size)
</font></p>
<blockquote>
  <p>This is a generic call to get data from the window component 'component', up to 'size' bytes, in the buffer 'buffer'.  The size and type of data that a given component will return is totally dependent upon the type and implementation of the component.
</p></blockquote>
<p><font face="Courier New">int windowComponentSetData(objectKey component, void *buffer, int size)
</font></p>
<blockquote>
  <p>This is a generic call to set data in the window component 'component', up to 'size' bytes, in the buffer 'buffer'.  The size and type of data that a given component will use or accept is totally dependent upon the type and implementation of the component.
</p></blockquote>
<p><font face="Courier New">int windowComponentGetSelected(objectKey component, int *selection)
</font></p>
<blockquote>
  <p>This is a call to get the 'selected' value of the window component 'component'.  The type of value returned depends upon the type of component; a list component, for example, will return the 0-based number(s) of its selected item(s).  On the other hand, a boolean component such as a checkbox will return 1 if it is currently selected.
</p></blockquote>
<p><font face="Courier New">int windowComponentSetSelected(objectKey component, int selected)
</font></p>
<blockquote>
  <p>This is a call to set the 'selected' value of the window component 'component'.  The type of value accepted depends upon the type of component; a list component, for example, will use the 0-based number to select one of its items.  On the other hand, a boolean component such as a checkbox will clear itself if 'selected' is 0, and set itself otherwise.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewButton(objectKey parent, const char *label, image *buttonImage, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new button component to be placed inside the parent object 'parent', with the given component parameters, and with the (optional) label 'label', or the (optional) image 'buttonImage'.  Either 'label' or 'buttonImage' can be used, but not both.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewCanvas(objectKey parent, int width, int height, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new canvas component, to be placed inside the parent object 'parent', using the supplied width and height, with the given component parameters.  Canvas components are areas which will allow drawing operations, for example to show line drawings or unique graphical elements.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewCheckbox(objectKey parent, const char *text, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new checkbox component, to be placed inside the parent object 'parent', using the accompanying text 'text', and with the given component parameters.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewContainer(objectKey parent, const char *name, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new container component, to be placed inside the parent object 'parent', using the name 'name', and with the given component parameters.  Containers are useful for layout when a simple grid is not sufficient.  Each container has its own internal grid layout (for components it contains) and external grid parameters for placing it inside a window or another container.  Containers can be nested arbitrarily.  This allows limitless control over a complex window layout.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewDivider(objectKey parent, dividerType type, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new divider component, to be placed inside the parent object 'parent', using the type 'type' (divider_vertical or divider_horizontal), and with the given component parameters.  These are just horizontal or vertical lines that can be used to visually separate sections of a window.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewIcon(objectKey parent, image *iconImage, const char *label, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new icon component to be placed inside the parent object 'parent', using the image data structure 'iconImage' and the label 'label', and with the given component parameters 'params'.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewImage(objectKey parent, image *baseImage, drawMode mode, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new image component to be placed inside the parent object 'parent', using the image data structure 'baseImage', and with the given component parameters 'params'.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewList(objectKey parent, windowListType type, int rows, int columns, int multiple, listItemParameters *items, int numItems, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new window list component to be placed inside the parent object 'parent', using the component parameters 'params'.  'type' specifies the type of list (see <sys/window.h> for possibilities), 'rows' and 'columns' specify the size of the list and layout of the list items, 'multiple' allows multiple selections if non-zero, and 'items' is an array of 'numItems' list item parameters.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewListItem(objectKey parent, windowListType type, listItemParameters *item, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new list item component to be placed inside the parent object 'parent', using the list item parameters 'item', and the component parameters 'params'.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewMenu(objectKey parent, const char *name, windowMenuContents *contents, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new menu component to be placed inside the parent object 'parent', using the name 'name' (which will be the header of the menu in a menu bar, for example), the menu contents structure 'contents', and the component parameters 'params'.  A menu component is an instance of a container, typically contains menu item components, and is typically added to a menu bar component.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewMenuBar(objectKey window, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new menu bar component to be placed inside the window 'window', using the component parameters 'params'.  A menu bar component is an instance of a container, and typically contains menu components.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewMenuItem(objectKey parent, const char *text, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new menu item component to be placed inside the parent object 'parent', using the string 'text' and the component parameters 'params'.  A menu item  component is typically added to menu components, which are in turn added to menu bar components.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewPasswordField(objectKey parent, int columns, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new password field component to be placed inside the parent object 'parent', using 'columns' columns and the component parameters 'params'.  A password field component is a special case of a text field component, and behaves the same way except that typed characters are shown as asterisks (*).
</p></blockquote>
<p><font face="Courier New">objectKey windowNewProgressBar(objectKey parent, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new progress bar component to be placed inside the parent object 'parent', using the component parameters 'params'.  Use the windowComponentSetData() function to set the percentage of progress.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewRadioButton(objectKey parent, int rows, int columns, char *items[], int numItems, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new radio button component to be placed inside the parent object 'parent', using the component parameters 'params'.  'rows' and 'columns' specify the size and layout of the items, and 'numItems' specifies the number of strings in the array 'items', which specifies the different radio button choices.  The windowComponentSetSelected() and windowComponentGetSelected() functions can be used to get and set the selected item (numbered from zero, in the order they were supplied in 'items').
</p></blockquote>
<p><font face="Courier New">objectKey windowNewScrollBar(objectKey parent, scrollBarType type, int width, int height, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new scroll bar component to be placed inside the parent object 'parent', with the scroll bar type 'type', and the given component parameters 'params'.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewSlider(objectKey parent, scrollBarType type, int width, int height, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new slider component to be placed inside the parent object 'parent', with the scroll bar type 'type', and the given component parameters 'params'.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewTextArea(objectKey parent, int columns, int rows, int bufferLines, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new text area component to be placed inside the parent object 'parent', with the given component parameters 'params'.  The 'columns' and 'rows' are the visible portion, and 'bufferLines' is the number of extra lines of scrollback memory.  If 'font' is NULL, the default font will be used.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewTextField(objectKey parent, int columns, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new text field component to be placed inside the parent object 'parent', using the number of columns 'columns' and with the given component parameters 'params'.  Text field components are essentially 1-line 'text area' components.  If the params 'font' is NULL, the default font will be used.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewTextLabel(objectKey parent, const char *text, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new text labelComponent to be placed inside the parent object 'parent', with the given component parameters 'params', and using the text string 'text'.  If the params 'font' is NULL, the default font will be used.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="user"></a>User functions</b></p>
<p>
<p><font face="Courier New">int userAuthenticate(const char *name, const char *password)
</font></p>
<blockquote>
  <p>Given the user 'name', return 0 if 'password' is the correct password.
</p></blockquote>
<p><font face="Courier New">int userLogin(const char *name, const char *password)
</font></p>
<blockquote>
  <p>Log the user 'name' into the system, using the password 'password'.  Calling this function requires supervisor privilege level.
</p></blockquote>
<p><font face="Courier New">int userLogout(const char *name)
</font></p>
<blockquote>
  <p>Log the user 'name' out of the system.  This can only be called by a process with supervisor privilege, or one running as the same user being logged out.
</p></blockquote>
<p><font face="Courier New">int userGetNames(char *buffer, unsigned bufferSize)
</font></p>
<blockquote>
  <p>Fill the buffer 'buffer' with the names of all users, up to 'bufferSize' bytes.
</p></blockquote>
<p><font face="Courier New">int userAdd(const char *name, const char *password)
</font></p>
<blockquote>
  <p>Add the user 'name' with the password 'password'
</p></blockquote>
<p><font face="Courier New">int userDelete(const char *name)
</font></p>
<blockquote>
  <p>Delete the user 'name'
</p></blockquote>
<p><font face="Courier New">int userSetPassword(const char *name, const char *oldPass, const char *newPass)
</font></p>
<blockquote>
  <p>Set the password of user 'name'.  If the calling program is not supervisor privilege, the correct old password must be supplied in 'oldPass'.  The new password is supplied in 'newPass'.
</p></blockquote>
<p><font face="Courier New">int userGetPrivilege(const char *name)
</font></p>
<blockquote>
  <p>Get the privilege level of the user represented by 'name'.
</p></blockquote>
<p><font face="Courier New">int userGetPid(void)
</font></p>
<blockquote>
  <p>Get the process ID of the current user's 'login process'.
</p></blockquote>
<p><font face="Courier New">int userSetPid(const char *name, int pid)
</font></p>
<blockquote>
  <p>Set the login PID of user 'name' to 'pid'.  This is the process that gets killed when the user indicates that they want to logout.  In graphical mode this will typically be the PID of the window shell pid, and in text mode it will be the PID of the login VSH shell.
</p></blockquote>
<p><font face="Courier New">int userFileAdd(const char *passFile, const char *userName, const char *password)
</font></p>
<blockquote>
  <p>Add a user to the designated password file, with the given name and password.  This can only be done by a privileged user.
</p></blockquote>
<p><font face="Courier New">int userFileDelete(const char *passFile, const char *userName)
</font></p>
<blockquote>
  <p>Remove a user from the designated password file.  This can only be done by a privileged user
</p></blockquote>
<p><font face="Courier New">int userFileSetPassword(const char *passFile, const char *userName, const char *oldPass, const char *newPass)
</font></p>
<blockquote>
  <p>Set the password of user 'userName' in the designated password file.  If the calling program is not supervisor privilege, the correct old password must be supplied in 'oldPass'.  The new password is supplied in 'newPass'.
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="network"></a>Network functions</b></p>
<p>
<p><font face="Courier New">int networkDeviceGetCount(void)
</font></p>
<blockquote>
  <p>Returns the count of network devices
</p></blockquote>
<p><font face="Courier New">int networkDeviceGet(const char *name, networkDevice *dev)
</font></p>
<blockquote>
  <p>Returns the user-space portion of the requested (by 'name') network device in 'dev'.
</p></blockquote>
<p><font face="Courier New">int networkInitialized(void)
</font></p>
<blockquote>
  <p>Returns 1 if networking is currently enabled.
</p></blockquote>
<p><font face="Courier New">int networkInitialize(void)
</font></p>
<blockquote>
  <p>Initialize and start networking.
</p></blockquote>
<p><font face="Courier New">int networkShutdown(void)
</font></p>
<blockquote>
  <p>Shut down networking.
</p></blockquote>
<p><font face="Courier New">objectKey networkOpen(int mode, networkAddress *address, networkFilter *filter)
</font></p>
<blockquote>
  <p>Opens a connection for network communication.  The 'type' and 'mode' arguments describe the kind of connection to make (see possiblilities in the file <sys/network.h>.  If applicable, 'address' specifies the network address of the remote host to connect to.  If applicable, the 'localPort' and 'remotePort' arguments specify the TCP/UDP ports to use.
</p></blockquote>
<p><font face="Courier New">int networkClose(objectKey connection)
</font></p>
<blockquote>
  <p>Close the specified, previously-opened network connection.
</p></blockquote>
<p><font face="Courier New">int networkCount(objectKey connection)
</font></p>
<blockquote>
  <p>Given a network connection, return the number of bytes currently pending in the input stream
</p></blockquote>
<p><font face="Courier New">int networkRead(objectKey connection, unsigned char *buffer, unsigned bufferSize)
</font></p>
<blockquote>
  <p>Given a network connection, a buffer, and a buffer size, read up to 'bufferSize' bytes (or the number of bytes available in the connection's input stream) and return the number read.  The connection must be initiated using the networkConnectionOpen() function.
</p></blockquote>
<p><font face="Courier New">int networkWrite(objectKey connection, unsigned char *buffer, unsigned bufferSize)
</font></p>
<blockquote>
  <p>Given a network connection, a buffer, and a buffer size, write up to 'bufferSize' bytes from 'buffer' to the connection's output.  The connection must be initiated using the networkConnectionOpen() function.
</p></blockquote>
<p><font face="Courier New">int networkPing(objectKey connection, int seqNum, unsigned char *buffer, unsigned bufferSize)
</font></p>
<blockquote>
  <p>Send an ICMP "echo request" packet to the host at the network address 'destAddress', with the (optional) sequence number 'seqNum'.  The 'buffer' and 'bufferSize' arguments point to the location of data to send in the ping packet.  The content of the data is mostly irrelevant, except that it can be checked to ensure the same data is returned by the ping reply from the remote host.
</p></blockquote>
<p><font face="Courier New">int networkGetHostName(char *buffer, int bufferSize)
</font></p>
<blockquote>
  <p>Returns up to 'bufferSize' bytes of the system's network hostname in 'buffer' 
</p></blockquote>
<p><font face="Courier New">int networkSetHostName(const char *buffer, int bufferSize)
</font></p>
<blockquote>
  <p>Sets the system's network hostname using up to 'bufferSize' bytes from 'buffer'
</p></blockquote>
<p><font face="Courier New">int networkGetDomainName(char *buffer, int bufferSize)
</font></p>
<blockquote>
  <p>Returns up to 'bufferSize' bytes of the system's network domain name in 'buffer' 
</p></blockquote>
<p><font face="Courier New">int networkSetDomainName(const char *buffer, int bufferSize)
</font></p>
<blockquote>
  <p>Sets the system's network domain name using up to 'bufferSize' bytes from 'buffer'
</p></blockquote>
</p>
<p>&nbsp;</p>

<p><b><a name="miscellaneous"></a>Miscellaneous functions</b></p>
<p>
<p><font face="Courier New">int fontGetDefault(objectKey *pointer)
</font></p>
<blockquote>
  <p>Get an object key in 'pointer' to refer to the current default font.
</p></blockquote>
<p><font face="Courier New">int fontSetDefault(const char *name)
</font></p>
<blockquote>
  <p>Set the default font for the system to the font with the name 'name'.  The font must previously have been loaded by the system, for example using the fontLoad()  function.
</p></blockquote>
<p><font face="Courier New">int fontLoad(const char *filename, const char *fontname, objectKey *pointer, int fixedWidth)
</font></p>
<blockquote>
  <p>Load the font from the font file 'filename', give it the font name 'fontname' for future reference, and return an object key for the font in 'pointer' if successful.  The integer 'fixedWidth' argument should be non-zero if you want each character of the font to have uniform width (i.e. an 'i' character will be padded with empty space so that it takes up the same width as, for example, a 'W' character).
</p></blockquote>
<p><font face="Courier New">int fontGetPrintedWidth(objectKey font, const char *string)
</font></p>
<blockquote>
  <p>Given the supplied string, return the screen width that the text will consume given the font 'font'.  Useful for placing text when using a variable-width font, but not very useful otherwise.
</p></blockquote>
<p><font face="Courier New">int fontGetWidth(objectKey font)
</font></p>
<blockquote>
  <p>Returns the character width of the supplied font.  Only useful when the font is fixed-width.
</p></blockquote>
<p><font face="Courier New">int fontGetHeight(objectKey font)
</font></p>
<blockquote>
  <p>Returns the character height of the supplied font.
</p></blockquote>
<p><font face="Courier New">int imageNew(image *blankImage, unsigned width, unsigned height)
</font></p>
<blockquote>
  <p>Using the (possibly uninitialized) image data structure 'blankImage', allocate memory for a new image with the specified 'width' and 'height'.
</p></blockquote>
<p><font face="Courier New">int imageFree(image *freeImage)
</font></p>
<blockquote>
  <p>Frees memory allocated for image data (but does not deallocate the image structure itself).
</p></blockquote>
<p><font face="Courier New">int imageLoad(const char *filename, unsigned width, unsigned height, image *loadImage)
</font></p>
<blockquote>
  <p>Try to load the image file 'filename' (with the specified 'width' and 'height' if possible -- zeros indicate no preference), and if successful, save the data in the image data structure 'loadImage'.
</p></blockquote>
<p><font face="Courier New">int imageSave(const char *filename, int format, image *saveImage)
</font></p>
<blockquote>
  <p>Save the image data structure 'saveImage' using the image format 'format' to the file 'fileName'.  Image format codes are found in the file <sys/image.h>
</p></blockquote>
<p><font face="Courier New">int imageResize(image *resizeImage, unsigned width, unsigned height)
</font></p>
<blockquote>
  <p>Resize the image represented in the image data structure 'resizeImage' to the new 'width' and 'height' values.
</p></blockquote>
<p><font face="Courier New">int imageCopy(image *srcImage, image *destImage)
</font></p>
<blockquote>
  <p>Make a copy of the image 'srcImage' to 'destImage', including all of its data, alpha channel information (if applicable), etc.
</p></blockquote>
<p><font face="Courier New">int shutdown(int reboot, int nice)
</font></p>
<blockquote>
  <p>Shut down the system.  If 'reboot' is non-zero, the system will reboot.  If 'nice' is zero, the shutdown will be orderly and will abort if serious errors are detected.  If 'nice' is non-zero, the system will go down like a kamikaze regardless of errors.
</p></blockquote>
<p><font face="Courier New">void getVersion(char *buff, int buffSize)
</font></p>
<blockquote>
  <p>Get the kernel's version string int the buffer 'buff', up to 'buffSize' bytes
</p></blockquote>
<p><font face="Courier New">int systemInfo(struct utsname *uname)
</font></p>
<blockquote>
  <p>Gathers some info about the system and puts it into the utsname structure 'uname', just like the one returned by the system call 'uname' in Unix.
</p></blockquote>
<p><font face="Courier New">int encryptMD5(const char *in, char *out)
</font></p>
<blockquote>
  <p>Given the input string 'in', return the encrypted numerical message digest in the buffer 'out'.
</p></blockquote>
<p><font face="Courier New">int lockGet(lock *getLock)
</font></p>
<blockquote>
  <p>Get an exclusive lock based on the lock structure 'getLock'.
</p></blockquote>
<p><font face="Courier New">int lockRelease(lock *relLock)
</font></p>
<blockquote>
  <p>Release a lock on the lock structure 'lock' previously obtained with a call to the lockGet() function.
</p></blockquote>
<p><font face="Courier New">int lockVerify(lock *verLock)
</font></p>
<blockquote>
  <p>Verify that a lock on the lock structure 'verLock' is still valid.  This can be useful for retrying a lock attempt if a previous one failed; if the process that was previously holding the lock has failed, this will release the lock.
</p></blockquote>
<p><font face="Courier New">int variableListCreate(variableList *list)
</font></p>
<blockquote>
  <p>Set up a new variable list structure.
</p></blockquote>
<p><font face="Courier New">int variableListDestroy(variableList *list)
</font></p>
<blockquote>
  <p>Deallocate a variable list structure previously allocated by a call to variableListCreate() or configurationReader()
</p></blockquote>
<p><font face="Courier New">int variableListGet(variableList *list, const char *var, char *buffer, unsigned buffSize)
</font></p>
<blockquote>
  <p>Get the value of the variable 'var' from the variable list 'list' in the buffer 'buffer', up to 'buffSize' bytes.
</p></blockquote>
<p><font face="Courier New">int variableListSet(variableList *list, const char *var, const char *value)
</font></p>
<blockquote>
  <p>Set the value of the variable 'var' to the value 'value'.
</p></blockquote>
<p><font face="Courier New">int variableListUnset(variableList *list, const char *var)
</font></p>
<blockquote>
  <p>Remove the variable 'var' from the variable list 'list'.
</p></blockquote>
<p><font face="Courier New">int configRead(const char *fileName, variableList *list)
</font></p>
<blockquote>
  <p>Read the contents of the configuration file 'fileName', and return the data in the variable list structure 'list'.  Configuration files are simple properties files, consisting of lines of the format "variable=value"
</p></blockquote>
<p><font face="Courier New">int configWrite(const char *fileName, variableList *list)
</font></p>
<blockquote>
  <p>Write the contents of the variable list 'list' to the configuration file 'fileName'.  Configuration files are simple properties files, consisting of lines of the format "variable=value".  If the configuration file already exists, the configuration writer will attempt to preserve comment lines (beginning with '#') and formatting whitespace.
</p></blockquote>
<p><font face="Courier New">int configGet(const char *fileName, const char *variable, char *buffer, unsigned buffSize)
</font></p>
<blockquote>
  <p>This is a convenience function giving the ability to quickly get a single variable value from a config file.  Uses the configRead function, above, to read the config file 'fileName', and attempt to read the variable 'variable' into the buffer 'buffer' with size 'buffSize'.
</p></blockquote>
<p><font face="Courier New">int configSet(const char *fileName, const char *variable, const char *value)
</font></p>
<blockquote>
  <p>This is a convenience function giving the ability to quickly set a single variable value in a config file.  Uses the configRead and configWrite functions, above, to change the variable 'variable' to the value 'value'.
</p></blockquote>
<p><font face="Courier New">int configUnset(const char *fileName, const char *variable)
</font></p>
<blockquote>
  <p>This is a convenience function giving the ability to quickly unset a single variable value in a config file.  Uses the configRead and configWrite functions, above, to delete the variable 'variable'.
</p></blockquote>
<p><font face="Courier New">int guidGenerate(guid *g)
</font></p>
<blockquote>
  <p>Generates a GUID in the guid structure 'g'.
</p></blockquote>
<p><font face="Courier New">unsigned crc32(void *buff, unsigned len, unsigned *lastCrc)
</font></p>
<blockquote>
  <p>Generate a CRC32 from 'len' bytes of the buffer 'buff', using an optional previous CRC32 value (otherwise lastCrc should be NULL).
</p></blockquote>
<p><font face="Courier New">int keyboardGetMap(keyMap *map)
</font></p>
<blockquote>
  <p>Returns a copy of the current keyboard map in 'map'.
</p></blockquote>
<p><font face="Courier New">int keyboardSetMap(const char *name)
</font></p>
<blockquote>
  <p>Load the keyboard map from the file 'name' and set it as the system's current mapping.  If the filename is NULL, then the default (English US) mapping will be used.
</p></blockquote>
<p><font face="Courier New">int deviceTreeGetCount(void)
</font></p>
<blockquote>
  <p>Returns the number of devices in the kernel's device tree.
</p></blockquote>
<p><font face="Courier New">int deviceTreeGetRoot(device *rootDev)
</font></p>
<blockquote>
  <p>Returns the user-space portion of the device tree root device in the structure 'rootDev'.
</p></blockquote>
<p><font face="Courier New">int deviceTreeGetChild(device *parentDev, device *childDev)
</font></p>
<blockquote>
  <p>Returns the user-space portion of the first child device of 'parentDev' in the structure 'childDev'.
</p></blockquote>
<p><font face="Courier New">int deviceTreeGetNext(device *siblingDev)
</font></p>
<blockquote>
  <p>Returns the user-space portion of the next sibling device of the supplied device 'siblingDev' in the same data structure.
</p></blockquote>
<p><font face="Courier New">int mouseLoadPointer(const char *pointerName, const char *fileName)
</font></p>
<blockquote>
  <p>Tells the mouse driver code to load the mouse pointer 'pointerName' from the file 'fileName'.
</p></blockquote>
<p><font face="Courier New">void *pageGetPhysical(int processId, void *pointer)
</font></p>
<blockquote>
  <p>Returns the physical address corresponding pointed to by the virtual address 'pointer' for the process 'processId'
</p></blockquote>
</p>
<p>&nbsp;</p>
  
      </td>
    </tr>
  </table>
  </center>
</div>

        <p>&nbsp;</td>
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