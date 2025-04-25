<?php 
include 'config.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if username or email already exists
    $stmt = $mysqli->prepare("SELECT id FROM register WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Duplicate found
        echo "<script>alert('Username or Email already exists. Please try another one.'); window.location='register.php';</script>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $mysqli->prepare("INSERT INTO register (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            // Set session
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $mysqli->insert_id;

            // Send welcome email
            $mail = new PHPMailer(true);
            try {
                // SMTP config
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'thuvask001@gmail.com';       // Your Gmail
                $mail->Password = 'jrclxlfvrgbnftey';           // App password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Email content
                $mail->setFrom('thuvask001@gmail.com', 'LIT Team');
                $mail->addAddress($email, $username);

                $mail->isHTML(true);
                $mail->Subject = 'Welcome to LIT!';
                $mail->Body = "
                    <h2>Welcome, $username!</h2>
                    <p>Thanks for joining Learn ICT Together 🎉</p>
                    <p>We're excited to have you onboard. Let us know if you need help!</p>
                    <br><p><strong> - The LIT Team</strong></p>
                ";

                $mail->send();
            } catch (Exception $e) {
                error_log("Email could not be sent: {$mail->ErrorInfo}");
            }

            // Redirect to drive
            header("Location: https://drive.google.com/drive/folders/1Jzhka6vjnLy5oENzQLwtTJgscTD53M3C?usp=drive_link");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $mysqli->close();
}
?>


<!doctype html>
<html lang="en">
<head>
    <title>Register-LIT</title>
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
                            <h2>Welcome to Sign Up </h2>
                            <p>Already Have an account? Sign In now!</p>
                            <a href="login.php" class="btn btn-white btn-outline-white">Sign In</a>
                        </div>
                    </div>
                    <div class="login-wrap p-4 p-lg-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4"><b><center>SIGN UP</center></b></h3>
                            </div>
                        </div>
                        <form action="" method="POST">
                            <div class="form-group mb-3">
                                <label class="label" for="username">User Name </label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your user name!" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="email">E-Mail</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email!" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password!" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Sign Up</button>
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


