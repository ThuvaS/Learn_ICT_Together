<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lit";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Uncomment the line below if you want to confirm a successful connection
// echo "Connected successfully";
?>
