<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Visopsys | Visual Operating System | Kernel API 0.4</title>
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
      <td><font face="Arial"><b>THE VISOPSYS KERNEL API (Version 0.4)<br>
</b>(version 0.3 is <a href="kernel_API_0.3.php">here</a>)</font><p>
      <font face="Arial">All of the kernel's functions are defined in the file 
/system/headers/sys/api.h. In future, this file may be split into smaller 
chunks, by functional area. Data structures referred to in these function 
definitions are found in header files in the /system/headers/sys directory. For 
example, a 'disk' object is defined in /system/headers/sys/disk.h.</font></p>
<blockquote>
  <p align="left"><font face="Arial"><i>One note on the 'objectKey' type used by many of these 
  functions: This is used to refer to data structures in kernel memory that are 
  not accessible (in a practical sense) to external programs. Yes, it's a 
  pointer -- A pointer to a structure that is probably defined in one of the 
  kernel header files. You could try to use it as more than just a reference 
  key, but you would do so at your own risk.</i></font></p>
</blockquote>
<p><font face="Arial">Here is the breakdown of functions divided by functional area:</font></p>
<p><font face="Arial"><a href="kernel_API_0.4.php#text">Text input/output functions</a><br>
<a href="kernel_API_0.4.php#disk">Disk functions</a><br>
<a href="kernel_API_0.4.php#filesystem">Filesystem functions</a><br>
<a href="kernel_API_0.4.php#file">File functions</a><br>
<a href="kernel_API_0.4.php#memory">Memory functions</a><br>
<a href="kernel_API_0.4.php#multitasker">Multitasker functions</a><br>
<a href="kernel_API_0.4.php#loader">Loader functions</a><br>
<a href="kernel_API_0.4.php#rtc">Real-time clock functions</a><br>
<a href="kernel_API_0.4.php#random">Random number functions</a><br>
<a href="kernel_API_0.4.php#environment">Environment functions</a><br>
<a href="kernel_API_0.4.php#graphics">Raw graphics functions</a><br>
<a href="kernel_API_0.4.php#window">Window manager functions</a><br>
<a href="kernel_API_0.4.php#user">User functions</a><br>
<a href="kernel_API_0.4.php#miscellaneous">Miscellaneous functions</a></font></p>
<p>&nbsp;</p>
<p></p>
<p><b><a name="text"></a>Text input/output functions</b></p>
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
<p><font face="Courier New">int textGetForeground(void)
</font></p>
<blockquote>
  <p>Get the current foreground color as an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC built-in color value.  Here is a listing: 0=Black, 4=Red, 8=Dark gray, 12=Light red,  1=Blue, 5=Magenta, 9=Light blue, 13=Light magenta, 2=Green, 6=Brown, 10=Light green, 14=Yellow, 3=Cyan, 7=Light gray, 11=Light cyan, 15=White
</p></blockquote>
<p><font face="Courier New">int textSetForeground(int foreground)
</font></p>
<blockquote>
  <p>Set the current foreground color from an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC builtin color value.  See chart above.
</p></blockquote>
<p><font face="Courier New">int textGetBackground(void)
</font></p>
<blockquote>
  <p>Get the current background color as an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC builtin color value.  See chart above.
</p></blockquote>
<p><font face="Courier New">int textSetBackground(int background)
</font></p>
<blockquote>
  <p>Set the current foreground color from an int value.  Currently this is only applicable in text mode, and the color value should be treated as a PC builtin color value.  See chart above.
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
<p><font face="Courier New">int textScreenSave(void)
</font></p>
<blockquote>
  <p>Save the current screen in an internal buffer.  Use with the textScreenRestore function.
</p></blockquote>
<p><font face="Courier New">int textScreenRestore(void)
</font></p>
<blockquote>
  <p>Restore the screen previously saved with the textScreenSave function
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
  <p>&nbsp;
</p>
<p><b><a name="disk"></a>Disk functions</b></p>
<p><font face="Courier New">int diskReadPartitions(void)
</font></p>
<blockquote>
  <p>Tells the kernel to (re)read the disk partition tables.
</p></blockquote>
<p><font face="Courier New">int diskSync(void)
</font></p>
<blockquote>
  <p>Tells the kernel to synchronize all the disks, flushing any output.
</p></blockquote>
<p><font face="Courier New">int diskGetBoot(char *name)
</font></p>
<blockquote>
  <p>Get the disk name of the boot device.  Normally this will contain the root filesystem.
</p></blockquote>
<p><font face="Courier New">int diskGetReadOnly(const char *name)
</font></p>
<blockquote>
  <p>Returns 1 if the supplied disk name is a read-only device, media, or filesystem
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
<p><font face="Courier New">int diskGetInfo(disk *d)
</font></p>
<blockquote>
  <p>Get information about the logical disk volume named by the disk structure's 'name' field and fill in the remainder of the disk structure d.
