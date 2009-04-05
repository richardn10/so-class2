<?php

ini_set("display_errors","1");
error_reporting(E_ALL);
require_once("db_constants.php");
require_once("db_functions.php");

$debug=true;

function debuglog($msg) {
	if(isset($debug)) {
		echo $msg;
	}
}
