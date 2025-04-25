<?php 
include 'config.php';

// Fetching the record if `id` is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Sanitize input to prevent SQL Injection
    $id = mysqli_real_escape_string($mysqli, $id);

    // Correct SQL query to fetch user data
    $result = mysqli_query($mysqli, "SELECT * FROM register WHERE id = $id");

    if ($result) {
        $resultData = mysqli_fetch_assoc($result);

        $username = $resultData['username'];
        $email = $resultData['email'];
        $password = $resultData['password'];
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $id = $_POST['id'];
    $username = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before updating the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statement to prevent SQL injection
    $sql = "UPDATE register SET username=?, email=?, password=? WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    
    // Bind parameters to the statement
    $stmt->bind_param("ssssssi", $username, $email, $hashedPassword, $id);

    // Execute the query
    if ($stmt->execute()) {
        header("Location: view.php"); // Redirect after successful update
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
</head>
<body>
    <h2>Edit Data</h2>
    <p><a href="index.php">Home</a></p>    

    <form method="POST" action="update.php">
        <!-- Hidden input for the ID -->
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <table border="0">
            <tr>
                <td>User Name</td>
                <td><input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required></td>
            </tr>
            <tr>
            <tr>
                <td>Email</td>
                <td><input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required></td>
            </tr>
            <tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required></td>
            </tr>
        </table>
        <input type="submit" value="Update">
    </form>
</body>
</html>
