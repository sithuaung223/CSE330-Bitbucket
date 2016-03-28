<?php
/*what im trying to do
create an event
time is a string
*/
session_start();

// if($_POST['token'] == $_SESSION["token"]){//create a session id when i log in
if(isset($_SESSION['user_id'])){  
  header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
  require 'database.php';

  $user_id = $_SESSION['user_id'];
  $date = $_POST['date'];
  $time = $_POST['time'];
  $title = $_POST['title'];
  $category = $_POST['category'];

$stmt= $mysqli->prepare("insert into events (user_id, date, time, title, category) values (?, ?, ?, ?, ?)");
    if (!$stmt){
      echo json_encode(array(
      "success" => false,
      "message" => "Invalid Statement"
    ));
      exit; 
    }
$stmt->bind_param('issss', $user_id, $date, $time, $title, $category);
    $stmt->execute();
    $stmt->close();

  echo json_encode(array(
    "success" => true
  ));
  exit;

}else{
  echo json_encode(array(
    "success" => false,
    "message" => "Invalid Login"
  ));
  exit;
}

?>