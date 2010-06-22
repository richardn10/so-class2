<?php
/*
*Configuration is in ../conf/config.inc.php (rename config.inc.php.orig and edit!)
*/
require('../conf/config.inc.php');

/*
* Input validation
*/
if(!isset($_GET['form_pending_id']) || !ctype_digit($_GET['form_pending_id']) ) {
     die("No form pending id given");
}

/*
* User authentication
*/

// not implemented yet


/*
* Make attachment in table
*/

#$mysqli = new Mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);

#$statement = $mysqli->prepare("INSERT INTO ".$mysql_table." (title, description, date, ss_FormPending_idss_FormPending) VALUES(?,?,?, ?)");
#$statement->bind_param('sssi',$_GET['title'],$_GET['description'],date('YmdHis'), $_GET['form_pending_id']);
#$statement->execute() or die($statement->error);

#$file_id = $statement->insert_id;
$file_id = $_GET['file_id'];


header("Cache-Control: no-cache"); 
$timestamp = time();
$addition = "INTALIOTOSUA";

$token = hash('sha256', $key . $file_id . $timestamp . $addition);

echo $training_centre_server_url."?file_id=${file_id}&timestamp=${timestamp}&sua_token=${token}&description=".rawurlencode($_GET['description'])."&title=".rawurlencode($_GET['title'])."&form_pending_id=".$_GET['form_pending_id'];
//echo "http://sua-demo-s.smitmail.eu/?correlationid=${correlationid}&timestamp=${timestamp}&token=${token}";

