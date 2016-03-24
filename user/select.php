<?php
require 'database.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
session_start();

/*logout*/ 
	if (isset($_POST['logout'])){ 
		$_SESSION= array(); 
		if (session_destroy()){
			echo json_encode(array(
				"success" => true
			));
			exit; 				
		}
		else {
			echo json_encode(array(
				"success" => false,
				"message" => "Cannot logout"
			));
			exit;
		}

	}
/*login*/
	if (isset($_POST['username'])){ 
	   $username= $_POST['username'];
	   $pwd_guess= $_POST['password'];
	// Use a prepared statement
		$stmt = $mysqli->prepare("SELECT COUNT(*), user_id, user_pass FROM users WHERE user_name=?");
		// Bind the parameter
		$stmt->bind_param('s', $username);
		$stmt->execute();
		// Bind the results
		$stmt->bind_result($cnt, $user_id, $pwd_hash);
		$stmt->fetch();
		$stmt->close();
		 
		// Compare the submitted password to the actual password hash
		if( $cnt == 1 && crypt($pwd_guess, $pwd_hash)==$pwd_hash){
			// Login succeeded!
			$_SESSION['user_id']= $user_id;
			$_SESSION['username']= $username;
			echo json_encode(array(
				"success" => true
			));
			exit;
		}else{
			// Login failed
			echo json_encode(array(
				"success" => false,
				"message" => "Incorrect Username or Password" 
			));
			exit;
		}
  
	}
	
	if(isset($_SESSION['username'])){
		echo json_encode(array(
			"login" => true
		));
		exit;
	}else{
		echo json_encode(array(
			"login" => false
		));
		exit;	
	}
?>
