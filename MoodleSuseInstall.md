# Introduction #

Add your content here.

# Pre requisites #

  * LAMP (Linux Apache MySQL PHP) installed!

# Install of Moodle #

Notes from /usr/share/doc/packages/moodle/README.SuSE

```
# Create the database for moodle
1) Start mysql (rcmysql start) and create a database for Moodle as root:
   # mysql -u root -p
   or (if you havn't set the mysql-password):
   # mysql -u root
   mysql> CREATE DATABASE moodle DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
   mysql> GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,CREATE TEMPORARY TABLES,DROP,INDEX,ALTER ON moodle.* TO moodleuser@localhost IDENTIFIED BY 'passwd';
   mysql> flush privileges;
   mysql> quit


# Configure moodle via Browser
2) Start apache (rcapache2 start) and open the following URL in a browser on your host:
   http://localhost/moodle/

3) Browser based installation

3.1) Select your language 

3.2) Check the PHP settings (should all be green)

3.3) 
 - Enter the correct webaddress of your host (normally moodle detects this automatically).
 - The prepared datadir is /srv/www/moodledata

3.4) Enter your database settings:
  If you've prepared the database as described in 1, please enter:

  Database: moodle
  User:     moodleuser
  Password: passwd

 (see step 1 for your password ;-)

3.5) Check aditional server settings (should all be green)

3.6) Download your language pack (this should normally not be necessary as you can install the rpm for your language).

3.7) copy and paste the config.php file. You have two options now:

a) Create a new file /srv/www/moodle/config.php 
   This is the upstream way and should work.    <------------ Use this way.  The next seemed to fail, at least on OpenSUSE 11.0

b) Create/Replace the file /etc/moodle/moodle-config.php

   This is the prefered openSUSE way. So your settings including passwords, etc. are stored outside of the webservers root directory.

   Afterwards, you should rename the file:  /srv/www/moodle/config-suse.php to /srv/www/moodle/co
nfig.php 
   # mv /srv/www/moodle/config-suse.php /srv/www/moodle/config.php

3.8) Accept the license

3.9) Read the Release Notes. 
     You can enable the "unattended" checkbox and moodle will create/update the needed database tables for you.

4) Configure moodle to your needs

   Now you should be able to edit your admin account for moodle (this is NOT the root account of your machine!), edit your sites name and description and start with your new moodle site.


```


# Post-install system config #

These are changes that don't need to be in source control (subversion), since they are system configuration items - even though they require changes to some files.

# Allow symbolic links.<br />
# (By default these aren't allowed from a system security perspective... however moodle uses symbolic links for e.g. images.)<br />
#<br />
vi /etc/apache2/conf.d/moodle\_include.conf
> within '<Directory /srv/www/moodle>'
> modify
> > 'Options None'

> to be
> > 'Options FollowSymLinks'

# Allow apache to write to the moodle and moodledata directories.<br />
# (Apache runs as root, but its client threads run as wwwrun.)<br />
# Specifically the moodledata/sessions/ directory - otherwise moodle authenticates you, but doesn't remember you as being logged in.<br />
# Also allow the users group to write files in the directory.<br />
#<br />

> chown -R wwwrun:users /srv/www/moodle
> chown -R wwwrun:users /srv/www/moodledata
#<br />
> chmod -R 775 /srv/www/moodle
> chmod -R 775 /srv/www/moodledata

REN - Not sure this step of changing permissions is needed.  Will try without.

# Since the local network (whilst in Cambridge at least) doesn't have a DNS server, don't have moodle re-write the URL to use the domain name of the server.<br />
# Just use the IP instead.<br />
#<br />
vi /srv/www/moodle/config.php
> Modify the '$CFG->wwwroot' value to be
> > 'http://192.168.0.50/moodle'

> Instead of the e.g. default
> > 'http://linux-wmf0/moodle'

# Move Moodle to new server (and upgrade) #
The following worked from openSUSE 11.0 to openSUSE 11.1

Adapted from: http://docs.moodle.org/en/Upgrading
Note the above instructions (adapted from) assume upgrading moodle in place, i.e. that the database and that moodledata are unchanged from the previous version.  Moodle upgrades these automatically.  However, these instructions assume a fresh OS install.

Backup 11.0 database:

```
mysqldump -u root -p -C -Q -e -a moodle > moodle-backup-DATE.sql
```

# Backup moodledata
  1. cp -Rp /srv/www/moodledata store/

# Move to new server or reinstall OS

# Create the database for moodle (as above)
```
1) Start mysql (rcmysql start) and create a database for Moodle as root:
   # mysql -u root -p
   or (if you havn't set the mysql-password):
   # mysql -u root
   mysql> CREATE DATABASE moodle DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
   mysql> GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,CREATE TEMPORARY TABLES,DROP,INDEX,ALTER ON moodle.* TO moodleuser@localhost IDENTIFIED BY 'passwd';
   mysql> flush privileges;
   mysql> quit
```

# Copy in moodledata
  1. cp -Rp store/moodledata /srv/www/

Note there should not be a /srv/www/moodle directory.  This is to be installed next.

# Install base software -
Install:
  * mysql
  * php
  * moodle
  * xmlrpc for php (will be reminded of later if don't do now).

# Install the backed-up database
  1. mysql -u root (-p) moodle < moodle-backup-DATE.sql

# Upgrade moodle
This step runs code to upgrade the database that has been installed.

Go to http://localhost/moodle/admin/

Follow the prompts.

Follow "Post-install system config" instructions above.