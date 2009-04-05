<?php
require_once("header.php");

$student_id = $_POST["id"];

$student_delete_query = 
	"DELETE FROM $student_table WHERE idtblLessonStudent=$student_id";

$lessonstudent_delete_query = 
	"DELETE FROM $lessonstudent_table WHERE tblStudent_idtblLessonStudent=$student_id";

db_run_query($lessonstudent_delete_query);
db_run_query($student_delete_query);

header("location: db_manageusers.php");
?>
