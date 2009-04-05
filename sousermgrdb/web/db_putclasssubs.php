<?php
require_once("header.php");

$lesson_query = 
	"SELECT idtblLesson,dFee FROM $lesson_table";
$lesson_results = db_run_query($lesson_query);

/*
 * The student_id is received from a hidden field in the previous page.
 * It is used to link all of the selected lesson ids to the student in question.
 */

$student_id = $_POST["student_id"];

while($row = mysql_fetch_array($lesson_results)) {
	extract($row);
	if(isset($_POST["courseid$idtblLesson"])) {
		
		/*
		 * TODO: need to get a date that the student wants to take this
		 * lesson. At the moment we are just using NOW() because the 
		 * value cannot be NULL in the database.
		 */

		$lesson_date = "NOW()";

		$rateoragreedfee = $_POST["rateoragreedfeeid$idtblLesson"];
		if($rateoragreedfee == "rate") {
			$discount = $_POST["discountid$idtblLesson"];
			$paid = 0;
		} else {
			$discount = 0;
			$paid = $_POST["paidid$idtblLesson"];
		}
		if(isset($_POST["paymentconfirmedid$idtblLesson"])) {
			$confirmed = 1;
		} else {
			$confirmed = 0;
		}
		
		$store_lesson_query = 
			"INSERT INTO $lessonstudent_table(" . 
				"tblStudent_idtblLessonStudent," . 
				"dtLessonDate," . 
				"dFee," .
				"dDiscount," . 
				"dPaid," . 
				"bPaymentConfirmed," .
				"tblLesson_idtblLesson) " . 
			"VALUES(" . 
				"$student_id," . 
				"$lesson_date," . 
				"$dFee," . 
				"$discount," . 
				"$paid," . 
				"$confirmed," . 
				"$idtblLesson)";
		
		db_run_query($store_lesson_query);
	}
}

$student_query = 
	"SELECT strFirstName,strLastName FROM $student_table WHERE idtblLessonStudent=$student_id";

$student_result = db_run_query($student_query);
$student_row = mysql_fetch_array($student_result);
extract($student_row);	

$template =& new Template("tmpl/db_putclasssubs.tmpl");
	
$template->AddParam("firstname",$strFirstName);
$template->AddParam("lastname",$strLastName);

$template->EchoOutput(); 

?>