</p></blockquote>
<p><font face="Courier New">int diskGetPhysicalInfo(disk *d)
</font></p>
<blockquote>
  <p>Get information about the physical disk device named by the disk structure's 'name' field and fill in the remainder of the disk structure d.
</p></blockquote>
<p><font face="Courier New">int diskGetPartType(int code, partitionType *p)
</font></p>
<blockquote>
  <p>Gets the partition type data for the corresponding code.  This function was added specifically by use by programs such as 'fdisk' to get descriptions of different types known to the kernel.
</p></blockquote>
<p><font face="Courier New">partitionType *diskGetPartTypes(void)
</font></p>
<blockquote>
  <p>Like diskGetPartType(), but returns a pointer to a list of all known types.
</p></blockquote>
<p><font face="Courier New">int diskSetDoorState(const char *name, int state)
</font></p>
<blockquote>
  <p>Set the locked state of the disk 'name' to either unlocked (0) or locked (1)
</p></blockquote>
<p><font face="Courier New">int diskReadSectors(const char *name, unsigned sect, unsigned count, void *buf)
</font></p>
<blockquote>
  <p>Read 'count' sectors from disk 'name', starting at (zero-based) logical sector number 'sect'.  Put the data in memory area 'buf'.
</p></blockquote>
<p><font face="Courier New">int diskWriteSectors(const char *name, unsigned sect, unsigned count, void *buf)
</font></p>
<blockquote>
  <p>Write 'count' sectors to disk 'name', starting at (zero-based) logical sector number 'sect'.  Get the data from memory area 'buf'.
</p></blockquote>
<p><font face="Courier New">int diskReadAbsoluteSectors(const char *name, unsigned sect, unsigned count, void *buf)
</font></p>
<blockquote>
  <p>Read 'count' sectors from disk 'name', starting at (zero-based) absolute sector number 'sect'.  Put the data in memory area 'buf'.  This function requires supervisor privilege and is used to read outside the logical confines of a volume, such as a hard disk partition.  Not very useful unless you know what you're doing.
</p></blockquote>
<p><font face="Courier New">int diskWriteAbsoluteSectors(const char *name, unsigned sect, unsigned count, void *buf)
</font></p>
<blockquote>
  <p>Write 'count' sectors to disk 'name', starting at (zero-based) absolute sector number 'sect'.  Get the data from memory area 'buf'.  This function requires supervisor privilege and is used to write outside the logical confines of a volume, such as a hard disk partition.  Don't use this unless you know what you're doing.
