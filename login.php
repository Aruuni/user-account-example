<?php
include_once 'src/connection.php';
include_once 'tokenAuth.php';
include_once 'src/captcha.php';
//site      6LeeNCEpAAAAACjAcEUxAEKzRPGkN4Odwveq8Fh_
//secret    6LeeNCEpAAAAAAvBEIXPf4PQX-Wn0MoRBF2yRCUp
check_captcha();
session_start();

if ($_POST['token'] != $_SESSION['token']) {
    session_destroy();
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');    
    die("Error: Tokens do not match.");
} 
$username = $_POST['username'];
$password = $_POST['password'];

if ($accountLockCheck = $connection->prepare('SELECT id FROM accounts WHERE locked_until > NOW() AND username = ?')) {
	$accountLockCheck->bind_param('s', $username);
	$accountLockCheck->execute();
	$accountLockCheck->store_result();
	if ($accountLockCheck->num_rows > 0) {
		$accountLockCheck->close();
		header('Location: confirmation/account_locked.html');
		exit();
	}
	$accountLockCheck->close();
}

if ($statement = $connection->prepare('SELECT id, email, confirmed, password, is_admin FROM accounts WHERE username = ?')) {
	$statement->bind_param('s', $_POST['username']);
	$statement->execute();
	$statement->store_result();
	if ($statement->num_rows > 0) {
		$statement->bind_result($id, $email, $confirmed, $pass, $is_admin);
		$statement->fetch();
		if ($is_admin == 1) {
			header("Location: app/admin.php");
			exit();
		}
		if ($confirmed == 0) {
			send_account_confirmation($email, $connection);   
			header('Location: confirmation/check_email.html');
			exit();
		}
		if (password_verify($password, $pass)) {
			if ($lockAccount = $connection->prepare('UPDATE accounts SET fast_fails = 0, locked_until = NULL WHERE username = ?')) {
				$lockAccount->bind_param('s', $username);
				$lockAccount->execute();
				$lockAccount->close();
			}
			$_SESSION['session_email'] = $email;
			$_SESSION['session_id'] = $id;
			$_SESSION['session_user'] = $username;
			send_login_code($email, $connection);
			header("Location: src/confirm.php");
			exit();

		} else {
			if ($retyLimit = $connection->prepare('SELECT fast_fails FROM accounts WHERE username = ?')) {
				$retyLimit->bind_param('s', $username);
				$retyLimit->execute();
				$retyLimit->store_result();

				if ($retyLimit->num_rows > 0) {
					$retyLimit->bind_result($fast_fails);
					$retyLimit->fetch();
					$fast_fails++;
					if ($fast_fails > 3) {
						$retyLimit->close();
						if ($lockAccount = $connection->prepare('UPDATE accounts SET fast_fails = 0, locked_until = DATE_ADD(NOW(), INTERVAL 20 MINUTE) WHERE username = ?')) {
							$lockAccount->bind_param('s', $username);
							$lockAccount->execute();
							$lockAccount->close();
						}
						header('Location: confirmation/account_locked.html');
						exit();
					} else {
						$retyLimit->close();
						if ($updateFails = $connection->prepare('UPDATE accounts SET fast_fails = ? , locked_until = Now() WHERE username = ?')) {
							$updateFails->bind_param('is', $fast_fails, $username);
							$updateFails->execute();
							$updateFails->close();
						}
						header('Location: confirmation/incorrect_password.html');
						exit();
					}
				} 
			}
		}
	} else {
		header('Location: confirmation/username_not_found.html');
		exit();
	}
	$statement->close();
	exit();
}
?>