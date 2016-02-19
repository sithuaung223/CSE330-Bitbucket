<?php
require 'database.php';

session_start();

$username= $_SESSION['username'];
$user_password= $_SESSION['password'];

$stmt = $mysqli->prepare("select id, username, password from users order by username");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
 
$stmt->execute();
 
$stmt->bind_result($id, $user, $password);
 
while($stmt->fetch()){
	if($user=== $username && $password=== $user_password){
		$_SESSION['user_id']= $id;
		header("Location: profile.php");
		break;
	}
}
$stmt->close();
?>
