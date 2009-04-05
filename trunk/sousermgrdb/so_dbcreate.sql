-- Copyright SwitchedOn 2009
--
-- TODO: auto SVN revision id
--
-- The main creation script to create everything required for the soclass (SwitchedOn Class) database.
--
-- Don't run this script in 'batch' mode into mysql client.
-- Instead, please execute the comments in _readme.txt

CREATE DATABASE IF NOT EXISTS soclass;

-- Admin user for this database
-- Only for adminstering the mysql database.
-- Not to be used for client application access.
--
-- TODO: need a more secure password!
--
CREATE USER 'so_admin'@'%' IDENTIFIED BY 'so_admin';
GRANT ALL PRIVILEGES ON soclass.* TO 'so_admin'@'%' WITH GRANT OPTION;

-- Make sure we're in the correct database before creating the database-specific objects!
--
USE soclass;

-- Create the tables
-- Note that this is not just a table creation script; it's a dump of the initial setup of the database, so might currently include some insert statements not required.
--
SOURCE so_class.sql

-- Create the soclass specific users
--
SOURCE so_users.sql

-- Allow us to make use of other (i.e. moodle) databases
--
SOURCE so-grants_from-soclass.sql

-- Allow moodle to make use of this database
--
SOURCE so-grants_from-moodle.sql

