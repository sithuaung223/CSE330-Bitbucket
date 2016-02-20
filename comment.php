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

	<h1>Comments </h1>

	<form action= "home.php" method="post">

		<div class= "logout_btn">

			<input type="submit" name="logout_btn" value="Log Out"/>

		</div>

	</form>



	<form method="post">

		<label> Your Comment: </label>

			<input type="text" name="comment"/>

			<input type="submit" name="submit_comment" value="Submit"/><br>

	<br>

<!--php-->

<?php

  require 'database.php';

  session_start();

	if(isset($_POST['submit_comment'])){



		$post_id= $_SESSION['post_id'];

		$comment= $_POST['comment'];



		$stmt= $mysqli->prepare("insert into comments (post_id, comment) values (?, ?)");

		if (!$stmt){

			printf("Query Prep Failed: %s\n", $mysqli->error);

			exit;

		}



		$stmt->bind_param('is', $post_id, $comment);

		$stmt->execute();

		$stmt->close();

		header("Location: profile.php");
	}

?>
</body>
</html>
