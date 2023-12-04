<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'compsec';

// Create a database connection
$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
