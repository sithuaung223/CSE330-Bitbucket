<?php
require 'database.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);
session_start();

/*register*/
   	$username= htmlentities($_POST['username']);
    $pwd= htmlentities($_POST['password']);
	 
	$_SESSION['username']= $username;
	$_SESSION['password']= $pwd;
	$pwd_hash= crypt($pwd);

	$stmt= $mysqli->prepare("insert into users (user_name, user_pass) values (?, ?)");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('ss', $username, $pwd_hash);
	$stmt->execute();
	$stmt->close();

	echo json_encode(array(
		'success' => true,
		'message' => "you have been registered"));
	exit;  	
?>
