<!DOCTYPE html>
<html>

<head>
	<title>File Sharing Site</title>
	<style type = "text/css">
		h1 {text-align: center;
			color: #600000 ;
			size: 40}
		body {background: #606060}	
	</style>
</head>
<body>

<!--logout -->
<form method="post">
	<p align="right">
		<input type="submit" name="logout_btn" value="logout"/>
	</p>
</form>

<!--uploading -->
<form enctype="multipart/form-data" action="uploader.php" method="POST">
	<p>
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
	</p>
	<p>
		<input type="submit" value="Upload File" />
	</p>
</form>
<form action="downloader.php" method="post">
<?php
session_start();
	if(isset($_POST['logout_btn'])){
		$_SESSION= array();
		session_destroy();
		header("Location: file_sharing.php");
	}
	
	//downloading
	if(isset($_SESSION['username'])){
		$dir= sprintf("/home/sithuaung/uploads/%s", $_SESSION['username']);
		$dh= opendir($dir);
		while (false !== ($filename = readdir($dh))) {
				$files[] = $filename;
		}
		sort($files);
		if( count($files) <3){
			echo "No File Exists";
			exit;
		}
		for ($i= 2; $i< count($files); $i++){
			echo "<input type='radio' name='file' value=";
			echo $files[$i];
			echo ">";
			print_r ($files[$i]. "<br>");
		}
	}
	else{
		exit;
	}
?>
	<input type="submit" name="button" value="download"/>
	<input type="submit" name="button" value="delete"/><br>
</form>

</body>

</html>
