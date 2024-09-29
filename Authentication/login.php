<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../Css/Login1.css">
    <title>Maze Login Page</title>
    <link rel="icon" href="../Mazelogo.png" type="image/png">
<link rel="shortcut icon" href="Mazelogo.ico" type="image/x-icon">

</head>


<body>
    <?php
    if (isset($_GET['signup']) && $_GET['signup'] === 'success') {
        echo "<div id='popup' class='popup'>Signup successful! Please log in.</div>";
    }
    ?>
    <?php
    if (isset($_GET['signup']) && $_GET['signup'] === 'success') {
        echo "<div id='popup' class='popup'>Signup successful! Please log in.</div>";
    }
    ?>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST" action="Register_otp.php">
                <h1>Create Account</h1>
                <br>
                <input type="text" name="name" placeholder="Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form method="POST" action="">
                <h1>Sign In</h1>
                <br>
                <!-- <input type="email" name="email" placeholder="Email" required> -->
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <!-- <a href="#">Forget Your Password?</a> -->
                <button type="submit" name="signin">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal br details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <div id="accountDeletedPopup" class="popup" style="display: none;">
        <div class="popup-content">
            <h2>Account Deleted</h2>
            <p>Your account has been deleted successfully.</p>
            <button id="closePopup" class="confirm-btn">Close</button>
        </div>
    </div>
    <script src="../Js/login.js"></script>
    <script>
        // Check if the popup exists
        const popup = document.getElementById('popup');
        if (popup) {
            // Show the popup for 3 seconds, then hide it
            setTimeout(() => {
                popup.style.display = 'none';
            }, 3000);
        }

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('deleted') === 'true') {
            document.getElementById('accountDeletedPopup').style.display = 'flex';
        }

        document.getElementById('closePopup').addEventListener('click', function() {
            document.getElementById('accountDeletedPopup').style.display = 'none';
        });

        window.onclick = function(event) {
            var popup = document.getElementById('accountDeletedPopup');
            if (event.target == popup) {
                popup.style.display = 'none';
            }
        }
    </script>
</body>

</html>


<?php
session_start(); // Start the session

// Include the config file
include 'config.php';
include 'mail_handler.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sign Up Logic
    if (isset($_POST['signup'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security

        $sql = "INSERT INTO maze_user (username, email, passkey) VALUES ('$name', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "New account created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Sign In Logic
    if (isset($_POST['signin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query to get the user details including user_id and password hash
        $sql = "SELECT * FROM maze_user WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $row = $result->fetch_assoc();
            if ($row['otp_verified'] == 0) {
                $user_id = $row['user_id'];
                $otp = rand(100000, 999999);
                // update the new otp into the database
                $sql = "UPDATE `maze_user` SET `otp` = '$otp' WHERE `username` = '$username' OR `user_id` = '$user_id'";
                $upd = $conn->query($sql);
                if (!$upd) {
                    die("Error updating");
                    exit();
                }
                $_SESSION['otp_email'] = $row['email'];
                $mail = sendMail($username, $row['email'], $otp);
                echo "otp not verified";
                if ($mail == "OK") {
                    echo "<script>
                            window.location.href = 'otp.php';
                          </script>";
                } else {
                    echo $mail;
                }
                exit();
            }
            if (password_verify($password, $row['passkey'])) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['user_id'];
                header('Location: ../dashboard.php');
                exit();
            } else {
                echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert('Invalid password!');
    });
</script>";
            }
        } else {
            echo "No user found with this username!";
        }
    }
}
$conn->close();
?>