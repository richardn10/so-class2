-- Copyright SwitchedOn 2009
--
-- TODO: auto SVN revision id
--
-- Allow the soclass database users to use the moodle database as required.
--

-- The so_admin user isn't granted access to moodle.
-- This is because it doesn't require it, since it's only for adminstering the mysql database.
--

-- TODO: we really need to be more specific than this, in 2 ways:
--         - not all hosts: should be e.g. localhost and 127.0.0.1
--         - (perhaps) not everything in the moodle database
--
GRANT ALL PRIVILEGES ON moodle.* TO 'so_user'@'%';

