<?php
include_once '../src/connection.php';

session_start();
//if not logged in or csrf token invalid, then we cannot procede

if (!hash_equals($_SESSION['token'], $_POST['token']) || !$_SESSION['logged_in']) {
  session_destroy();
  header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');    
  exit();
}

$contact = $_POST['contact'];
$id = $_SESSION['session_id'];
$comment = $_POST['comment'];
$target_dir = "photos/".$id."/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  if(getimagesize($_FILES["fileToUpload"]["tmp_name"] == false)) {     
    exit("File is not an image.");
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  exit("Sorry, file already exists.");
}

if (getimagesize($_FILES["fileToUpload"]["tmp_name"]) === false) {
    exit("File is not an image.");
}

//Check file size to limit a file beeing too big
if ($_FILES["fileToUpload"]["size"] > 1000000) {
  exit( "Sorry, your file is too large.");
}

// Allow only these file formats
if($imageFileType != "jpg" && 
  $imageFileType != "png" && 
  $imageFileType != "jpeg" && 
  $imageFileType != "gif" ) {
  exit("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
}

// Create the directory if it doesn't exist
if (!file_exists($target_dir)) {
  mkdir($target_dir, 0777, true);
}
if ($contact == "Email") {
  if ($statement = $connection->prepare('SELECT email FROM accounts WHERE id = ?')) {
    $statement->bind_param('s', $id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($contact);
  }
} else {
  if ($statement = $connection->prepare('SELECT phone FROM accounts WHERE id = ?')) {
    $statement->bind_param('s', $id);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($contact);
  }
}
// uploads the file
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  $filename = basename( $_FILES["fileToUpload"]["name"]);
  if ($query = $connection->prepare("INSERT INTO images (id, comment, file_name, contact) VALUES (?, ?, ?, ?)")) {
    $query->bind_param("ssss", $id, $comment, $filename, $contact);
    $query->execute();

    if ($query->affected_rows > 0) {
      header('Location: responses/file_upload_succesful.html');
      exit();
    } else {
      header('Location: responses/file_upload_fail.html');
      exit();
    }

    $query->close();
  } else {
    header('Location: responses/file_upload_fail.html');
    exit();
  }
} else {
  header('Location: responses/file_upload_fail.html');
  exit();
}

?>
