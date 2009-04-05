<?php
ini_set("display_errors","1");
require_once("db_constants.php");

function error_redirect($msg, $url = "db_error.php?msg=") {
	header("location: $url$msg");
}

function db_run_query($query) {
	$connect = mysql_connect($GLOBALS["host"], $GLOBALS["user"], $GLOBALS["pass"]) or
		error_redirect("E1 " . mysql_error());
	mysql_select_db($GLOBALS["dbname"]);
	$result = mysql_query($query) or
		error_redirect("E2 " . mysql_error());
	return $result;
}
		
?>
