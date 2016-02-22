<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Profile</title>
	<style type= "text/css">
    body{
      background: #55B14A;
      color: white;
    }
		h1{
      text-align: center;
		}
		#story{
			height: 50px;
			width: 500px;
		}

		#btn{
			text-align: right;
		}
	</style>
</head>
<body>
	<form id="btn" action="home.php" method="post">
			<input type="submit" name="logout_btn" value="Log Out"/>
	</form>
<h1>Profile</h1>
	<form action="main.php" method="post">
			<input type="submit" name="main_page_btn" value="Main Page"/>
			 <input type="hidden" name="token" value="
					<?php 
						echo $_SESSION['token'];
					?>" />

	</form>
<hr>
<p>My Posts </p>
<!--php-->
<form method="post">
<?php
  require 'database.php';
  session_start();
	$user_id= $_SESSION['user_id'];
	$stmt= $mysqli->prepare("select post_id, post_title,hlink from posts where user_id=?");
	if(!$stmt){
		printf("Query Prep Failed: %s\n", $mysqli->error);
		exit;
	}
	 
	$stmt->bind_param('i', $user_id);
	 
	$stmt->execute();
	 
	$stmt->bind_result($post_id, $post_title,$hlink);
	 
	 
	while($stmt-> fetch()){
			echo '<input type="radio" name="stories" value="'.$post_id.'"/>';
			if(!$hlink){
					printf("\t%s\n<br>",
				htmlspecialchars($post_title)
			);
			}else{
				echo "<a href=http://".htmlspecialchars($hlink).">" .$post_title. "</a><br>";
			}
		}
	$stmt->close();
	if(isset($_POST['button'])){
		$_SESSION['post_id']= $_POST['stories'];
		header("Location: posts.php");
	}

?>
	<br>
  <input type="submit" name="button" value="View"/>
</form><br><br>

<form action="write_post.php" method="post">
	<input type="submit" value="Wirte a Story"/>
</form>
</body>
	
</html>
