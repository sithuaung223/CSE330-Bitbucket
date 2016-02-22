<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Main Page</title>
	 <style type= "text/css">
    body{
      background: #55B14A;
      color: white;
    }
    #btn{
			text-align: right;
    }
		h1{
			text-align: center;
		}
	</style>

</head>
<body>
<h1>Saidit</h1>
<?php
  require 'database.php';
  session_start();
	if(isset($_SESSION['user_id'])){
		 if(($_SESSION['token']-$_POST['token'])!=0){ 
					die("Request forgery detected");
				}
		echo'<form action="profile.php">';
		echo'<input type="submit" value="My Profile"/>';
		echo'</form>';
		echo'<form id="btn" action="home.php" method="post">';
		echo'<input type="submit" name="logout_btn" value="Log Out"/>';
		echo'</form>';
	}
	else{
		echo'<form id="btn" action="home.php">';
		echo'<input type="submit" value="Login"/>';
		echo'</form>';
	}
?>

<form method="post">
<?php
  $stmt= $mysqli->prepare("select users.username, post_id, post_title,hlink from posts join users on (posts.user_id=users.id) ");

  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }

  $stmt->execute();
  $stmt->bind_result($username, $post_id, $post_title,$hlink);



  while($stmt-> fetch()){
      echo '<input type="radio" name="stories" value="'.$post_id.'"/>';
      if(!$hlink){
          printf("\t%s\n<br>",
        htmlspecialchars($post_title)
      );
      }else{
      echo "<a href=http://".htmlspecialchars($hlink).">" .$post_title. "</a><br>";
      }
			echo '<p>posted by '.$username.'</p><hr>';
    }
  $stmt->close();
  if(isset($_POST['button'])){
    $_SESSION['post_id']= $_POST['stories'];
  header("Location: posts.php");
  }

?>
  <br>
  <input type="submit" name="button" value="View"/>
</form>

</body>
</html>
