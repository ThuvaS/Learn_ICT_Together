<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "UPDATE register SET username=?, email=?, password=? WHERE id=?";
    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("sssi", $username, $email, $password, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
