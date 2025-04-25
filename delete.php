<?php
include 'config.php';

// Check if the ID is set and delete the record
if (isset($_GET['id'])) {
    // Sanitize input to prevent SQL Injection
    $id = mysqli_real_escape_string($mysqli, $_GET['id']);
    
    // SQL query to delete the record
    $sql = "DELETE FROM register WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    
    // Bind the parameter and execute the query
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Redirect to view.php after successful deletion
        header("Location: view.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid ID.";
}
?>
