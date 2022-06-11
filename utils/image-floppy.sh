#!/bin/sh
##
##  Visopsys
##  Copyright (C) 1998-2004 J. Andrew McLaughlin
## 
##  This program is free software; you can redistribute it and/or modify it
##  under the terms of the GNU General Public License as published by the Free
##  Software Foundation; either version 2 of the License, or (at your option)
##  any later version.
## 
##  This program is distributed in the hope that it will be useful, but
##  WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
##  or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
##  for more details.
##  
##  You should have received a copy of the GNU General Public License along
##  with this program; if not, write to the Free Software Foundation, Inc.,
##  59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
##
##  image-floppy.sh
##

echo ""
echo "Making Visopsys FLOPPY IMAGE file"
echo ""

# Are we doing a release version?  If the argument is "-r" then we use
# the release number in the destination directory name.  Otherwise, we
# assume an interim package and use the date instead
if [ "$1" == "-r" ] ; then
	echo "(doing RELEASE version)"
	echo ""
	# What is the current release version?
	RELEASE=`./release.sh`
else
	echo "(doing INTERIM version -- use -r flag for RELEASES)"
	echo ""
	# What is the date?
	RELEASE=`date +%Y-%m-%d`
fi

NAME=visopsys-$RELEASE
IMAGEFILE=floppy.img #$NAME.img
ZIPFILE=$NAME-img.zip

rm -f $IMAGEFILE
cp blankfloppy.gz $IMAGEFILE.gz
gunzip $IMAGEFILE.gz

./install.sh $IMAGEFILE

echo "Visopsys $RELEASE Image Release" > /tmp/comment
echo "Copyright (C) 1998-2004 J. Andrew McLaughlin" >> /tmp/comment
rm -f $ZIPFILE
zip -9 -z -r $ZIPFILE $IMAGEFILE < /tmp/comment >& /dev/null

rm /tmp/comment

echo ""
echo "File is: $ZIPFILE"
echo ""

exit 0
