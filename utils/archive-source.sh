#!/bin/sh
##
##  Visopsys
##  Copyright (C) 1998-2005 J. Andrew McLaughlin
## 
##  archive-source.sh
##

# This just does all of the things necessary to prepare an archive (zipfile)
# of the visopsys sources and utilities.

echo ""
echo "Making Visopsys SOURCE archive"
echo ""

# Are we doing a release version?  If the argument is "-r" then we use
# the release number in the destination directory name.  Otherwise, we
# assume an interim package and use the date instead
if [ "$1" = "-r" ] ; then
    # What is the current release version?
    RELEASE=`./release.sh`
    echo "(doing RELEASE version $RELEASE)"
    echo ""
else
    # What is the date?
    RELEASE=`date +%Y-%m-%d`
    echo "(doing INTERIM version $RELEASE -- use -r flag for RELEASES)"
    echo ""
fi

DESTDIR=visopsys-"$RELEASE"-src

# Make a copy of the visopsys directory.  We will not fiddle with the current
# working area
rm -Rf "$DESTDIR" /tmp/"$DESTDIR"
mkdir -p /tmp/"$DESTDIR"
(cd ..; tar cf - *) | (cd /tmp/"$DESTDIR"; tar xf - )
mv /tmp/"$DESTDIR" ./

# Make sure it's clean
echo -n "Making clean... "
make -C "$DESTDIR" clean >& /dev/null

# Remove all the things we don't want to distribute
# CVS droppings
find "$DESTDIR" -name CVS -exec rm -R {} \; >& /dev/null
# Other stuff
rm -Rf "$DESTDIR"/work
rm -f "$DESTDIR"/src/ISSUES.txt

echo done
echo -n "Archiving... "

echo "Visopsys $RELEASE Source Release" > /tmp/comment
echo "Copyright (C) 1998-2005 J. Andrew McLaughlin" >> /tmp/comment    
rm -f "$DESTDIR".zip
zip -9 -z -r "$DESTDIR".zip "$DESTDIR" < /tmp/comment >& /dev/null

echo done
echo -n "Cleaning up... "

# Remove the working directory
rm -Rf "$DESTDIR"
rm /tmp/comment

echo done

echo "File is: $DESTDIR.zip"
echo ""

exit 0
