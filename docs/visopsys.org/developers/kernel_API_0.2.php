<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Visopsys | Visual Operating System | Kernel API 0.2</title>
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
      <td>

<p align="left"><font face="Arial"><b>THE VISOPSYS KERNEL API&nbsp; (version 0.2)</b></font></p>

<p align="left"><font face="Arial">All of the kernel's functions are defined in the 
file /system/headers/sys/api.h.&nbsp; Going forward, this file may be split into 
more manageable chunks.&nbsp; Data structures referred to in these function 
definitions are found in the applicable header file in /system/headers/sys.&nbsp; 
For example, a 'disk' object is defined in /system/headers/sys/disk.h.</font></p>

<blockquote>

<p align="left"><font face="Arial"><i>One note on the 'objectKey' type used by many of these 
functions: This is used to refer to data structures in kernel memory that are 
not accessible (in a practical sense) to external programs.&nbsp; Yes, it's a 
pointer -- A pointer to a structure that is probably defined in one of the 
kernel header files.&nbsp; You could try to use it as more than just a reference 
key, but you would do so at your own risk.</i></font></p>

</blockquote>

<p align="left"><font face="Arial">Here is the breakdown of functions available at 
the time of writing:</font></p>

<p><font face="Arial"><a href="kernel_API_0.2.php#text">Text input/output functions</a><br>
<a href="kernel_API_0.2.php#disk">Disk functions</a><br>
<a href="kernel_API_0.2.php#filesystem">Filesystem functions</a><br>
<a href="kernel_API_0.2.php#file">File functions</a><br>
<a href="kernel_API_0.2.php#memory">Memory functions</a><br>
<a href="kernel_API_0.2.php#multitasker">Multitasker functions</a><br>
<a href="kernel_API_0.2.php#loader">Loader functions</a><br>
<a href="kernel_API_0.2.php#realtime">Real-time clock functions</a><br>
<a href="kernel_API_0.2.php#random">Random number functions</a><br>
<a href="kernel_API_0.2.php#environment">Environment functions</a><br>
<a href="kernel_API_0.2.php#graphics">Raw graphics functions</a><br>
<a href="kernel_API_0.2.php#window">Window manager functions</a><br>
<a href="kernel_API_0.2.php#misc">Miscellaneous functions</a></font></p>
<p>&nbsp;</p>
<p><b><a name="text"></a>Text input/output functions</b></p>
<p><font face="Courier New">int textGetForeground(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the current foreground color as an int 
  value.&nbsp; Currently this is only applicable in text mode, and the color 
  value should be treated as a PC built-in color value.&nbsp; Here is a listing:</font></p>
  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111">
    <tr>
      <td width="25%"><font face="Arial">0 - Black</font></td>
      <td width="25%"><font face="Arial">4 - Red</font></td>
      <td width="25%"><font face="Arial">8 - Dark gray</font></td>
      <td width="25%"><font face="Arial">12 - Light red</font></td>
    </tr>
    <tr>
      <td width="25%"><font face="Arial">1 - Blue</font></td>
      <td width="25%"><font face="Arial">5 - Magenta</font></td>
      <td width="25%"><font face="Arial">9 - Light blue</font></td>
      <td width="25%"><font face="Arial">13 - Light magenta</font></td>
    </tr>
    <tr>
      <td width="25%"><font face="Arial">2 - Green</font></td>
      <td width="25%"><font face="Arial">6 - Brown</font></td>
      <td width="25%"><font face="Arial">10 - Light green</font></td>
      <td width="25%"><font face="Arial">14 - Yellow</font></td>
    </tr>
    <tr>
      <td width="25%"><font face="Arial">3 - Cyan</font></td>
      <td width="25%"><font face="Arial">7 - Light gray</font></td>
      <td width="25%"><font face="Arial">11 - Light cyan</font></td>
      <td width="25%"><font face="Arial">15 - White</font></td>
    </tr>
  </table>
</blockquote>
<p><font face="Courier New">int textSetForeground(int foreground)</font></p>
<blockquote>
  <p><font face="Arial">Set the current foreground color from an int 
  value.&nbsp; Currently this is only applicable in text mode, and the color 
  value should be treated as a PC builtin color value.&nbsp; See chart above.</font></p>
</blockquote>
<p><font face="Courier New">int textGetBackground(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the current background color as an int 
  value.&nbsp; Currently this is only applicable in text mode, and the color 
  value should be treated as a PC builtin color value.&nbsp; See chart above.</font></p>
</blockquote>
<p><font face="Courier New">int textSetBackground(int background)</font></p>
<blockquote>
  <p><font face="Arial">Set the current foreground color from an int 
  value.&nbsp; Currently this is only applicable in text mode, and the color 
  value should be treated as a PC builtin color value.&nbsp; See chart above.</font></p>
</blockquote>
<p><font face="Courier New">int textPutc(int ascii)</font></p>
<blockquote>
  <p><font face="Arial">Print a single character</font></p>
</blockquote>
<p><font face="Courier New">int textPrint(const char *str)</font></p>
<blockquote>
  <p><font face="Arial">Print a string</font></p>
</blockquote>
<p><font face="Courier New">int textPrintLine(const char *str)</font></p>
<blockquote>
  <p><font face="Arial">Print a string with a newline at the end</font></p>
</blockquote>
<p><font face="Courier New">void textNewline(void)</font></p>
<blockquote>
  <p><font face="Arial">Print a newline</font></p>
</blockquote>
<p><font face="Courier New">int textBackSpace(void)</font></p>
<blockquote>
  <p><font face="Arial">Backspace the cursor, deleting any character 
  there</font></p>
</blockquote>
<p><font face="Courier New">int textTab(void)</font></p>
<blockquote>
  <p><font face="Arial">Print a tab</font></p>
</blockquote>
<p><font face="Courier New">int textCursorUp(void)</font></p>
<blockquote>
  <p><font face="Arial">Move the cursor up one row.&nbsp; Doesn't 
  affect any characters there.</font></p>
</blockquote>
<p><font face="Courier New">int textCursorDown(void)</font></p>
<blockquote>
  <p><font face="Arial">Move the cursor down one row.&nbsp; Doesn't 
  affect any characters there.</font></p>
</blockquote>
<p><font face="Courier New">int textCursorLeft(void)</font></p>
<blockquote>
  <p><font face="Arial">Move the cursor left one column.&nbsp; Doesn't 
  affect any characters there.</font></p>
</blockquote>
<p><font face="Courier New">int textCursorRight(void)</font></p>
<blockquote>
  <p><font face="Arial">Move the cursor right one column.&nbsp; 
  Doesn't affect any characters there.</font></p>
</blockquote>
<p><font face="Courier New">int textGetNumColumns(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the total number of columns in the text 
  area.</font></p>
</blockquote>
<p><font face="Courier New">int textGetNumRows(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the total number of rows in the text area.</font></p>
</blockquote>
<p><font face="Courier New">int textGetColumn(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the number of the current column.&nbsp; 
  Zero-based.</font></p>
</blockquote>
<p><font face="Courier New">void textSetColumn(int c)</font></p>
<blockquote>
  <p><font face="Arial">Set the number of the current column.&nbsp; 
  Zero-based.&nbsp; Doesn't affect any characters there.</font></p>
</blockquote>
<p><font face="Courier New">int textGetRow(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the number of the current row.&nbsp; 
  Zero-based.</font></p>
</blockquote>
<p><font face="Courier New">void textSetRow(int r)</font></p>
<blockquote>
  <p><font face="Arial">Set the number of the current row.&nbsp; 
  Zero-based.&nbsp; Doesn't affect any characters there.</font></p>
</blockquote>
<p><font face="Courier New">int textClearScreen(void)</font></p>
<blockquote>
  <p><font face="Arial">Erase all characters in the text area and set 
  the row and column to (0, 0)</font></p>
</blockquote>
<p><font face="Courier New">int textInputCount(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the number of characters currently waiting 
  in the input stream</font></p>
</blockquote>
<p><font face="Courier New">int textInputGetc(char *cp)</font></p>
<blockquote>
  <p><font face="Arial">Get one character from the input stream (as an 
  integer value).</font></p>
</blockquote>
<p><font face="Courier New">int textInputReadN(int num, char *buff)</font></p>
<blockquote>
  <p><font face="Arial">Read up to 'num' characters from the input 
  stream into 'buff'</font></p>
</blockquote>
<p><font face="Courier New">int textInputReadAll(char *buff)</font></p>
<blockquote>
  <p><font face="Arial">Read all of the characters from the input 
  stream into 'buff'</font></p>
</blockquote>
<p><font face="Courier New">int textInputAppend(int ascii)</font></p>
<blockquote>
  <p><font face="Arial">Append a character (as an integer value) to 
  the end of the input stream.</font></p>
</blockquote>
<p><font face="Courier New">int textInputAppendN(int num, char *str)</font></p>
<blockquote>
  <p><font face="Arial">Append 'num' characters to the end of the 
  input stream from 'str'</font></p>
</blockquote>
<p><font face="Courier New">int textInputRemove(void)</font></p>
<blockquote>
  <p><font face="Arial">Remove one character from the start of the 
  input stream.</font></p>
</blockquote>
<p><font face="Courier New">int textInputRemoveN(int num)</font></p>
<blockquote>
  <p><font face="Arial">Remove 'num' characters from the start of the 
  input stream.</font></p>
</blockquote>
<p><font face="Courier New">int textInputRemoveAll(void)</font></p>
<blockquote>
  <p><font face="Arial">Empty the input stream.</font></p>
</blockquote>
<p><font face="Courier New">void textInputSetEcho(int onOff)</font></p>
<blockquote>
  <p><font face="Arial">Set echo on (1) or off (0) for the input 
  stream.&nbsp; When on, any characters typed will be automatically printed to 
  the text area.&nbsp; When off, they won't.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="disk"></a>Disk functions</b></p>
<p><font face="Courier New">int diskFunctionsGetBoot(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the internal disk number of the boot 
  device.&nbsp; Normally this will contain the root filesystem.</font></p>
</blockquote>
<p><font face="Courier New">int diskFunctionsGetCount(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the number of disk volumes recognized by 
  the system</font></p>
</blockquote>
<p><font face="Courier New">int diskFunctionsGetInfo(int num, disk *d)</font></p>
<blockquote>
  <p><font face="Arial">Get information about the disk volume 'num' 
  and put it in the disk structure d.&nbsp; The disk numbers are sequential, so 
  you 'num' can be any value from 0 to </font><font face="Courier New">
  diskFunctionsGetCount()</font><font face="Arial">. </font></p>
</blockquote>
<p><font face="Courier New">int diskFunctionsMotorOn(int num)</font></p>
<blockquote>
  <p><font face="Arial">Turn the disk motor of disk 'num' on, if 
  applicable.&nbsp; Generally only applicable to removable devices like 
  floppies.</font></p>
</blockquote>
<p><font face="Courier New">int diskFunctionsMotorOff(int num)</font></p>
<blockquote>
  <p><font face="Arial">Turn the disk motor of disk 'num' off, if 
  applicable.&nbsp; Generally only applicable to removable devices like 
  floppies.</font></p>
</blockquote>
<p><font face="Courier New">int diskFunctionsDiskChanged(int num)</font></p>
<blockquote>
  <p><font face="Arial">Return 1 if disk 'num' is a removable device 
  such as a floppy or CD-ROM, and the media has been changed or removed.</font></p>
</blockquote>
<p><font face="Courier New">int diskFunctionsReadSectors(int num, unsigned sect, 
unsigned count, void *buf)</font></p>
<blockquote>
  <p><font face="Arial">Read 'count' sectors from disk 'num', starting 
  at (zero-based) logical sector number 'sect'.&nbsp; Put the data in memory 
  area 'buf'.</font></p>
</blockquote>
<p><font face="Courier New">int diskFunctionsWriteSectors(int num, unsigned 
sect, unsigned count, void *buf)</font></p>
<blockquote>
  <p><font face="Arial">Write 'count' sectors to disk 'num', starting 
  at (zero-based) logical sector number 'sect'.&nbsp; Get the data from memory 
  area 'buf'.</font></p>
</blockquote>
<p><font face="Courier New">int diskFunctionsReadAbsoluteSectors(int num, 
unsigned sect, unsigned count, void *buf)</font></p>
<blockquote>
  <p><font face="Arial">Read 'count' sectors from disk 'num', starting 
  at (zero-based) absolute sector number 'sect'.&nbsp; Put the data in memory 
  area 'buf'.&nbsp; This function requires supervisor privilege and is used to 
  read outside the logical confines of a volume, such as a hard disk partition.&nbsp; 
  Not very useful unless you know what you're doing.</font></p>
</blockquote>
<p><font face="Courier New">int diskFunctionsWriteAbsoluteSectors(int num, 
unsigned sect, unsigned count, void *buf)</font></p>
<blockquote>
  <p><font face="Arial">Write 'count' sectors to disk 'num', starting 
  at (zero-based) absolute sector number 'sect'.&nbsp; Get the data from memory 
  area 'buf'.&nbsp; This function requires supervisor privilege and is used to 
  write outside the logical confines of a volume, such as a hard disk partition.&nbsp; 
  Don't use this unless you know what you're doing.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="filesystem"></a>Filesystem functions</b></p>
<p><font face="Courier New">int filesystemCheck(int disknum, int force, int 
repair)</font></p>
<blockquote>
  <p><font face="Arial">Check the filesystem on disk 'disknum'.&nbsp; 
  If 'force' is non-zero, the filesystem will be checked regardless of whether 
  the filesystem driver thinks it needs to be.&nbsp; If 'repair' is non-zero, 
  the filesystem driver will attempt to repair any errors found.&nbsp; If 
  'repair' is zero, a non-zero return value may indicate that errors were found.&nbsp; 
  If 'repair' is non-zero, a non-zero return value may indicate that errors were 
  found but could not be fixed.&nbsp; It is optional for filesystem drivers to 
  implement this function.</font></p>
</blockquote>
<p><font face="Courier New">int filesystemDefragment(int disknum)</font></p>
<blockquote>
  <p><font face="Arial">Defragment the filesystem on disk 'disknum'.&nbsp; 
  It is optional for filesystem drivers to implement this function.</font></p>
</blockquote>
<p><font face="Courier New">int filesystemMount(int disknum, const char *mp)</font></p>
<blockquote>
  <p><font face="Arial">Mount the filesystem on disk 'disknum', using 
  the mount point specified by the absolute pathname 'mp'.&nbsp; Note that no 
  file or directory called 'mp' should exist, as the mount function will expect 
  to be able to create it.</font></p>
</blockquote>
<p><font face="Courier New">int filesystemSync(const char *fs)</font></p>
<blockquote>
  <p><font face="Arial">Synchronize the filesystem mounted represented 
  by the mount point 'fs'.</font></p>
</blockquote>
<p><font face="Courier New">int filesystemUnmount(const char *mp)</font></p>
<blockquote>
  <p><font face="Arial">Unmount the filesystem mounted represented by 
  the mount point 'fs'.</font></p>
</blockquote>
<p><font face="Courier New">int filesystemNumberMounted(void)</font></p>
<blockquote>
  <p><font face="Arial">Returns the number of filesystems currently 
  mounted.</font></p>
</blockquote>
<p><font face="Courier New">void filesystemFirstFilesystem(char *buff)</font></p>
<blockquote>
  <p><font face="Arial">Returns the mount point of the first mounted 
  filesystem in 'buff'.&nbsp; Normally this will be the root filesystem &quot;/&quot;.</font></p>
</blockquote>
<p><font face="Courier New">void filesystemNextFilesystem(char *buff)</font></p>
<blockquote>
  <p><font face="Arial">Returns the mount point of the next mounted 
  filesystem as returned by a previous call to either </font>
  <font face="Courier New">filesystemFirstFilesystem()</font><font face="Arial">or
  </font><font face="Courier New">filesystemNextFilesystem()</font></p>
</blockquote>
<p><font face="Courier New">int filesystemGetFree(const char *fs)</font></p>
<blockquote>
  <p><font face="Arial">Returns the amount of free space on the 
  filesystem represented by the mount point 'fs'.</font></p>
</blockquote>
<p><font face="Courier New">unsigned int filesystemGetBlockSize(const char *fs)</font></p>
<blockquote>
  <p><font face="Arial">Returns the block size (for example, 512 or 
  1024) of the filesystem represented by the mount point 'fs'.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="file"></a>File functions</b></p>
<p>Note that in all of the functions of this section, any 
reference to pathnames means absolute pathnames, from root.&nbsp; E.g. '/files/myfile', 
not simply 'myfile'.&nbsp; From the kernel's point of view, 'myfile' might be 
ambiguous.</p>
<p><font face="Courier New">int fileFixupPath(const char *orig, char *new)</font></p>
<blockquote>
  <p><font face="Arial">Take the absolute pathname in 'orig' and fix 
  it up.&nbsp; This means eliminating extra file separator characters (for 
  example) and resolving links or '.' or '..' components in the pathname.</font></p>
</blockquote>
<p><font face="Courier New">int fileFirst(const char *path, file *f)</font></p>
<blockquote>
  <p><font face="Arial">Get the first file from the directory 
  referenced by 'path'.&nbsp; Put the information in the file structure 'f'.</font></p>
</blockquote>
<p><font face="Courier New">int fileNext(const char *path, file *f)</font></p>
<blockquote>
  <p><font face="Arial">Get the next file from the directory 
  referenced by 'path'.&nbsp; 'f' should be a file structure previously filled 
  by a call to either </font><font face="Courier New">fileFirst()</font><font face="Arial"> 
  or </font><font face="Courier New">fileNext()</font><font face="Arial">.</font></p>
</blockquote>
<p><font face="Courier New">int fileFind(const char *name, file *f)</font></p>
<blockquote>
  <p><font face="Arial">Find the file referenced by 'name', and fill 
  the file data structure 'f' with the results if successful.</font></p>
</blockquote>
<p><font face="Courier New">int fileOpen(const char *name, int mode, file *f)</font></p>
<blockquote>
  <p><font face="Arial">Open the file referenced by 'name' using the 
  file open mode 'mode' (defined in &lt;sys/file.h&gt;).&nbsp; Update the file data 
  structure 'f' if successful.</font></p>
</blockquote>
<p><font face="Courier New">int fileClose(file *f)</font></p>
<blockquote>
  <p><font face="Arial">Close the previously opened file 'f'.</font></p>
</blockquote>
<p><font face="Courier New">int fileRead(file *f, unsigned int blocknum, 
unsigned int blocks, unsigned char *buff)</font></p>
<blockquote>
  <p><font face="Arial">Read data from the previously opened file 'f'.&nbsp; 
  'f' should have been opened in a read or read/write mode.&nbsp; Read 'blocks' 
  blocks (see the filesystem functions for information about getting the block 
  size of a given filesystem) and put them in buffer 'buff'.</font></p>
</blockquote>
<p><font face="Courier New">int fileWrite(file *f, unsigned int blocknum, 
unsigned int blocks, unsigned char *buff)</font></p>
<blockquote>
  <p><font face="Arial">Write data to the previously opened file 'f'.&nbsp; 
  'f' should have been opened in a write or read/write mode.&nbsp; Write 
  'blocks' blocks (see the filesystem functions for information about getting 
  the block size of a given filesystem) from the buffer 'buff'.</font></p>
</blockquote>
<p><font face="Courier New">int fileDelete(const char *name)</font></p>
<blockquote>
  <p><font face="Arial">Delete the file referenced by the pathname 
  'name'.</font></p>
</blockquote>
<p><font face="Courier New">int fileDeleteSecure(const char *name)</font></p>
<blockquote>
  <p><font face="Arial">Securely delete the file referenced by the 
  pathname 'name'.&nbsp; If supported.</font></p>
</blockquote>
<p><font face="Courier New">int fileMakeDir(const char *name)</font></p>
<blockquote>
  <p><font face="Arial">Create a directory to be referenced by the 
  pathname 'name'.</font></p>
</blockquote>
<p><font face="Courier New">int fileRemoveDir(const char *name)</font></p>
<blockquote>
  <p><font face="Arial">Remove the directory referenced by the 
  pathname 'name'.</font></p>
</blockquote>
<p><font face="Courier New">int fileCopy(const char *src, const char *dest)</font></p>
<blockquote>
  <p><font face="Arial">Copy the file referenced by the pathname 'src' 
  to the pathname 'dest'.&nbsp; This will overwrite 'dest' if it already exists.</font></p>
</blockquote>
<p><font face="Courier New">int fileCopyRecursive(const char *src, const char *dest)</font></p>
<blockquote>
  <p><font face="Arial">Recursively copy the file referenced by the 
  pathname 'src' to the pathname 'dest'.&nbsp; If 'src' is a regular file, the 
  result will be the same as using the non-recursive call.&nbsp; However if it 
  is a directory, all contents of the directory and its subdirectories will be 
  copied.&nbsp; This will overwrite any files in the 'dest' tree if they already 
  exist.</font></p>
</blockquote>
<p><font face="Courier New">int fileMove(const char *src, const char *dest)</font></p>
<blockquote>
  <p><font face="Arial">Move (rename) a file referenced by the 
  pathname 'src' to the pathname 'dest'.</font></p>
</blockquote>
<p><font face="Courier New">int fileTimestamp(const char *name)</font></p>
<blockquote>
  <p><font face="Arial">Update the time stamp on the file referenced 
  by the pathname 'name'</font></p>
</blockquote>
<p><font face="Courier New">int fileStreamOpen(const char *name, int mode, 
fileStream *f)</font></p>
<blockquote>
  <p><font face="Arial">Open the file referenced by the pathname 
  'name' for streaming operations, using the open mode 'mode' (defined in &lt;sys/file.h&gt;).&nbsp; 
  Fills the fileStream data structure 'f' with information needed for subsequent 
  file stream operations.</font></p>
</blockquote>
<p><font face="Courier New">int fileStreamSeek(fileStream *f, int offset)</font></p>
<blockquote>
  <p><font face="Arial">Seek the file stream 'f' to the absolute 
  position 'offset'</font></p>
</blockquote>
<p><font face="Courier New">int fileStreamRead(fileStream *f, int bytes, char 
*buff)</font></p>
<blockquote>
  <p><font face="Arial">Read 'bytes' bytes from the filestream 'f' and 
  put them into 'buff'.</font></p>
</blockquote>
<p><font face="Courier New">int fileStreamWrite(fileStream *f, int bytes, char 
*buff)</font></p>
<blockquote>
  <p><font face="Arial">Write 'bytes' bytes from the buffer 'buff' to 
  the file stream 'f'.</font></p>
</blockquote>
<p><font face="Courier New">int fileStreamFlush(fileStream *f)</font></p>
<blockquote>
  <p><font face="Arial">Flush file stream 'f'.</font></p>
</blockquote>
<p><font face="Courier New">int fileStreamClose(fileStream *f)</font></p>
<blockquote>
  <p><font face="Arial">[Flush and] close the file stream 'f'.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="memory"></a>Memory functions</b></p>
<p><font face="Courier New">void memoryPrintUsage(void)</font></p>
<blockquote>
  <p><font face="Arial">Prints the current memory usage statistics to 
  the current output stream.</font></p>
</blockquote>
<p><font face="Courier New">void *memoryRequestBlock(unsigned int size, unsigned 
int align, const char *desc)</font></p>
<blockquote>
  <p><font face="Arial">Return a pointer to a new block of memory of 
  size 'size' and (optional) physical alignment 'align', adding the (optional) 
  description 'desc'.&nbsp; If no specific alignment is required, use '0'.&nbsp; 
  Memory allocated using this function is automatically cleared (like 'calloc').</font></p>
</blockquote>
<p><font face="Courier New">void *memoryRequestPhysicalBlock(unsigned int size, 
unsigned int align, const char *desc)</font></p>
<blockquote>
  <p><font face="Arial">Return a pointer to a new physical block of 
  memory of size 'size' and (optional) physical alignment 'align', adding the 
  (optional) description 'desc'.&nbsp; If no specific alignment is required, use 
  '0'.&nbsp; Memory allocated using this function is NOT automatically cleared.&nbsp; 
  'Physical' refers to an actual physical memory address, and is not necessarily 
  useful to external programs.</font></p>
</blockquote>
<p><font face="Courier New">int memoryReleaseBlock(void *p)</font></p>
<blockquote>
  <p><font face="Arial">Release the memory block starting at the 
  address 'p'.&nbsp; Must have been previously allocated using the </font>
  <font face="Courier New">memoryRequestBlock() </font>
  <font face="Arial">function.</font></p>
</blockquote>
<p><font face="Courier New">int memoryReleaseAllByProcId(int pid)</font></p>
<blockquote>
  <p><font face="Arial">Release all memory allocated to/by the process 
  referenced by process ID 'pid'.&nbsp; Only privileged functions can release 
  memory owned by other processes.</font></p>
</blockquote>
<p><font face="Courier New">int memoryChangeOwner(int opid, int npid, void *addr, 
void **naddr)</font></p>
<blockquote>
  <p><font face="Arial">Change the ownership of an allocated block of 
  memory beginning at address 'addr'.&nbsp; 'opid' is the process ID of the 
  currently owning process, and 'npid' is the process ID of the intended new 
  owner.&nbsp; 'naddr' is filled with the new address of the memory (since it 
  changes address spaces in the process).&nbsp; Note that only a privileged 
  process can change memory ownership.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="multitasker"></a>Multitasker functions</b></p>
<p><font face="Courier New">int multitaskerCreateProcess(void *addr, unsigned 
int size, const char *name, int numargs, void *args)</font></p>
<blockquote>
  <p><font face="Arial">Create a new process.&nbsp; The code should 
  have been loaded at the address 'addr' and be of size 'size'.&nbsp; 'name' 
  will be the new process' name.&nbsp; 'numargs' and 'args' will be passed as 
  the &quot;int argc, char *argv[]) parameters of the new process.&nbsp; If there are 
  no arguments, these should be 0 and NULL, respectively.&nbsp; If the value 
  returned by the call is a positive integer, the call was successful and the 
  value is the new process' process ID.&nbsp; New processes are created and left 
  in a stopped state, so if you want it to run you will need to set it to a 
  running state ('ready', actually) using the function call </font>
  <font face="Courier New">multitaskerSetProcessState()</font><font face="Arial">.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerSpawn(void *addr, const char *name, 
int numargs, void *args)</font></p>
<blockquote>
  <p><font face="Arial">Spawn a thread from the current process.&nbsp; 
  The starting point of the code (for example, a function address) should be 
  specified as 'addr'.&nbsp; 'name' will be the new thread's name.&nbsp; 'numargs' 
  and 'args' will be passed as the &quot;int argc, char *argv[]) parameters of the 
  new thread.&nbsp; If there are no arguments, these should be 0 and NULL, 
  respectively.&nbsp; If the value returned by the call is a positive integer, 
  the call was successful and the value is the new thread's process ID.&nbsp; 
  New threads are created and left in a stopped state, so if you want it to run 
  you will need to set it to a running state ('ready', actually) using the 
  function call </font><font face="Courier New">multitaskerSetProcessState()</font><font face="Arial">.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerGetCurrentProcessId(void)</font></p>
<blockquote>
  <p><font face="Arial">Returns the process ID of the calling program.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerGetProcessOwner(int pid)</font></p>
<blockquote>
  <p><font face="Arial">Returns the user ID of the user that owns the 
  process referenced by process ID 'pid'.</font></p>
</blockquote>
<p><font face="Courier New">const char *multitaskerGetProcessName(int pid)</font></p>
<blockquote>
  <p><font face="Arial">Returns the process name of the process 
  referenced by process ID 'pid'.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerGetProcessState(int pid, int *statep)</font></p>
<blockquote>
  <p><font face="Arial">Gets the state of the process referenced by 
  process ID 'pid'.&nbsp; Puts the result in 'statep'.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerSetProcessState(int pid, int state)</font></p>
<blockquote>
  <p><font face="Arial">Sets the state of the process referenced by 
  process ID 'pid' to the new state 'state'.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerGetProcessPriority(int pid)</font></p>
<blockquote>
  <p><font face="Arial">Gets the priority of the process referenced by 
  process ID 'pid'.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerSetProcessPriority(int pid, int 
priority)</font></p>
<blockquote>
  <p><font face="Arial">Sets the priority of the process referenced by 
  process ID 'pid' to 'priority'..</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerGetProcessPrivilege(int pid)</font></p>
<blockquote>
  <p><font face="Arial">Gets the privilege level of the process 
  referenced by process ID 'pid'.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerGetCurrentDirectory(char *buff, int 
buffsz)</font></p>
<blockquote>
  <p>Returns the absolute pathname of the calling process' current directory.&nbsp; 
  Puts the value in the buffer 'buff' which is of size 'buffsz'.</p>
</blockquote>
<p><font face="Courier New">int multitaskerSetCurrentDirectory(char *buff)</font></p>
<blockquote>
  <p><font face="Arial">Sets the current directory of the calling 
  process to the absolute pathname 'buff'.</font></p>
</blockquote>
<p><font face="Courier New">objectKey multitaskerGetTextInput(void)</font></p>
<blockquote>
  <p><font face="Arial">Get an object key to refer to the current text 
  input stream of the calling process.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerSetTextInput(int processId, objectKey 
key)</font></p>
<blockquote>
  <p><font face="Arial">Set the text input stream of the process 
  referenced by process ID 'processId' to a text stream referenced by the object 
  key 'key'.</font></p>
</blockquote>
<p><font face="Courier New">objectKey multitaskerGetTextOutput(void)</font></p>
<blockquote>
  <p><font face="Arial">Get an object key to refer to the current text 
  output stream of the calling process.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerSetTextOutput(int processId, 
objectKey key)</font></p>
<blockquote>
  <p><font face="Arial">Set the text output stream of the process 
  referenced by process ID 'processId' to a text stream referenced by the object 
  key 'key'.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerGetProcessorTime(clock_t *clk)</font></p>
<blockquote>
  <p><font face="Arial">Fill the clock_t structure with the amount of 
  processor time consumed by the calling process.</font></p>
</blockquote>
<p><font face="Courier New">void multitaskerYield(void)</font></p>
<blockquote>
  <p><font face="Arial">Yield the remainder of the current processor 
  timeslice back to the multitasker's scheduler.&nbsp; It's nice to do this when 
  you are waiting for some event, so that your process is not 'hungry' (i.e. 
  hogging processor cycles unnecessarily).</font></p>
</blockquote>
<p><font face="Courier New">void multitaskerWait(unsigned int ticks)</font></p>
<blockquote>
  <p><font face="Arial">Yield the remainder of the current processor 
  timeslice back to the multitasker's scheduler, and wait at least 'ticks' timer 
  ticks before running the calling process again.&nbsp; On the PC, one second is 
  approximately 20 system timer ticks.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerBlock(int pid)</font></p>
<blockquote>
  <p><font face="Arial">Yield the remainder of the current processor 
  timeslice back to the multitasker's scheduler, and block on the process 
  referenced by process ID 'pid'.&nbsp; This means that the calling process will 
  not run again until process 'pid' has terminated.&nbsp; The return value of 
  this function is the return value of process 'pid'.</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerKillProcess(int pid, int force)</font></p>
<blockquote>
  <p><font face="Arial">Terminate the process referenced by process ID 
  'pid'.&nbsp; If 'force' is non-zero, the multitasker will attempt to ignore 
  any errors and dismantle the process with extreme prejudice.&nbsp; The 'force' 
  flag also has the necessary side effect of killing any child threads spawned 
  by process 'pid'.&nbsp; (Otherwise, 'pid' is left in a stopped state until its 
  threads have terminated normally).</font></p>
</blockquote>
<p><font face="Courier New">int multitaskerTerminate(int code)</font></p>
<blockquote>
  <p><font face="Arial">Terminate the calling process, returning the 
  exit code 'code'</font></p>
</blockquote>
<p><font face="Courier New">void multitaskerDumpProcessList(void)</font></p>
<blockquote>
  <p><font face="Arial">Print a listing of all current processes to 
  the current text output stream.&nbsp; Might not be the current output stream 
  of the calling process, but rather the console output stream.&nbsp; This could 
  be considered a bug, but is more of a &quot;currently necessary peculiarity&quot;.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="loader"></a>Loader functions</b></p>
<p><font face="Courier New">void loaderLoad(const char *filename, file *theFile)</font></p>
<blockquote>
  <p><font face="Arial">Load a file referenced by the pathname 
  'filename', and fill the file data structure 'theFile' with the details.</font></p>
</blockquote>
<p><font face="Courier New">int loaderLoadProgram(const char *userProgram, int 
privilege, int argc, char *argv[])</font></p>
<blockquote>
  <p><font face="Arial">Load the file referenced by the pathname 'userProgram' 
  as a process with the privilege level 'privilege'.&nbsp; Pass the arguments 'argc' 
  and 'argv'.&nbsp; If there are no arguments, these should be 0 and NULL, 
  respectively.&nbsp; If successful, the call's return value is the process ID 
  of the new process.&nbsp; The process is left in a stopped state and must be 
  set to a running state explicitly using the multitasker function </font>
  <font face="Courier New">multitaskerSetProcessState()</font><font face="Arial"> 
  or the loader function </font><font face="Courier New">loaderExecProgram()</font><font face="Arial">.</font></p>
</blockquote>
<p><font face="Courier New">int loaderExecProgram(int processId, int block)</font></p>
<blockquote>
  <p><font face="Arial">Execute the process referenced by process ID 'processId'.&nbsp; 
  If 'block' is non-zero, the calling process will block until process 'pid' has 
  terminated, and the return value of the call is the return value of process 'pid'.</font></p>
</blockquote>
<p><font face="Courier New">int loaderLoadAndExec(const char *name, int 
privilege, int argc, char *argv[], int block)</font></p>
<blockquote>
  <p><font face="Arial">This function is just for convenience, and is 
  an amalgamation of the loader functions </font><font face="Courier New">
  loaderLoadProgram()</font><font face="Arial"> and&nbsp; </font>
  <font face="Courier New">loaderExecProgram()</font><font face="Arial">.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="realtime"></a>Real-time clock functions</b></p>
<p><font face="Courier New">int rtcReadSeconds(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the current seconds value.</font></p>
</blockquote>
<p><font face="Courier New">int rtcReadMinutes(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the current minutes value.</font></p>
</blockquote>
<p><font face="Courier New">int rtcReadHours(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the current hours value.</font></p>
</blockquote>
<p><font face="Courier New">int rtcReadDayOfWeek(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the current day of the week value.</font></p>
</blockquote>
<p><font face="Courier New">int rtcReadDayOfMonth(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the current day of the month value.</font></p>
</blockquote>
<p><font face="Courier New">int rtcReadMonth(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the current month value.</font></p>
</blockquote>
<p><font face="Courier New">int rtcReadYear(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the current year value.</font></p>
</blockquote>
<p><font face="Courier New">unsigned int rtcUptimeSeconds(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the number of seconds the system has been 
  running.</font></p>
</blockquote>
<p><font face="Courier New">int rtcDateTime(struct tm *time)</font></p>
<blockquote>
  <p><font face="Arial">Get the current data and time as a tm data 
  structure in 'time'.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="random"></a>Random number functions</b></p>
<p><font face="Courier New">unsigned int randomUnformatted(void)</font></p>
<blockquote>
  <p><font face="Arial">Get an unformatted random unsigned number.&nbsp; 
  Just any unsigned number.</font></p>
</blockquote>
<p><font face="Courier New">unsigned int randomFormatted(unsigned int start, 
unsigned int end)</font></p>
<blockquote>
  <p><font face="Arial">Get a random unsigned number between the start 
  value 'start' and the end value 'end', inclusive.</font></p>
</blockquote>
<p><font face="Courier New">unsigned int randomSeededUnformatted(unsigned int 
seed)</font></p>
<blockquote>
  <p><font face="Arial">Get an unformatted random unsigned number, 
  using the random seed 'seed' instead of the kernel's default random seed.</font></p>
</blockquote>
<p><font face="Courier New">unsigned int randomSeededFormatted(unsigned int 
seed, unsigned int start, unsigned int end)</font></p>
<blockquote>
  <p><font face="Arial">Get a random unsigned number between the start 
  value 'start' and the end value 'end', inclusive, using the random seed 'seed' 
  instead of the kernel's default random seed.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="environment"></a>Environment functions</b></p>
<p><font face="Courier New">int environmentGet(const char *var, char *buf, 
unsigned int bufsz)</font></p>
<blockquote>
  <p>Get the value of the environment variable named 'var', and put it into the 
  buffer 'buf' of size 'bufsz' if successful.</p>
</blockquote>
<p><font face="Courier New">int environmentSet(const char *var, const char *val)</font></p>
<blockquote>
  <p><font face="Arial">Set the environment variable 'var' to the 
  value 'val', overwriting any old value that might have been previously set.</font></p>
</blockquote>
<p><font face="Courier New">int environmentUnset(const char *var)</font></p>
<blockquote>
  <p>Delete the environment variable 'var'.</p>
</blockquote>
<p><font face="Courier New">void environmentDump(void)</font></p>
<blockquote>
  <p>Print a listing of all the currently set environment variables in the 
  calling process' environment space to the current text output stream.</p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="graphics"></a>Raw graphics functions</b></p>
<p><font face="Courier New">int graphicsAreEnabled(void)</font></p>
<blockquote>
  <p><font face="Arial">Returns 1 if the kernel is operating in 
  graphics mode.</font></p>
</blockquote>
<p><font face="Courier New">unsigned graphicGetScreenWidth(void)</font></p>
<blockquote>
  <p><font face="Arial">Returns the width of the graphics screen.</font></p>
</blockquote>
<p><font face="Courier New">unsigned graphicGetScreenHeight(void)</font></p>
<blockquote>
  <p><font face="Arial">Returns the height of the graphics screen.</font></p>
</blockquote>
<p><font face="Courier New">unsigned graphicCalculateAreaBytes(unsigned width, 
unsigned height)</font></p>
<blockquote>
  <p><font face="Arial">Returns the number of bytes required to 
  allocate a graphic buffer of width 'width' and height 'height'.&nbsp; This is 
  a function of the screen resolution, etc.</font></p>
</blockquote>
<p><font face="Courier New">int graphicClearScreen(color *background)</font></p>
<blockquote>
  <p><font face="Arial">Clear the screen to the background color 
  'background'.</font></p>
</blockquote>
<p><font face="Courier New">int graphicDrawPixel(objectKey buffer, color 
*foreground, drawMode mode, int xCoord, int 
yCoord)</font></p>
<blockquote>
  <p><font face="Arial">Draw a single pixel into the graphic buffer 
  'buffer', using the color 'foreground', the drawing mode 'drawMode' (for 
  example, 'draw_normal' or 'draw_xor'), the X coordinate 'xCoord' and the Y 
  coordinate 'yCoord'.&nbsp; If 'buffer' is NULL, draw directly onto the screen.</font></p>
</blockquote>
<p><font face="Courier New">int graphicDrawLine(objectKey buffer, color 
*foreground, drawMode mode, int startX, int 
startY, int endX, int endY)</font></p>
<blockquote>
  <p><font face="Arial">Draw a line into the graphic buffer 'buffer', 
  using the color 'foreground', the drawing mode 'drawMode' (for example, 'draw_normal' 
  or 'draw_xor'), the starting X coordinate 'startX', the starting Y coordinate 
  'startY', the ending X coordinate 'endX' and the ending Y coordinate 'endY'.&nbsp; 
  At the time of writing, only horizontal and vertical lines are supported by 
  the linear framebuffer graphic driver.&nbsp; If 'buffer' is NULL, draw 
  directly onto the screen.</font></p>
</blockquote>
<p><font face="Courier New">int graphicDrawRect(objectKey buffer, color 
*foreground, drawMode mode, int xCoord, int 
yCoord, unsigned width, unsigned height, unsigned thickness, int fill)</font></p>
<blockquote>
  <p><font face="Arial">Draw a rectangle into the graphic buffer 
  'buffer', using the color 'foreground', the drawing mode 'drawMode' (for 
  example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', the 
  starting Y coordinate 'yCoord', the width 'width', the height 'height', the 
  line thickness 'thickness' and the fill value 'fill'.&nbsp; Non-zero fill 
  value means fill the rectangle.&nbsp;&nbsp; If 'buffer' is NULL, draw directly 
  onto the screen.</font></p>
</blockquote>
<p><font face="Courier New">int graphicDrawOval(objectKey buffer, color 
*foreground, drawMode mode, int xCoord, int 
yCoord, unsigned width, unsigned height, unsigned thickness, int fill)</font></p>
<blockquote>
  <p><font face="Arial">Draw an oval (circle, whatever) into the 
  graphic buffer 'buffer', using the color 'foreground', the drawing mode 'drawMode' 
  (for example, 'draw_normal' or 'draw_xor'), the starting X coordinate 'xCoord', 
  the starting Y coordinate 'yCoord', the width 'width', the height 'height', 
  the line thickness 'thickness' and the fill value 'fill'.&nbsp; Non-zero fill 
  value means fill the oval.&nbsp;&nbsp; If 'buffer' is NULL, draw directly onto 
  the screen.&nbsp; Currently not supported by the linear framebuffer graphic 
  driver.</font></p>
</blockquote>
<p><font face="Courier New">int graphicDrawImage(objectKey buffer, image *drawImage, 
int xCoord, int yCoord)</font></p>
<blockquote>
  <p><font face="Arial">Draw the image 'drawImage' into the graphic 
  buffer 'buffer', using the starting X coordinate 'xCoord' and the starting Y 
  coordinate 'yCoord'.&nbsp;&nbsp; If 'buffer' is NULL, draw directly onto the 
  screen.</font></p>
</blockquote>
<p><font face="Courier New">int graphicGetImage(objectKey buffer, image *getImage, 
int xCoord, int yCoord, unsigned width, unsigned 
height)</font></p>
<blockquote>
  <p><font face="Arial">Grab a new image 'getImage' from the graphic 
  buffer 'buffer', using the starting X coordinate 'xCoord', the starting Y 
  coordinate 'yCoord', the width 'width' and the height 'height'.&nbsp;&nbsp; If 
  'buffer' is NULL, grab the image directly from the screen.</font></p>
</blockquote>
<p><font face="Courier New">int graphicDrawText(objectKey buffer, color 
*foreground, objectKey font, const char *text, 
drawMode mode, int xCoord, int yCoord)</font></p>
<blockquote>
  <p><font face="Arial">Draw the text string 'text' into the graphic 
  buffer 'buffer', using the color 'foreground', the font 'font', the drawing 
  mode 'drawMode' (for example, 'draw_normal' or 'draw_xor'), the starting X 
  coordinate 'xCoord', the starting Y coordinate 'yCoord'.&nbsp;&nbsp; If 
  'buffer' is NULL, draw directly onto the screen.&nbsp; If 'font' is NULL, use 
  the default font.</font></p>
</blockquote>
<p><font face="Courier New">int graphicCopyArea(objectKey buffer, int xCoord1, 
int yCoord1, unsigned width, unsigned height, int 
xCoord2, int yCoord2)</font></p>
<blockquote>
  <p><font face="Arial">Within the graphic buffer 'buffer', copy the 
  area bounded by ('xCoord1', 'yCoord1'), width 'width' and height 'height' to 
  the starting X coordinate 'xCoord2' and the starting Y coordinate 'yCoord2'.&nbsp; 
  If 'buffer' is NULL, copy directly to and from the screen.</font></p>
</blockquote>
<p><font face="Courier New">int graphicClearArea(objectKey buffer, color 
*background, int xCoord, int yCoord, unsigned 
width, unsigned height)</font></p>
<blockquote>
  <p><font face="Arial">Clear the area of the graphic buffer 'buffer' 
  using the background color 'background', using the starting X coordinate 'xCoord', 
  the starting Y coordinate 'yCoord', the width 'width' and the height 'height'.&nbsp; 
  If 'buffer' is NULL, clear the area directly on the screen.</font></p>
</blockquote>
<p><font face="Courier New">int graphicRenderBuffer(objectKey buffer, int drawX, 
int drawY, int clipX, int clipY, unsigned 
clipWidth, unsigned clipHeight)</font></p>
<blockquote>
  <p><font face="Arial">Draw the clip of the buffer 'buffer' onto the 
  screen.&nbsp; Draw it on the screen at starting X coordinate 'drawX' and 
  starting Y coordinate 'drawY'.&nbsp; The buffer clip is bounded by the 
  starting X coordinate 'clipX', the starting Y coordinate 'clipY', the width 'clipWidth' 
  and the height 'clipHeight'.&nbsp; It is not legal for 'buffer' to be NULL in 
  this case.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="window"></a>Window manager functions</b></p>
<p><font face="Courier New">int windowManagerStart(void)</font></p>
<blockquote>
  <p><font face="Arial">Starts the window manager.&nbsp; Not useful 
  for most external programa.</font></p>
</blockquote>
<p><font face="Courier New">int windowManagerLogin(int userId)</font></p>
<blockquote>
  <p><font face="Arial">Log the user specified by the user ID 'userId' 
  into the window manager.</font></p>
</blockquote>
<p><font face="Courier New">int windowManagerLogout(void)</font></p>
<blockquote>
  <p><font face="Arial">Log the current user out of the window 
  manager.</font></p>
</blockquote>
<p><font face="Courier New">objectKey windowManagerNewWindow(int processId, char 
*title, int xCoord, int yCoord, int 
width, int height)</font></p>
<blockquote>
  <p><font face="Arial">Create a new window, owned by the process 
  referenced by the process ID 'processId'.&nbsp; Set the window title to 
  'title', and place it initially at the specified coordinates with the given 
  width and height.&nbsp; Returns an object key to referenc the window, needed 
  by most other window manager functions below.</font></p>
</blockquote>
<p><font face="Courier New">int windowManagerDestroyWindow(objectKey window)</font></p>
<blockquote>
  <p><font face="Arial">Destroy the window referenced by the object 
  key 'wndow'</font></p>
</blockquote>
<p><font face="Courier New">int windowManagerUpdateBuffer(void *buffer, int 
xCoord, int yCoord, unsigned width, unsigned 
height)</font></p>
<blockquote>
  <p><font face="Arial">Tells the window manager to redraw the visible 
  portions of the window's graphic buffer 'buffer' and the given clip 
  coordinates/size.</font></p>
</blockquote>
<p><font face="Courier New">int windowSetTitle(objectKey window, const char 
*title)</font></p>
<blockquote>
  <p><font face="Arial">Set the new title of window 'window' to be 
  'title'.</font></p>
</blockquote>
<p><font face="Courier New">int windowGetSize(objectKey window, unsigned *width, 
unsigned *height)</font></p>
<blockquote>
  <p><font face="Arial">Get the size of the window 'window', and put 
  the results in 'width' and 'height'.</font></p>
</blockquote>
<p><font face="Courier New">int windowSetSize(objectKey window, unsigned width, 
unsigned height)</font></p>
<blockquote>
  <p><font face="Courier New">&nbsp;&nbsp;&nbsp; </font>
  <font face="Arial">Resize the window 'window' to the width 'width' 
  and the height 'height'.</font></p>
</blockquote>
<p><font face="Courier New">int windowAutoSize(objectKey window)</font></p>
<blockquote>
  <p><font face="Arial">Automatically set the size of window 'window' 
  based on the sizes and locations of the window components it contains.</font></p>
</blockquote>
<p><font face="Courier New">int windowGetLocation(objectKey window, int *xCoord, 
int *yCoord)</font></p>
<blockquote>
  <p><font face="Arial">Get the current screen location of the window 
  'window' and put it into the coordinate variables 'xCoord' and 'yCoord'.</font></p>
</blockquote>
<p><font face="Courier New">int windowSetLocation(objectKey window, int xCoord, 
int&nbsp; yCoord)</font></p>
<blockquote>
  <p><font face="Arial">Set the screen location of the window 'window' 
  using the coordinate variables 'xCoord' and 'yCoord'.</font></p>
</blockquote>
<p><font face="Courier New">int windowSetHasBorder(objectKey window, int 
trueFalse)</font></p>
<blockquote>
  <p><font face="Arial">Tells the window manager whether to draw a 
  border around the window 'window'.&nbsp; 'trueFalse' being non-zero means draw 
  a border.&nbsp; Windows have borders by default.</font></p>
</blockquote>
<p><font face="Courier New">int windowSetHasTitleBar(objectKey window, int 
trueFalse)</font></p>
<blockquote>
  <p><font face="Arial">Tells the window manager whether to draw a 
  title bar on the window 'window'.&nbsp; 'trueFalse' being non-zero means draw 
  a title bar.&nbsp; Windows have title bars by default.</font></p>
</blockquote>
<p><font face="Courier New">int windowSetMovable(objectKey window, int trueFalse)</font></p>
<blockquote>
  <p><font face="Arial">Tells the window manager whether the window 
  'window' should be movable by the user (i.e. clicking and dragging it).&nbsp; 
  'trueFalse' being non-zero means the window is movable.&nbsp; Windows are 
  movable by default.</font></p>
</blockquote>
<p><font face="Courier New">int windowSetHasCloseButton(objectKey window, int 
trueFalse)</font></p>
<blockquote>
  <p><font face="Arial">Tells the window manager whether to draw a 
  close button on the title bar of the window 'window'.&nbsp; 'trueFalse' being 
  non-zero means draw a close button.&nbsp; Windows have close buttons by 
  default, as long as they have a title bar.&nbsp; If there is no title bar, 
  then this function has no effect.</font></p>
</blockquote>
<p><font face="Courier New">int windowLayout(objectKey window)</font></p>
<blockquote>
  <p><font face="Arial">Do the layout of the window 'window' after all 
  the components have been added.&nbsp; You really should call this function 
  before displaying a window, or else all the window components will be squished 
  together in the top corner of the window, ignoring any grid coordinates you 
  have set in the 'componentParameters' structure of an </font>
  <font face="Courier New">windowAdd*Component()</font><font face="Arial"> 
  call.&nbsp; If you are going to use </font><font face="Courier New">
  windowAutoSize()</font><font face="Arial"> to size the window, you 
  should do so after this call.</font></p>
</blockquote>
<p><font face="Courier New">int windowSetVisible(objectKey window, int visible)</font></p>
<blockquote>
  <p><font face="Arial">Tell the window manager whether to make the 
  window 'window' visible or not.&nbsp; Non-zero 'visible' means make the window 
  visible.&nbsp; When windows are created, they are not visible by default so 
  you can add components, do layout, set the size, etc.</font></p>
</blockquote>
<p><font face="Courier New">int windowAddComponent(objectKey window, objectKey 
component, componentParameters *params)</font></p>
<blockquote>
  <p><font face="Arial">Add a window component 'component' to the 
  window 'window' using the parameters specified in the componentParameters 
  structure 'params'.&nbsp; You should probably use the </font>
  <font face="Courier New">windowAddClientComponent()</font><font face="Arial"> 
  function instead, as this function disregards things like the sizes of window 
  title bars and borders, so your window might look funny unless you know what 
  you're doing.</font></p>
</blockquote>
<p><font face="Courier New">int windowAddClientComponent(objectKey window, 
objectKey component, componentParameters 
*params)</font></p>
<blockquote>
  <p><font face="Arial">Add a window component 'component' to the 
  client area of the window 'window' using the parameters specified in the 
  componentParameters structure 'params'.&nbsp; This function is the normal way 
  to add any component to a window.</font></p>
</blockquote>
<p><font face="Courier New">unsigned windowComponentGetWidth(objectKey 
component)</font></p>
<blockquote>
  <p><font face="Arial">Get the pixel width of the window component 
  'component'.&nbsp; Useful if you are doing your window layout manually.</font></p>
</blockquote>
<p><font face="Courier New">unsigned windowComponentGetHeight(objectKey 
component)</font></p>
<blockquote>
  <p><font face="Arial">Get the pixel height of the window component 
  'component'.&nbsp; Useful if you are doing your window layout manually.</font></p>
</blockquote>
<p><font face="Courier New">void windowManagerRedrawArea(int xCoord, int yCoord, 
unsigned width, unsigned height)</font></p>
<blockquote>
  <p><font face="Arial">Tells the window manager to redraw whatever is 
  supposed to be in the screen area bounded by the supplied coordinates.&nbsp; 
  This might be useful if you were drawing non-window-based things on the screen 
  and you wanted them to go away later.</font></p>
</blockquote>
<p><font face="Courier New">void windowManagerProcessMouseEvent(objectKey 
mouseStatus)</font></p>
<blockquote>
  <p><font face="Arial">Called by the mouse functions to tell the 
  window manager that the mouse status has changed.&nbsp; Might be able to do 
  unusual things with this function if you're not a mouse driver, but I'm not 
  going to suggest any.</font></p>
</blockquote>
<p><font face="Courier New">int windowManagerTileBackground(const char *file)</font></p>
<blockquote>
  <p><font face="Arial">Load the image file specified by the pathname 
  'file', and if successful, tile the image on the background root window.</font></p>
</blockquote>
<p><font face="Courier New">int windowManagerCenterBackground(const char *file)</font></p>
<blockquote>
  <p><font face="Arial">Load the image file specified by the pathname 
  'file', and if successful, center the image on the background root window.</font></p>
</blockquote>
<p><font face="Courier New">int windowManagerScreenShot(image *saveImage)</font></p>
<blockquote>
  <p><font face="Arial">Get an image representation of the entire 
  screen in the image data structure 'saveImage'.&nbsp; Note that it is not 
  necessary to allocate memory for the data pointer of the image structure 
  beforehand, as this is done automatically.&nbsp; You should, however, 
  deallocate the data field of the image structure when you are finished with 
  it.</font></p>
</blockquote>
<p><font face="Courier New">int windowManagerSaveScreenShot(const char 
*filename)</font></p>
<blockquote>
  <p><font face="Arial">Save a screenshot of the entire screen to the 
  file specified by the pathname 'filename'.</font></p>
</blockquote>
<p><font face="Courier New">int windowManagerSetTextOutput(objectKey key) </font>
</p>
<blockquote>
  <p><font face="Arial">Set the text output (and input) of the calling 
  process to the object key of some window component, such as a TextArea or 
  TextField component.&nbsp; You'll need to use this if you want to output text 
  to one of these components or receive input from one.</font></p>
</blockquote>
<p><font face="Courier New">objectKey windowNewButtonComponent(objectKey window, 
unsigned width, unsigned height, const char *label, image *buttonImage)</font></p>
<blockquote>
  <p><font face="Arial">Get a new ButtonComponent to be placed in the 
  window 'window', using the supplied width and height, and with the (optional) 
  label 'label', or the (optional) image 'buttonImage'.&nbsp; Either 'label' or 
  'buttonImage' can be non-NULL, but not both.&nbsp; For the moment, there is no 
  mechanism for a callback function to a user space program, so a button 
  component is not currently very useful to user programs since it won't be able 
  to trigger any action.&nbsp; After creating any window component you should 
  add it to the window by calling the </font><font face="Courier New">
  windowAddClientComponent()</font><font face="Arial">&nbsp; function.</font></p>
</blockquote>
<p><font face="Courier New">objectKey windowNewIconComponent(objectKey window, 
image *iconImage, const char *label, const char *command)</font></p>
<blockquote>
  <p><font face="Arial">Get a new IconComponent to be placed in the 
  window 'window', using the image data structure 'iconImage' and the label 
  'label'.&nbsp; If you want the icon to execute a command when clicked, you 
  should specify it in 'command'.&nbsp; After creating any window component you 
  should add it to the window by calling the </font><font face="Courier New">
  windowAddClientComponent()</font><font face="Arial">&nbsp; function.</font></p>
</blockquote>
<p><font face="Courier New">objectKey windowNewImageComponent(objectKey window, 
image *baseImage)</font></p>
<blockquote>
  <p><font face="Arial">Get a new ImageComponent to be placed in the 
  window 'window', using the image data structure 'baseImage' .&nbsp; After 
  creating any window component you should add it to the window by calling the
  </font><font face="Courier New">windowAddClientComponent()</font><font face="Arial">&nbsp; 
  function.</font></p>
</blockquote>
<p><font face="Courier New">objectKey windowNewTextAreaComponent(objectKey 
window, int columns, int rows, objectKey font)</font></p>
<blockquote>
  <p><font face="Arial">Get a new TextAreaComponent to be placed in 
  the window 'window', using the number of columns 'columns', the number of rows 
  'rows', and the font 'font'.&nbsp; If 'font' is NULL, that means use the 
  default font.&nbsp; After creating any window component you should add it to 
  the window by calling the </font><font face="Courier New">
  windowAddClientComponent()</font><font face="Arial">&nbsp; function.</font></p>
</blockquote>
<p><font face="Courier New">objectKey windowNewTextFieldComponent(objectKey 
window, int columns, objectKey font)</font></p>
<blockquote>
  <p><font face="Arial">Get a new TextFieldComponent to be placed in 
  the window 'window', using the number of columns 'columns' and the font 
  'font'.&nbsp; TextFieldComponents are essentially 1-line TextAreaComponents.&nbsp; 
  If 'font' is NULL, that means use the default font.&nbsp; After creating any 
  window component you should add it to the window by calling the </font>
  <font face="Courier New">windowAddClientComponent()</font><font face="Arial">&nbsp; 
  function.</font></p>
</blockquote>
<p><font face="Courier New">objectKey windowNewTextLabelComponent(objectKey 
window, objectKey font, const char *text)</font></p>
<blockquote>
  <p><font face="Arial">Get a new TextLabelComponent to be placed in 
  the window 'window', using the text string 'text' and the font 'font'.&nbsp; 
  If 'font' is NULL, that means use the default font.&nbsp; After creating any 
  window component you should add it to the window by calling the </font>
  <font face="Courier New">windowAddClientComponent()</font><font face="Arial">&nbsp; 
  function.</font></p>
</blockquote>
<p><font face="Courier New">objectKey windowNewTitleBarComponent(objectKey 
window, unsigned width, unsigned height)</font></p>
<blockquote>
  <p><font face="Arial">Get a new TitleBarComponent to be placed in 
  the window 'window', using the width 'width' and the height 'height'.&nbsp; At 
  the time of writing, this is not necessarily useful to external programs as 
  window title bars are created automatically if applicable, and using this 
  function might produce surprising results.&nbsp; After creating any window 
  component you should add it to the window by calling the </font>
  <font face="Courier New">windowAddClientComponent()</font><font face="Arial">&nbsp; 
  function.</font></p>
</blockquote>
<p>&nbsp;</p>
<p><b><a name="misc"></a>Miscellaneous functions</b></p>
<p><font face="Courier New">int fontGetDefault(objectKey *pointer)</font></p>
<blockquote>
  <p><font face="Arial">Get an object key in 'pointer' to refer to the 
  current default font.</font></p>
</blockquote>
<p><font face="Courier New">int fontSetDefault(const char *name)</font></p>
<blockquote>
  <p><font face="Arial">Set the default font for the system to the 
  font with the name 'name'.&nbsp; The font must previously have been loaded by 
  the system, for example using the </font><font face="Courier New">fontLoad()</font><font face="Arial">&nbsp; 
  function.</font></p>
</blockquote>
<p><font face="Courier New">int fontLoad(const char* filename, const char *fontname, 
objectKey *pointer)</font></p>
<blockquote>
  <p><font face="Arial">Load the font from the font file 'filename', 
  give it the font name 'fontname' for future reference, and return an object 
  key for the font in 'pointer' if successful.</font></p>
</blockquote>
<p><font face="Courier New">unsigned fontGetPrintedWidth(objectKey font, const 
char *string)</font></p>
<blockquote>
  <p><font face="Arial">Given the supplied string, return the screen 
  width that the text will consume given the font 'font'.&nbsp; Useful for 
  placing text when using a variable-width font, but not very useful otherwise.</font></p>
</blockquote>
<p><font face="Courier New">unsigned fontGetHeight(objectKey font)</font></p>
<blockquote>
  <p><font face="Arial">Get the height of characters when using the 
  font 'font'.</font></p>
</blockquote>
<p><font face="Courier New">int imageLoadBmp(const char *filename, image *loadImage)</font></p>
<blockquote>
  <p><font face="Arial">Try to load the bitmap image file 'filename', 
  and if successful, save the data in the image data structure 'loadImage'.</font></p>
</blockquote>
<p><font face="Courier New">int imageSaveBmp(const char *filename, image *saveImage)</font></p>
<blockquote>
  <p><font face="Arial">Save the image data structure 'saveImage' as a 
  bitmap, to the file 'fileName'.</font></p>
</blockquote>
<p><font face="Courier New">int shutdown(int type, int nice)</font></p>
<blockquote>
  <p><font face="Arial">Shutdown or reboot the system, according to 
  the value ('shutdown' or 'reboot') 'type'.&nbsp; If 'nice' is zero, the 
  shutdown will be orderly and will abort if serious errors are detected.&nbsp; 
  If 'nice' is non-zero, the system will go down like a kamikaze regardless of 
  errors.</font></p>
</blockquote>
<p><font face="Courier New">const char *version(void)</font></p>
<blockquote>
  <p><font face="Arial">Get the kernel's version string.</font></p>
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