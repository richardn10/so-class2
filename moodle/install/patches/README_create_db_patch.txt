# These instructions/notes are for how to create a database patch for moodle.
#
# This is required, since it's easy to patch moodle files - since we can just replace them all.
# (The only files that matter are config.php (which is part of the customisations)
#  and moodledata (which sits outside of the moodle www dir).)
#
# However the database is tricky, since it contains data that we need to keep.
#
# The method here uses http://iank.org/querysniffer/
#
# MAKE SURE
# that these instructions are run against an install of moodle that is being used
# for nothing other than this patch creation.
# Otherwise the db patch will contain SQL statements that are not applicable.
#
# Also see README_create_db_patch.txt.old for additional background information.
#
# Edward Buckley
#


# Step 1
# Perform an install of moodle (SwitchedOn customised) up to the latest patching level.


# Step 2
# Overwrite the moodle www files with the new moodle version (the one that we're creating the patch for).
# Not forgetting the SwitchedOn customisations!
# e.g.
#   cd /srv/www/
#   rm -rf moodle
#   jar zxvf moodle-1.9.4.tgz
#   cp -R <path_to>/moodle_www-so-mods/* moodle/


# Step 3
# Configure moodle to connect to 127.0.0.1 (and not localhost).
# Otherwise tcpdump won't catch the packets
# (needs to connect to ip, rather than unix socket).
#
vi /srv/www/moodle/config.php
  $CFG->dbhost    = '127.0.0.1';


# Step 4
# install querysniffer
#
# The following perl packages were required for me:
#
wget http://search.cpan.org/CPAN/authors/id/T/TI/TIMPOTTER/Net-PcapUtils-0.01.tar.gz
tar zxvf Net-PcapUtils-0.01.tar.gz
Net-PcapUtils-0.01
perl Makefile.PL
sudo make install
#
wget http://search.cpan.org/CPAN/authors/id/A/AT/ATRAK/NetPacket-0.04.tar.gz
tar zxvf NetPacket-0.04.tar.gz
cd NetPacket-0.04
perl Makefile.PL
sudo make install
#
wget http://iank.org/querysniffer/querysniffer-0.10.tar.gz
tar zxvf querysniffer-0.10.tar.gz
cd querysniffer
# Hack the perl so that it appends the ; delimiter to all queries.
vi mysqlsniff.pl
  modify the line
    print(substr($data,5) . "\n");
  to be
    print(substr($data,5) . ";\n");


# Step 5
# Capture MySQL traffic.
#
# Notes: - Have to use a specific interface (e.g. not 'any').
#        - Have to run as root, otherwise doesn't find any of the interfaces.
#
#sudo ./mysqlsniff.x86 lo > mysqlsniff-`date +%Y%m%d`.sql
sudo perl mysqlsniff.pl lo > mysqlsniff-`date +%Y%m%d`.sql



# Step 6
# Perform the moodle upgrade from the web interface.
http://localhost/moodle/admin/index.php


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
