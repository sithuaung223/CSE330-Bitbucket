<!DOCTYPE html>
<html>
<head>
		<title>Post</title>
</head>
<body>

<?php
require "database.php";
session_start();
	$button= $_POST['button'];
	if(isset($button)){
		//View
		if ($button== "View"){
		 $post_id= $_POST['stories'];
		 $_SESSION['post_id'] = $post_id;
		 $stmt= $mysqli->prepare("select post_title,post from posts where post_id=?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			 
			$stmt->bind_param('i', $post_id);
			 
			$stmt->execute();
			 
			$stmt->bind_result($post_title, $post);
			 
			while ($stmt->fetch()){
				echo "<h1>".$post_title."</h1>";
				echo "<p>".$post."</p>";
			}

			$stmt->close();
		}

		//Delete
		if ($button== "Delete"){
		 $post_id= $_POST['stories'];
		 $stmt= $mysqli->prepare("delete from posts where post_id=?");
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			 
			$stmt->bind_param('i', $post_id);
			 
			$stmt->execute();
			$stmt->close();
			header("Location: profile.php");
		}
	}

?>
<form action="comment.php" method="posts">
	<input type="submit" name="comment" value="comment"/>
</form>

</body>
</html>

