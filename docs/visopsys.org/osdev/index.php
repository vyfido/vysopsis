<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Visopsys | Visual Operating System | OS Development</title>
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
              <a href="../download/index.php"><img border="0" src="../img/nav_buttons/download.gif"></a>&nbsp;&nbsp; <a href="../forums/index.php"><img border="0" src="../img/nav_buttons/forum.gif"></a>&nbsp; <a href="../developers/index.php"><img border="0" src="../img/nav_buttons/developers.gif"></a></b></font><font color="#EEEEFF" size="2" face="arial"><b>&nbsp;&nbsp; 
              <a href="index.php"><img border="0" src="../img/nav_buttons/osdev.gif"></a>&nbsp;&nbsp; 
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

<p align="left"><b><font size="4">OS Development</font></b></p>

<div align="center">
  <center>
  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="700">
    <tr>
      <td>

<p align="left">This little page is  a small collection of source code,
information, and links related to general Operating Systems' Development on the Web.</p>

<blockquote>
  <p align="left"><a href="index.php#SOURCE">Source code</a><br>
  <a href="index.php#LINKS">Links</a><br>
  </p>
</blockquote>

<p align="left"><a name="SOURCE"></a>SOURCE CODE</p>

<p align="left">Here is some source code, written by Andy McLaughlin, which might be
useful to programmers who are developing OS- like products on the x86 platform. &nbsp; All
code ending with an &quot;.s&quot; extension is NASM- compatible Assembler code.&nbsp; All
&quot;.c&quot; code is tested for gcc-2.95 (or compatible) C compilers.</p>

<blockquote>
  <div align="center"><center><table border="1" cellpadding="2">
    <tr>
      <td><a href="sources/enableA20.php">enableA20.s</a></td>
      <td>This is a fairly versatile snippet of code for enabling the x86's A20 address
      line. &nbsp; It's a little bit lengthy, but it seems to work more reliably than other
      examples I've tried.&nbsp; Cut and paste it into one of your existing source files.</td>
    </tr>
    <tr>
      <td><a href="sources/vesaModes.php">vesaModes.s</a></td>
      <td>This piece of 16-bit code will query the VESA BIOS for a supported graphics mode
      number based on the desired parameters of resolution and colour depth.&nbsp; Cut and paste
      it into one of your existing source files.</td>
    </tr>
  </table>
  </center></div>
</blockquote>

<p>&nbsp;</p>

<p><a name="LINKS"></a>LINKS</p>

<p>Here are some selected links to sites useful to OS developers (much of this is
specific to PC- style hardware architectures).&nbsp; Please
<a href="mailto:andy@visopsys.org">email me</a> about any broken links or erroneous
descriptions.&nbsp; Thanks.</p>

<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" valign="top" align="left"><p align="center">
    <br>
    General<br>
&nbsp;</th>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a ADD_DATE="941145092" LAST_VISIT="941144904" LAST_MODIFIED="941144904" href="http://chuos.genezys.net/wiki/Questions%20for%20an%20OS%20designer">Questions
    For an OS Designer</a></td>
    <td valign="top" align="left">So, why are you doing this anyway?&nbsp; This should be
    required reading for anyone contemplating starting an OS project</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a ADD_DATE="942169435" LAST_VISIT="956860285" LAST_MODIFIED="942169427" href="http://wiki.osdev.org/Main_Page">
    The OSDev.org wiki</a></td>
    <td valign="top" align="left">Almost everything you need to know about OS development</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a ADD_DATE="936812205" LAST_VISIT="947741046"
    LAST_MODIFIED="936812199" href="http://www.nondot.org/sabre/os/">
    The Operating Systems
    Resource Center</a></td>
    <td valign="top" align="left">Great collection of technical information and tutorials</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a HREF="http://www.acm.uiuc.edu/sigops/roll_your_own/"
    ADD_DATE="944517138" LAST_VISIT="956694396" LAST_MODIFIED="944517129">
    SigOps: Create Your
    Own Operating System</a></td>
    <td valign="top" align="left">This is a broadly focused site about OS theory</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a HREF="http://www.cs.cmu.edu/afs/cs/user/ralf/pub/WWW/files.html"
        ADD_DATE="944155995" LAST_VISIT="957927099" LAST_MODIFIED="944155986">
    Ralf Brown's
        Interrupt List</a> <a HREF="http://ctyme.com/rbrown.htm" ADD_DATE="910562877"
        LAST_VISIT="954626368" LAST_MODIFIED="910562874">(also try this HTML Version)</a></td>
    <td valign="top" align="left">Don't start any OS project on an x86 machine without
    getting this first.</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a ADD_DATE="957927954" LAST_VISIT="957927975" LAST_MODIFIED="957927942" href="http://docs.huihoo.com/help-pc/">HelpPC WWW conversion
    </a>
    <a
        ADD_DATE="937975683" LAST_VISIT="0" LAST_MODIFIED="0"
        href="ftp://ftp.simtel.net/pub/simtelnet/msdos/info/helppc21.zip">
    (or download the actual
        HelpPC application)</a></td>
    <td valign="top" align="left">Likewise.</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a HREF="http://www.sandpile.org/80x86/index.shtml"
    ADD_DATE="917740542" LAST_VISIT="939708597" LAST_MODIFIED="917740506">
    sandpile.org --
    80x86 index</a></td>
    <td valign="top" align="left">Lots of good information about x86 processors.</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a HREF="http://sourceforge.net/projects/nasm"
    ADD_DATE="905722436" LAST_VISIT="958004961" LAST_MODIFIED="905722431">
    NASM - The Netwide
    Assembler Project - FREE 80x86 assembler</a></td>
    <td valign="top" align="left">A GREAT little open- source assembler for x86 machines.</td>
  </tr>
  </table>

