<?php
/*
*Configuration
*/
$key = "";

$mysql_username = "";
$mysql_password = "";
$mysql_host = "";
$mysql_database = "";
$mysql_table = "";

$training_centre_server_url = "http://sua-test.smitmail.eu/upload";

/*
* User authentication
*/

// not implemented yet


/*
* Make attachment in table
*/

$mysqli = new Mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);

$statement = $mysqli->prepare("INSERT INTO ".$mysql_table." VALUES(?)");
$statement->bind_param("aparam");
$statement->execute();

$file_id = $mysqli->insert_id;



header("Cache-Control: no-cache"); 
$file_id = rand(10000000, 99999999);
$timestamp = time();
$addition = "INTALIOTOSUA";

$token = hash('sha256', $key . $correlationid . $timestamp . $addition);

echo $training_centre_server_url."?attachmentid=${correlationid}&timestamp=${timestamp}&token=${token}";
//echo "http://sua-demo-s.smitmail.eu/?correlationid=${correlationid}&timestamp=${timestamp}&token=${token}";

