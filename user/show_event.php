<?php
require 'database.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
session_start();

/*login*/
if (isset($_SESSION['user_id'])){ 
	// Use a prepared statement
		$user_id= $_SESSION['user_id'];
		$date= $_POST['dayid'];
		$stmt = $mysqli->prepare("SELECT COUNT(*), id, time, title, category FROM events WHERE user_id=? and date=?");
		// Bind the parameter
		$stmt->bind_param('is', $user_id, $date);
		$stmt->execute();
		// Bind the results
		$stmt->bind_result($cnt, $id, $time, $title, $category);
		$bindResults=array();
		while($stmt->fetch()){
			$bindResults= array($title,$time,$category)+$bindResults;
			echo json_encode(array(
				"title" => $bindResults,
				'success' => true
			));
		}

		// echo json_encode(array(
		// 	'success' => false
		// ));			
		exit;	
		$stmt->close();
		 
		// Compare the submitted password to the actual password hash
}

?>
