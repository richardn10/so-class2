<?php
require_once("template.php");

$template =& new Template("tmpl/db_manageusers.tmpl");

$template->AddParam('firstname', 'Larry');
$template->AddParam('lastname', 'Shark');

$template->EchoOutput();
?>
