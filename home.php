<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Facebook</title>
	<style type= "text/css">
		body{
			background: #25383C;
			text-align: center;
			color: white;
		}
	</style>
</head>

<body>
<?php
session_start();

/*logout*/
  if (isset($_POST['logout_btn'])){
    $_SESSION= array();
    session_destroy();
    echo "logout!";
  }
	
/*register*/
	if (isset ($_POST ['register'])){
		header("Location: insert.php");
		$_SESSION['username']= $_POST['username'];
		$_SESSION['password']= $_POST['password'];
		$_SESSION['email']= $_POST['email'];
	}
/*login*/
	if (isset ($_POST ['login'])){
		header("Location: select.php");
		$_SESSION['username']= $_POST['username'];
		$_SESSION['password']= $_POST['password'];
	}
?>
<h1> Welcome To Facebook!</h1>
<!--Rigester form-->
<form method= "post">
	<label>Username: </label>
		<input type= "text" name= "username"/><br>
	<label>Password: </label>
		<input type= "password" name= "password"/><br>
	<label>Email: </label> 
		<input type= "email" name= "email"/><br>
	<input type= "submit" name="register" value= "Register"/>
</form>

<hr>
<!--LogIn form-->
<form method= "post">
	<label>Username: </label>
		<input type= "text" name= "username"/><br>
	<label>Password: </label>
		<input type= "password" name= "password"/><br>
	<input type= "submit" name="login" value="log in"/>
</form>

</body>
</html>
