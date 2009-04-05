<?php
require_once("header.php");

$template =& new Template("tmpl/db_adduser.tmpl");

$template->AddParam('title', 'User Manager');
$template->AddParam('body', 'Add User');

$template->EchoOutput();
?>
