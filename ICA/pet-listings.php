<!DOCTYPE html>
<head>
<meta charset="utf-8"/>
<title>My Web Page</title>
<style type="text/css">
body{
	width: 760px; /* how wide to make your web page */
	background-color: teal; /* what color to make the background */
	margin: 0 auto;
	padding: 0;
	font:12px/16px Verdana, sans-serif; /* default font */
}
div#main{
	background-color: #FFF;
	margin: 0;
	padding: 10px;
}
</style>
</head>
<body>

<?php
session_start();
	// This is a *good* example of how you can implement password-based user authentication in your web application
require 'database.php';
// Use a prepared statement
	$stmt = $mysqli->prepare("SELECT COUNT(*) FROM pets");
	 
	// Bind the results
	$stmt->bind_result($cnt);
	$stmt->fetch();

	$stmt-> close();

	$stmt = $mysqli->prepare("select species, name, weight, description, picture FROM pets");
	 
	// Bind the results
	$stmt->bind_result($species, $name, $weight, $description, $picture);
	$stmt->fetch();

	$stmt-> close();
	
	
?>
<div id="main">
 
<!-- CONTENT HERE -->
 
</div></body>
</html>