</p></blockquote>
<p>&nbsp;</p>
<p><b><a name="filesystem"></a>Filesystem functions</b></p>
<p><font face="Courier New">int filesystemFormat(const char *disk, const char *type, const char *label, int
longFormat)
</font></p>
<blockquote>
  <p>Format the logical volume 'disk', with a string 'type' representing the preferred filesystem type (for example, "fat", "fat16", "fat32, etc).  Label it with 'label'.  'longFormat' will do a sector-by-sector format, if supported.  It is optional for filesystem drivers to implement this function.
</p></blockquote>
<p><font face="Courier New">int filesystemCheck(const char *name, int force, int repair)
</font></p>
<blockquote>
  <p>Check the filesystem on disk 'name'.  If 'force' is non-zero, the filesystem will be checked regardless of whether the filesystem driver thinks it needs to be.  If 'repair' is non-zero, the filesystem driver will attempt to repair any errors found.  If 'repair' is zero, a non-zero return value may indicate that errors were found.  If 'repair' is non-zero, a non-zero return value may indicate that errors were found but could not be fixed.  It is optional for filesystem drivers to implement this function.
</p></blockquote>
<p><font face="Courier New">int filesystemDefragment(const char *name)
</font></p>
<blockquote>
  <p>Defragment the filesystem on disk 'name'.  It is optional for filesystem drivers to implement this function.
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
<p><font face="Courier New">int filesystemNumberMounted(void)
</font></p>
<blockquote>
  <p>Returns the number of filesystems currently mounted.
</p></blockquote>
<p><font face="Courier New">int filesystemGetFree(const char *fs)
</font></p>
<blockquote>
  <p>Returns the amount of free space on the filesystem represented by the mount point 'fs'.
</p></blockquote>
<p><font face="Courier New">unsigned int filesystemGetBlockSize(const char *fs)
</font></p>
<blockquote>
  <p>Returns the block size (for example, 512 or 1024) of the filesystem represented by the mount point 'fs'.
</p></blockquote>
<p>&nbsp;</p>
<p><b><a name="file"></a>File functions</b></p>
<p>Note that in all of the functions of this section, any 
reference to pathnames means absolute pathnames, from root. E.g. '/files/myfile', 
not simply 'myfile'. From the kernel's point of view, 'myfile' might be 
ambiguous.</p>
<p><font face="Courier New">int fileFixupPath(const char *orig, char *new)
</font></p>
<blockquote>
  <p>Take the absolute pathname in 'orig' and fix it up.  This means eliminating extra file separator characters (for example) and resolving links or '.' or '..' components in the pathname.
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
<p><font face="Courier New">int fileRead(file *f, unsigned int blocknum, unsigned int blocks, unsigned char *buff)
</font></p>
<blockquote>
  <p>Read data from the previously opened file 'f'.  'f' should have been opened in a read or read/write mode.  Read 'blocks' blocks (see the filesystem functions for information about getting the block size of a given filesystem) and put them in buffer 'buff'.
</p></blockquote>
<p><font face="Courier New">int fileWrite(file *f, unsigned blocknum, unsigned blocks, unsigned char *buff)
</font></p>
<blockquote>
  <p>Write data to the previously opened file 'f'.  'f' should have been opened in a write or read/write mode.  Write 'blocks' blocks (see the filesystem functions for information about getting the block size of a given filesystem) from the buffer 'buff'.
</p></blockquote>
<p><font face="Courier New">int fileDelete(const char *name)
</font></p>
<blockquote>
  <p>Delete the file referenced by the pathname 'name'.
</p></blockquote>
<p><font face="Courier New">int fileDeleteSecure(const char *name)
</font></p>
<blockquote>
  <p>Securely delete the file referenced by the pathname 'name'.  If supported.
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
<p><font face="Courier New">int fileStreamOpen(const char *name, int mode, fileStream *f)
</font></p>
<blockquote>
  <p>Open the file referenced by the pathname 'name' for streaming operations, using the open mode 'mode' (defined in <sys/file.h>).  Fills the fileStream data structure 'f' with information needed for subsequent filestream operations.
</p></blockquote>
<p><font face="Courier New">int fileStreamSeek(fileStream *f, int offset)
</font></p>
<blockquote>
  <p>Seek the filestream 'f' to the absolute position 'offset'
</p></blockquote>
<p><font face="Courier New">int fileStreamRead(fileStream *f, int bytes, char *buff)
</font></p>
<blockquote>
  <p>Read 'bytes' bytes from the filestream 'f' and put them into 'buff'.
</p></blockquote>
<p><font face="Courier New">int fileStreamReadLine(fileStream *f, int bytes, char *buff)
</font></p>
<blockquote>
  <p>Read a complete line of text from the filestream 'f', and put up to 'bytes' characters into 'buff'
</p></blockquote>
<p><font face="Courier New">int fileStreamWrite(fileStream *f, int bytes, char *buff)
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
<p>&nbsp;</p>
<p><b><a name="memory"></a>Memory functions</b></p>
<p><font face="Courier New">void memoryPrintUsage(int kernel)
</font></p>
<blockquote>
  <p>Prints the current memory usage statistics to the current output stream.  If non-zero, the flag 'kernel' will show usage of kernel dynamic memory as well.
</p></blockquote>
<p><font face="Courier New">void *memoryGet(unsigned size, const char *desc)
</font></p>
<blockquote>
  <p>Return a pointer to a new block of memory of size 'size' and (optional) physical alignment 'align', adding the (optional) description 'desc'.  If no specific alignment is required, use '0'.  Memory allocated using this function is automatically cleared (like 'calloc').
</p></blockquote>
<p><font face="Courier New">void *memoryGetPhysical(unsigned size, unsigned align, const char *desc)
</font></p>
<blockquote>
  <p>Return a pointer to a new physical block of memory of size 'size' and (optional) physical alignment 'align', adding the (optional) description 'desc'.  If no specific alignment is required, use '0'.  Memory allocated using this function is NOT automatically cleared.  'Physical' refers to an actual physical memory address, and is not necessarily useful to external programs.
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
<p><font face="Courier New">int memoryChangeOwner(int opid, int npid, void *addr, void **naddr)
</font></p>
<blockquote>
  <p>Change the ownership of an allocated block of memory beginning at address 'addr'.  'opid' is the process ID of the currently owning process, and 'npid' is the process ID of the intended new owner.  'naddr' is filled with the new address of the memory (since it changes address spaces in the process).  Note that only a privileged process can change memory ownership.
</p></blockquote>
<p>&nbsp;</p>
<p><b><a name="multitasker"></a>Multitasker functions</b></p>
<p><font face="Courier New">int multitaskerCreateProcess(void *addr, unsigned int size, const char *name, int numargs, void *args)
</font></p>
<blockquote>
  <p>Create a new process.  The code should have been loaded at the address 'addr' and be of size 'size'.  'name' will be the new process' name.  'numargs' and 'args' will be passed as the "int argc, char *argv[]) parameters of the new process.  If there are no arguments, these should be 0 and NULL, respectively.  If the value returned by the call is a positive integer, the call was successful and the value is the new process' process ID.  New processes are created and left in a stopped state, so if you want it to run you will need to set it to a running state ('ready', actually) using the function call multitaskerSetProcessState().
</p></blockquote>
<p><font face="Courier New">int multitaskerSpawn(void *addr, const char *name, int numargs, void *args)
</font></p>
<blockquote>
  <p>Spawn a thread from the current process.  The starting point of the code (for example, a function address) should be specified as 'addr'.  'name' will be the new thread's name.  'numargs' and 'args' will be passed as the "int argc, char *argv[]) parameters of the new thread.  If there are no arguments, these should be 0 and NULL, respectively.  If the value returned by the call is a positive integer, the call was successful and the value is the new thread's process ID.  New threads are created and left in a stopped state, so if you want it to run you will need to set it to a running state ('ready', actually) using the function call multitaskerSetProcessState().
</p></blockquote>
<p><font face="Courier New">int multitaskerGetCurrentProcessId(void)
</font></p>
<blockquote>
  <p>Returns the process ID of the calling program.
</p></blockquote>
<p><font face="Courier New">int multitaskerGetProcessOwner(int pid)
</font></p>
<blockquote>
  <p>Returns the user ID of the user that owns the process referenced by process ID 'pid'.
</p></blockquote>
<p><font face="Courier New">const char *multitaskerGetProcessName(int pid)
</font></p>
<blockquote>
  <p>Returns the process name of the process referenced by process ID 'pid'.
</p></blockquote>
<p><font face="Courier New">int multitaskerGetProcessState(int pid, int *statep)
</font></p>
<blockquote>
  <p>Gets the state of the process referenced by process ID 'pid'.  Puts the result in 'statep'.
</p></blockquote>
<p><font face="Courier New">int multitaskerSetProcessState(int pid, int state)
</font></p>
<blockquote>
  <p>Sets the state of the process referenced by process ID 'pid' to the new state 'state'.
</p></blockquote>
<p><font face="Courier New">int multitaskerGetProcessPriority(int pid)
</font></p>
<blockquote>
  <p>Gets the priority of the process referenced by process ID 'pid'.
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
<p><font face="Courier New">int multitaskerSetCurrentDirectory(char *buff)
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
<p><font face="Courier New">void multitaskerWait(unsigned int ticks)
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
<p><font face="Courier New">int multitaskerTerminate(int code)
</font></p>
<blockquote>
  <p>Terminate the calling process, returning the exit code 'code'
</p></blockquote>
<p><font face="Courier New">void multitaskerDumpProcessList(void)
</font></p>
<blockquote>
  <p>Print a listing of all current processes to the current text output stream.  Might not be the current output stream of the calling process, but rather the console output stream.  This could be considered a bug, but is more of a "currently necessary peculiarity".
</p></blockquote>
<p>&nbsp;</p>
<p><b><a name="loader"></a>Loader functions</b></p>
<p><font face="Courier New">void *loaderLoad(const char *filename, file *theFile)
</font></p>
<blockquote>
  <p>Load a file referenced by the pathname 'filename', and fill the file data structure 'theFile' with the details.  The pointer returned points to the resulting file data.
</p></blockquote>
<p><font face="Courier New">int loaderLoadProgram(const char *userProgram, int privilege, int argc, char *argv[])
</font></p>
<blockquote>
  <p>Load the file referenced by the pathname 'userProgram' as a process with the privilege level 'privilege'.  Pass the arguments 'argc' and 'argv'.  If there are no arguments, these should be 0 and NULL, respectively.  If successful, the call's return value is the process ID of the new process.  The process is left in a stopped state and must be set to a running state explicitly using the multitasker function multitaskerSetProcessState() or the loader function loaderExecProgram().
</p></blockquote>
<p><font face="Courier New">int loaderExecProgram(int processId, int block)
</font></p>
<blockquote>
  <p>Execute the process referenced by process ID 'processId'.  If 'block' is non-zero, the calling process will block until process 'pid' has terminated, and the return value of the call is the return value of process 'pid'.
</p></blockquote>
<p><font face="Courier New">int loaderLoadAndExec(const char *name, int privilege, int argc, char *argv[], int block)
</font></p>
<blockquote>
  <p>This function is just for convenience, and is an amalgamation of the loader functions loaderLoadProgram() and  loaderExecProgram().
</p></blockquote>
<p>&nbsp;</p>
<p><b><a name="rtc"></a>Real-time clock functions</b></p>
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
<p><font face="Courier New">unsigned int rtcUptimeSeconds(void)
</font></p>
<blockquote>
  <p>Get the number of seconds the system has been running.
</p></blockquote>
<p><font face="Courier New">int rtcDateTime(struct tm *time)
</font></p>
<blockquote>
  <p>Get the current data and time as a tm data structure in 'time'.
</p></blockquote>
<p>&nbsp;</p>
<p><b><a name="random"></a>Random number functions</b></p>
<p><font face="Courier New">unsigned int randomUnformatted(void)
</font></p>
<blockquote>
  <p>Get an unformatted random unsigned number.  Just any unsigned number.
</p></blockquote>
<p><font face="Courier New">unsigned int randomFormatted(unsigned int start, unsigned int end)
</font></p>
<blockquote>
  <p>Get a random unsigned number between the start value 'start' and the end value 'end', inclusive.
</p></blockquote>
<p><font face="Courier New">unsigned int randomSeededUnformatted(unsigned int seed)
</font></p>
<blockquote>
  <p>Get an unformatted random unsigned number, using the random seed 'seed' instead of the kernel's default random seed.
</p></blockquote>
<p><font face="Courier New">unsigned int randomSeededFormatted(unsigned int seed, unsigned int start, unsigned int end)
</font></p>
<blockquote>
  <p>Get a random unsigned number between the start value 'start' and the end value 'end', inclusive, using the random seed 'seed' instead of the kernel's default random seed.
</p></blockquote>
<p>&nbsp;</p>
<p><b><a name="environment"></a>Environment functions</b></p>
<p><font face="Courier New">int environmentGet(const char *var, char *buf, unsigned int bufsz)
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
<p>&nbsp;</p>
<p><b><a name="graphics"></a>Raw graphics functions</b></p>
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
<p><font face="Courier New">unsigned graphicGetScreenWidth(void)
</font></p>
<blockquote>
  <p>Returns the width of the graphics screen.
</p></blockquote>
<p><font face="Courier New">unsigned graphicGetScreenHeight(void)
</font></p>
<blockquote>
  <p>Returns the height of the graphics screen.
</p></blockquote>
<p><font face="Courier New">unsigned graphicCalculateAreaBytes(unsigned width, unsigned height)
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
<p><font face="Courier New">int graphicDrawRect(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord, unsigned width, unsigned height, unsigned thickness, int fill)
</font></p>
<blockquote>
  <p>Draw a rectangle into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width', the height 'height', the line thickness 'thickness' and the fill value 'fill'.  Non-zero fill value means fill the rectangle.   If 'buffer' is NULL, draw directly onto the screen.
</p></blockquote>
<p><font face="Courier New">int graphicDrawOval(objectKey buffer, color *foreground, drawMode mode, int xCoord, int yCoord, unsigned width, unsigned height, unsigned thickness, int fill)
</font></p>
<blockquote>
  <p>Draw an oval (circle, whatever) into the graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width', the height 'height', the line thickness 'thickness' and the fill value 'fill'.  Non-zero fill value means fill the oval.   If 'buffer' is NULL, draw directly onto the screen.  Currently not supported by the linear framebuffer graphic driver.
</p></blockquote>
<p><font face="Courier New">int graphicDrawImage(objectKey buffer, image *drawImage, drawMode mode, int xCoord, int yCoord, unsigned xOffset, unsigned yOffset, unsigned width, unsigned height)
</font></p>
<blockquote>
  <p>Draw the image 'drawImage' into the graphic buffer 'buffer', using the drawing mode 'mode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord' and the starting Y coordinate 'yCoord'.   The 'xOffset' and 'yOffset' parameters specify an offset into the image to start the drawing (0, 0 to draw the whole image).  Similarly the 'width' and 'height' parameters allow you to specify a portion of the image (0, 0 to draw the whole image -- minus any X or Y offsets from the previous parameters).  So, for example, to draw only the middle pixel of a 3x3 image, you would specify xOffset=1, yOffset=1, width=1, height=1.  If 'buffer' is NULL, draw directly onto the screen.
</p></blockquote>
<p><font face="Courier New">int graphicGetImage(objectKey buffer, image *getImage, int xCoord, int yCoord, unsigned width, unsigned height)
</font></p>
<blockquote>
  <p>Grab a new image 'getImage' from the graphic buffer 'buffer', using the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width' and the height 'height'.   If 'buffer' is NULL, grab the image directly from the screen.
</p></blockquote>
<p><font face="Courier New">int graphicDrawText(objectKey buffer, color *foreground, color *background, objectKey font, const char *text, drawMode mode, int xCoord, int yCoord)
</font></p>
<blockquote>
  <p>Draw the text string 'text' into the graphic buffer 'buffer', using the colors 'foreground' and 'background', the font 'font', the drawing mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord'.   If 'buffer' is NULL, draw directly onto the screen.  If 'font' is NULL, use the default font.
</p></blockquote>
<p><font face="Courier New">int graphicCopyArea(objectKey buffer, int xCoord1, int yCoord1, unsigned width, unsigned height, int xCoord2, int yCoord2)
</font></p>
<blockquote>
  <p>Within the graphic buffer 'buffer', copy the area bounded by ('xCoord1', 'yCoord1'), width 'width' and height 'height' to the starting X coordinate 'xCoord2' and the starting Y coordinate 'yCoord2'.  If 'buffer' is NULL, copy directly to and from the screen.
</p></blockquote>
<p><font face="Courier New">int graphicClearArea(objectKey buffer, color *background, int xCoord, int yCoord, unsigned width, unsigned height)
</font></p>
<blockquote>
  <p>Clear the area of the graphic buffer 'buffer' using the background color 'background', using the starting X coordinate 'xCoord', the starting Y coordinate 'yCoord', the width 'width' and the height 'height'.  If 'buffer' is NULL, clear the area directly on the screen.
</p></blockquote>
<p><font face="Courier New">int graphicRenderBuffer(objectKey buffer, int drawX, int drawY, int clipX, int clipY, unsigned clipWidth, unsigned clipHeight)
</font></p>
<blockquote>
  <p>Draw the clip of the buffer 'buffer' onto the screen.  Draw it on the screen at starting X coordinate 'drawX' and starting Y coordinate 'drawY'.  The buffer clip is bounded by the starting X coordinate 'clipX', the starting Y coordinate 'clipY', the width 'clipWidth' and the height 'clipHeight'.  It is not legal for 'buffer' to be NULL in this case.
</p></blockquote>
<p>&nbsp;</p>
<p><b><a name="window"></a>Windowing system functions</b></p>
<p><font face="Courier New">int windowLogin(const char *userName, const char *passwd)
</font></p>
<blockquote>
  <p>Log the user into the window environment with 'userName' and 'passwd'.  The return value is the PID of the window shell for this session.
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
  <p>Destroy the window referenced by the object key 'wndow'
</p></blockquote>
<p><font face="Courier New">int windowUpdateBuffer(void *buffer, int xCoord, int yCoord, unsigned width, unsigned height)
</font></p>
<blockquote>
  <p>Tells the windowing system to redraw the visible portions of the graphic buffer 'buffer', using the given clip coordinates/size.
</p></blockquote>
<p><font face="Courier New">int windowSetTitle(objectKey window, const char *title)
</font></p>
<blockquote>
  <p>Set the new title of window 'window' to be 'title'.
</p></blockquote>
<p><font face="Courier New">int windowGetSize(objectKey window, unsigned *width, unsigned *height)
</font></p>
<blockquote>
  <p>Get the size of the window 'window', and put the results in 'width' and 'height'.
</p></blockquote>
<p><font face="Courier New">int windowSetSize(objectKey window, unsigned width, unsigned height)
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
<p><font face="Courier New">int windowPack(objectKey window)
</font></p>
<blockquote>
  <p>Pack and resize 'window' based on the sizes and parameters of the components it contains.
</p></blockquote>
<p><font face="Courier New">int windowCenter(objectKey window)
</font></p>
<blockquote>
  <p>Center 'window' on the screen.
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
  <p>Tells the windowing system whether to allow 'window' to be resized by the user.
</p></blockquote>
<p><font face="Courier New">int windowSetPacked(objectKey window, int trueFalse)
</font></p>
<blockquote>
  <p>Calling this function with 'trueFalse' set to 1 will set 'window's packed attribute.  Packed windows will automatically resize to the smallest appropriate size based on the sizes and parameters of the components it contains.
</p></blockquote>
<p><font face="Courier New">int windowSetHasCloseButton(objectKey window, int trueFalse)
</font></p>
<blockquote>
  <p>Tells the windowing system whether to draw a close button on the title bar of the window 'window'.  'trueFalse' being non-zero means draw a close button.  Windows have close buttons by default, as long as they have a title bar.  If there is no title bar, then this function has no effect.
</p></blockquote>
<p><font face="Courier New">int windowSetVisible(objectKey window, int visible)
</font></p>
<blockquote>
  <p>Tell the windowing system whether to make the window 'window' visible or not.  Non-zero 'visible' means make the window visible.  When windows are created, they are not visible by default so you can add components, do layout, set the size, etc.
</p></blockquote>
<p><font face="Courier New">int windowAddConsoleTextArea(objectKey window, componentParameters *params)
</font></p>
<blockquote>
  <p>Add a console text area component to 'window' using the supplied componentParameters.  The console text area is where most kernel logging and error messages are sent, particularly at boot time.  Note that there is only one instance of the console text area, and thus it can only exist in one window at a time.  Destroying the window is one way to free the console area to be used in another window.
</p></blockquote>
<p><font face="Courier New">void windowRedrawArea(int xCoord, int yCoord, unsigned width, unsigned height)
</font></p>
<blockquote>
  <p>Tells the windowing system to redraw whatever is supposed to be in the screen area bounded by the supplied coordinates.  This might be useful if you were drawing non-window-based things (i.e., things without their own independent graphics buffer) directly onto the screen and you wanted to restore an area to its original contents.  For example, the mouse driver uses this method to erase the pointer from its previous position.
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
<p><font face="Courier New">int windowTileBackground(const char *file)
</font></p>
<blockquote>
  <p>Load the image file specified by the pathname 'file', and if successful, tile the image on the background root window.
</p></blockquote>
<p><font face="Courier New">int windowCenterBackground(const char *file)
</font></p>
<blockquote>
  <p>Load the image file specified by the pathname 'file', and if successful, center the image on the background root window.
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
<p><font face="Courier New">unsigned windowComponentGetWidth(objectKey component)
</font></p>
<blockquote>
  <p>Get the pixel width of the window component 'component'.
</p></blockquote>
<p><font face="Courier New">int windowComponentSetWidth(objectKey component, unsigned width)
</font></p>
<blockquote>
  <p>Set the pixel width of the window component 'component'
</p></blockquote>
<p><font face="Courier New">unsigned windowComponentGetHeight(objectKey component)
</font></p>
<blockquote>
  <p>Get the pixel height of the window component 'component'.
</p></blockquote>
<p><font face="Courier New">int windowComponentSetHeight(objectKey component, unsigned height)
</font></p>
<blockquote>
  <p>Set the pixel height of the window component 'component'.
</p></blockquote>
<p><font face="Courier New">int windowComponentFocus(objectKey component)
</font></p>
<blockquote>
  <p>Give window component 'component' the focus of its window.
</p></blockquote>
<p><font face="Courier New">int windowComponentDraw(objectKey component)
</font></p>
<blockquote>
  <p>Calls the window component 'component' to redraw itself.
</p></blockquote>
<p><font face="Courier New">int windowComponentGetData(objectKey component, void *buffer, unsigned size)
</font></p>
<blockquote>
  <p>This is a generic call to get data from the window component 'component', up to 'size' bytes, in the buffer 'buffer'.  The size and type of data that a given component will return is totally dependent upon the type and implementation of the component.
</p></blockquote>
<p><font face="Courier New">int windowComponentSetData(objectKey component, void *buffer, unsigned size)
</font></p>
<blockquote>
  <p>This is a generic call to set data in the window component 'component', up to 'size' bytes, in the buffer 'buffer'.  The size and type of data that a given component will use or accept is totally dependent upon the type and implementation of the component.
</p></blockquote>
<p><font face="Courier New">int windowComponentGetSelected(objectKey component)
</font></p>
<blockquote>
  <p>This is a call to get the 'selected' value of the window component 'component'.  The type of value returned depends upon the type of component; a list component, for example, will return the 0-based number of its selected item.  On the other hand, a boolean component such as a checkbox will return 1 if it is currently selected.
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
<p><font face="Courier New">objectKey windowNewCanvas(objectKey parent, unsigned width, unsigned height, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new canvas component, to be placed inside the parent object 'parent', using the supplied width and height, with the given component parameters.  Canvas components are areas which will allow drawing operations, for example to show line drawings or unique graphical elements.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewCheckbox(objectKey parent, objectKey font, const char *text, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new checkbox component, to be placed inside the parent object 'parent', using the font 'cont', the accompanying text 'text', and with the given component parameters.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewContainer(objectKey parent, const char *name, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new container component, to be placed inside the parent object 'parent', using the name 'name', and with the given component parameters.  Containers are useful for layout when a simple grid is not sufficient.  Each container has its own internal grid layout (for components it contains) and external grid parameters for placing it inside a window or another container.  Containers can be nested arbitrarily.  This allows limitless control over a complex window layout.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewIcon(objectKey parent, image *iconImage, const char *label, const char *command, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new icon component to be placed inside the parent object 'parent', using the image data structure 'iconImage' and the label 'label', and with the given component parameters 'params'.  If you want the icon to execute a command when clicked, you should specify it in 'command'.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewImage(objectKey parent, image *baseImage, drawMode mode, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new image component to be placed inside the parent object 'parent', using the image data structure 'baseImage', and with the given component parameters 'params'.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewList(objectKey parent, objectKey font, unsigned rows, unsigned columns, int multiple, char *items[], int numItems, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new window list component to be placed inside the parent object 'parent', using the font 'font' and the component parameters 'params'.  'rows' and 'columns' specify the size of the list and layout of the list items, 'multiple' allows multiple selections if non-zero, and 'numItems' specifies the number of strings in the array 'items' (which is an array of strings to represent the list items)
</p></blockquote>
<p><font face="Courier New">objectKey windowNewListItem(objectKey parent, objectKey font, const char *text, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new list item component to be placed inside the parent object 'parent', using the font 'font', the string 'text', and the component parameters 'params'.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewMenu(objectKey parent, const char *name, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new menu component to be placed inside the parent object 'parent', using the name 'name' (which will be the header of the menu) and the component parameters 'params', and with the given component parameters 'params'.  A menu component is an instance of a container, typically contains menu item components, and is typically added to a menu bar component.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewMenuBar(objectKey parent, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new menu bar component to be placed inside the parent object 'parent', using the component parameters 'params'.  A menu bar component is an instance of a container, and typically contains menu components.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewMenuItem(objectKey parent, const char *text, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new menu item component to be placed inside the parent object 'parent', using the string 'text' and the component parameters 'params'.  A menu item  component is typically added to menu components, which are in turn added to menu bar components.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewPasswordField(objectKey parent, int columns, objectKey font, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new password field component to be placed inside the parent object 'parent', using 'columns' columns, the font 'font' and the component parameters 'params'.  A password field component is a special case of a text field component, and behaves the same way except that typed characters are shown as asterisks (*).
</p></blockquote>
<p><font face="Courier New">objectKey windowNewProgressBar(objectKey parent, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new progress bar component to be placed inside the parent object 'parent', using the component parameters 'params'.  Use the windowComponentSetData() function to set the percentage of progress.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewRadioButton(objectKey parent, objectKey font, unsigned rows, unsigned columns, char *items[], int numItems, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new radio button component to be placed inside the parent object 'parent', using the font 'font' and the component parameters 'params'.  'rows' and 'columns' specify the size and layout of the items, and 'numItems' specifies the number of strings in the array 'items', which specifies the different radio button choices.  The windowComponentSetSelected() and windowComponentGetSelected() functions can be used to get and set the selected item (numbered from zero, in the order they were supplied in 'items').
</p></blockquote>
<p><font face="Courier New">objectKey windowNewTextArea(objectKey parent, int columns, int rows, objectKey font, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new text area component to be placed inside the parent object 'parent', with the given component parameters 'params', and using the number of columns 'columns', the number of rows 'rows', and the font 'font'.  If 'font' is NULL, the default font will be used.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewTextField(objectKey parent, int columns, objectKey font, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new text field component to be placed inside the parent object 'parent', using the number of columns 'columns' and the font 'font', and with the given component parameters 'params'.  Text field components are essentially 1-line 'text area' components.  If 'font' is NULL, the default font will be used.
</p></blockquote>
<p><font face="Courier New">objectKey windowNewTextLabel(objectKey parent, objectKey font, const char *text, componentParameters *params)
</font></p>
<blockquote>
  <p>Get a new text labelComponent to be placed inside the parent object 'parent', with the given component parameters 'params', and using the text string 'text' and the font 'font'.  If 'font' is NULL, the default font will be used.
</p></blockquote>
<p>&nbsp;</p>
<p><b><a name="user"></a>User functions</b></p>
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
<p>&nbsp;</p>
<p><b><a name="miscellaneous"></a>Miscellaneous functions</b></p>

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
<p><font face="Courier New">int fontLoad(const char* filename, const char *fontname, objectKey *pointer)
</font></p>
<blockquote>
  <p>Load the font from the font file 'filename', give it the font name 'fontname' for future reference, and return an object key for the font in 'pointer' if successful.
</p></blockquote>
<p><font face="Courier New">unsigned fontGetPrintedWidth(objectKey font, const char *string)
</font></p>
<blockquote>
  <p>Given the supplied string, return the screen width that the text will consume given the font 'font'.  Useful for placing text when using a variable-width font, but not very useful otherwise.
</p></blockquote>
<p><font face="Courier New">int imageLoadBmp(const char *filename, image *loadImage)
</font></p>
<blockquote>
  <p>Try to load the bitmap image file 'filename', and if successful, save the data in the image data structure 'loadImage'.
</p></blockquote>
<p><font face="Courier New">int imageSaveBmp(const char *filename, image *saveImage)
</font></p>
<blockquote>
  <p>Save the image data structure 'saveImage' as a bitmap, to the file 'fileName'.
</p></blockquote>
<p><font face="Courier New">int shutdown(int reboot, int nice)
</font></p>
<blockquote>
  <p>Shut down the system.  If 'reboot' is non-zero, the system will reboot.  If 'nice' is zero, the shutdown will be orderly and will abort if serious errors are detected.  If 'nice' is non-zero, the system will go down like a kamikaze regardless of errors.
</p></blockquote>
<p><font face="Courier New">const char *version(void)
</font></p>
<blockquote>
  <p>Get the kernel's version string.
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
<p><font face="Courier New">variableList *variableListCreate(unsigned maxVar, unsigned size, const char *desc)
</font></p>
<blockquote>
  <p>Get a new variable list structure with the maximum number of variables 'maxVar', the total data size 'size', and the description 'desc'.
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
<p><font face="Courier New">variableList *configurationReader(const char *fileName)
</font></p>
<blockquote>
  <p>Read the contents of the configuration file 'fileName', and return the data in a variable list structure.  Configuration files are simple properties files, consisting of lines of the format "variable=value"
</p></blockquote>
<p><font face="Courier New">int configurationWriter(const char *fileName, variableList *list)
</font></p>
<blockquote>
  <p>Write the contents of the variable list 'list' to the configuration file 'fileName'.  Configuration files are simple properties files, consisting of lines of the format "variable=value".  If the configuration file already exists, the configuration writer will attempt to preserve comment lines (beginning with '#') and formatting
  whitespace.
</p>
      </blockquote>

      </td>
    </tr>
  </table>
  </center>
</div>
<sys/file.h>
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