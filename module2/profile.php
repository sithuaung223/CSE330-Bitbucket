<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>File Sharing Site</title>
	<style type= "text/css">
		h1{
			text-align: center;
			color: white;
			size: 60
		}
		body{
			background: #25383C;
			color: #808080;
		}
		div.logout_btn{
			text-align: right;
		}
	</style>
</head>
<body>

<!--username title-->
<h1>
	<?php 
		session_start();
		echo $_SESSION['username'];
	?>
</h1>

<!--logout -->
<form action="file_sharing.php" method="post">
	<div class= "logout_btn">
		<input type="submit" name="logout_btn" value="Log Out"/>
	</div>
</form>

<!--uploading -->
<h2>Upload</h2><hr>
<form enctype="multipart/form-data" action="uploader.php" method="POST">
	<p>
		<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
		<label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input" />
	</p>
	<p>
		<input type="submit" value="Upload File" />
	</p>
</form>
<br>

<!--users' file list-->
<h2>File List</h2>
<hr>
<form action="downloader.php" method="post">
<?php
	//getting user files from server 
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
			echo '<input type="radio" name="file" value="';
			echo $files[$i];
			echo '"/>';
			print_r ($files[$i]. "<br>\n");
		}
	}
	else{
		header("LOCATION: file_sharing.php");
		exit;
	}
?>
	<input type="submit" name="button" value="View"/>
	<input type="submit" name="button" value="Delete"/>
</form>

</body>

</html>
