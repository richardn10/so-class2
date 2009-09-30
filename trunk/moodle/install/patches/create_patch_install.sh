#!/bin/sh
#
# (c) SwitchedOn
#
# $Id$
#
# This creates a shar (shell archive) file, containing everything
# required for install of a specific moodle patch.
# Once the install shar has been created, it can then be simply executed.
#
# Pre-requisites:
#  - patchId dir is created and has relevant files created
#  - if required, moodle_www-so-mods is at the relevant state 
#
# TODO: what about moodledata...?
#

# This *must* be the same as in shar-installer.sh
SHAR_DIR=__tmp_sharFiles

if [ $# -ne 1 ] ;then
    echo "ERROR: wrong arguments supplied"
    echo ""
	echo "usage: $0 patchId"
	echo ""
	echo "   where patchId refers to a sub-directory of this script"
	exit 1
fi

patchId=$1

cd `dirname $0`
thisDir=`pwd`

patchDir=$thisDir/$1

if [ ! -d "$patchDir" ]; then
	echo "ERROR: patchDir ($patchDir) doesn't exist"
	exit 1
fi

patchInfoFile=$patchDir/patch_$patchId.txt

if [ ! -f "$patchInfoFile" ]; then
	echo "ERROR: patchInfoFile ($patchInfoFile) doesn't exist"
	exit 1
fi

patchDesc=`grep -E "^description=" $patchInfoFile | sed 's/.*=\(.*\)/\1/'`
moodleCorePackageUrl=`grep -E "^moodle-core-package-url=" $patchInfoFile | sed 's/.*=\(.*\)/\1/'`
moodleCorePackageFile=`grep -E "^moodle-core-package-file=" $patchInfoFile | sed 's/.*=\(.*\)/\1/'`
moodleCorePackageSubdir=`grep -E "^moodle-core-package-subdir=" $patchInfoFile | sed 's/.*=\(.*\)/\1/'`
moodleWwwSubdir=`grep -E "^moodle-www-subdir=" $patchInfoFile | sed 's/.*=\(.*\)/\1/'`
dbExistingSchema=`grep -E "^db-existing-schema=" $patchInfoFile | sed 's/.*=\(.*\)/\1/'`
patchWww=`grep -E "^patch-www=" $patchInfoFile | sed 's/.*=\(.*\)/\1/'`

if [ "$moodleCorePackageUrl" != "" -a "$moodleCorePackageFile" = "" ] ;then
	echo "ERROR: moodle-core-package-file must be set, since moodle-core-package-url is set"
	exit 1
fi

if [ "$moodleCorePackageUrl" = "" -a "$moodleCorePackageFile" != "" ] ;then
	echo "ERROR: why is moodle-core-package-file set, when moodle-core-package-url is not set?"
	exit 1
fi

if [ "$patchWww" != "yes" -a "$patchWww" != "no" ] ;then
	echo "ERROR: patch_www must be set to yes or no"
	exit 1
fi

if [ "$moodleCorePackageUrl" != "" -a "$patchWww" = "no" ] ;then
	echo "ERROR: patch_www must be set to yes, since moodle-core-package-url is set"
	exit 1
fi

# We've finished verifying input and info parameters.
# On with the install creation!



echo ""
echo "** Creating patch install for $patchId: $patchDesc"
echo ""

SHAR=moodle-patch-install_$patchId.sh

# Make sure we're in the dir of this script.
# Everything will be done relative to this dir.
cd `dirname $0`
thisDir=`pwd`

# (Re)Create temporary directory.
if [ -d $SHAR_DIR ] ;then
	rm -r $SHAR_DIR
fi
mkdir -p $SHAR_DIR

# Grab the core moodle package
#
wget --output-document=$SHAR_DIR/$moodleCorePackageFile $moodleCorePackageUrl
if [ $? -ne 0 ] ;then
	echo "ERROR: couldn't download core moodle package"
	exit 1
fi

if [ "$patchWww" = "yes" ] ;then
	# We'll be extracting these files directly into the moodle dir,
	# so make sure moodle_www-so-mods isn't included in the .tar.gz
	#
	if [ ! -d  ../../moodle_www-so-mods ] ; then
		echo "ERROR: the moodle_www-so-mods dir doesn't seem to exist!"
		exit 1
	fi
	cd ../../moodle_www-so-mods
	
	# This customisations patch will contain e.g. the .svn dirs.
	# It doesn't really matter though...
	#
	#tar cvf $thisDir/$SHAR_DIR/patch_$patchId-moodle_www-so-mods.tar *
	#gzip $thisDir/$SHAR_DIR/patch_$patchId-moodle_www-so-mods.tar
	tar cvf - * | gzip -c > $thisDir/$SHAR_DIR/patch_$patchId-moodle_www-so-mods.tar.gz
	if [ $? -ne 0 ] ;then
		echo "ERROR: couldn't create moodle mods package"
		exit 1
	fi
	
	# Back to this script's dir
	cd $thisDir
fi

# Include any files from the patchDir in the shar.
# e.g. The actual install script will make use of patch_$patchId-db.sql
#
cp -R $patchDir/* $SHAR_DIR

# (Re)Create the shar file
:>$SHAR
echo "rm -r $SHAR_DIR" >> $SHAR
echo "" >> $SHAR
shar $SHAR_DIR >> $SHAR
if [ $? -ne 0 ] ;then
	echo "ERROR: couldn't create the shar"
	exit 1
fi

# Remove the last line from the shar (which is `exit 0`)
if [ "`tail -1 $SHAR`" != "exit 0" ] ; then
	echo "ERROR: shar file ($SHAR) doesn't end with what we expect; renaming to .wrong"
	mv $SHAR $SHAR.wrong
	exit 1
fi
sed '$d' < $SHAR > $SHAR.tmp ; mv $SHAR.tmp $SHAR

echo "" >> $SHAR
#
# Inject parameters into the shar
#
echo "PATCH_ID=\"$patchId\"" >> $SHAR
echo "PATCH_DESC=\"$patchDesc\"" >> $SHAR
echo "MOODLE_CORE_PACKAGE=\"$moodleCorePackageFile\"" >> $SHAR
echo "MOODLE_CORE_PACKAGE_SUBDIR=\"$moodleCorePackageSubdir\"" >> $SHAR
echo "MOODLE_WWW_SUBDIR=\"$moodleWwwSubdir\"" >> $SHAR
echo "DB_EXISTING_SCHEMA=\"$dbExistingSchema\"" >> $SHAR
echo "SHAR_DIR=\"$SHAR_DIR\"" >> $SHAR
echo "" >> $SHAR
#
# Inject the install script into the shar
#
cat create_patch_install__shar-installer.sh.fragment >> $SHAR

# Make the shar executable
chmod u+x $SHAR

# Remove temporary directory/files.
rm -r $SHAR_DIR

echo ""
echo ""
echo "** Completed creating patch install for $patchId: $patchDesc"
echo ""
echo "created patch install shar: $SHAR"
echo ""
