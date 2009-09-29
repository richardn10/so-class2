-- This is the first time the database is setup.
-- Therefore create the complete schema; no actual patching work.
--
-- $Id$

CREATE DATABASE moodle DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,CREATE TEMPORARY TABLES,DROP,INDEX,ALTER
  ON moodle.*
  TO moodle@localhost
  IDENTIFIED BY 'm4gnad00dl1ing';
flush privileges;

-- This is important, otherwise the data won't get created in the correct place.
USE moodle;

-- The contents of this file are taken from a dump of the database immediately following
-- a base install of moodle+so mods.
--
source patch_0-db-data.sql;
