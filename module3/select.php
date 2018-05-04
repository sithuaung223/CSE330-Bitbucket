<?php
require 'database.php';

session_start();
	// This is a *good* example of how you can implement password-based user authentication in your web application.
	 
	require 'database.php';
	$username= $_SESSION['username'];
	$pwd_guess= $_SESSION['password'];
	 
	// Use a prepared statement
	$stmt = $mysqli->prepare("SELECT COUNT(*), id, password FROM users WHERE username=?");
	 
	// Bind the parameter
	$stmt->bind_param('s', $username);
	$stmt->execute();
	 
	// Bind the results
	$stmt->bind_result($cnt, $user_id, $pwd_hash);
	$stmt->fetch();
	 
	// Compare the submitted password to the actual password hash
	if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
		// Login succeeded!
		$_SESSION['user_id'] = $user_id;
		// Redirect to your target page
		header("Location: profile.php");
	}else{
		// Login failed; redirect back to the login screen
		header("Location: home.php");
	}
?>
