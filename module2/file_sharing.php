<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>File Sharing Site</title>
	<style type= "text/css">
		body{
			background: #25383C;
			text-align: center;
			color: white;
		}
	</style>
</head>

<body>
<h1> Welcome To Awesome Filesharing site!</h1>
<!--Login form-->
<form method= "post">
	<input type= "text" name= "username"/>
	<input type= "submit" name="login" value= "Log In"/>
</form>

<?php
	session_start();

	/*after logout*/
	if (isset($_POST['logout_btn'])){
		$_SESSION= array();
		session_destroy();
		echo "logout!";
	}

	/*login button to check valid user*/
	if (isset($_POST['login'])){
		ini_set('auto_detect_line_endings', true);
		$h = fopen("/home/sithuaung/users.txt", "r");
		$linenum = 1;
		echo "<ul>\n";

		while (!feof($h)){
			$username= trim (fgets ($h));
			if ($_POST['username']=== $username && strlen($username)> 0){
				$_SESSION['username']= $_POST['username'];
				header("Location: profile.php");
				exit;
			}
			
		}
		echo "</ul>\n";
		fclose($h);
	}
?>	
</body>
</html>
