<?php
session_start();
include_once 'src/connection.php';
include_once 'tokenAuth.php';
include_once 'src/captcha.php';

check_captcha();

// Retrieve form data
$username           = $_POST['username'];
$email              = $_POST['email'];
$password           = $_POST['password'];
$confirmPassword    = $_POST['confirm_password'];
$phonenumber        = $_POST['phone'];

$username       = mysqli_real_escape_string($connection, $username);
$email          = mysqli_real_escape_string($connection, $email);
$phonenumber    = mysqli_real_escape_string($connection, $phonenumber);

//password match 
if ($password !== $confirmPassword) {
    die("Error: Passwords do not match.");
}

// Validate password strength
$uppercase      = preg_match('@[A-Z]@', $password);
$lowercase      = preg_match('@[a-z]@', $password);
$number         = preg_match('@[0-9]@', $password);
$specialChars   = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
    die('Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.');
}

if ($statement = $connection->prepare("SELECT * FROM accounts WHERE username = ? OR email = ?" )) {
    mysqli_stmt_bind_param($statement, "ss", $username, $email);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);

    if (mysqli_num_rows($result) > 0) {
        die("Username already exists. Please choose a different one.");  
    } 
} else {
    header('Location: "fail/database_connection.html"');
    exit();
}


// Hash the password for security (you should use a more secure hashing method in production)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

if ($query = $connection->prepare("INSERT INTO accounts (username, password, email, phone) VALUES (?, ?, ?, ? )")) {
    $query->bind_param("ssss", $username, $hashedPassword, $email, $phonenumber);
    $query->execute();

    // Check if the insertion was successful
    if ($query->affected_rows > 0) {
        send_account_confirmation($email, $connection);   
        header('Location: confirmation/check_email.html');
        exit(); // Make sure to exit after the header redirect
    } else {
        header('Location: "fail/database_connection.html"');
        exit();
    }

    $query->close();
} else {
    header('Location: "fail/database_connection.html"');
    exit();
}


$connection->close();
?>
