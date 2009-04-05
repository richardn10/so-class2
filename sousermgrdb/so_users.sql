-- Copyright SwitchedOn 2009
--
-- TODO: auto SVN revision id
--

-- TODO: More secure passwords!
--

-- TODO: might want to restrict the privs somewhat...?
-- TODO: currently allows access from any host to aid development...
--
-- CREATE USER 'so_manageuser'@'%' IDENTIFIED BY 'so_manageuser';
GRANT DELETE,EXECUTE,INSERT,SELECT,UPDATE ON soclass.* TO 'so_manageuser'@'%' IDENTIFIED BY 'so_manageuser';

