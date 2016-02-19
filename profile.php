<!DOCTYPE html>
<html>
<head>
	<style type='text/css'>
		div.logout_btn{
			text-align: right;
		}
	</style>
</head>
<body>
	<h1>Profile </h1>
	<form action="home.php" method="post">
		<div class= "logout_btn">
			<input type="submit" name="logout_btn" value="Log Out"/>
		</div>
	</form>

	<form method="post">
		<label> Story Title: </label>
			<input type="text" name="title"/>
			<input type="submit" name="submit_story" value="Submit"/><br>
	</form>
		<label> About: </label>
			<textarea method="post" name="post" rows="4" cols="100"></textarea><br>
<!--php-->
<?php
  require 'database.php';
  session_start();
	if(isset($_POST['submit_story'])){

		$user_id= $_SESSION['user_id'];
		$post= $_POST['title'];
		$stmt= $mysqli->prepare("insert into posts (user_id, post) values (?, ?)");
		if (!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}

		$stmt->bind_param('is', $user_id, $post);

		$stmt->execute();

		$stmt->close();
		header("Location: profile.php");
	}
?>

</body>
	
</html>