<p>&nbsp;</p>

<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" valign="top" align="left">
    <p align="center"><br>
    <b>File systems<br>
&nbsp;</b></td>
  </tr>
  <tr>
    <th valign="top" align="left"><span style="font-weight: 400">
    <a href="http://e2fsprogs.sourceforge.net/ext2intro.html">Design and Implementation of the Second Extended File System</a></span></th>
    <th valign="top" align="left"><span style="font-weight: 400">
    The original EXT2 white paper</span></th>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://www.science.unitn.it/~fiorella/guidelinux/tlk/node95.html">
    The Second Extended File System</a></td>
    <td valign="top" align="left">Another EXT2 doc from a Linux 
    site</td>
  </tr>
  <tr>
    <th valign="top" align="left">
    <span style="font-weight: 400">
    <a href="http://www.penguin.cz/~mhi/fs/Filesystems-HOWTO/Filesystems-HOWTO.html">
    The Filesystems HOWTO</a></span></th>
    <th valign="top" align="left"><span style="font-weight: 400">
    Info about lots of different 
    filesystems</span></th>
  </tr>
  <tr>
    <th valign="top" align="left">
    <span style="font-weight: 400">
    <a href="http://www.dfsee.com/fsinfo.htm">File System Info</a></span></th>
    <th valign="top" align="left"><span style="font-weight: 400">
    HPFS, FAT, NTFS info</span></th>
  </tr>
  <tr>
    <th valign="top" align="left">
    <span style="font-weight: 400">
    <a href="http://www.nongnu.org/ext2-doc/ext2.html">The Second Extended 
    (EXT2) File System</a></span></th>
    <th valign="top" align="left"><span style="font-weight: 400">
    An EXT2 &quot;book&quot; by Dave Poirier.&nbsp; 
    Very good.</span></th>
  </tr>
  <tr>
    <th valign="top" align="left">
    <span style="font-weight: 400">
    <a href="http://www.nondot.org/sabre/os/files/FileSystems/Ext2fs-overview-0.1.pdf">
    The Extended-2 (EXT2) Filesystem Overview</a></span></th>
    <th valign="top" align="left"><span style="font-weight: 400">
    A white paper by Gadi Oxman.&nbsp; A 
    bit dated, but good as an alternative source of EXT2 information.</span></th>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://www.osta.org/specs">UDF (DVD) filesystem</a></td>
    <td valign="top" align="left">DVD-ROM filesystem format 
    specifications</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://homepage.mac.com/wenguangwang/myhome/udf.html">UDF (DVD) 
    filesystem</a></td>
    <td valign="top" align="left">Good intoduction to UDF</td>
  </tr>
  </table>

<p>&nbsp;</p>

<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" align="left" valign="top"><p align="center">
    <br>
    File Formats<br>
