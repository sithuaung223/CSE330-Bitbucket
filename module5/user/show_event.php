<?php
require 'database.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);
session_start();

/*login*/
if (isset($_SESSION['user_id'])){ 
	// Use a prepared statement
		$user_id= $_SESSION['user_id'];
		// $date= $_POST['dayid'];
		// $stmt = $mysqli->prepare("select count(*), id, time, date, title, category from events where user_id=?");
		$stmt = $mysqli->prepare("select id, time, date, title, category from events where user_id=?");
		// Bind the parameter
		if(!$stmt){
  			printf("Query Prep Failed: %s\n", $mysqli->error);
  			exit;
  		}
		$stmt->bind_param('i', $user_id);
		$stmt->execute();
		// Bind the results
		$stmt->bind_result($id, $time, $date, $title, $category);
		// $bindResults=array();
		// $output=array();
		$i=0;
		while($stmt->fetch()){
			// $bindResults= array($title,$time,$category)+$bindResults;
			$event[$i]= array("date"=> $date, "time"=> $time,"title"=> $title);
			// array_push($event, $output);
			$i++;
		}
		echo json_encode(array('output'=>$event,'count'=>count($event),'success'=>true));
		exit;
		// echo json_encode(array(
		// 	'success' => false
		// ));			
		// exit;
		
		$stmt->close();
		 
		// Compare the submitted password to the actual password hash
}

?>
