<!DOCTYPE html>
<html>
<head>
</head>
<body>
<form action="home.php">
	<input type="submit" value="Login"/>
</form>
<h1>Saidit</h1>
<form method="post">
<?php
  require 'database.php';
  session_start();
  $stmt= $mysqli->prepare("select post_id, post_title,hlink from posts ");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }

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
</form>

</body>
</html>
