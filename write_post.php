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
  <h1>Story </h1>
  <form method="post">
    <label> Story Title: </label>
      <input type="text"  name="story_title"/><br>
    <label> About: </label>
      <input type="text"  id="story" name="story"/><br>
      <input type="submit" name="submit_story" value="Submit"/><br>
      <input type="submit" name="cancel" value="Cancel"/><br>
		
  </form>

<!--php-->
<?php
  require 'database.php';
  session_start();
  $user_id= $_SESSION['user_id'];
  if (isset($_POST['submit_story'])){

    $post_title= $_POST['story_title'];
		$post= $_POST['story'];
    $stmt= $mysqli->prepare("insert into posts (user_id, post_title, post) values (?, ?, ?)");
    if (!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }

    $stmt->bind_param('iss', $user_id, $post_title, $post);

    $stmt->execute();

    $stmt->close();
    header("Location: profile.php");
  }
  if (isset($_POST['cancel'])){
    header("Location: profile.php");
	}
?>
</body>
</html>
