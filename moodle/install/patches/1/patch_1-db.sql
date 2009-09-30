--
-- $Id$
--

-- This is important, otherwise the data won't get created in the correct place.
USE moodle;

-- This is taken from manually snooping the SQL
-- sent by Moodle to the DB, when the Moodle web-based upgrade is carried out.
--
-- See README_create_db_patch.txt for details.
--
source patch_1-db-data.sql;
