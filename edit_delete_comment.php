<!DOCTYPE html> 
<html>
<head>
  <style type='text/css'>
    #comment{
      height: 50px;
      width: 500px;
    }
  </style>
</head>
<body>
  <h1>Comment </h1>
  <form method="post">
    <label>Your Comment: </label>
      <input type="text"  id="comment" name="comment"/><br>
			<br>
      <input type="submit" name="update" value="Update"/><br>
      <input type="submit" name="cancel" value="Cancel"/><br>

  </form>
<!--php-->
<?php
  require 'database.php';
  session_start();
	$comment_id= $_SESSION['comment_id'];

	//update;
  if (isset($_POST['update'])){

		$comment_id= $_SESSION['comment_id'];
    $comment= $_POST['comment'];
    $stmt= $mysqli->prepare("update comments set comment=?  where comment_id=?");
    if (!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }

    $stmt->bind_param('si',$comment, $comment_id );

    $stmt->execute();

    $stmt->close();
    header("Location: posts.php");
  }
  if (isset($_POST['cancel'])){
    header("Location: posts.php"); 
  } 

	// Edit and Delete comment from posts.php
    if (isset($_POST['button'])){
			$_SESSION['comment_id']= (int)$_POST['comment_id'];
			$comment_id= $_SESSION['comment_id'];
      $button= $_POST['button'];
      if ($button== "Edit Comment"){
      }
      if ($button== "Delete Comment"){
        $stmt= $mysqli->prepare("delete from comments where comment_id=?");

        if(!$stmt){
          printf("Query Prep Failed: %s\n", $mysqli->error);
          exit;
        }

        $stmt->bind_param('i', $comment_id);
        $stmt->execute();
        $stmt->close();
        header("Location: posts.php");
      }
    }

?> 
</body>

</html>


