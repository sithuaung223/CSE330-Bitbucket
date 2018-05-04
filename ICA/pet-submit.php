<?php
	require "database.php";
	session_start();
	//getting user files from server 
	// $check_array= array('species','name','weight','description','picture')
	if(isset($_POST['species']) && isset($_POST['name']) && isset($_POST['weight']) && isset($_POST['description']) && isset($_POST['picture'])){
		//save values
		$species= $_POST['species'];
		$name= $_POST['name'];
		$weight= (float)$_POST['weight'];
		$description= $_POST['description'];
		// Get the filename and make sure it is valid
		$filename= basename($_FILES['picture']['name']);
		if (!preg_match('/^[\w_\.\-]+$/', $filename) ){
			echo "Invalid filename";
			exit;
		}


		$stmt= $mysqli->prepare("insert into pets (species, name, filename, weight,description) values (?, ?, ?,? ,?)");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}
		 
		$stmt->bind_param('sssds', $species, $name, $filename, $weight, $description);
		 
		$stmt->execute();
		 
		$stmt->close();
		
		//uploads files
		$full_path= sprintf("/home/sithuaung/uploads/%s", $filename); 
		if (move_uploaded_file($_FILES['picture']['tmp_name'], $full_path) ){
			//successful uploads and quaires
			header("Location: pet-listings.php");
			exit;
		} 
		else{
			echo "file upload fails";
			
			exit;
		}


	}
	else{
		echo "Not enough Information";
		exit;
	}



	
?>