&nbsp;</th>
  </tr>
  <tr>
    <td valign="top" align="left"><a HREF="http://www.wotsit.org/" ADD_DATE="922861319"
    LAST_VISIT="960751669" LAST_MODIFIED="922861311">Wotsit's Format: The programmer's file
    formats and data formats resource.</a></td>
    <td valign="top" align="left">This site is a godsend.&nbsp; Information on file
    formats of almost any kind. &nbsp; Look here before you go anywhere else.</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a HREF="http://www.maverick-os.dk/FileSystemFormats/Standard_DiskFormat.html"
        ADD_DATE="952632826" LAST_VISIT="953150996" LAST_MODIFIED="952632769">
    Standard Disk Format
        (Maverick)</a></td>
    <td valign="top" align="left">All about the format of the x86 Master Boot Sector</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a HREF="http://www.delorie.com/djgpp/doc/coff/"
    ADD_DATE="948823955" LAST_VISIT="948824026" LAST_MODIFIED="948823940">
    DJGPP COFF Spec</a></td>
    <td valign="top" align="left">About the COFF object file format</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a HREF="http://www.dcs.ed.ac.uk/~mxr/gfx/"
    ADD_DATE="939713004" LAST_VISIT="939713001" LAST_MODIFIED="939713001">
    The Graphics File
    Format Page</a></td>
    <td valign="top" align="left">Info about lots of graphic file 
    formats</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://fontforge.sourceforge.net/pcf-format.html">PCF Bitmap Font 
    Files</a></td>
    <td valign="top" align="left">X11 (Linux, Unix) font file 
    format </td>
  </tr>
  </table>

<p>&nbsp;</p>

<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <th colspan="2" align="left" valign="top">
    <p align="center"><br>
        PC Hardware References<br>
&nbsp;</th>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a ADD_DATE="936035099" LAST_VISIT="937975603" LAST_MODIFIED="936035094" href="http://www.intel.com/products/processor/manuals/index.htm">Pentium(r)Processor - Manuals</a></td>
    <td valign="top" align="left">You need this if you're going to do any coding in x86
    Assembly language</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a HREF="http://www.ata-atapi.com/" ADD_DATE="940438338" LAST_VISIT="949559132"
        LAST_MODIFIED="940438321">ATA-ATAPI.COM -- ATA ATAPI IDE EIDE</a><br>
    <a HREF="http://www.repairfaq.org/filipg/LINK/F_IDE-tech.html" ADD_DATE="947283126"
        LAST_VISIT="953416474" LAST_MODIFIED="947283121">Fil's FAQ-Link-In Corner: IDE Ref.</a><br>
    <a href="http://suif.stanford.edu/~csapuntz/blackmagic.html">
    ATA/ATAPI Errata</a></td>
    <td valign="top" align="left">Programming the PC's IDE controller</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://wiki.osdev.org/AHCI">OSDev.org's AHCI (native SATA) page</a><br>
    <a href="http://linuxmafia.com/faq/Hardware/sata.html">SATA on Linux</a></td>
    <td valign="top" align="left">Programming the PC's SATA 
    controller</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a HREF="http://atschool.eduweb.co.uk/camdean/pupils/amac/vga.htm"
        ADD_DATE="939883140" LAST_VISIT="957999110" LAST_MODIFIED="939882924">VGA graphics
        Programming</a><br>
    <a HREF="http://www.monstersoft.com/tutorial1/" ADD_DATE="939711347"
        LAST_VISIT="960854272" LAST_MODIFIED="939711345">High-res high-speed VESA tutorial</a><br>
    <a HREF="http://gameprogrammer.com/" ADD_DATE="939712551" LAST_VISIT="939869549"
        LAST_MODIFIED="939712542">Game Programming and graphics programming</a><br>
    <a HREF="http://www.brackeen.com/home/vga/" ADD_DATE="939880909"
        LAST_VISIT="939880891" LAST_MODIFIED="939880891">256-Color VGA Programming in C - Home</a><br>
    <a HREF="http://www.hornet.org/" ADD_DATE="942167526" LAST_VISIT="942340497"
        LAST_MODIFIED="942167525">Graphics and sound - The Hornet Archive</a></td>
    <td valign="top" align="left">Programming the PC's video 
    hardware</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://www.computer-engineering.org/ps2keyboard/">The PS/2 Keyboard 
    Interface</a></td>
    <td valign="top" align="left">Programming the PC keyboard</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://www.computer-engineering.org/ps2mouse/">PS/2 Mouse 
    Interfacing</a></td>
    <td valign="top" align="left">Programming the PC mouse</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a HREF="http://www.lvr.com/serport.htm" ADD_DATE="936145651"
        LAST_VISIT="936145642" LAST_MODIFIED="936145642">Serial Links using RS-232 and RS-485</a></td>
    <td valign="top" align="left">Serial port programming information</td>
  </tr>
  <tr>
    <td valign="top" align="left"><a
    HREF="ftp://rtfm.mit.edu/pub/usenet/news.answers/pc-hardware-faq/" ADD_DATE="939229824"
    LAST_VISIT="939708137" LAST_MODIFIED="939229087">/pub/usenet/news.answers/pc-hardware-faq</a></td>
    <td valign="top" align="left">PC hardware Usenet FAQ</td>
  </tr>
  </table>

