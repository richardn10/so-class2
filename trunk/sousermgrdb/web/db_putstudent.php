<?php
require_once("header.php");

$username  = $_POST["username"];
$password  = $_POST["password"];
$lastname  = $_POST["lastname"];
$firstname = $_POST["firstname"];
$building  = $_POST["building"];
$street    = $_POST["street"];
$city      = $_POST["city"];
$district  = $_POST["district"];
$postcode  = $_POST["postcode"];
$telephone = $_POST["telephone"];
$mobile    = $_POST["mobile"];
$dobday    = $_POST["dobday"];
$dobmonth  = $_POST["dobmonth"];
$dobyear   = $_POST["dobyear"];

$template =& new Template("tmpl/db_putstudent.tmpl");

$template->AddParam("firstname", $username);
$template->AddParam("lastname", $lastname);


$put_student_insert =
	"INSERT INTO $student_table (" . 
		"strStudentID," . 
		"strPassword," . 
		"strLastName," . 
		"strFirstName," . 
		"strBuilding," . 
		"strStreet," . 
		"strCity," . 
		"strDistrict," . 
		"strTelephone," . 
		"strMobile," . 
		"strPostcode," . 
		"dtDOB)" .
	"VALUES (" .
		"'$username'," .
		"'$password'," .
		"'$lastname'," .
		"'$firstname'," .
		"'$building'," .
		"'$street'," .
		"'$city'," .
		"'$district'," .
		"'$telephone'," .
		"'$mobile'," . 
		"'$postcode'," . 
		"'$dobyear-$dobmonth-$dobday')";


$result = db_run_query($put_student_insert);

$get_student_id = 
	"SELECT idtblLessonStudent " . 
	"FROM $student_table " . 
	"WHERE strStudentID='$username' " . 
	"AND strPassword='$password'";

$student_id_result = db_run_query($get_student_id);
$student_id_row = mysql_fetch_array($student_id_result);
extract($student_id_row);
$student_id = $idtblLessonStudent;

$query = "SELECT * FROM $lesson_table";
$result = db_run_query($query);

$lesson_array = array();
while($row = mysql_fetch_array($result)) {
        extract($row);
	$row_array = array("id"=>$idtblLesson,"title"=>$strTitle,"fee"=>$dFee);
	array_push($lesson_array, $row_array);
}

$template->AddParam("student_id", $student_id);
$template->AddParam("lessonlist", $lesson_array);	
$template->EchoOutput();

?>
