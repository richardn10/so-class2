<?php
require_once("header.php");

$query = "SELECT * FROM $student_table ORDER BY strLastName";
$result = db_run_query($query);

$user_array = array();

while($row = mysql_fetch_array($result)) {
	extract($row);
	$user_row = array("id"=>$idtblLessonStudent,
			"username"=>$strStudentID,
			"lastname"=>$strLastName,
			"firstname"=>$strFirstName);
	array_push($user_array, $user_row);
}

$template =& new Template("tmpl/db_manageusers.tmpl");
$template->AddParam("userlist", $user_array);
$template->EchoOutput();
?>
