<?php
session_start();

include 'config.php';

if (!isset($_SESSION['otp_email'])) {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['otp_email'];

$otp_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];
    $sql = "SELECT otp FROM maze_user WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($entered_otp == $row['otp']) {
            $sql = "UPDATE maze_user SET otp_verified = TRUE WHERE email='$email' AND otp='$entered_otp'";
            $conn->query($sql);
            $otp_success = true;  // OTP verified successfully
        } else {
            echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert('Invalid OTP!');
    });
</script>";
        }
    } else {
        echo "No OTP found for this email!";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;

        }

        /* Body and Container */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            display: flex;
            width: 800px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* OTP Verification Form */
        .form-container {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-container.otp-verification {
            flex: 1;
        }

        .form-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .form-container input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            background-color: #f5f5f5;
        }

        .form-container button {
            padding: 12px;
            width: 100%;
            background-color: #6a0dad;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #5b099e;
        }

        /* Toggle Container */
        .toggle-container {
            flex: 1;
            background: linear-gradient(45deg, #6a0dad, #8a2be2);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            padding: 40px;
            border-radius: 0 12px 12px 0;
        }

        .toggle-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .toggle-container p {
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* popup  */
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 2px solid #6a0dad;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            text-align: center;
        }

        .popup.active {
            display: block;
        }

        .popup h2 {
            margin-bottom: 20px;
        }

        .popup p {
            margin: 20px;
        }

        .popup button {
            background-color: #6a0dad;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin: 12px;
        }

        .popup button:hover {
            background-color: #5b099e;
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 90%;
            }

            .toggle-container {
                border-radius: 0 0 12px 12px;
            }

            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container otp-verification">
            <h1>Verify OTP</h1>
            <form method="POST" action="">
                <input type="text" name="otp" placeholder="Enter OTP" required>
                <button type="submit" name="verify_otp">Verify</button>
            </form>
        </div>
        <div class="toggle-container">
            <h1>Secure Your Account</h1>
            <p>Enter the OTP sent to your registered email to complete the verification process.</p>
        </div>
    </div>
    <div class="overlay"></div>
    <div class="popup">
        <h2>Registration Successful</h2>
        <hr>
        <p>Your account has been <br> successfully verified!</p>
        <button onclick="redirectHome()">Go to Login Page</button>
    </div>

    <script>
        // Check if OTP verification was successful
        const otpSuccess = "<?php echo $otp_success ? 'true' : 'false'; ?>";

        if (otpSuccess === 'true') {
            document.querySelector('.popup').classList.add('active');
            document.querySelector('.overlay').classList.add('active');
        }

        // Redirect to homepage
        function redirectHome() {
            window.location.href = 'login.php';
        }
    </script>
</body>

</html>