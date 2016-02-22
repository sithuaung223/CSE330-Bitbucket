<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
		<title>Post</title>
	 <style type= "text/css">
			body{
				background: #55B14A;
				color: white;
			}
			img{
				width: 50%;
				height: 50%;
			}
			p{
				font-size: 24px;
			}
			h1{
				text-align: center;
			}
		</style>
</head>
<body>
<?php
require "database.php";
session_start();
  if(($_SESSION['token']-$_POST['token'])!=0){
      echo  $_SESSION['token'];
      echo  $_POST['token'];
      die("Request forgery detected");
    }
	if(isset($_SESSION['user_id'])){
		echo '<form action="profile.php" method="post">';
		echo '<input type="submit" value="My Profile "/>';
		echo '</form>';
	}

	echo '<form action="main.php" method="post">';
	echo '<input type="submit" value="Main Page "/>';
	echo '</form>';

	if(isset($_POST['button'])){
		$button= $_POST['button'];
		//Edit Post
		if ($button== "Edit Post"){
			header("Location: edit_post.php");
		}
		//Upvote
		if ($button== "Upvote Post"){
			$post_id = $_SESSION['post_id'];
			$stmt= $mysqli->prepare("update posts set upvote=upvote+1 where post_id=?");
				if(!$stmt){
					printf("Query Prep Failed: %s\n", $mysqli->error);
					exit;
				}
				 
			$stmt->bind_param('i', $post_id);
			$stmt->execute();
			$stmt->close();
		}

		//Delete Post
		if ($button== "Delete Post"){
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
			$post_id= $_SESSION['post_id'];
			$user_id= $_SESSION['user_id'];
			$comment= $_POST['comment'];
			$stmt= $mysqli->prepare("insert into comments (user_id, post_id, comment) values (?, ?, ?)");

			if (!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->bind_param('iis', $user_id, $post_id, $comment);
			$stmt->execute();
			$stmt->close();
			header("Location: posts.php");
		}
	}
  $post_id = $_SESSION['post_id'];
  $stmt= $mysqli->prepare("select user_id, post_title, post, upvote, img_link from posts where post_id=?");
  	if(!$stmt){
  		printf("Query Prep Failed: %s\n", $mysqli->error);
  		exit;
  	}
  	 
	$stmt->bind_param('i', $post_id);
	$stmt->execute();
	$stmt->bind_result($poster_id, $post_title, $post, $upvote,$img_link);
	 
	while ($stmt->fetch()){
		echo "<h1><ins>".$post_title."<ins></h1>";
		if($img_link){
			echo '<img src="'.$img_link.'" alt="image"><br>'; 
		}
		echo "<p>".$post."</p>";
		echo "<p1><b> Upvote :</b> ".$upvote."</p1>";
	}
	if($poster_id== $_SESSION['user_id']){
		$_SESSION['isPoster']= true;
	}
	else{
		$_SESSION['isPoster']= false;
	}

 	$stmt->close();
	if(isset($_SESSION['user_id'])){
		echo '<form method="post">';
		echo '<input type="submit" name="button" value="Upvote Post"/><br><br>';
		if ($_SESSION['isPoster']){
			echo '<input type="submit" name="button" value="Edit Post"/>';
			echo '<input type="submit" name="button" value="Delete Post"/>';
		}
		echo '</form>';
	}

?>
<hr>

<b><ins>Comments</ins></b>
<form  action="edit_delete_comment.php" method="post">
<?php
	$post_id= $_SESSION['post_id'];
	$stmt= $mysqli->prepare("select users.username, user_id, comment,comment_id from comments join users on (comments.user_id= users.id)where post_id=? ");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}

	$stmt->bind_param('i', $post_id);

	$stmt->execute();

	$stmt->bind_result($username,$commenter_id, $comment, $comment_id);

	while($stmt-> fetch()){
		if(isset($_SESSION['user_id'])){
			if($commenter_id== $_SESSION['user_id']){
				echo '<input type="radio" name="comment_id" value="';
				echo $comment_id;
				echo '"/>';
				echo '<b>'.$username.':</b> ';
				printf("\t%s\n<br>",
					htmlspecialchars($comment)
				);
			}
			else{
				echo '<b>'.$username.':</b>';
				echo $comment; 
				echo '<br><br>';
			}
		}
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
</form>
</body>
</html>

