<!DOCTYPE html>
<html>
<head>
	<title>Write Posts</title>
	<meta charset="UTF-8">
  <style type= "text/css">
    body{
      background: #55B14A;
      color: white;
    }

    #story{
      height: 50px;
      width: 500px;
    }

    div.logout_btn{
      text-align: right;
    }
		h1{
      text-align: center;
		}
  </style>
</head>

<body>
  <h1><ins>Story</ins> </h1>
  <form method="post">
    <label> Story Title: </label>
      <input type="text"  name="story_title"/><br>
    <label> Link: </label>
      <input type="text"  name="story_link"/><br>
    <label>Image Link: </label>
      <input type="text"  name="img_link"/><br>
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
		$upvote= 0;
		$_SESSION['hlink']= $_POST['story_link'];
		$hlink= $_SESSION['hlink'];
		$img_link= $_POST['img_link'];
    $stmt= $mysqli->prepare("insert into posts (user_id, post_title, post, upvote, hlink, img_link) values (?, ?, ?, ?, ?, ?)");
    if (!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }

    $stmt->bind_param('ississ', $user_id, $post_title, $post,$upvote, $hlink, $img_link);

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
