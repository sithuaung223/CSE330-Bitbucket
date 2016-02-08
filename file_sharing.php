<!DOCTYPE html>
<html>
<head>
	<title>File Sharing Site</title>
</head>

<body>
<form method= "post">
	<input type= "text" name= "username"/>
	<input type= "submit" name="login" value= "Log In"/>
</form>

<?php
session_start();
	if (isset($_POSt['login'])){
		echo "logout!";
	}
	if (isset($_POST['login'])){
		ini_set('auto_detect_line_endings', true);
		$h = fopen("users.txt", "r");
		 
		$linenum = 1;
		echo "<ul>\n";
		while( !feof($h) ){
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
