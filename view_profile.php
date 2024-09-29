<?php
include 'authentication/config.php';
include 'authentication/session.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email FROM maze_user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();

$username_exists = false; // Flag to track if username exists

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username'])) {
        $new_username = $_POST['username'];

        // Check if username already exists
        $check_sql = "SELECT username FROM maze_user WHERE username = ? AND user_id != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $new_username, $user_id);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            // Username already exists
            $username_exists = true;
        } else {
            // Proceed with updating username if it doesn't exist
            $update_sql = "UPDATE maze_user SET username = ? WHERE user_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $new_username, $user_id);
            $update_stmt->execute();
            $update_stmt->close();
            $name = $new_username; // Update the name displayed without needing to reload
        }
        $check_stmt->close();
    } elseif (isset($_POST['new_password'])) {
        // Updating password
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $update_sql = "UPDATE maze_user SET password = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $new_password, $user_id);
        $update_stmt->execute();
        $update_stmt->close();
    } elseif (isset($_POST['delete_user']) && $_POST['delete_user'] == "true") {
        // Delete the user from the database
        $delete_sql = "DELETE FROM maze_user WHERE user_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $user_id);
        $delete_stmt->execute();
        $delete_stmt->close();

        session_destroy();
        header('Location: Authentication/login.php');
        exit();
    }
}
$conn->close();
?>
<?php if ($username_exists): ?>
    <script>
        alert("Username already exists. Please choose a different username.");
    </script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="css/user_profile.css">
    <link rel="icon" href="Mazelogo.png" type="image/png">
<link rel="shortcut icon" href="Mazelogo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <aside>
            <?php include 'sidebar.php'; ?>
        </aside>
        <div class="main-content">
            <header>
                <i class="fa fa-bars fa-2xl " id="toggle-sidebar"></i>
                <h1>View Profile</h1>
                <div class="user-profile">
                    <i class="fa-regular fa-circle-user fa-2xl" id="user-icon"></i>

                    <div class="popup-menu" id="popup-menu">
                        <ul>
                            <li><a href="view_profile.php"><i class="fa fa-user"></i>
                                    View Profile</a></li>
                            <li><a href="view_profile.php"><i class="fa fa-key"></i>
                                    Change Password</a></li>
                            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i><span> Logout</span></a></li>
                        </ul>
                    </div>
                </div>
            </header>

            <div class="user_details">
                <div class="card">
                    <form method="post">
                        <label for="username" class="form-label">User Name:</label><br>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($name); ?>">

                        <button type="submit" class="update">Update Username</button><br>

                        <label for="email">Email:</label><br>
                        <input type="text" id="email" value="<?php echo htmlspecialchars($email); ?>" readonly class="inactive-input"><br>

                        <label for="new_password" class="form-label">New Password:</label>
                        <input type="password" id="new_password" name="new_password">
                        <button type="submit" class="update">Change Password</button>

                        <!-- Hidden input for account deletion confirmation -->
                        <input type="hidden" name="delete_user" id="delete_user" value="">

                        <button type="button" class="delete">Delete Account</button>
                    </form>


                </div>
            </div>

        </div>
    </div>


    <!-- Custom Popup for Delete Confirmation -->
    <div id="deletePopup" class="popup">
        <div class="popup-content">
            <h2>Confirm Account Deletion</h2>
            <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            <div class="popup-buttons">
                <button id="confirmDelete" class="confirm-btn">Yes, Delete</button>
                <button id="cancelDelete" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

</body>
<script>
    const userIcon = document.getElementById('user-icon');
    const popupMenu = document.getElementById('popup-menu');

    if (userIcon && popupMenu) {
        // Toggle popup visibility when user icon is clicked
        userIcon.addEventListener('click', function() {
            popupMenu.style.display = (popupMenu.style.display === 'block') ? 'none' : 'block';
        });

        // Close the popup if clicking outside of it
        document.addEventListener('click', function(event) {
            if (!userIcon.contains(event.target) && !popupMenu.contains(event.target)) {
                popupMenu.style.display = 'none';
            }
        });
    }

     // Show the delete confirmation popup
     document.querySelector('.delete').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the form from submitting immediately
        document.getElementById('deletePopup').style.display = 'flex'; // Show the popup
    });

    // Handle Confirm Delete button click
    document.getElementById('confirmDelete').addEventListener('click', function() {
        // Redirect to delete_user.php page
        window.location.href = 'delete_user.php';
    });

    // Handle Cancel button click
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deletePopup').style.display = 'none'; // Hide the popup
    });

    // Optional: Close the popup if the user clicks outside the popup content
    window.onclick = function(event) {
        var popup = document.getElementById('deletePopup');
        if (event.target == popup) {
            popup.style.display = 'none';
        }
    }
</script>




</html>