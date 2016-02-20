<!DOCTYPE html>
<html>
<head>
		<title>Post</title>
</head>
<body>

<?php
require "database.php";
session_start();
	if(isset($_POST['button'])){
		$button= $_POST['button'];

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

		//View
		if ($button== "View"){
		 $post_id= $_POST['stories'];
		 $_SESSION['post_id'] = $post_id;
		}

		//Comment
		if ($button== "Comment"){
			$post_id = $_SESSION['post_id'];
			$comment= $_POST['comment'];
			$stmt= $mysqli->prepare("insert into comments (post_id, comment) values (?, ?)");

			if (!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->bind_param('is', $post_id, $comment);
			$stmt->execute();

			$stmt->close();
			header("Location: posts.php");
		}
	}
  $post_id = $_SESSION['post_id'];
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

?>
<form action="edit_delete.php" method="posts">
<?php
	$post_id= $_SESSION['post_id'];
	$stmt= $mysqli->prepare("select comment,comment_id from comments where post_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('i', $post_id);

	$stmt->execute();

	$stmt->bind_result($comment, $comment_id);

	while($stmt-> fetch()){
		echo '<input type="radio" name="stories" value="';
		echo $comment_id;
		echo '"/>';
		printf("\t%s\n<br>",
			htmlspecialchars($comment)
		);
	}

	$stmt->close();
?>
	<input type="submit" name="button" value="Edit"/>
	<input type="submit" name="button" value="Delete"/>
</form>

<form  method="post">
	<label> Your Comment</label>
		<input type="text" name="comment"/>
		<input type="submit" name="button" value="Comment"/>
</form>

</body>
</html>

