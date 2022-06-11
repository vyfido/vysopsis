;;
;;  Visopsys
;;  Copyright (C) 1998-2006 J. Andrew McLaughlin
;; 
;;  This program is free software; you can redistribute it and/or modify it
;;  under the terms of the GNU General Public License as published by the Free
;;  Software Foundation; either version 2 of the License, or (at your option)
;;  any later version.
;; 
;;  This program is distributed in the hope that it will be useful, but
;;  WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
;;  or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
;;  for more details.
;;  
;;  You should have received a copy of the GNU General Public License along
;;  with this program; if not, write to the Free Software Foundation, Inc.,
;;  59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
;;
;;  bootsect-read.s
;;

;; This code is a common disk reading routine for bootsector code.  It's just
;; meant to be %included, not compiled separately.


read:
	;; Proto: int read(dword logical, word seg, word offset, word count);

	pusha
	
	;; Save the stack pointer
	mov BP, SP

	push word 0		; To keep track of read attempts

	.readAttempt:
	;; Determine whether int13 extensions are available
	cmp byte [DISK], 80h
	jb .noExtended
	
	mov AH, 41h
	mov BX, 55AAh
	mov DL, byte [DISK]
	int 13h
	jc .noExtended

	;; We have a nice extended read function which will allow us to
	;; just use the logical sector number for the read

	mov word [DISKPACKET], 0010h		; Packet size
	mov byte [DISKPACKET + 1], 0		; Reserved
	mov AX, word [SS:(BP + 26)]
	mov word [DISKPACKET + 2], AX		; Sector count
	mov AX, word [SS:(BP + 24)]
	mov word [DISKPACKET + 4], AX		; Offset
	mov AX, word [SS:(BP + 22)]
	mov word [DISKPACKET + 6], AX		; Segment
	mov EAX, dword [SS:(BP + 18)]
	mov dword [DISKPACKET + 8], EAX		; Logical sector
	mov dword [DISKPACKET + 12], 0		;
	mov AX, 4200h
	mov DL, byte [DISK]
	mov SI, DISKPACKET
	int 13h
	jc .error
	jmp .done

	.noExtended:
	;; No extended functionality.  Read the sectors one at a time.

	;; Calculate the CHS.  First the sector
	mov EAX, dword [SS:(BP + 18)]
	xor EBX, EBX
	xor EDX, EDX
	mov BX, word [NUMSECTS]
	div EBX
	mov byte [SECTOR], DL		; The remainder
	add byte [SECTOR], 1		; Sectors start at 1
	
	;; Now the head and track
	xor EDX, EDX			; Don't need the remainder anymore
	xor EBX, EBX
	mov BX, word [NUMHEADS]
	div EBX
	mov byte [HEAD], DL		; The remainder
	mov word [CYLINDER], AX

	mov AX, word [SS:(BP + 26)]	; Number to read
	mov AH, 02h			; Subfunction 2
	mov CX, word [CYLINDER]		; >
	rol CX, 8			; > Cylinder
	shl CL, 6			; >
	or CL, byte [SECTOR]		; Sector
	mov DH, byte [HEAD]		; Head
	mov DL, byte [DISK]		; Disk
	mov BX, word [SS:(BP + 24)]	; Offset
	push ES				; Save ES
	mov ES, word [SS:(BP + 22)]	; Use user-supplied segment
	int 13h
	pop ES				; Restore ES
	jnc .done

	.error:
	;; We'll reset the disk and retry up to 4 more times

	;; Reset the disk controller
	xor AH, AH
	mov DL, byte [DISK]
	int 13h
			
	;; Increment the counter
	pop AX
	inc AX
	push AX
	cmp AX, 05h
	jnae .readAttempt
	
	;; We've run out of retries.  Fatal.
	jmp IOError

	.done:	
	pop AX			; Counter
	popa
	ret
