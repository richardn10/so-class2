**Table of Contents**



# Introduction #

There are two steps to getting the installation of moodle on the site machines.
  1. Installing Moodle on the HQ sever, applying the patches, configuring moodle and then finally creating a patched version of Moodle for distributing to the sites.
  1. The patched version of Moodle will be distributed to the sites.  It will be a shar file which will install the patched version of Moodle on to the machine and update all the databases and config files.

# Requirements #
  * Subversion Client _- E.g. TortoiseSVN - see [Workpackage\_Repository\_InstallingSVN](Workpackage_Repository_InstallingSVN.md)_
  * shar - included in the install of openSUSE
  * querysniffer (see step 5)
  * access to the internet for the first step - the moodle on the HQ machine

# Creating a Moodle install #

**Note: It is important that this is not on a _live_ machine.  The method this process uses is a MySQL packet sniffer from http://iank.org/querysniffer/  The only connections to the database should be created by Moodle!**

## Step 1 ##
Use svn to get the following:

  * moodle/install
  * moodle/moodle\_www-so-mods

## Step 2 ##
Install the latest available patched version of SwitchedOn Moodle (ie if the new patch you're creating is patch version 4, install patch version 3)

## Step 3 ##

Overwrite the moodle www files with the new moodle version (the one that we're creating the patch for).

**Not forgetting the SwitchedOn customisations!**
The customisations are stored in the `moodle/moodle_www-so-mods` directory.

For example:
```
   cd /srv/www/
   rm -rf moodle
   jar zxvf moodle-1.9.4.tgz
   cp -R <path_to>/moodle_www-so-mods/* moodle/
```


### Step 4 ###
Configure moodle to connect to 127.0.0.1 (and not localhost).
Otherwise tcpdump won't catch the packets
(needs to connect to ip, rather than unix socket).

```
vi /srv/www/moodle/config.php
  $CFG->dbhost    = '127.0.0.1';
```


### Step 5 ###
install querysniffer

The following perl packages were required for me (EB):
```
  wget http://search.cpan.org/CPAN/authors/id/T/TI/TIMPOTTER/Net-PcapUtils-0.01.tar.gz
  tar zxvf Net-PcapUtils-0.01.tar.gz
  Net-PcapUtils-0.01
  perl Makefile.PL
  sudo make install

  wget http://search.cpan.org/CPAN/authors/id/A/AT/ATRAK/NetPacket-0.04.tar.gz
  tar zxvf NetPacket-0.04.tar.gz
  cd NetPacket-0.04
  perl Makefile.PL
  sudo make install

  wget http://iank.org/querysniffer/querysniffer-0.10.tar.gz
  tar zxvf querysniffer-0.10.tar.gz
  cd querysniffer
```

Hack the perl so that it appends the ; delimiter to all queries.
```
  vi mysqlsniff.pl
```

modify the line
```
      print(substr($data,5) . "\n");
```
to be
```
      print(substr($data,5) . ";\n");
```

### Step 6 ###
Capture MySQL traffic.

**Notes:**
  * Have to use a specific interface (e.g. not 'any').
  * Have to run as root, otherwise doesn't find any of the interfaces.

_(Ed, can you please edit this and remove the line that is wrong. - AB)_
```
  #sudo ./mysqlsniff.x86 lo > mysqlsniff-`date +%Y%m%d`.sql
  sudo perl mysqlsniff.pl lo > mysqlsniff-`date +%Y%m%d`.sql
```


### Step 7 ###
Perform the moodle upgrade from the web interface.
http://localhost/moodle/admin/index.php

### Step 8 ###
Once you've finished setting up Moodle, stop the mysqlsniff.pl process by pressing Ctrl+C.

This will have created a file called `mysqlsniff-<whateverTheDateIs>.sql`

### Step 9 ###

Create a new patch directory in `moodle/install/patches/`.  It will be the next number in the sequence.  From now on, I will assume it's called 4 (i.e. this is patch 4 - being built on patch 3 in step 2 above).

### Step 10 ###

Copy the .sql file generated in step 9 into the new directory as `patch_4-db.sql`.

(You'll have to change this next line, it needs the correct path and the correct patch numbers!)
```
  cp mysqlsniff-<whateverTheDateIs>.sql moodle/install/patches/4/patch_4-db.sql
```

### Step 11 ###



**BELOW THIS POINT IN DEVLOPMENT!!!**

Rename this and put it into the new patch dir
run the sharer
run the shar file on the site machines.



# Step n/a
# WE could filter out only the queries that we need for updates.
# (e.g. We only need '^(UPDATE|INSERT|DELETE|SET|ALTER|CREATE|SET)'.)
#
# However:
# - We'd be in danger of missing out any future queries that are needed.
#    (Obviously non-SELECTs etc.)
# - It doesn't matter anyway even if we do execute e.g. SELECTs.
# - Keep the full set of queries so that we have a record of what
#   the actual Moodle update actually does against the DB.
#
# So don't use either of these!
#grep -iE '^(UPDATE|INSERT|DELETE|SET|ALTER|CREATE)' mysqlsniff-`date +%Y%m%d`.sql
#grep -viE '^(SELECT|SHOW)' mysqlsniff-`date +%Y%m%d`.sql > test.sql


# Step n/a
# Add the ';' query delimiter to the end of every line.
# This is so the queries can be input directly into mysql command line.
# (The MySQL protocol doesn't send the query delimiter.)
#
# However don't do this, since there are queries that run over multiple lines.
# (Instead the previous mysqlsniff.pl hack was used.)
#sed -i 's/$/;/' mysqlsniff-`date +%Y%m%d`.sql



# Installing Moodle #

The quick and the ugly to geting Moodle up running (assuming you're using a SUSE Linux):

  1. Install Moodle 1.9.3  You can get it [here](http://download.moodle.org/stable19/moodle-1.9.4.tgz)
    * All examples following assume that the moodle directory is called moodle-1.9.3 - keeping it called this will keep things simple for now.
  1. Copy the original moodle files:
> > `cp -r moodle-1.9.3 moodle-1.9.3-SO`
    * The `moodle-1.9.3-SO` directory is the working directory, make all changes here - keep the original directory untouched for creating the patch in the future.
  1. Get the following files from the SVN repository under moodle and save them into the `moodle-1.9.3-SO` directory:
    * moodle-1.9.3-moodle-1.9.3-SO.deletedfiles
    * moodle-1.9.3-moodle-1.9.3-SO.patch
    * moodle-1.9.3-1.9.3-SO-patch.tar.gz
  1. Make the .deletedfiles file executable with:
> > `chmod 755 moodle-1.9.3-moodle-1.9.3-SO.deletedfiles`
  1. Run the .deletedfiles script to remove all files that should be deleted in the Switched On distribution.
  1. Run the following command to patch the files:
> > `patch -p1 < moodle-1.9.3-moodle-1.9.3-SO.patch`
  1. Run the following command to extract the new files into the correct places:
> > `tar -zxf moodle-1.9.3-1.9.3-SO-patch.tar.gz`
  1. Remove the three files you copied into the base directory, namely:
    * moodle-1.9.3-moodle-1.9.3-SO.deletedfiles
    * moodle-1.9.3-moodle-1.9.3-SO.patch
    * moodle-1.9.3-1.9.3-SO-patch.tar.gz
  1. Your moodle is now a Switched On moodle... hopefully!

Please note that I will be making a script to do all this in the near future.

# Creating the patch files for the repository #

When you've finished developing Switched On Moodle, please get the script `makesodiff` from the moodle project in the repository.  You shouldn't need to edit the script if you've used the recommended directory names.  But, please make sure the names of the original (old) directory and the modified (new) directory are correct in the script.

Change the permissions so you can run it:  `chmod 755 makesodiff`
And run it:  `./makesodiff`

It will take about 10 minutes to finish creating the patch files and when it has you'll have:
  * moodle-1.9.3-moodle-1.9.3-SO.deletedfiles
  * moodle-1.9.3-moodle-1.9.3-SO.patch
  * moodle-1.9.3-1.9.3-SO-patch.tar.gz

If you haven't used the recommended names for the directories, these will have different names which will depend on the names of your original and Switched On moodle directories.  Please upload these patch files to the repository.

_If you have questions, please ask Adam before committing to the repository!_