<?php
require_once("header.php");

$query = "SELECT * FROM $lesson_table";
$result = db_run_query($query);

while($row = mysql_fetch_array($result)) {
	extract($row);
	$lesson_array = array("id"=>$idtblLesson,"title"=>$strTitle,"fee"=>$dFee);

}
?>
