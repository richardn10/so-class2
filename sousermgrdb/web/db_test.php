<?php
ini_set("display_errors","1");

require_once("db_constants.php");

$connect = mysql_connect($host, $user, $pass) or
	die ("Failed to connect to database");

mysql_select_db($dbname);

$selectlogs = "select * from tbllessonlog";
$results = mysql_query($selectlogs);

while ($row = mysql_fetch_array($results)) {
	extract($row);
	echo $dtTimeStamp;
	echo ":";
	echo $strAction;
	echo "-";
	echo $strTitle;
	echo "-";
	echo $dFee;
	echo "<br>";
}

?>
