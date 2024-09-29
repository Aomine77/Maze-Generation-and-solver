<?php

session_start();  // Start the session
include 'config.php';
require '../vendor/autoload.php'; // Make sure PHPMailer is autoloaded

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['signup'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security

        // Check if the username or email already exists
        $checkQuery = "SELECT * FROM maze_user WHERE username='$name' OR email='$email'";
        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            // If username or email exists, show an error message
            echo "<script>
                    alert('Username or Email already exists!');
                    window.location.href = 'login.php';
                  </script>";
        } else {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Insert the new user into the database
            $sql = "INSERT INTO maze_user (username, email, passkey, otp) VALUES ('$name', '$email', '$password', '$otp')";

            if ($conn->query($sql) === TRUE) {
                // Store the email in session for OTP verification
                $_SESSION['otp_email'] = $email;
                $_SESSION['username'] = $name;

                // Send OTP email using PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'sthabipin0713@gmail.com';
                    $mail->Password = 'lujrtsnxffkbxipl'; 
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('reply@noreply.com', 'Maze');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Your OTP Code';
                    $mail->Body    = "Hi $name,<br><br>Your OTP code is <b>$otp</b>.<br>Please use this code to complete your registration.";

                    $mail->send();
                    echo "<script>
                            window.location.href = 'otp.php';
                          </script>";
                } catch (Exception $e) {
                    // If email sending fails, delete the user from the database
                    $deleteSql = "DELETE FROM maze_user WHERE email='$email' AND username='$username'";
                    $conn->query($deleteSql);

                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    echo "<script>
                            alert('Registration failed! Please try again.');
                            window.location.href = 'login.php';
                          </script>";
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}
?>
