<!DOCTYPE html>
<html>
<head>
	<style type='text/css'>
		#story{
			height: 50px;
			width: 500px;
		}

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

	<form action="write_post.php" method="post">
			<input type="submit" value="Wirte a Story"/><br>
	</form>
<!--php-->
<form action="posts.php" method="post">
<?php
  require 'database.php';
  session_start();
	$user_id= $_SESSION['user_id'];
	$stmt= $mysqli->prepare("select post_id, post_title from posts where user_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('i', $user_id);
	 
	$stmt->execute();
	 
	$stmt->bind_result($post_id, $post_title);
	 
	while($stmt-> fetch()){
    echo '<input type="radio" name="stories" value="'; 
    echo $post_id; 
    echo '"/>'; 
		printf("\t%s\n<br>",
			htmlspecialchars($post_title)
		);
	}
	 
	$stmt->close();
?>
 <input type="submit" name="button" value="View"/>
 <input type="submit" name="button" value="Delete"/>
</form>

</body>
	
</html>
