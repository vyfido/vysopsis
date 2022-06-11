<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Visopsys | Visual Operating System | OS Development - Querying VESA Video Modes</title>
    <meta id="description" name="description" content="Visopsys | Visual Operating System"/>
    <link rel="icon" href="../../favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="../../favicon.ico" type="image/x-icon"/>
    <font face="arial">
    </head><body><div align="center">
      <center>
		<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" id="main">
		  <tr>
			<td bgcolor="#1C42A7" nowrap align="left">
			  <p align="center">
			  <img border="0" src="../../img/visopsys-upper.gif" align="left" width="193" height="35"></td>
			<td bgcolor="#1C42A7" nowrap align="left">
    <font face="arial">
			  <font color="#EEEEFF" size="2">
			  <b>
              &nbsp; <a href="http://visopsys.org/index.php"><img border="0" src="../../img/nav_buttons/home.gif"></a>&nbsp; 
              <a href="../../about/index.php"><img border="0" src="../../img/nav_buttons/about.gif"></a>&nbsp;&nbsp; <a href="../../about/news.php"><img border="0" src="../../img/nav_buttons/news.gif"></a>&nbsp;&nbsp; <a href="../../about/screenshots.php"><img border="0" src="../../img/nav_buttons/screenshots.gif"></a>&nbsp;&nbsp; 
              <a href="../../download/index.php"><img border="0" src="../../img/nav_buttons/download.gif"></a>&nbsp;&nbsp; <a href="../../forums/index.php"><img border="0" src="../../img/nav_buttons/forum.gif"></a>&nbsp; <a href="../../developers/index.php"><img border="0" src="../../img/nav_buttons/developers.gif"></a></b></font><font color="#EEEEFF" size="2" face="arial"><b>&nbsp;&nbsp; 
              <a href="../index.php"><img border="0" src="../../img/nav_buttons/osdev.gif"></a>&nbsp;&nbsp; 
              <a href="../../search.php"><img border="0" src="../../img/nav_buttons/search.gif"></a></b></font></font></td>
		  </tr>
		  <tr>
			<td bgcolor="#1C42A7" nowrap align="left" colspan="3">
				<img border="0" src="../../img/visopsys-lower.gif" align="left" width="299" height="15"></td>
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
      <td>QUERYING VESA VIDEO MODES&nbsp;
(<a href="vesaModes.s">download as a text file</a>)<pre><font size="3">;;
;; vesaModes.s (adapted from Visopsys OS-loader)
;;
;; Copyright (c) 2000, J. Andrew McLaughlin
;; You're free to use this code in any manner you like, as long as this
;; notice is included (and you give credit where it is due), and as long
;; as you understand and accept that it comes with NO WARRANTY OF ANY KIND.
;; Contact me at &lt;andy@visopsys.org&gt; about any bugs or problems.
;;

	;; Change this to zero if you don't require Linear Framebuffer
	;; abilities in your graphics modes.  This could be turned into
	;; a function parameter of the routine below, if desired.
	%define REQUIRELFB 1

	
	BITS 16
	
	
findGraphicMode:
	;; The VESA 2.0 specification states that they will no longer
	;; create standard video mode numbers, and video card vendors are
	;; no longer required to support the old numbers.  This routine
	;; will dynamically find a supported mode number from the VIDEO BIOS,
	;; according to the desired resolutions, etc.
	
	;; The function takes parameters that describe the desired graphic
	;; mode, (X resolution, Y resolution, and Bits Per Pixel) and returns
	; the VESA mode number in EAX, if found.  Returns 0 on error.
	
	;; The C prototype for this function would look like the following:
	;; int findGraphicMode(short int x_res, short int y_res, 
	;;                     short int bpp);
	;; (Push bpp, then y_res, then x_res onto the 16-bit stack before
	;; calling.  Caller pops them off again after the call.)

	;; Save space on the stack for the mode number we're returning
	sub SP, 2

	;; Save regs
	pusha

	;; Save the stack pointer
	mov BP, SP

	;; By default, return the value 0 (failure)
	mov word [SS:(BP + 16)], 0

	;; Get the VESA info block.  Save ES, since this call could
	;; destroy it
        push ES
        mov DI, VESAINFO
        mov AX, 4F00h
        int 10h
        ;; Restore ES
        pop ES

        cmp AX, 004Fh
	;; Fail
        jne .done
	
	;; We need to get a far pointer to a list of graphics mode numbers
	;; from the VESA info block we just retrieved.  Get the offset now,
	;; and the segment inside the loop.
	mov SI, [VESAINFO + 0Eh]

	;; Do a loop through the supported modes
	.modeLoop:
	
	;; Save ES
	push ES

	;; Now get the segment of the far pointer, as mentioned above
	mov AX, [VESAINFO + 10h]
	mov ES, AX

	;; ES:SI is now a pointer to the next supported mode.  The list
	;; terminates with the value FFFFh

	;; Get the first/next mode number
	mov DX, word [ES:SI]

	;; Restore ES
	pop ES

	;; Is it the end of the mode number list?
	cmp DX, 0FFFFh
	je near .done

	;; Increment the pointer for the next loop
	add SI, 2

	;; We have a mode number.  Now we need to do a VBE call to
	;; determine whether this mode number suits our needs.
	;; This call will put a bunch of info in the buffer pointed to
	;; by ES:DI

	mov CX, DX
	mov AX, 4F01h
	mov DI, MODEINFO
	int 10h

	;; Make sure the function call is supported
	cmp AL, 4Fh
	;; Fail
	jne near .done
	
	;; Is the mode supported by this call? (sometimes, they're not)
	cmp AH, 00h
	jne .modeLoop

	;; We need to look for a few features to determine whether this
	;; is the mode we want.  First, it needs to be supported, and it
	;; needs to be a graphics mode.  Next, it needs to match the
	;; requested attributes of resolution and BPP

	;; Get the first word of the buffer
	mov AX, word [MODEINFO]
	
	;; Is the mode supported?
	bt AX, 0
	jnc .modeLoop

	;; Is this mode a graphics mode?
	bt AX, 4
	jnc .modeLoop

	%if REQUIRELFB
	;; Does this mode support a linear frame buffer?
	bt AX, 7
	jnc .modeLoop
	%endif

	;; Does the horizontal resolution of this mode match the requested
	;; number?
	mov AX, word [MODEINFO + 12h]
	cmp AX, word [SS:(BP + 20)]
	jne near .modeLoop

	;; Does the vertical resolution of this mode match the requested
	;; number?
	mov AX, word [MODEINFO + 14h]
	cmp AX, word [SS:(BP + 22)]
	jne near .modeLoop

	;; Do the Bits Per Pixel of this mode match the requested number?
	xor AX, AX
	mov AL, byte [MODEINFO + 19h]
	cmp AX, word [SS:(BP + 24)]
	jne near .modeLoop

	;; If we fall through to here, this is the mode we want.
	mov word [SS:(BP + 16)], DX
	
	.done:
	popa
	;; Return the mode number
	xor EAX, EAX
	pop AX
	ret


;;
;; The data segment
;;

	SEGMENT .data
	ALIGN 4

VESAINFO  	db 'VBE2'		;; Space for info ret by vid BIOS
		times 508  db 0
MODEINFO	times 256 db 0</font></pre>
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