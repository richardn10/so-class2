#!/bin/sh
#
# (c) SwitchedOn
#
# This script will update the specific centre's server admin/root passwords.
# This is because the install/patch scripts in the respository use e.g. TEMP
# as the initial passwords.
#
# $Id$
#

alterMoodleConfigValue() {
  configFile=$1
  configParam=$2
  configValue=$3
  
  sed -i "s/\(\\$CFG->$configParam[ ]*=[ ]*'\).*\(';\)/\1$configValue\2/" $configFile
  
  if [ $? -ne 0 ] ;then
    echo "ERROR: couldn't modify moodle config (file='$configFile'  param='$configParam'  value='$configValue')"
    exit 1
  fi
}

if [ $# -ne 4 ] ;then
  echo "ERROR: wrong arguments supplied"
  echo ""
  echo "usage: $0 centreId existingCentreAdminPassword masterAdminPassword wwwMoodleDir
  echo ""
  echo "   e.g. $0 soinndel01 TEMP IamAsecurePassword /srv/www/moodle
  
  exit 1
fi

centreId=$1
existingCentreAdminPassword=$2
masterAdminPassword=$3
wwwMoodleDir=$4

# Make sure the dir params don't end in slash.
wwwMoodleDir=`echo "$wwwMoodleDir" | sed 's/^\(.*\)\/$/\1/'`


# New centre-specific admin password
#
newCentreAdminPassword=`echo -n "$centreId|$masterAdminPassword" | md5sum | awk '{print $1}'`

echo "newCentreAdminPassword: $newCentreAdminPassword"


# MySQL root password
#
mysqladmin -uroot -p$existingCentreAdminPassword password $newCentreAdminPassword
if [ $? -ne 0 ] ;then
  echo "ERROR: couldn't change MySQL root password"
  exit 1
fi

# MySQL moodle password
#
mysqladmin -umoodle -p$existingCentreAdminPassword password $newCentreAdminPassword
if [ $? -ne 0 ] ;then
  echo "ERROR: couldn't change MySQL root password"
  exit 1
fi

# Modify moodle config.php
# Do this after changing the database password.
#
alterMoodleConfigValue $wwwMoodleDir/config.php "dbpass" $newCentreAdminPassword
