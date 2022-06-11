<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Visopsys | Visual Operating System | Kernel API 0.6</title>
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
      <td><font face="Arial"><b>THE VISOPSYS KERNEL API (Version 0.6)<br>
      </b>(version 0.5 is <a href="kernel_API_0.5.php">here</a>)</font><p>
      <font face="Arial">All of the kernel's functions are defined in the file 
/system/headers/sys/api.h. In future, this file may be split into smaller 
chunks, by functional area. Data structures referred to in these function 
definitions are found in header files in the /system/headers/sys directory. For 
example, a 'disk' object is defined in /system/headers/sys/disk.h.</font></p>
<blockquote>
  <p><i><font face="Arial">One note on the 'objectKey' type used by many of these 
  functions: This is used to refer to data structures in kernel memory that are 
  not accessible (in a practical sense) to external programs. Yes, it's a 
  pointer -- A pointer to a structure that is probably defined in one of the 
  kernel header files. You could try to use it as more than just a reference 
  key, but you would do so at your own risk.</font></i></p>
</blockquote>
<p><font face="Arial">Here is the breakdown of functions divided by functional area:</font></p>
<p><font face="Arial"><a href="kernel_API_0.6.php#text">Text input/output functions</a><br>
<a href="kernel_API_0.6.php#disk">Disk functions</a><br>
<a href="kernel_API_0.6.php#filesystem">Filesystem functions</a><br>
<a href="kernel_API_0.6.php#file">File functions</a><br>
<a href="kernel_API_0.6.php#memory">Memory functions</a><br>
<a href="kernel_API_0.6.php#multitasker">Multitasker functions</a><br>
<a href="kernel_API_0.6.php#loader">Loader functions</a><br>
<a href="kernel_API_0.6.php#rtc">Real-time clock functions</a><br>
<a href="kernel_API_0.6.php#random">Random number functions</a><br>
<a href="kernel_API_0.6.php#environment">Environment functions</a><br>
<a href="kernel_API_0.6.php#graphics">Raw graphics functions</a><br>
<a href="kernel_API_0.6.php#window">Window manager functions</a><br>
<a href="kernel_API_0.6.php#user">User functions</a><br>
<a href="kernel_API_0.6.php#network">Network functions</a><br>
<a href="kernel_API_0.6.php#miscellaneous">Miscellaneous functions</a></font></p>
<p>&nbsp;</p>
<p></p>
<p><b>
<font face="Arial"><a name="text"></a>Text input/output functions</font></b></p>
<p><font face="Courier">objectKey textGetConsoleInput(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns a reference to the console input stream.  This is where keyboard input goes by default.
  </font>
</p></blockquote>
<p><font face="Courier">int textSetConsoleInput(objectKey newStream) </font></p>
<blockquote>
  <p><font face="Arial">Changes the console input stream.  GUI programs can use this function to redirect input to a text area or text field, for example.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey 
textGetConsoleOutput(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns a reference to the console output stream.  This is where kernel logging output goes by default.
  </font>
</p></blockquote>
<p><font face="Courier">int textSetConsoleOutput(objectKey newStream) </font></p>
<blockquote>
  <p><font face="Arial">Changes the console output stream.  GUI programs can use this function to redirect output to a text area or text field, for example.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey textGetCurrentInput(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns a reference to the input stream of the current process.  This is where standard input (for example, from a getc() call) is received.
  </font>
</p></blockquote>
<p><font face="Courier">int textSetCurrentInput(objectKey newStream) </font></p>
<blockquote>
  <p><font face="Arial">Changes the current input stream.  GUI programs can use this function to redirect input to a text area or text field, for example.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey textGetCurrentOutput(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns a reference to the console output stream.
  </font>
</p></blockquote>
<p><font face="Courier">int textSetCurrentOutput(objectKey newStream) </font></p>
<blockquote>
  <p><font face="Arial">Changes the current output stream.  This is where standard output (for example, from a putc() call) goes.
  </font>
</p></blockquote>
<p><font face="Courier">int textGetForeground(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the current foreground color as an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC built-in color value.  Here is a listing: 0=Black, 4=Red, 8=Dark gray, 12=Light red,  1=Blue, 5=Magenta, 9=Light blue, 13=Light magenta, 2=Green, 6=Brown, 10=Light green, 14=Yellow, 3=Cyan, 7=Light gray, 11=Light cyan, 15=White
  </font>
</p></blockquote>
<p><font face="Courier">int textSetForeground(int foreground) </font></p>
<blockquote>
  <p><font face="Arial">Set the current foreground color from an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC builtin color value.  See chart above.
  </font>
</p></blockquote>
<p><font face="Courier">int textGetBackground(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the current background color as an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC builtin color value.  See chart above.
  </font>
</p></blockquote>
<p><font face="Courier">int textSetBackground(int background) </font></p>
<blockquote>
  <p><font face="Arial">Set the current foreground color from an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC builtin color value.  See chart above.
  </font>
</p></blockquote>
<p><font face="Courier">int textPutc(int ascii) </font></p>
<blockquote>
  <p><font face="Arial">Print a single character </font>
</p></blockquote>
<p><font face="Courier">int textPrint(const char *str) </font></p>
<blockquote>
  <p><font face="Arial">Print a string </font>
</p></blockquote>
<p><font face="Courier">int textPrintLine(const char *str) </font></p>
<blockquote>
  <p><font face="Arial">Print a string with a newline at the end </font>
</p></blockquote>
<p><font face="Courier">void textNewline(void) </font></p>
<blockquote>
  <p><font face="Arial">Print a newline </font>
</p></blockquote>
<p><font face="Courier">int textBackSpace(void) </font></p>
<blockquote>
  <p><font face="Arial">Backspace the cursor, deleting any character there
  </font>
</p></blockquote>
<p><font face="Courier">int textTab(void) </font></p>
<blockquote>
  <p><font face="Arial">Print a tab </font>
</p></blockquote>
<p><font face="Courier">int textCursorUp(void) </font></p>
<blockquote>
  <p><font face="Arial">Move the cursor up one row.  Doesn't affect any characters there.
  </font>
</p></blockquote>
<p><font face="Courier">int textCursorDown(void) </font></p>
<blockquote>
  <p><font face="Arial">Move the cursor down one row.  Doesn't affect any characters there.
  </font>
</p></blockquote>
<p><font face="Courier">int textCursorLeft(void) </font></p>
<blockquote>
  <p><font face="Arial">Move the cursor left one column.  Doesn't affect any characters there.
  </font>
</p></blockquote>
<p><font face="Courier">int textCursorRight(void) </font></p>
<blockquote>
  <p><font face="Arial">Move the cursor right one column.  Doesn't affect any characters there.
  </font>
</p></blockquote>
<p><font face="Courier">void textScroll(int upDown) </font></p>
<blockquote>
  <p><font face="Arial">Scroll the current text area up (-1) or down (+1)
  </font>
</p></blockquote>
<p><font face="Courier">int textGetNumColumns(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the total number of columns in the text area.
  </font>
</p></blockquote>
<p><font face="Courier">int textGetNumRows(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the total number of rows in the text area.
  </font>
</p></blockquote>
<p><font face="Courier">int textGetColumn(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the number of the current column.  Zero-based.
  </font>
</p></blockquote>
<p><font face="Courier">void textSetColumn(int c) </font></p>
<blockquote>
  <p><font face="Arial">Set the number of the current column.  Zero-based.  Doesn't affect any characters there.
  </font>
</p></blockquote>
<p><font face="Courier">int textGetRow(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the number of the current row.  Zero-based.
  </font>
</p></blockquote>
<p><font face="Courier">void textSetRow(int r) </font></p>
<blockquote>
  <p><font face="Arial">Set the number of the current row.  Zero-based.  Doesn't affect any characters there.
  </font>
</p></blockquote>
<p><font face="Courier">void textSetCursor(int on) </font></p>
<blockquote>
  <p><font face="Arial">Turn the cursor on (1) or off (0) </font>
</p></blockquote>
<p><font face="Courier">int textScreenClear(void) </font></p>
<blockquote>
  <p><font face="Arial">Erase all characters in the text area and set the row and column to (0, 0)
  </font>
</p></blockquote>
<p><font face="Courier">int textScreenSave(void) </font></p>
<blockquote>
  <p><font face="Arial">Save the current screen in an internal buffer.  Use with the textScreenRestore function.
  </font>
</p></blockquote>
<p><font face="Courier">int textScreenRestore(void) </font></p>
<blockquote>
  <p><font face="Arial">Restore the screen previously saved with the textScreenSave function
  </font>
</p></blockquote>
<p><font face="Courier">int textInputStreamCount(objectKey strm) </font></p>
<blockquote>
  <p><font face="Arial">Get the number of characters currently waiting in the specified input stream
  </font>
</p></blockquote>
<p><font face="Courier">int textInputCount(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the number of characters currently waiting in the current input stream
  </font>
</p></blockquote>
<p><font face="Courier">int textInputStreamGetc(objectKey strm, char *cp) </font></p>
<blockquote>
  <p><font face="Arial">Get one character from the specified input stream (as an integer value).
  </font>
</p></blockquote>
<p><font face="Courier">int textInputGetc(char *cp) </font></p>
<blockquote>
  <p><font face="Arial">Get one character from the default input stream (as an integer value).
  </font>
</p></blockquote>
<p><font face="Courier">int textInputStreamReadN(objectKey strm, int num, char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Read up to 'num' characters from the specified input stream into 'buff'
  </font>
</p></blockquote>
<p><font face="Courier">int textInputReadN(int num, char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Read up to 'num' characters from the default input stream into 'buff'
  </font>
</p></blockquote>
<p><font face="Courier">int textInputStreamReadAll(objectKey strm, char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Read all of the characters from the specified input stream into 'buff'
  </font>
</p></blockquote>
<p><font face="Courier">int textInputReadAll(char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Read all of the characters from the default input stream into 'buff'
  </font>
</p></blockquote>
<p><font face="Courier">int textInputStreamAppend(objectKey strm, int ascii) </font></p>
<blockquote>
  <p><font face="Arial">Append a character (as an integer value) to the end of the specified input stream.
  </font>
</p></blockquote>
<p><font face="Courier">int textInputAppend(int ascii) </font></p>
<blockquote>
  <p><font face="Arial">Append a character (as an integer value) to the end of the default input stream.
  </font>
</p></blockquote>
<p><font face="Courier">int textInputStreamAppendN(objectKey strm, int num, char *str) </font></p>
<blockquote>
  <p><font face="Arial">Append 'num' characters to the end of the specified input stream from 'str'
  </font>
</p></blockquote>
<p><font face="Courier">int textInputAppendN(int num, char *str) </font></p>
<blockquote>
  <p><font face="Arial">Append 'num' characters to the end of the default input stream from 'str'
  </font>
</p></blockquote>
<p><font face="Courier">int textInputStreamRemove(objectKey strm) </font></p>
<blockquote>
  <p><font face="Arial">Remove one character from the start of the specified input stream.
  </font>
</p></blockquote>
<p><font face="Courier">int textInputRemove(void) </font></p>
<blockquote>
  <p><font face="Arial">Remove one character from the start of the default input stream.
  </font>
</p></blockquote>
<p><font face="Courier">int textInputStreamRemoveN(objectKey strm, int num) </font></p>
<blockquote>
  <p><font face="Arial">Remove 'num' characters from the start of the specified input stream.
  </font>
</p></blockquote>
<p><font face="Courier">int textInputRemoveN(int num) </font></p>
<blockquote>
  <p><font face="Arial">Remove 'num' characters from the start of the default input stream.
  </font>
</p></blockquote>
<p><font face="Courier">int textInputStreamRemoveAll(objectKey strm) </font></p>
<blockquote>
  <p><font face="Arial">Empty the specified input stream. </font>
</p></blockquote>
<p><font face="Courier">int textInputRemoveAll(void) </font></p>
<blockquote>
  <p><font face="Arial">Empty the default input stream. </font>
</p></blockquote>
<p><font face="Courier">void textInputStreamSetEcho(objectKey strm, int onOff)
</font></p>
<blockquote>
  <p><font face="Arial">Set echo on (1) or off (0) for the specified input stream.  When on, any characters typed will be automatically printed to the text area.  When off, they won't.
  </font>
</p></blockquote>
<p><font face="Courier">void textInputSetEcho(int onOff) </font></p>
<blockquote>
  <p><font face="Arial">Set echo on (1) or off (0) for the default input stream.  When on, any characters typed will be automatically printed to the text area.  When off, they won't.</font></p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p></p>
<p></p>
<p></p>

<p><b>
<font face="Arial"><a name="disk"></a>Disk functions</font></b></p>

<p><font face="Courier">int diskReadPartitions(void) </font></p>
<blockquote>
  <p><font face="Arial">Tells the kernel to (re)read the disk partition tables.
  </font>
</p></blockquote>
<p><font face="Courier">int diskSync(void) </font></p>
<blockquote>
  <p><font face="Arial">Tells the kernel to synchronize all the disks, flushing any output.
  </font>
</p></blockquote>
<p><font face="Courier">int diskGetBoot(char *name) </font></p>
<blockquote>
  <p><font face="Arial">Get the disk name of the boot device.  Normally this will contain the root filesystem.
  </font>
</p></blockquote>
<p><font face="Courier">int diskGetCount(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the number of logical disk volumes recognized by the system
  </font>
</p></blockquote>
<p><font face="Courier">int diskGetPhysicalCount(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the number of physical disk devices recognized by the system
  </font>
</p></blockquote>
<p><font face="Courier">int diskGet(const char *name, disk *userDisk) </font></p>
<blockquote>
  <p><font face="Arial">Given a disk name string 'name', fill in the corresponding user space disk structure 'userDisk.
  </font>
</p></blockquote>
<p><font face="Courier">int diskGetAll(disk *userDiskArray, unsigned buffSize) </font></p>
<blockquote>
  <p><font face="Arial">Return user space disk structures in 'userDiskArray' for each logical disk, up to 'buffSize' bytes.
  </font>
</p></blockquote>
<p><font face="Courier">int diskGetAllPhysical(disk *userDiskArray, unsigned buffSize) </font></p>
<blockquote>
  <p><font face="Arial">Return user space disk structures in 'userDiskArray' for each physical disk, up to 'buffSize' bytes.
  </font>
</p></blockquote>
<p><font face="Courier">int diskGetPartType(int code, partitionType *p) </font></p>
<blockquote>
  <p><font face="Arial">Gets the partition type data for the corresponding code.  This function was added specifically by use by programs such as 'fdisk' to get descriptions of different types known to the kernel.
  </font>
</p></blockquote>
<p><font face="Courier">partitionType *diskGetPartTypes(void) </font></p>
<blockquote>
  <p><font face="Arial">Like diskGetPartType(), but returns a pointer to a list of all known types.
  </font>
</p></blockquote>
<p><font face="Courier">int diskSetLockState(const char *name, int state) </font></p>
<blockquote>
  <p><font face="Arial">Set the locked state of the disk 'name' to either unlocked (0) or locked (1)
  </font>
</p></blockquote>
<p><font face="Courier">int diskSetDoorState(const char *name, int state) </font></p>
<blockquote>
  <p><font face="Arial">Open (1) or close (0) the disk 'name'.  May require a unlocking the door first, see diskSetLockState().
  </font>
</p></blockquote>
<p><font face="Courier">int diskGetMediaState(const char *diskName) </font></p>
<blockquote>
  <p><font face="Arial">Returns 1 if the removable disk 'diskName' is known to have media present.
  </font>
</p></blockquote>
<p><font face="Courier">int diskReadSectors(const char *name, unsigned sect, unsigned count, void *buf) </font></p>
<blockquote>
  <p><font face="Arial">Read 'count' sectors from disk 'name', starting at (zero-based) logical sector number 'sect'.  Put the data in memory area 'buf'.  This function requires supervisor privilege.
  </font>
</p></blockquote>
<p><font face="Courier">int diskWriteSectors(const char *name, unsigned sect, unsigned count, void *buf) </font></p>
<blockquote>
  <p><font face="Arial">Write 'count' sectors to disk 'name', starting at (zero-based) logical sector number 'sect'.  Get the data from memory area 'buf'.  This function requires supervisor privilege.</font></p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p><b>
<font face="Arial"><a name="filesystem"></a>Filesystem functions</font></b></p>

<p><font face="Courier">int filesystemFormat(const char *theDisk, const char *type, const char *label, int longFormat, progress *prog) </font></p>
<blockquote>
  <p><font face="Arial">Format the logical volume 'theDisk', with a string 'type' representing the preferred filesystem type (for example, "fat", "fat16", "fat32, etc).  Label it with 'label'.  'longFormat' will do a sector-by-sector format, if supported, and progress can optionally be monitored by passing a non-NULL progress structure pointer 'prog'.  It is optional for filesystem drivers to implement this function.
  </font>
</p></blockquote>
<p><font face="Courier">int filesystemClobber(const char *theDisk) </font></p>
<blockquote>
  <p><font face="Arial">Clobber all known filesystem types on the logical volume 'theDisk'.  It is optional for filesystem drivers to implement this function.
  </font>
</p></blockquote>
<p><font face="Courier">int filesystemCheck(const char *name, int force, int repair, progress *prog) </font></p>
<blockquote>
  <p><font face="Arial">Check the filesystem on disk 'name'.  If 'force' is non-zero, the filesystem will be checked regardless of whether the filesystem driver thinks it needs to be.  If 'repair' is non-zero, the filesystem driver will attempt to repair any errors found.  If 'repair' is zero, a non-zero return value may indicate that errors were found.  If 'repair' is non-zero, a non-zero return value may indicate that errors were found but could not be fixed.  Progress can optionally be monitored by passing a non-NULL progress structure pointer 'prog'.  It is optional for filesystem drivers to implement this function.
  </font>
</p></blockquote>
<p><font face="Courier">int filesystemDefragment(const char *name, progress *prog) </font></p>
<blockquote>
  <p><font face="Arial">Defragment the filesystem on disk 'name'.  Progress can optionally be monitored by passing a non-NULL progress structure pointer 'prog'.  It is optional for filesystem drivers to implement this function.
  </font>
</p></blockquote>
<p><font face="Courier">int filesystemMount(const char *name, const char *mp) </font></p>
<blockquote>
  <p><font face="Arial">Mount the filesystem on disk 'name', using the mount point specified by the absolute pathname 'mp'.  Note that no file or directory called 'mp' should exist, as the mount function will expect to be able to create it.
  </font>
</p></blockquote>
<p><font face="Courier">int filesystemUnmount(const char *mp) </font></p>
<blockquote>
  <p><font face="Arial">Unmount the filesystem mounted represented by the mount point 'fs'.
  </font>
</p></blockquote>
<p><font face="Courier">int filesystemGetFree(const char *fs) </font></p>
<blockquote>
  <p><font face="Arial">Returns the amount of free space on the filesystem represented by the mount point 'fs'.
  </font>
</p></blockquote>
<p><font face="Courier">unsigned filesystemGetBlockSize(const char *fs)
</font></p>
<blockquote>
  <p><font face="Arial">Returns the block size (for example, 512 or 1024) of the filesystem represented by the mount point 'fs'.</font></p>
  <p>&nbsp;</p></blockquote>
      <p></p>
<p><b>
<font face="Arial"><a name="file"></a>File functions</font></b></p>
<p><font face="Arial">Note that in all of the functions of this section, any 
reference to pathnames means absolute pathnames, from root. E.g. '/files/myfile', 
not simply 'myfile'. From the kernel's point of view, 'myfile' might be 
ambiguous.</font></p>
<p><font face="Courier">int fileFixupPath(const char *orig, char *new) </font></p>
<blockquote>
  <p><font face="Arial">Take the absolute pathname in 'orig' and fix it up.  This means eliminating extra file separator characters (for example) and resolving links or '.' or '..' components in the pathname.
  </font>
</p></blockquote>
<p><font face="Courier">int fileSeparateLast(const char *origPath, char *pathName, char *fileName) </font></p>
<blockquote>
  <p><font face="Arial">This function will take a combined pathname/filename string and separate the two.  The user will pass in the "combined" string along with two pre-allocated char arrays to hold the resulting separated elements.
  </font>
</p></blockquote>
<p><font face="Courier">int fileGetDisk(const char *path, disk *d) </font></p>
<blockquote>
  <p><font face="Arial">Given the file name 'path', return the user space structure for the logical disk that the file resides on.
  </font>
</p></blockquote>
<p><font face="Courier">int fileCount(const char *path) </font></p>
<blockquote>
  <p><font face="Arial">Get the count of file entries from the directory referenced by 'path'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileFirst(const char *path, file *f) </font></p>
<blockquote>
  <p><font face="Arial">Get the first file from the directory referenced by 'path'.  Put the information in the file structure 'f'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileNext(const char *path, file *f) </font></p>
<blockquote>
  <p><font face="Arial">Get the next file from the directory referenced by 'path'.  'f' should be a file structure previously filled by a call to either fileFirst() or fileNext().
  </font>
</p></blockquote>
<p><font face="Courier">int fileFind(const char *name, file *f) </font></p>
<blockquote>
  <p><font face="Arial">Find the file referenced by 'name', and fill the file data structure 'f' with the results if successful.
  </font>
</p></blockquote>
<p><font face="Courier">int fileOpen(const char *name, int mode, file *f) </font></p>
<blockquote>
  <p><font face="Arial">Open the file referenced by 'name' using the file open mode 'mode' (defined in ).  Update the file data structure 'f' if successful.
  </font>
</p></blockquote>
<p><font face="Courier">int fileClose(file *f) </font></p>
<blockquote>
  <p><font face="Arial">Close the previously opened file 'f'. </font>
</p></blockquote>
<p><font face="Courier">int fileRead(file *f, unsigned blocknum, unsigned blocks, unsigned char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Read data from the previously opened file 'f'.  'f' should have been opened in a read or read/write mode.  Read 'blocks' blocks (see the filesystem functions for information about getting the block size of a given filesystem) and put them in buffer 'buff'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileWrite(file *f, unsigned blocknum, unsigned blocks, unsigned char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Write data to the previously opened file 'f'.  'f' should have been opened in a write or read/write mode.  Write 'blocks' blocks (see the filesystem functions for information about getting the block size of a given filesystem) from the buffer 'buff'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileDelete(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Delete the file referenced by the pathname 'name'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileDeleteRecursive(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Recursively delete filesystem items, starting with the one referenced by the pathname 'name'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileDeleteSecure(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Securely delete the file referenced by the pathname 'name'.  If supported.
  </font>
</p></blockquote>
<p><font face="Courier">int fileMakeDir(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Create a directory to be referenced by the pathname 'name'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileRemoveDir(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Remove the directory referenced by the pathname 'name'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileCopy(const char *src, const char *dest) </font></p>
<blockquote>
  <p><font face="Arial">Copy the file referenced by the pathname 'src' to the pathname 'dest'.  This will overwrite 'dest' if it already exists.
  </font>
</p></blockquote>
<p><font face="Courier">int fileCopyRecursive(const char *src, const char *dest) </font></p>
<blockquote>
  <p><font face="Arial">Recursively copy the file referenced by the pathname 'src' to the pathname 'dest'.  If 'src' is a regular file, the result will be the same as using the non-recursive call.  However if it is a directory, all contents of the directory and its subdirectories will be copied.  This will overwrite any files in the 'dest' tree if they already exist.
  </font>
</p></blockquote>
<p><font face="Courier">int fileMove(const char *src, const char *dest) </font></p>
<blockquote>
  <p><font face="Arial">Move (rename) a file referenced by the pathname 'src' to the pathname 'dest'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileTimestamp(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Update the time stamp on the file referenced by the pathname 'name'
  </font>
</p></blockquote>
<p><font face="Courier">int fileGetTemp(file *f) </font></p>
<blockquote>
  <p><font face="Arial">Create and open a temporary file in write mode.
  </font>
</p></blockquote>
<p><font face="Courier">int fileStreamOpen(const char *name, int mode, fileStream *f) </font></p>
<blockquote>
  <p><font face="Arial">Open the file referenced by the pathname 'name' for streaming operations, using the open mode 'mode' (defined in ).  Fills the fileStream data structure 'f' with information needed for subsequent filestream operations.
  </font>
</p></blockquote>
<p><font face="Courier">int fileStreamSeek(fileStream *f, int offset) </font></p>
<blockquote>
  <p><font face="Arial">Seek the filestream 'f' to the absolute position 'offset'
  </font>
</p></blockquote>
<p><font face="Courier">int fileStreamRead(fileStream *f, unsigned bytes, char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Read 'bytes' bytes from the filestream 'f' and put them into 'buff'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileStreamReadLine(fileStream *f, unsigned bytes, char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Read a complete line of text from the filestream 'f', and put up to 'bytes' characters into 'buff'
  </font>
</p></blockquote>
<p><font face="Courier">int fileStreamWrite(fileStream *f, unsigned bytes, char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Write 'bytes' bytes from the buffer 'buff' to the filestream 'f'.
  </font>
</p></blockquote>
<p><font face="Courier">int fileStreamWriteStr(fileStream *f, char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Write the string in 'buff' to the filestream 'f'
  </font>
</p></blockquote>
<p><font face="Courier">int fileStreamWriteLine(fileStream *f, char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Write the string in 'buff' to the filestream 'f', and add a newline at the end
  </font>
</p></blockquote>
<p><font face="Courier">int fileStreamFlush(fileStream *f) </font></p>
<blockquote>
  <p><font face="Arial">Flush filestream 'f'. </font>
</p></blockquote>
<p><font face="Courier">int fileStreamClose(fileStream *f) </font></p>
<blockquote>
  <p><font face="Arial">[Flush and] close the filestream 'f'. </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p><b>
<font face="Arial"><a name="memory"></a>Memory functions</font></b></p>

<p><font face="Courier">void *memoryGet(unsigned size, const char *desc)
</font></p>
<blockquote>
  <p><font face="Arial">Return a pointer to a new block of memory of size 'size' and (optional) physical alignment 'align', adding the (optional) description 'desc'.  If no specific alignment is required, use '0'.  Memory allocated using this function is automatically cleared (like 'calloc').
  </font>
</p></blockquote>
<p><font face="Courier">void *memoryGetPhysical(unsigned size, unsigned align, const char *desc)
</font></p>
<blockquote>
  <p><font face="Arial">Return a pointer to a new physical block of memory of size 'size' and (optional) physical alignment 'align', adding the (optional) description 'desc'.  If no specific alignment is required, use '0'.  Memory allocated using this function is NOT automatically cleared.  'Physical' refers to an actual physical memory address, and is not necessarily useful to external programs.
  </font>
</p></blockquote>
<p><font face="Courier">int memoryRelease(void *p) </font></p>
<blockquote>
  <p><font face="Arial">Release the memory block starting at the address 'p'.  Must have been previously allocated using the memoryRequestBlock() function.
  </font>
</p></blockquote>
<p><font face="Courier">int memoryReleaseAllByProcId(int pid) </font></p>
<blockquote>
  <p><font face="Arial">Release all memory allocated to/by the process referenced by process ID 'pid'.  Only privileged functions can release memory owned by other processes.
  </font>
</p></blockquote>
<p><font face="Courier">int memoryChangeOwner(int opid, int npid, void *addr, void **naddr) </font></p>
<blockquote>
  <p><font face="Arial">Change the ownership of an allocated block of memory beginning at address 'addr'.  'opid' is the process ID of the currently owning process, and 'npid' is the process ID of the intended new owner.  'naddr' is filled with the new address of the memory (since it changes address spaces in the process).  Note that only a privileged process can change memory ownership.
  </font>
</p></blockquote>
<p><font face="Courier">int memoryGetStats(memoryStats *stats, int kernel) </font></p>
<blockquote>
  <p><font face="Arial">Returns the current memory totals and usage values to the current output stream.  If non-zero, the flag 'kernel' will return kernel heap statistics instead of overall system statistics.
  </font>
</p></blockquote>
<p><font face="Courier">int 
memoryGetBlocks(memoryBlock *blocksArray, unsigned buffSize, int kernel) </font></p>
<blockquote>
  <p><font face="Arial">Returns a copy of the array of used memory blocks in 'blocksArray', up to 'buffSize' bytes.  If non-zero, the flag 'kernel' will return kernel heap blocks instead of overall heap allocations.
  </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>
<p><b>
<font face="Arial"><a name="multitasker"></a>Multitasker functions</font></b></p>

<p><font face="Courier">int multitaskerCreateProcess(const char *name, int privilege, processImage *execImage) </font></p>
<blockquote>
  <p><font face="Arial">Create a new process.  'name' will be the new process' name.  'privilege' is the privilege level.  'execImage' is a processImage structure that describes the loaded location of the file, the program's desired virtual address, entry point, size, etc.  If the value returned by the call is a positive integer, the call was successful and the value is the new process' process ID.  New processes are created and left in a stopped state, so if you want it to run you will need to set it to a running state ('ready', actually) using the function call multitaskerSetProcessState().
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerSpawn(void *addr, const char *name, int numargs, void *args[]) </font></p>
<blockquote>
  <p><font face="Arial">Spawn a thread from the current process.  The starting point of the code (for example, a function address) should be specified as 'addr'.  'name' will be the new thread's name.  'numargs' and 'args' will be passed as the "int argc, char *argv[]) parameters of the new thread.  If there are no arguments, these should be 0 and NULL, respectively.  If the value returned by the call is a positive integer, the call was successful and the value is the new thread's process ID.  New threads are created and made runnable, so there is no need to change its state to activate it.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerGetCurrentProcessId(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns the process ID of the calling program.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerGetProcess(int pid, process *proc) </font></p>
<blockquote>
  <p><font face="Arial">Returns the process structure for the supplied process ID.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerGetProcessByName(const char *name, process *proc) </font></p>
<blockquote>
  <p><font face="Arial">Returns the process structure for the supplied process name
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerGetProcesses(void *buffer, unsigned buffSize) </font></p>
<blockquote>
  <p><font face="Arial">Fills 'buffer' with up to 'buffSize' bytes' worth of process structures, and returns the number of structures copied.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerSetProcessState(int pid, int state) </font></p>
<blockquote>
  <p><font face="Arial">Sets the state of the process referenced by process ID 'pid' to the new state 'state'.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerProcessIsAlive(int pid) </font></p>
<blockquote>
  <p><font face="Arial">Returns 1 if the process with the id 'pid' still exists and is in a 'runnable' (viable) state.  Returns 0 if the process does not exist or is in a 'finished' state.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerSetProcessPriority(int pid, int priority) </font></p>
<blockquote>
  <p><font face="Arial">Sets the priority of the process referenced by process ID 'pid' to 'priority'.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerGetProcessPrivilege(int pid) </font></p>
<blockquote>
  <p><font face="Arial">Gets the privilege level of the process referenced by process ID 'pid'.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerGetCurrentDirectory(char *buff, int buffsz) </font></p>
<blockquote>
  <p><font face="Arial">Returns the absolute pathname of the calling process' current directory.  Puts the value in the buffer 'buff' which is of size 'buffsz'.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerSetCurrentDirectory(const char *buff) </font></p>
<blockquote>
  <p><font face="Arial">Sets the current directory of the calling process to the absolute pathname 'buff'.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey multitaskerGetTextInput(void) </font></p>
<blockquote>
  <p><font face="Arial">Get an object key to refer to the current text input stream of the calling process.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerSetTextInput(int processId, objectKey key) </font></p>
<blockquote>
  <p><font face="Arial">Set the text input stream of the process referenced by process ID 'processId' to a text stream referenced by the object key 'key'.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey multitaskerGetTextOutput(void) </font></p>
<blockquote>
  <p><font face="Arial">Get an object key to refer to the current text output stream of the calling process.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerSetTextOutput(int processId, objectKey key) </font></p>
<blockquote>
  <p><font face="Arial">Set the text output stream of the process referenced by process ID 'processId' to a text stream referenced by the object key 'key'.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerDuplicateIO(int pid1, int pid2, int clear) </font></p>
<blockquote>
  <p><font face="Arial">Set 'pid2' to use the same input and output streams as 'pid1', and if 'clear' is non-zero, clear any pending input or output.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerGetProcessorTime(clock_t *clk) </font></p>
<blockquote>
  <p><font face="Arial">Fill the clock_t structure with the amount of processor time consumed by the calling process.
  </font>
</p></blockquote>
<p><font face="Courier">void multitaskerYield(void) </font></p>
<blockquote>
  <p><font face="Arial">Yield the remainder of the current processor timeslice back to the multitasker's scheduler.  It's nice to do this when you are waiting for some event, so that your process is not 'hungry' (i.e. hogging processor cycles unnecessarily).
  </font>
</p></blockquote>
<p><font face="Courier">void multitaskerWait(unsigned ticks) </font></p>
<blockquote>
  <p><font face="Arial">Yield the remainder of the current processor timeslice back to the multitasker's scheduler, and wait at least 'ticks' timer ticks before running the calling process again.  On the PC, one second is approximately 20 system timer ticks.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerBlock(int pid) </font></p>
<blockquote>
  <p><font face="Arial">Yield the remainder of the current processor timeslice back to the multitasker's scheduler, and block on the process referenced by process ID 'pid'.  This means that the calling process will not run again until process 'pid' has terminated.  The return value of this function is the return value of process 'pid'.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerDetach(void) </font></p>
<blockquote>
  <p><font face="Arial">This allows a program to 'daemonize', detaching from the IO streams of its parent and, if applicable, the parent stops blocking.  Useful for a process that want to operate in the background, or that doesn't want to be killed if its parent is killed.
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerKillProcess(int pid, int force) </font></p>
<blockquote>
  <p><font face="Arial">Terminate the process referenced by process ID 'pid'.  If 'force' is non-zero, the multitasker will attempt to ignore any errors and dismantle the process with extreme prejudice.  The 'force' flag also has the necessary side effect of killing any child threads spawned by process 'pid'.  (Otherwise, 'pid' is left in a stopped state until its threads have terminated normally).
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerKillByName(const char *name, int force) </font></p>
<blockquote>
  <p><font face="Arial">Like multitaskerKillProcess, except that it attempts to kill all instances of processes whose names match 'name'
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerTerminate(int code) </font></p>
<blockquote>
  <p><font face="Arial">Terminate the calling process, returning the exit code 'code'
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerSignalSet(int processId, int sig, int on) </font></p>
<blockquote>
  <p><font face="Arial">Set the current process' signal handling enabled (on) or disabled for the specified signal number 'sig'
  </font>
</p></blockquote>
<p><font face="Courier">int 
multitaskerSignal(int processId, int sig) </font></p>
<blockquote>
  <p><font face="Arial">Send the requested signal 'sig' to the process 'processId'
  </font>
</p></blockquote>
<p><font face="Courier">int multitaskerSignalRead(int processId) </font></p>
<blockquote>
  <p><font face="Arial">Returns the number code of the next pending signal for the current process, or 0 if no signals are pending.
  </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p><b>
<font face="Arial"><a name="loader"></a>Loader functions</font></b></p>

<p><font face="Courier">void *loaderLoad(const char *filename, file *theFile)
</font></p>
<blockquote>
  <p><font face="Arial">Load a file referenced by the pathname 'filename', and fill the file data structure 'theFile' with the details.  The pointer returned points to the resulting file data.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey loaderClassify(const char *fileName, void *fileData, int size, loaderFileClass *class) </font></p>
<blockquote>
  <p><font face="Arial">Given a file by the name 'fileName', the contents 'fileData', of size 'size', get the kernel loader's idea of the file type.  If successful, the return  value is non-NULL and the loaderFileClass structure 'class' is filled out with the known information.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey loaderClassifyFile(const char *fileName, loaderFileClass *class) </font></p>
<blockquote>
  <p><font face="Arial">Like loaderClassify(), except the first argument 'fileName' is a file name to classify.  Returns the kernel loader's idea of the file type.  If successful, the return value is non-NULL and the loaderFileClass structure 'class' is filled out with the known information.
  </font>
</p></blockquote>
<p><font face="Courier">loaderSymbolTable *loaderGetSymbols(const char *fileName, int dynamic) </font></p>
<blockquote>
  <p><font face="Arial">Given a binary executable, library, or object file 'fileName' and a flag 'dynamic', return a loaderSymbolTable structure filled out with the loader symbols from the file.  If 'dynamic' is non-zero, only symbols used in dynamic linking will be returned (if the file is not a dynamic library or executable, NULL will be returned).  If 'dynamic' is zero, return all symbols found in the file.
  </font>
</p></blockquote>
<p><font face="Courier">int loaderLoadProgram(const char *command, int privilege) </font></p>
<blockquote>
  <p><font face="Arial">Run 'command' as a process with the privilege level 'privilege'.  If successful, the call's return value is the process ID of the new process.  The process is left in a stopped state and must be set to a running state explicitly using the multitasker function multitaskerSetProcessState() or the loader function loaderExecProgram().
  </font>
</p></blockquote>
<p><font face="Courier">int loaderLoadLibrary(const char *libraryName) </font></p>
<blockquote>
  <p><font face="Arial">This takes the name of a library file 'libraryName' to load and creates a shared library in the kernel.  This function is not especially useful to user programs, since normal shared library loading happens automatically as part of the 'loaderLoadProgram' process.
  </font>
</p></blockquote>
<p><font face="Courier">int loaderExecProgram(int processId, int block) </font></p>
<blockquote>
  <p><font face="Arial">Execute the process referenced by process ID 'processId'.  If 'block' is non-zero, the calling process will block until process 'pid' has terminated, and the return value of the call is the return value of process 'pid'.
  </font>
</p></blockquote>
<p><font face="Courier">int loaderLoadAndExec(const char *command, int privilege, int block) </font></p>
<blockquote>
  <p><font face="Arial">This function is just for convenience, and is an amalgamation of the loader functions loaderLoadProgram() and  loaderExecProgram().
  </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p><b><font face="Arial"><a name="rtc"></a>Real-time clock functions</font></b></p>

<p><font face="Courier">int rtcReadSeconds(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the current seconds value. </font>
</p></blockquote>
<p><font face="Courier">int rtcReadMinutes(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the current minutes value. </font>
</p></blockquote>
<p><font face="Courier">int rtcReadHours(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the current hours value. </font>
</p></blockquote>
<p><font face="Courier">int rtcDayOfWeek(unsigned day, unsigned month, unsigned year) </font></p>
<blockquote>
  <p><font face="Arial">Get the current day of the week value. </font>
</p></blockquote>
<p><font face="Courier">int 
rtcReadDayOfMonth(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the current day of the month value. </font>
</p></blockquote>
<p><font face="Courier">int rtcReadMonth(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the current month value. </font>
</p></blockquote>
<p><font face="Courier">int rtcReadYear(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the current year value. </font>
</p></blockquote>
<p><font face="Courier">unsigned rtcUptimeSeconds(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the number of seconds the system has been running.
  </font>
</p></blockquote>
<p><font face="Courier">int rtcDateTime(struct tm *theTime) </font></p>
<blockquote>
  <p><font face="Arial">Get the current data and time as a tm data structure in 'theTime'.
  </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p><b>
<font face="Arial"><a name="random"></a>Random number functions</font></b></p>

<p><font face="Courier">unsigned randomUnformatted(void) </font></p>
<blockquote>
  <p><font face="Arial">Get an unformatted random unsigned number.  Just any unsigned number.
  </font>
</p></blockquote>
<p><font face="Courier">unsigned randomFormatted(unsigned start, unsigned end)
</font></p>
<blockquote>
  <p><font face="Arial">Get a random unsigned number between the start value 'start' and the end value 'end', inclusive.
  </font>
</p></blockquote>
<p><font face="Courier">unsigned randomSeededUnformatted(unsigned seed)
</font></p>
<blockquote>
  <p><font face="Arial">Get an unformatted random unsigned number, using the random seed 'seed' instead of the kernel's default random seed.
  </font>
</p></blockquote>
<p><font face="Courier">unsigned randomSeededFormatted(unsigned seed, unsigned start, unsigned end)
</font></p>
<blockquote>
  <p><font face="Arial">Get a random unsigned number between the start value 'start' and the end value 'end', inclusive, using the random seed 'seed' instead of the kernel's default random seed.
  </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p><b>
<font face="Arial"><a name="environment"></a>Environment functions</font></b></p>

<p><font face="Courier">int environmentGet(const char *var, char *buf, unsigned bufsz) </font></p>
<blockquote>
  <p><font face="Arial">Get the value of the environment variable named 'var', and put it into the buffer 'buf' of size 'bufsz' if successful.
  </font>
</p></blockquote>
<p><font face="Courier">int environmentSet(const char *var, const char *val) </font></p>
<blockquote>
  <p><font face="Arial">Set the environment variable 'var' to the value 'val', overwriting any old value that might have been previously set.
  </font>
</p></blockquote>
<p><font face="Courier">int 
environmentUnset(const char *var) </font></p>
<blockquote>
  <p><font face="Arial">Delete the environment variable 'var'. </font>
</p></blockquote>
<p><font face="Courier">void environmentDump(void) </font></p>
<blockquote>
  <p><font face="Arial">Print a listing of all the currently set environment variables in the calling process' environment space to the current text output stream.
  </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p><b>
<font face="Arial"><a name="graphics"></a>Raw graphics functions</font></b></p>

<p><font face="Courier">int graphicsAreEnabled(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns 1 if the kernel is operating in graphics mode.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicGetModes(videoMode *buffer, unsigned size) </font></p>
<blockquote>
  <p><font face="Arial">Get up to 'size' bytes worth of videoMode structures in 'buffer' for the supported video modes of the current hardware.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicGetMode(videoMode *mode) </font></p>
<blockquote>
  <p><font face="Arial">Get the current video mode in 'mode' </font>
</p></blockquote>
<p><font face="Courier">int graphicSetMode(videoMode *mode) </font></p>
<blockquote>
  <p><font face="Arial">Set the video mode in 'mode'.  Generally this will require a reboot in order to take effect.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicGetScreenWidth(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns the width of the graphics screen.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicGetScreenHeight(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns the height of the graphics screen.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicCalculateAreaBytes(int width, int height) </font></p>
<blockquote>
  <p><font face="Arial">Returns the number of bytes required to allocate a graphic buffer of width 'width' and height 'height'.  This is a function of the screen resolution, etc.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicClearScreen(color *background) </font></p>
<blockquote>
  <p><font face="Arial">Clear the screen to the background color 'background'.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicGetColor(const char *colorName, color *getColor) </font></p>
<blockquote>
  <p><font face="Arial">Get the system color 'colorName' and place its values in the color structure 'getColor'.  Examples of system color names include 'foreground', 'background', and 'desktop'.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicSetColor(const char *colorName, color *setColor) </font></p>
<blockquote>
  <p><font face="Arial">Set the system color 'colorName' to the values in the color structure 'getColor'.  Examples of system color names include 'foreground', 'background', and 'desktop'.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicDrawPixel(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord) </font></p>
<blockquote>
  <p><font face="Arial">Draw a single pixel into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the X coordinate 'xCoord' and the Y coordinate 'yCoord'.  If 'buffer' is NULL, draw directly onto the screen.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicDrawLine(objectKey buffer, color *foreground, drawMode mode, int startX, int startY, int endX, int endY) </font></p>
<blockquote>
  <p><font face="Arial">Draw a line into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'startX', the starting Y coordinate 'startY', the ending X coordinate 'endX' and the ending Y coordinate 'endY'.  At the time of writing, only horizontal and vertical lines are supported by the linear framebuffer graphic driver.  If 'buffer' is NULL, draw directly onto the screen.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicDrawRect(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord, int width, int height, int thickness, int fill) </font></p>
<blockquote>
  <p><font face="Arial">Draw a rectangle into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width', the height 'height', the line thickness 'thickness' and the fill value 'fill'.  Non-zero fill value means fill the rectangle.   If 'buffer' is NULL, draw directly onto the screen.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicDrawOval(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord, int width, int height, int thickness, int fill) </font></p>
<blockquote>
  <p><font face="Arial">Draw an oval (circle, whatever) into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width', the height 'height', the line thickness 'thickness' and the fill value 'fill'.  Non-zero fill value means fill the oval.   If 'buffer' is NULL, draw directly onto the screen.  Currently not supported by the linear framebuffer graphic driver.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicDrawImage(objectKey buffer, image *drawImage, drawMode mode, int xCoord, int yCoord, int xOffset, int yOffset, int width, int height) </font></p>
<blockquote>
  <p><font face="Arial">Draw the image 'drawImage' into the graphic buffer 'buffer', using the drawing mode 'mode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord' and the starting Y coordinate 'yCoord'.   The 'xOffset' and 'yOffset' parameters specify an offset into the image to start the drawing (0, 0 to draw the whole image).  Similarly the 'width' and 'height' parameters allow you to specify a portion of the image (0, 0 to draw the whole image -- minus any X or Y offsets from the previous parameters).  So, for example, to draw only the middle pixel of a 3x3 image, you would specify xOffset=1, yOffset=1, width=1, height=1.  If 'buffer' is NULL, draw directly onto the screen.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicGetImage(objectKey buffer, image *getImage, int xCoord, int yCoord, int width, int height) </font></p>
<blockquote>
  <p><font face="Arial">Grab a new image 'getImage' from the graphic buffer 'buffer', using the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width' and the height 'height'.   If 'buffer' is NULL, grab the image directly from the screen.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicDrawText(objectKey buffer, color *foreground, color *background, objectKey font, const char *text, drawMode mode, int xCoord, int yCoord) </font></p>
<blockquote>
  <p><font face="Arial">Draw the text string 'text' into the graphic buffer 'buffer', using the colors 'foreground' and 'background', the font 'font', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord'.   If 'buffer' is NULL, draw directly onto the screen.  If 'font' is NULL, use the default font.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicCopyArea(objectKey buffer, int xCoord1, int yCoord1, int width, int height, int xCoord2, int yCoord2) </font></p>
<blockquote>
  <p><font face="Arial">Within the graphic buffer 'buffer', copy the area bounded by ('xCoord1', 'yCoord1'), width 'width' and height 'height' to the starting X coordinate 'xCoord2' and the starting Y coordinate 'yCoord2'.  If 'buffer' is NULL, copy directly to and from the screen.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicClearArea(objectKey buffer, color *background, int xCoord, int yCoord, int width, int height) </font></p>
<blockquote>
  <p><font face="Arial">Clear the area of the graphic buffer 'buffer' using the background color 'background', using the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width' and the height 'height'.  If 'buffer' is NULL, clear the area directly on the screen.
  </font>
</p></blockquote>
<p><font face="Courier">int graphicRenderBuffer(objectKey buffer, int drawX, int drawY, int clipX, int clipY, int clipWidth, int clipHeight) </font></p>
<blockquote>
  <p><font face="Arial">Draw the clip of the buffer 'buffer' onto the screen.  Draw it on the screen at starting X coordinate 'drawX' and starting Y coordinate 'drawY'.  The buffer clip is bounded by the starting X coordinate 'clipX', the starting Y coordinate 'clipY', the width 'clipWidth' and the height 'clipHeight'.  It is not legal for 'buffer' to be NULL in this case.
  </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p><b>
<font face="Arial"><a name="window"></a>Windowing system functions</font></b></p>

<p><font face="Courier">int windowLogin(const char *userName) </font></p>
<blockquote>
  <p><font face="Arial">Log the user into the window environment with 'userName'.  The return value is the PID of the window shell for this session.  The calling program must have supervisor privilege in order to use this function.
  </font>
</p></blockquote>
<p><font face="Courier">int windowLogout(void) </font></p>
<blockquote>
  <p><font face="Arial">Log the current user out of the windowing system.  This kills the window shell process returned by windowLogin() call.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNew(int processId, const char *title) </font></p>
<blockquote>
  <p><font face="Arial">Create a new window, owned by the process 'processId', and with the title 'title'.  Returns an object key to reference the window, needed by most other window functions below (such as adding components to the window)
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewDialog(objectKey parent, const char *title) </font></p>
<blockquote>
  <p><font face="Arial">Create a dialog window to associate with the parent window 'parent', using the supplied title.  In the current implementation, dialog windows are modal, which is the main characteristic distinguishing them from regular windows.
  </font>
</p></blockquote>
<p><font face="Courier">int windowDestroy(objectKey window) </font></p>
<blockquote>
  <p><font face="Arial">Destroy the window referenced by the object key 'wndow'
  </font>
</p></blockquote>
<p><font face="Courier">int windowUpdateBuffer(void *buffer, int xCoord, int yCoord, int width, int height) </font></p>
<blockquote>
  <p><font face="Arial">Tells the windowing system to redraw the visible portions of the graphic buffer 'buffer', using the given clip coordinates/size.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetTitle(objectKey window, const char *title) </font></p>
<blockquote>
  <p><font face="Arial">Set the new title of window 'window' to be 'title'.
  </font>
</p></blockquote>
<p><font face="Courier">int windowGetSize(objectKey window, int *width, int *height) </font></p>
<blockquote>
  <p><font face="Arial">Get the size of the window 'window', and put the results in 'width' and 'height'.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetSize(objectKey window, int width, int height) </font></p>
<blockquote>
  <p><font face="Arial">Resize the window 'window' to the width 'width' and the height 'height'.
  </font>
</p></blockquote>
<p><font face="Courier">int windowGetLocation(objectKey window, int *xCoord, int *yCoord) </font></p>
<blockquote>
  <p><font face="Arial">Get the current screen location of the window 'window' and put it into the coordinate variables 'xCoord' and 'yCoord'.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetLocation(objectKey window, int xCoord, int yCoord) </font></p>
<blockquote>
  <p><font face="Arial">Set the screen location of the window 'window' using the coordinate variables 'xCoord' and 'yCoord'.
  </font>
</p></blockquote>
<p><font face="Courier">int windowCenter(objectKey window) </font></p>
<blockquote>
  <p><font face="Arial">Center 'window' on the screen. </font>
</p></blockquote>
<p><font face="Courier">int windowSnapIcons(objectKey parent) </font></p>
<blockquote>
  <p><font face="Arial">If 'container' (either a window or a windowContainer) has icon components inside it, this will snap them to a grid.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetHasBorder(objectKey window, int trueFalse) </font></p>
<blockquote>
  <p><font face="Arial">Tells the windowing system whether to draw a border around the window 'window'.  'trueFalse' being non-zero means draw a border.  Windows have borders by default.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetHasTitleBar(objectKey window, int trueFalse) </font></p>
<blockquote>
  <p><font face="Arial">Tells the windowing system whether to draw a title bar on the window 'window'.  'trueFalse' being non-zero means draw a title bar.  Windows have title bars by default.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetMovable(objectKey window, int trueFalse) </font></p>
<blockquote>
  <p><font face="Arial">Tells the windowing system whether the window 'window' should be movable by the user (i.e. clicking and dragging it).  'trueFalse' being non-zero means the window is movable.  Windows are movable by default.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetResizable(objectKey window, int trueFalse) </font></p>
<blockquote>
  <p><font face="Arial">Tells the windowing system whether to allow 'window' to be resized by the user.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetHasMinimizeButton(objectKey window, </font></p>
<blockquote>
  <p><font face="Arial">Tells the windowing system whether to draw a minimize button on the title bar of the window 'window'.  'trueFalse' being non-zero means draw a minimize button.  Windows have minimize buttons by default, as long as they have a title bar.  If there is no title bar, then this function has no effect.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetHasCloseButton(objectKey window, int trueFalse) </font></p>
<blockquote>
  <p><font face="Arial">Tells the windowing system whether to draw a close button on the title bar of the window 'window'.  'trueFalse' being non-zero means draw a close button.  Windows have close buttons by default, as long as they have a title bar.  If there is no title bar, then this function has no effect.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetColors(objectKey window, color *background) </font></p>
<blockquote>
  <p><font face="Arial">Set the background color of 'window'.  If 'color' is NULL, use the default.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetVisible(objectKey window, int visible) </font></p>
<blockquote>
  <p><font face="Arial">Tell the windowing system whether to make 'window' visible or not.  Non-zero 'visible' means make the window visible.  When windows are created, they are not visible by default so you can add components, do layout, set the size, etc.
  </font>
</p></blockquote>
<p><font face="Courier">void windowSetMinimized(objectKey window, int minimized)
</font></p>
<blockquote>
  <p><font face="Arial">Tell the windowing system whether to make 'window' minimized or not.  Non-zero 'minimized' means make the window non-visible, but accessible via the task bar.  Zero 'minimized' means restore a minimized window to its normal, visible size.
  </font>
</p></blockquote>
<p><font face="Courier">int windowAddConsoleTextArea(objectKey window, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Add a console text area component to 'window' using the supplied componentParameters.  The console text area is where most kernel logging and error messages are sent, particularly at boot time.  Note that there is only one instance of the console text area, and thus it can only exist in one window at a time.  Destroying the window is one way to free the console area to be used in another window.
  </font>
</p></blockquote>
<p><font face="Courier">void windowRedrawArea(int xCoord, int yCoord, int width, int height)
</font></p>
<blockquote>
  <p><font face="Arial">Tells the windowing system to redraw whatever is supposed to be in the screen area bounded by the supplied coordinates.  This might be useful if you were drawing non-window-based things (i.e., things without their own independent graphics buffer) directly onto the screen and you wanted to restore an area to its original contents.  For example, the mouse driver uses this method to erase the pointer from its previous position.
  </font>
</p></blockquote>
<p><font face="Courier">void windowProcessEvent(objectKey event) </font></p>
<blockquote>
  <p><font face="Arial">Creates a window event using the supplied event structure.  This function is most often used within the kernel, particularly in the mouse and keyboard functions, to signify clicks or key presses.  It can, however, be used by external programs to create 'artificial' events.  The windowEvent structure specifies the target component and event type.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentEventGet(objectKey key, windowEvent *event) </font></p>
<blockquote>
  <p><font face="Arial">Gets a pending window event, if any, applicable to component 'key', and puts the data into the windowEvent structure 'event'.  If an event was received, the function returns a positive, non-zero value (the actual value reflects the amount of raw data read from the component's event stream -- not particularly useful to an application).  If the return value is zero, no event was pending.
  </font>
</p></blockquote>
<p><font face="Courier">int windowTileBackground(const char *theFile) </font></p>
<blockquote>
  <p><font face="Arial">Load the image file specified by the pathname 'theFile', and if successful, tile the image on the background root window.
  </font>
</p></blockquote>
<p><font face="Courier">int windowCenterBackground(const char *theFile) </font></p>
<blockquote>
  <p><font face="Arial">Load the image file specified by the pathname 'theFile', and if successful, center the image on the background root window.
  </font>
</p></blockquote>
<p><font face="Courier">int windowScreenShot(image *saveImage) </font></p>
<blockquote>
  <p><font face="Arial">Get an image representation of the entire screen in the image data structure 'saveImage'.  Note that it is not necessary to allocate memory for the data pointer of the image structure beforehand, as this is done automatically.  You should, however, deallocate the data field of the image structure when you are finished with it.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSaveScreenShot(const char *filename) </font></p>
<blockquote>
  <p><font face="Arial">Save a screenshot of the entire screen to the file specified by the pathname 'filename'.
  </font>
</p></blockquote>
<p><font face="Courier">int windowSetTextOutput(objectKey key) </font></p>
<blockquote>
  <p><font face="Arial">Set the text output (and input) of the calling process to the object key of some window component, such as a TextArea or TextField component.  You'll need to use this if you want to output text to one of these components or receive input from one.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentSetVisible(objectKey component, int visible) </font></p>
<blockquote>
  <p><font face="Arial">Set 'component' visible or non-visible. </font>
</p></blockquote>
<p><font face="Courier">int windowComponentSetEnabled(objectKey component, int enabled) </font></p>
<blockquote>
  <p><font face="Arial">Set 'component' enabled or non-enabled; non-enabled components appear greyed-out.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentGetWidth(objectKey component) </font></p>
<blockquote>
  <p><font face="Arial">Get the pixel width of the window component 'component'.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentSetWidth(objectKey component, int width) </font></p>
<blockquote>
  <p><font face="Arial">Set the pixel width of the window component 'component'
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentGetHeight(objectKey component) </font></p>
<blockquote>
  <p><font face="Arial">Get the pixel height of the window component 'component'.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentSetHeight(objectKey component, int height) </font></p>
<blockquote>
  <p><font face="Arial">Set the pixel height of the window component 'component'.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentFocus(objectKey component) </font></p>
<blockquote>
  <p><font face="Arial">Give window component 'component' the focus of its window.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentDraw(objectKey component) </font></p>
<blockquote>
  <p><font face="Arial">Calls the window component 'component' to redraw itself.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentGetData(objectKey component, void *buffer, int size) </font></p>
<blockquote>
  <p><font face="Arial">This is a generic call to get data from the window component 'component', up to 'size' bytes, in the buffer 'buffer'.  The size and type of data that a given component will return is totally dependent upon the type and implementation of the component.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentSetData(objectKey component, void *buffer, int size) </font></p>
<blockquote>
  <p><font face="Arial">This is a generic call to set data in the window component 'component', up to 'size' bytes, in the buffer 'buffer'.  The size and type of data that a given component will use or accept is totally dependent upon the type and implementation of the component.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentGetSelected(objectKey component, int *selection) </font></p>
<blockquote>
  <p><font face="Arial">This is a call to get the 'selected' value of the window component 'component'.  The type of value returned depends upon the type of component; a list component, for example, will return the 0-based number(s) of its selected item(s).  On the other hand, a boolean component such as a checkbox will return 1 if it is currently selected.
  </font>
</p></blockquote>
<p><font face="Courier">int windowComponentSetSelected(objectKey component, int selected) </font></p>
<blockquote>
  <p><font face="Arial">This is a call to set the 'selected' value of the window component 'component'.  The type of value accepted depends upon the type of component; a list component, for example, will use the 0-based number to select one of its items.  On the other hand, a boolean component such as a checkbox will clear itself if 'selected' is 0, and set itself otherwise.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewButton(objectKey parent, const char *label, image *buttonImage, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new button component to be placed inside the parent object 'parent', with the given component parameters, and with the (optional) label 'label', or the (optional) image 'buttonImage'.  Either 'label' or 'buttonImage' can be used, but not both.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewCanvas(objectKey parent, int width, int height, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new canvas component, to be placed inside the parent object 'parent', using the supplied width and height, with the given component parameters.  Canvas components are areas which will allow drawing operations, for example to show line drawings or unique graphical elements.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewCheckbox(objectKey parent, const char *text, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new checkbox component, to be placed inside the parent object 'parent', using the accompanying text 'text', and with the given component parameters.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewContainer(objectKey parent, const char *name, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new container component, to be placed inside the parent object 'parent', using the name 'name', and with the given component parameters.  Containers are useful for layout when a simple grid is not sufficient.  Each container has its own internal grid layout (for components it contains) and external grid parameters for placing it inside a window or another container.  Containers can be nested arbitrarily.  This allows limitless control over a complex window layout.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewIcon(objectKey parent, image *iconImage, const char *label, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new icon component to be placed inside the parent object 'parent', using the image data structure 'iconImage' and the label 'label', and with the given component parameters 'params'.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewImage(objectKey parent, image *baseImage, drawMode mode, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new image component to be placed inside the parent object 'parent', using the image data structure 'baseImage', and with the given component parameters 'params'.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewList(objectKey parent, windowListType type, int rows, int columns, int multiple, listItemParameters *items, int numItems, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new window list component to be placed inside the parent object 'parent', using the component parameters 'params'.  'type' specifies the type of list (see for possibilities), 'rows' and 'columns' specify the size of the list and layout of the list items, 'multiple' allows multiple selections if non-zero, and 'items' is an array of 'numItems' list item parameters.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewListItem(objectKey parent, listItemParameters *item, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new list item component to be placed inside the parent object 'parent', using the list item parameters 'item', and the component parameters 'params'.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewMenu(objectKey parent, const char *name, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new menu component to be placed inside the parent object 'parent', using the name 'name' (which will be the header of the menu) and the component parameters 'params', and with the given component parameters 'params'.  A menu component is an instance of a container, typically contains menu item components, and is typically added to a menu bar component.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewMenuBar(objectKey parent, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new menu bar component to be placed inside the parent object 'parent', using the component parameters 'params'.  A menu bar component is an instance of a container, and typically contains menu components.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewMenuItem(objectKey parent, const char *text, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new menu item component to be placed inside the parent object 'parent', using the string 'text' and the component parameters 'params'.  A menu item  component is typically added to menu components, which are in turn added to menu bar components.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewPasswordField(objectKey parent, int columns, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new password field component to be placed inside the parent object 'parent', using 'columns' columns and the component parameters 'params'.  A password field component is a special case of a text field component, and behaves the same way except that typed characters are shown as asterisks (*).
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewProgressBar(objectKey parent, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new progress bar component to be placed inside the parent object 'parent', using the component parameters 'params'.  Use the windowComponentSetData() function to set the percentage of progress.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewRadioButton(objectKey parent, int rows, int columns, char *items[], int numItems, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new radio button component to be placed inside the parent object 'parent', using the component parameters 'params'.  'rows' and 'columns' specify the size and layout of the items, and 'numItems' specifies the number of strings in the array 'items', which specifies the different radio button choices.  The windowComponentSetSelected() and windowComponentGetSelected() functions can be used to get and set the selected item (numbered from zero, in the order they were supplied in 'items').
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewScrollBar(objectKey parent, scrollBarType type, int width, int height, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new scroll bar component to be placed inside the parent object 'parent', with the scroll bar type 'type', and the given component parameters 'params'.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewTextArea(objectKey parent, int columns, int rows, int bufferLines, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new text area component to be placed inside the parent object 'parent', with the given component parameters 'params'.  The 'columns' and 'rows' are the visible portion, and 'bufferLines' is the number of extra lines of scrollback memory.  If 'font' is NULL, the default font will be used.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewTextField(objectKey parent, int columns, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new text field component to be placed inside the parent object 'parent', using the number of columns 'columns' and with the given component parameters 'params'.  Text field components are essentially 1-line 'text area' components.  If the params 'font' is NULL, the default font will be used.
  </font>
</p></blockquote>
<p><font face="Courier">objectKey windowNewTextLabel(objectKey parent, const char *text, componentParameters *params) </font></p>
<blockquote>
  <p><font face="Arial">Get a new text labelComponent to be placed inside the parent object 'parent', with the given component parameters 'params', and using the text string 'text'.  If the params 'font' is NULL, the default font will be used.
  </font>
</p></blockquote>
<p><font face="Courier">void windowDebugLayout(objectKey window) </font></p>
<blockquote>
  <p><font face="Arial">This function draws grid boxes around all the grid cells containing components (or parts thereof)
  </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p><b>
<font face="Arial"><a name="user"></a>User functions</font></b></p>

<p><font face="Courier">int userAuthenticate(const char *name, const char *password) </font></p>
<blockquote>
  <p><font face="Arial">Given the user 'name', return 0 if 'password' is the correct password.
  </font>
</p></blockquote>
<p><font face="Courier">int userLogin(const char *name, const char *password) </font></p>
<blockquote>
  <p><font face="Arial">Log the user 'name' into the system, using the password 'password'.  Calling this function requires supervisor privilege level.
  </font>
</p></blockquote>
<p><font face="Courier">int userLogout(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Log the user 'name' out of the system.  This can only be called by a process with supervisor privilege, or one running as the same user being logged out.
  </font>
</p></blockquote>
<p><font face="Courier">int userGetNames(char *buffer, unsigned bufferSize) </font></p>
<blockquote>
  <p><font face="Arial">Fill the buffer 'buffer' with the names of all users, up to 'bufferSize' bytes.
  </font>
</p></blockquote>
<p><font face="Courier">int userAdd(const char *name, const char *password) </font></p>
<blockquote>
  <p><font face="Arial">Add the user 'name' with the password 'password'
  </font>
</p></blockquote>
<p><font face="Courier">int userDelete(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Delete the user 'name' </font>
</p></blockquote>
<p><font face="Courier">int userSetPassword(const char *name, const char *oldPass, const char *newPass) </font></p>
<blockquote>
  <p><font face="Arial">Set the password of user 'name'.  If the calling program is not supervisor privilege, the correct old password must be supplied in 'oldPass'.  The new password is supplied in 'newPass'.
  </font>
</p></blockquote>
<p><font face="Courier">int userGetPrivilege(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Get the privilege level of the user represented by 'name'.
  </font>
</p></blockquote>
<p><font face="Courier">int userGetPid(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the process ID of the current user's 'login process'.
  </font>
</p></blockquote>
<p><font face="Courier">int userSetPid(const char *name, int pid) </font></p>
<blockquote>
  <p><font face="Arial">Set the login PID of user 'name' to 'pid'.  This is the process that gets killed when the user indicates that they want to logout.  In graphical mode this will typically be the PID of the window shell pid, and in text mode it will be the PID of the login VSH shell.
  </font>
</p></blockquote>
<p><font face="Courier">int userFileAdd(const char *passFile, const char *userName, const char *password) </font></p>
<blockquote>
  <p><font face="Arial">Add a user to the designated password file, with the given name and password.  This can only be done by a privileged user.
  </font>
</p></blockquote>
<p><font face="Courier">int userFileDelete(const char *passFile, const char *userName) </font></p>
<blockquote>
  <p><font face="Arial">Remove a user from the designated password file.  This can only be done by a privileged user
  </font>
</p></blockquote>
<p><font face="Courier">int userFileSetPassword(const char *passFile, const char *userName, const char *oldPass, const char *newPass) </font></p>
<blockquote>
  <p><font face="Arial">Set the password of user 'userName' in the designated password file.  If the calling program is not supervisor privilege, the correct old password must be supplied in 'oldPass'.  The new password is supplied in 'newPass'.
  </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>

<p><b>
<font face="Arial"><a name="network"></a>Network functions</font></b></p>

<p><font face="Courier">int networkDeviceGetCount(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns the count of network devices </font>
</p></blockquote>
<p><font face="Courier">int networkDeviceGet(const char *name, networkDevice *dev) </font></p>
<blockquote>
  <p><font face="Arial">Returns the user-space portion of the requested (by 'name') network device in 'dev'.
  </font>
</p></blockquote>
<p><font face="Courier">int networkInitialized(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns 1 if networking is currently enabled.
  </font>
</p></blockquote>
<p><font face="Courier">int networkInitialize(void) </font></p>
<blockquote>
  <p><font face="Arial">Initialize and start networking. </font>
</p></blockquote>
<p><font face="Courier">int networkShutdown(void) </font></p>
<blockquote>
  <p><font face="Arial">Shut down networking. </font>
</p></blockquote>
<p><font face="Courier">objectKey networkOpen(int mode, networkAddress *address, networkFilter *filter) </font></p>
<blockquote>
  <p><font face="Arial">Opens a connection for network communication.  The 'type' and 'mode' arguments describe the kind of connection to make (see possiblilities in the file .  If applicable, 'address' specifies the network address of the remote host to connect to.  If applicable, the 'localPort' and 'remotePort' arguments specify the TCP/UDP ports to use.
  </font>
</p></blockquote>
<p><font face="Courier">int networkClose(objectKey connection) </font></p>
<blockquote>
  <p><font face="Arial">Close the specified, previously-opened network connection.
  </font>
</p></blockquote>
<p><font face="Courier">int networkCount(objectKey connection) </font></p>
<blockquote>
  <p><font face="Arial">Given a network connection, return the number of bytes currently pending in the input stream
  </font>
</p></blockquote>
<p><font face="Courier">int networkRead(objectKey connection, unsigned char *buffer, unsigned bufferSize) </font></p>
<blockquote>
  <p><font face="Arial">Given a network connection, a buffer, and a buffer size, read up to 'bufferSize' bytes (or the number of bytes available in the connection's input stream) and return the number read.  The connection must be initiated using the networkConnectionOpen() function.
  </font>
</p></blockquote>
<p><font face="Courier">int networkWrite(objectKey connection, unsigned char *buffer, unsigned bufferSize) </font></p>
<blockquote>
  <p><font face="Arial">Given a network connection, a buffer, and a buffer size, write up to 'bufferSize' bytes from 'buffer' to the connection's output.  The connection must be initiated using the networkConnectionOpen() function.
  </font>
</p></blockquote>
<p><font face="Courier">int networkPing(objectKey connection, int seqNum, unsigned char *buffer, unsigned bufferSize) </font></p>
<blockquote>
  <p><font face="Arial">Send an ICMP "echo request" packet to the host at the network address 'destAddress', with the (optional) sequence number 'seqNum'.  The 'buffer' and 'bufferSize' arguments point to the location of data to send in the ping packet.  The content of the data is mostly irrelevant, except that it can be checked to ensure the same data is returned by the ping reply from the remote host.
  </font>
</p>
  <p>&nbsp;</p></blockquote>
      <p></p>
      <p></p>

<p><b>
<font face="Arial"><a name="miscellaneous"></a>Miscellaneous functions</font></b></p>

  
<p><font face="Courier">int fontGetDefault(objectKey *pointer) </font></p>
<blockquote>
  <p><font face="Arial">Get an object key in 'pointer' to refer to the current default font.
  </font>
</p></blockquote>
<p><font face="Courier">int fontSetDefault(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Set the default font for the system to the font with the name 'name'.  The font must previously have been loaded by the system, for example using the fontLoad()  function.
  </font>
</p></blockquote>
<p><font face="Courier">int fontLoad(const char* filename, const char *fontname, objectKey *pointer, int fixedWidth) </font></p>
<blockquote>
  <p><font face="Arial">Load the font from the font file 'filename', give it the font name 'fontname' for future reference, and return an object key for the font in 'pointer' if successful.  The integer 'fixedWidth' argument should be non-zero if you want each character of the font to have uniform width (i.e. an 'i' character will be padded with empty space so that it takes up the same width as, for example, a 'W' character).
  </font>
</p></blockquote>
<p><font face="Courier">int fontGetPrintedWidth(objectKey font, const char *string) </font></p>
<blockquote>
  <p><font face="Arial">Given the supplied string, return the screen width that the text will consume given the font 'font'.  Useful for placing text when using a variable-width font, but not very useful otherwise.
  </font>
</p></blockquote>
<p><font face="Courier">int imageLoad(const char *filename, int width, int height, image *loadImage) </font></p>
<blockquote>
  <p><font face="Arial">Try to load the bitmap image file 'filename' (with the specified 'width' and 'height' if possible -- zeros indicate no preference), and if successful, save the data in the image data structure 'loadImage'.
  </font>
</p></blockquote>
<p><font face="Courier">int imageSave(const char *filename, int format, image *saveImage) </font></p>
<blockquote>
  <p><font face="Arial">Save the image data structure 'saveImage' using the image format 'format' to the file 'fileName'.  Image format codes are found in the file
  </font>
</p></blockquote>
<p><font face="Courier">int shutdown(int reboot, int nice) </font></p>
<blockquote>
  <p><font face="Arial">Shut down the system.  If 'reboot' is non-zero, the system will reboot.  If 'nice' is zero, the shutdown will be orderly and will abort if serious errors are detected.  If 'nice' is non-zero, the system will go down like a kamikaze regardless of errors.
  </font>
</p></blockquote>
<p><font face="Courier">const char *version(void) </font></p>
<blockquote>
  <p><font face="Arial">Get the kernel's version string. </font>
</p></blockquote>
<p><font face="Courier">int encryptMD5(const char *in, char *out) </font></p>
<blockquote>
  <p><font face="Arial">Given the input string 'in', return the encrypted numerical message digest in the buffer 'out'.
  </font>
</p></blockquote>
<p><font face="Courier">int lockGet(lock *getLock) </font></p>
<blockquote>
  <p><font face="Arial">Get an exclusive lock based on the lock structure 'getLock'.
  </font>
</p></blockquote>
<p><font face="Courier">int lockRelease(lock *relLock) </font></p>
<blockquote>
  <p><font face="Arial">Release a lock on the lock structure 'lock' previously obtained with a call to the lockGet() function.
  </font>
</p></blockquote>
<p><font face="Courier">int lockVerify(lock *verLock) </font></p>
<blockquote>
  <p><font face="Arial">Verify that a lock on the lock structure 'verLock' is still valid.  This can be useful for retrying a lock attempt if a previous one failed; if the process that was previously holding the lock has failed, this will release the lock.
  </font>
</p></blockquote>
<p><font face="Courier">int variableListCreate(variableList *list) </font></p>
<blockquote>
  <p><font face="Arial">Set up a new variable list structure. </font>
</p></blockquote>
<p><font face="Courier">int variableListDestroy(variableList *list) </font></p>
<blockquote>
  <p><font face="Arial">Deallocate a variable list structure previously allocated by a call to variableListCreate() or configurationReader()
  </font>
</p></blockquote>
<p><font face="Courier">int variableListGet(variableList *list, const char *var, char *buffer, unsigned buffSize) </font></p>
<blockquote>
  <p><font face="Arial">Get the value of the variable 'var' from the variable list 'list' in the buffer 'buffer', up to 'buffSize' bytes.
  </font>
</p></blockquote>
<p><font face="Courier">int variableListSet(variableList *list, const char *var, const char *value) </font></p>
<blockquote>
  <p><font face="Arial">Set the value of the variable 'var' to the value 'value'.
  </font>
</p></blockquote>
<p><font face="Courier">int variableListUnset(variableList *list, const char *var) </font></p>
<blockquote>
  <p><font face="Arial">Remove the variable 'var' from the variable list 'list'.
  </font>
</p></blockquote>
<p><font face="Courier">int configurationReader(const char *fileName, variableList *list) </font></p>
<blockquote>
  <p><font face="Arial">Read the contents of the configuration file 'fileName', and return the data in the variable list structure 'list'.  Configuration files are simple properties files, consisting of lines of the format "variable=value"
  </font>
</p></blockquote>
<p><font face="Courier">int configurationWriter(const char *fileName, variableList *list) </font></p>
<blockquote>
  <p><font face="Arial">Write the contents of the variable list 'list' to the configuration file 'fileName'.  Configuration files are simple properties files, consisting of lines of the format "variable=value".  If the configuration file already exists, the configuration writer will attempt to preserve comment lines (beginning with '#') and formatting whitespace.
  </font>
</p></blockquote>
<p><font face="Courier">int keyboardGetMaps(char *buffer, unsigned size) </font></p>
<blockquote>
  <p><font face="Arial">Get a listing of the names of all available keyboard mappings.  The buffer is filled up to 'size' bytes with descriptive names, such as "English (UK)".  Each string is NULL-terminated, and the return value of the call is the number of strings copied.  The first string returned is the current map.
  </font>
</p></blockquote>
<p><font face="Courier">int keyboardSetMap(const char *name) </font></p>
<blockquote>
  <p><font face="Arial">Set the keyboard mapping to the supplied 'name'.  The normal procedure would be to first call the keyboardGetMaps() function, get the list of supported mappings, and then call this function with one of those names.  Only a name returned by the keyboardGetMaps function is valid in this scenario.
  </font>
</p></blockquote>
<p><font face="Courier">int deviceTreeGetCount(void) </font></p>
<blockquote>
  <p><font face="Arial">Returns the number of devices in the kernel's device tree.
  </font>
</p></blockquote>
<p><font face="Courier">int deviceTreeGetRoot(device *rootDev) </font></p>
<blockquote>
  <p><font face="Arial">Returns the user-space portion of the device tree root device in the structure 'rootDev'.
  </font>
</p></blockquote>
<p><font face="Courier">int deviceTreeGetChild(device *parentDev, device *childDev) </font></p>
<blockquote>
  <p><font face="Arial">Returns the user-space portion of the first child device of 'parentDev' in the structure 'childDev'.
  </font>
</p></blockquote>
<p><font face="Courier">int deviceTreeGetNext(device *siblingDev) </font></p>
<blockquote>
  <p><font face="Arial">Returns the user-space portion of the next sibling device of the supplied device 'siblingDev' in the same data structure.
  </font>
</p></blockquote>
<p><font face="Courier">int 
mouseLoadPointer(const char *pointerName, const char *fileName) </font></p>
<blockquote>
  <p><font face="Arial">Tells the mouse driver code to load the mouse pointer 'pointerName' from the file 'fileName'.
  </font>
</p></blockquote>
<p><font face="Courier">int mouseSwitchPointer(const char *pointerName) </font></p>
<blockquote>
  <p><font face="Arial">Tells the mouse driver code to switch to the mouse pointer with the given name (as specified by the pointer name argument to mouseLoadPointer).</font></p>
      </blockquote>

  
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