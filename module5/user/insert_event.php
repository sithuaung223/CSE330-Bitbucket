<?php
require 'database.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);
session_start();

/*add Event*/
   	$title= $_POST['title'];
    $date= $_POST['date'];
	$time= $_POST['time'];

	$stmt= $mysqli->prepare("insert into events (user_id, title, date, time) values (?, ?, ?, ?)");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('isss', $_SESSION['username'], $title, $date, $time);
	$stmt->execute();
	$stmt->close();

	echo json_encode(array(
		'success' => true,
		'message' => "you have been registered"));
	exit;  	
?>
