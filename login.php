<?php
include 'config.php';  // Include the database connection file

session_start(); // Start the session for user data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the registration form is submitted
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepared statement to insert user data
        $stmt = $mysqli->prepare("INSERT INTO register (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Error: Could not complete registration. Please try again later.'); window.location='register.php';</script>";
        }
        $stmt->close();
    }

    // Check if the login form is submitted
    elseif (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare SQL query to check user
        $stmt = $mysqli->prepare("SELECT id, password FROM register WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // Successful login, start session and store user data
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;

                echo "<script>alert('Login successful!'); window.location='https://drive.google.com/drive/folders/1Jzhka6vjnLy5oENzQLwtTJgscTD53M3C?usp=drive_link';</script>";
            } else {
                echo "<script>alert('Invalid password!'); window.location='login.php';</script>";
            }
        } else {
            echo "<script>alert('No user found with that username!'); window.location='login.php';</script>";
        }
        $stmt->close();
    }
    $mysqli->close();  // Close the database connection
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Login Page - LIT</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="wrap d-md-flex">
                    <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                        <div class="text w-100">
                            <h2>Welcome to login</h2>
                            <p>Don't have an account?</p>
                            <a class="btn btn-white btn-outline-white" href="register.php">Register</a>
                        </div>
                    </div>
                    <div class="login-wrap p-4 p-lg-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4"><b> SIGN IN </b></h3>
                            </div>
                        </div>
                        <form method="POST" action="login.php" class="signin-form">
                            <div class="form-group mb-3">
                                <label class="label" for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username" required autocomplete="off">
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <!-- Added name="login" so PHP can detect form submission -->
                                <button type="submit" name="login" class="form-control btn btn-primary submit px-3">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>


