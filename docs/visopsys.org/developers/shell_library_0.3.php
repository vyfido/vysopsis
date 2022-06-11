<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Visopsys | Visual Operating System | Shell Library 0.3</title>
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

<div align="center"><font face="Arial">
  <center>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="700">
    <tr>
      <td><b>THE VISOPSYS SHELL LIBRARY (Version 0.3)</b><p>The shell library is a small set of functions created for the 
Visopsys shell, /programs/vsh, and provided as a library for other programs to 
use. </p>
<p>The functions are defined in the header file &lt;sys/vsh.h&gt; and 
the code is contained in libvsh.a (link with '-lvsh'). This code also requires a 
C library to link correctly (link with '-lc').<br>
&nbsp;</p>
<p><font face="Courier New">void vshPrintTime(unsigned unformattedTime)</font></p>
<blockquote>
  <p>Print the packed time value, specified by the unsigned integer 'unformattedTime' 
  -- such as that found in the file.modifiedTime field -- in a (for now, 
  arbitrary) human-readable format to standard output.</p>
</blockquote>
<p><font face="Courier New">void vshPrintDate(unsigned unformattedDate)</font></p>
<blockquote>
  <p>Print the packed date value, specified by the unsigned integer 'unformattedDate' 
  -- such as that found in the file.modifiedDate field -- in a (for now, 
  arbitrary) human-readable format.</p>
</blockquote>
<p><font face="Courier New">int vshFileList(const char *itemName)</font></p>
<blockquote>
  <p>Print a listing of a file or directory named 'itemName'. 'itemName' must be 
  an absolute pathname, beginning with '/'.</p>
</blockquote>
<p><font face="Courier New">int vshDumpFile(const char *fileName)</font></p>
<blockquote>
  <p>Print the contents of the file, specified by 'fileName', to standard 
  output. 'fileName' must be an absolute pathname, beginning with '/'.</p>
</blockquote>
<p><font face="Courier New">int vshDeleteFile(const char *deleteFile)</font></p>
<blockquote>
  <p>Delete the file specified by the name 'deleteFile'. 'deleteFile' must be an 
  absolute pathname, beginning with '/'.</p>
</blockquote>
<p><font face="Courier New">int vshCopyFile(const char *srcFile, const char *destFile)</font></p>
<blockquote>
  <p>Copy the file specified by the name 'srcFile' to the filename 'destFile'. 
  Both filenames must be absolute pathnames, beginning with '/'.</p>
</blockquote>
<p><font face="Courier New">int vshRenameFile(const char *srcFile, const char *destFile)</font></p>
<blockquote>
  <p>Rename (move) the file specified by the name 'srcFile' to the destination 'destFile'. 
  Both filenames must be absolute pathnames, beginning with '/'.</p>
</blockquote>
<p><font face="Courier New">void vshMakeAbsolutePath(const char *orig, char 
*new)</font></p>
<blockquote>
  <p>Turns a filename, specified by 'orig', into an absolute pathname 'new'. 
  This basically just amounts to prepending the name of the current directory 
  (plus a '/') to the supplied name. 'new' must be a buffer large enough to hold 
  the entire filename.</p>
</blockquote>
<p><font face="Courier New">void vshCompleteFilename(char *buffer)</font></p>
<blockquote>
  <p>Attempts to complete a portion of a filename, 'buffer'. The function will 
  append either the remainder of the complete filename, or if possible, some 
  portion thereof. The result simply depends on whether a good completion or 
  partial completion exists. 'buffer' must of course be large enough to contain 
  any potential filename completion.</p>
</blockquote>
<p><font face="Courier New">int vshSearchPath(const char *orig, char *new)</font></p>
<blockquote>
  <p>Search the current path (defined by the PATH environment variable) for the 
  first occurrence of the filename specified in 'orig', and place the complete, 
  absolete pathname result in 'new'. If a match is found, the function returns 
  zero. Otherwise, it returns a negative error code. 'new' must be large enough 
  to hold the complete absolute filename of any match found.</p>
</blockquote>

      </td>
    </tr>
  </table>
  </center>
</font>
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