<?php  /// Moodle Configuration File
// $Id$

unset($CFG);

$CFG->dbtype    = 'mysql';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle';
$CFG->dbuser    = 'moodle';
$CFG->dbpass    = 'm4gnad00dl1ing';
$CFG->dbpersist =  false;
$CFG->prefix    = '';

#$CFG->wwwroot   = 'http://linux-wmf0/moodle';
$CFG->wwwroot   = 'http://192.168.0.50/moodle';
$CFG->dirroot   = '/srv/www/moodle';
$CFG->dataroot  = '/srv/moodledata';  // Do not have this beneath www
$CFG->dataroot_so_data = $CFG->dataroot.'/so_data';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 00777;  // try 02777 on a server in Safe Mode

require_once("$CFG->dirroot/lib/setup.php");
// MAKE SURE WHEN YOU EDIT THIS FILE THAT THERE ARE NO SPACES, BLANK LINES,
// RETURNS, OR ANYTHING ELSE AFTER THE TWO CHARACTERS ON THE NEXT LINE.
?>
