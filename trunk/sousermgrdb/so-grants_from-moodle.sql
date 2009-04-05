-- Copyright SwitchedOn 2009
--
-- TODO: auto SVN revision id
--
-- Allow the moodle database users to use the soclass (SwitchedOn Class) database as required.
--

-- TODO: we really need to be more specific than this, in 2 ways:
--         - not all hosts: should be e.g. localhost and 127.0.0.1
--         - (perhaps) not everything in the soclass database
--
GRANT ALL PRIVILEGES ON soclass.* TO 'moodleuser'@'%';

