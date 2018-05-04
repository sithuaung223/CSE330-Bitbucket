<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title> Calculator</title>
</head>
<body>
<form  method="post">
	<label> First Number</label>
	<input type="number" name="first_num" /><br><br>	
	<label>Second Number</label>
	<input type="number" name="second_num" /><br>
	<input type="radio" name="operator" value="add"/> Addition <br>
	<input type="radio" name="operator" value="sub"/> Substraction <br>
	<input type="radio" name="operator" value="mul"/> Multiplication <br>
	<input type="radio" name="operator" value="div"/> Division <br>
	<input type="submit" value="Submit"/>
</form>

<p> Answer: </p>
<?php
	if(isset($_POST['operator'])){
		$first= $_POST['first_num'];
		$second= $_POST['second_num'];
		$op= $_POST['operator'];
		switch($op){
		case"add":
			echo $first+$second;
			break;
		case"sub":
			echo $first-$second;
			break;
		case"mul":
			echo $first*$second;
			break;
		case"div":
			if($second == 0){
				echo "cannot divide ".$first." with zero";
			}
			else{
				echo $first/$second;
			}
			break;
		}
	}
?>
</body>
</html>
