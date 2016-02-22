<!DOCTYPE html>
<html>
<head>
		<title>Post</title>
</head>
<body>

<form action="profile.php" method="post">
		<input type="submit" value="Back "/>
</form>
<?php
require "database.php";
session_start();
	if(isset($_POST['button'])){
		$button= $_POST['button'];
		//Edit Post
		if ($button== "Edit Post"){
			header("Location: edit_post.php");
		}
		//Delete Post
		if ($button== "Delete" || $button== "Delete Post"){
		 $post_id= $_SESSION['post_id'];
		 //delete the comments related to post
		 $stmt= $mysqli->prepare("delete from comments where post_id=?");

			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->bind_param('i', $post_id);
			$stmt->execute();
			$stmt->close();
			//delete the post
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

		//View Post
		if ($button== "View"){
		}

		//Comment Post
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
	if(isset($_SESSION['user_id'])){
		echo '<form method="post">';
		echo '<input type="submit" name="button" value="Edit Post"/>';
		echo '<input type="submit" name="button" value="Delete Post"/>';
		echo '</form>';
	}

?>
<hr>

<form  action="edit_delete_comment.php" method="post">
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
		echo '<input type="radio" name="comment_id" value="';
		echo $comment_id;
		echo '"/>';
		printf("\t%s\n<br>",
			htmlspecialchars($comment)
		);
	}

	$stmt->close();
	if(isset($_SESSION['user_id'])){
		echo '<br>';
		echo '<input type="submit" name="button" value="Edit Comment"/>';
		echo '<input type="submit" name="button" value="Delete Comment"/>';
		echo '</form>';
		echo '<br>';
	  echo '<br>';

		echo '<form  method="post">';
		echo '<label> Your Comment:</label>';
		echo '	<input type="text" name="comment"/>';
		echo '<input type="submit" name="button" value="Comment"/>';
		echo '</form>';
	}

?>

</body>
</html>

