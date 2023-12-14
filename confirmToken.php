<?php
session_start();
include_once 'src/connection.php';
include_once 'tokenAuth.php';

if ($_POST['CSRF'] != $_SESSION['CSRF']) {
    session_destroy();
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');    
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email and token from the POST data
    $email = $_SESSION['session_email'];
    $token = $_POST["token"];

    if (confirmAuthToken($email, $token, $connection)) {
        if ($statement = $connection->prepare('UPDATE accounts SET confirmed = 1 WHERE email = ?')) {
            $statement->bind_param('s', $email);
            $statement->execute();
            $statement->close();
        }
        $_SESSION['logged_in'] = true;
        // session fixation prevention
        session_regenerate_id(true);
        header("Location: app/landing_page.php");
		exit();
    } else {
        header("Location: confirmation/account_verification_failed.html");
		exit();
    }
}
?>
