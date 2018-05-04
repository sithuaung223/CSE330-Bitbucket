<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Edit Post</title>
  <style type='text/css'>
    body{
      background: #55B14A;
      color: white;
    }
    #story{
      height: 50px;
      width: 500px;
    }
		h1{
      text-align: center;
		}
  </style>
</head>
<body>
  <h1><ins>Story </ins></h1>
  <form method="post">
    <label> Story Title: </label>
      <input type="text"  name="story_title"/><br>
    <label> About: </label>
      <input type="text"  id="story" name="story"/><br>
      <input type="submit" name="submit_story" value="Update"/><br>
      <input type="submit" name="cancel" value="Cancel"/><br>

  </form>
<!--php-->
<?php
  require 'database.php';
  session_start();
  $post_id= $_SESSION['post_id'];

  if (isset($_POST['submit_story'])){

    $post_title= $_POST['story_title'];
    $post= $_POST['story'];
    $stmt= $mysqli->prepare("update posts set post_title= ?, post= ? where post_id=?");
    if (!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }

    $stmt->bind_param('ssi', $post_title, $post, $post_id);

    $stmt->execute();

    $stmt->close();
    header("Location: posts.php");
  }
  if (isset($_POST['cancel'])){
    header("Location: posts.php");
  }
?>
</body>
</html>

