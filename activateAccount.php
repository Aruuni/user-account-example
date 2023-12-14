<?php
include_once 'src/connection.php';  

$email = $_GET['email'];
$activation_code = $_GET['activation_code'];

if ($statement = $connection->prepare('SELECT id FROM accounts WHERE email = ? AND activation_token = ? AND activation_token_timestamp > NOW()')) {
    $statement->bind_param('ss', $email, $activation_code);
    $statement->execute();
    $statement->store_result();
    if ($statement->num_rows > 0) {
        $statement->close();
        if ($statement = $connection->prepare('UPDATE accounts SET confirmed = 1 WHERE email = ?')) {
            $statement->bind_param('s', $email);
            $statement->execute();
            $statement->close();
            header("Location: confirmation/account_verified.html");
            exit();
        }
    } else {
        $statement->close();
        header("Location: confirmation/account_verification_failed.html");
        exit();
    }
}
?>
