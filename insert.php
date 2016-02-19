<!DOCTYPE html>
<?php
	require 'database.php';
	session_start();
	 
	$username= $_SESSION['username'];
	$password= $_SESSION['password'];
	$email= $_SESSION['email'];
	$stmt= $mysqli->prepare("insert into users (username, password, email_address) values (?, ?, ?)");
	if (!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('sss', $username, $password, $email);
	 
	$stmt->execute();
	 
	$stmt->close();
	header("Location: profile.php");
?>