<p>&nbsp;</p>

<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="left" colspan="2">
    <p align="center"><br>
    <b>Networking<br>
&nbsp;</b></td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://www.freesoft.org/CIE/Course/Section3/">The IP Protocol</a></td>
    <td valign="top" align="left">The IP networking protocol (you 
    need to implement this before TCP, UDP, etc.)</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://www.fefe.de/linuxeth/">Choosing an Ethernet NIC</a></td>
    <td valign="top" align="left">Some Linux-related general info 
    about network cards</td>
  </tr>
  </table>

<p>&nbsp;</p>

<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="left" colspan="2">
    <p align="center"><br>
    <b>Graphics<br>
&nbsp;</b></td>
  </tr>
  <tr>
    <td valign="top" align="left"><a href="http://en.wikipedia.org/wiki/JPEG">
    Wikipedia's JPEG page</a><br>
    <a href="http://www.impulseadventure.com/photo/jpeg-decoder.html">Calvin 
    Hass's JPEG decoding pages</a><br>
&nbsp;&nbsp;&nbsp;&nbsp; -
    <a href="http://www.impulseadventure.com/photo/jpeg-huffman-coding.html">
    Huffman coding</a><br>
&nbsp;&nbsp;&nbsp;&nbsp; -
    <a href="http://www.impulseadventure.com/photo/jpeg-minimum-coded-unit.html">
    MCUs</a><br>
&nbsp;&nbsp;&nbsp;&nbsp; -
    <a href="http://www.impulseadventure.com/photo/chroma-subsampling.html">
    Chroma subsampling</a><br>
&nbsp;&nbsp;&nbsp;&nbsp; -
    <a href="http://www.impulseadventure.com/photo/jpeg-snoop.html">JPEGsnoop</a> 
    (dumps JPEG data)<br>
&nbsp;&nbsp;&nbsp;&nbsp; -
    <a href="http://www.impulseadventure.com/photo/lossless-rotation.html">
    Lossless rotation</a><br>
&nbsp;&nbsp;&nbsp;&nbsp; -
    <a href="http://www.impulseadventure.com/photo/rotation-partial-mcu.html">
    Lossless rotation of partial MCUs</a><br>
    <a href="http://www.ddj.com/184409589?pgno=8">Dr. 
    Dobb's JPEG-like image compression</a></td>
    <td valign="top" align="left">JPEG image decoding and the 
    JFIF file format</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://en.wikipedia.org/wiki/Bicubic_interpolation">Wikipedia's bicubic interpolation page</a><br>
    <a href="http://en.wikipedia.org/wiki/Bilinear_filtering">Wikipedia's 
    bilinear filtering page</a></td>
    <td valign="top" align="left">Image resizing</td>
  </tr>
  </table>

<p>&nbsp;</p>

<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="left" colspan="2">
    <p align="center"><br>
    <b>Miscellaneous<br>
&nbsp;</b></td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://www.freesoft.org/CIE/RFC/1321/index.htm">RFC 1321 - The MD5 
    Message-Digest Algorithm</a></td>
    <td valign="top" align="left">The MD5 hashing algorithm (for 
    passwords, etc.)</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <a href="http://www.microsoft.com/whdc/system/platform/64bit/default.mspx">
    EFI: 64-bit System Design</a></td>
    <td valign="top" align="left">Documents and links describing 
    EFI firmware, GPT partition tables, etc. from Microsoft</td>
  </tr>
  </table>

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