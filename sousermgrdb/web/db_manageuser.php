<?php
require_once("header.php");

$student_id = $_POST["id"];

$get_user_query = 
	"SELECT * " . 
	"FROM $student_table " . 
	"WHERE idtblLessonStudent=$student_id";

$user_result = db_run_query($get_user_query);
$user_row = mysql_fetch_array($user_result);
extract($user_row);

$template =& new Template("tmpl/db_manageuser.tmpl");
$template->AddParam("id",$idtblLessonStudent);
$template->AddParam("username",$strStudentID);
//$template->AddParam("password",$strPassword);
$template->AddParam("firstname",$strFirstName);
$template->AddParam("lastname",$strLastName);
$template->AddParam("building",$strBuilding);
$template->AddParam("street",$strStreet);
$template->AddParam("city",$strCity);
$template->AddParam("district",$strDistrict);
$template->AddParam("postcode",$strPostCode);
$template->AddParam("telephone",$strTelephone);
$template->AddParam("mobile",$strMobile);

$template->EchoOutput();

?>
