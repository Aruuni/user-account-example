<?php
session_start();
include_once 'src/connection.php';
include_once 'tokenAuth.php';
include_once 'src/captcha.php';
//site      6LeeNCEpAAAAACjAcEUxAEKzRPGkN4Odwveq8Fh_
//secret    6LeeNCEpAAAAAAvBEIXPf4PQX-Wn0MoRBF2yRCUp
check_captcha();
	
$username = $_POST['username'];
$password = $_POST['password'];
	
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($statement = $connection->prepare('SELECT id, email, confirmed, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$statement->bind_param('s', $_POST['username']);
	$statement->execute();
	$statement->store_result();
	if ($statement->num_rows > 0) {
		$statement->bind_result($id, $email, $confirmed, $pass);
		$statement->fetch();
		if ($confirmed == 0) {
			send_account_confirmation($email, $connection);   
			header('Location: confirmation/check_email.html');
			exit();
		}
		if (password_verify($password, $pass)) {
			$_SESSION['session_email'] = $email;
			send_login_code($email, $connection);
			header("Location: http://localhost/IntroToCompSec/confirmation/confirm.html");
			exit();

		} else {
			echo 'Incorrect username and/or password!';
		}
	} else {

		echo 'Incorrect username and/or password!';
	}

	$statement->close();
	exit();
}


?>
