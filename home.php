<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Saidit</title>
	<style type= "text/css">
		body{
			background: #55B14A;
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
		$_SESSION['username']= $_POST['username'];
		$_SESSION['password']= $_POST['password'];
		$_SESSION['email']= $_POST['email'];
		header("Location: insert.php");
	}
/*login*/
	if (isset ($_POST ['login'])){
		$_SESSION['username']= $_POST['username'];
		$_SESSION['password']= $_POST['password'];
		$_SESSION['token'] = substr(md5(rand()), 0, 10); // generate a 10-character random string
		header("Location: select.php");
	}
?>
<h1> Welcome To Saidit!</h1>
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
