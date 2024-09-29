<?php
include 'authentication/config.php';
include 'authentication/session.php';

$user_id = $_SESSION['user_id'];
$selected_level = isset($_POST['level']) ? $_POST['level'] : 'all';
$games_count = isset($_POST['games_count']) ? (int)$_POST['games_count'] : 10;
$query = "SELECT level, time_taken, created_at FROM user_scores WHERE user_id = ?";
if ($selected_level !== 'all') {
    $query .= " AND level = ?";
}
$query .= " ORDER BY created_at DESC LIMIT ?"; // Limit results based on selection
$stmt = $conn->prepare($query);
if ($selected_level !== 'all') {
    $stmt->bind_param("isi", $user_id, $selected_level, $games_count);
} else {
    $stmt->bind_param("ii", $user_id, $games_count);
}
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Mazelogo.png" type="image/png">
<link rel="shortcut icon" href="Mazelogo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>View History</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        aside {
            width: 240px;
            background-color: #111725;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: start;
            height: 100vh;
            position: fixed;
        }

        .main-content {
            padding: 20px;
            background-color: #fff;
            margin-left: 240px;
            width: 100%;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #333;
        }

        hr {
            border: none;
            height: 2px;
            background-color: #333;
            margin-bottom: 20px;
        }

        table {
            margin-left: 24px;
            padding: 24px;
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #111725;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        select {
            margin-bottom: 20px;
            padding: 10px;
            font-size: 16px;
        }

        .level-select {
            border-radius: 8px;
            margin-left: 12px;
        }

        .level-select option {
            background-color: #111725;
            color: white;
            border-radius: 4px;
        }

        label {
            margin-left: 12px;
        }
        header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 2px solid #ddd;
    color: black;
    padding: 24px;

}

header h1 {
    font-size: 32px;
}

.user-profile {
    position: relative; /* This allows the popup to be positioned relative to the user profile icon */
    display: inline-block;
}

#user-icon {
    cursor: pointer;
    transition: color 0.3s ease;
}

#user-icon:hover {
    color: #555; /* Change to any color you prefer on hover */
}

.popup-menu {
    display: none; /* Hidden by default */
    position: absolute;
    top: 40px; /* Adjust this to control the position of the popup */
    right: 0;
    background-color: #111725;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    z-index: 1000; /* Ensure the popup appears above other elements */
    padding: 10px;
    width: 180px;
}

.popup-menu ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.popup-menu ul li {
    padding: 10px 0;
    text-align: left;
}

.popup-menu ul li a {
    text-decoration: none;
    font-weight: bold;
    color: #EEEEF0;
}

.popup-menu ul li a:hover {
    color: #93B4FF;
}
    </style>
</head>

<body>
    <div class="container">
        <aside>
            <?php include 'sidebar.php'; ?>
        </aside>
        <div class="main-content">
        <header>
                <!-- This is the icon that toggles the sidebar -->
                <i class="fa fa-bars fa-2xl" id="toggle-sidebar"></i>

                <h1>History</h1>
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
            </header><br>
            <form method="POST">
                <label for="level-select">Filter by Level:</label>
                <select class="level-select" id="level-select" name="level" onchange="this.form.submit()">
                    <option value="all" <?php echo $selected_level === 'all' ? 'selected' : ''; ?>>All</option>
                    <option value="veryeasy" <?php echo $selected_level === 'veryeasy' ? 'selected' : ''; ?>>Very Easy</option>
                    <option value="easy" <?php echo $selected_level === 'easy' ? 'selected' : ''; ?>>Easy</option>
                    <option value="medium" <?php echo $selected_level === 'medium' ? 'selected' : ''; ?>>Medium</option>
                    <option value="hard" <?php echo $selected_level === 'hard' ? 'selected' : ''; ?>>Hard</option>
                    <option value="extreme" <?php echo $selected_level === 'extreme' ? 'selected' : ''; ?>>Extreme</option>
                </select>

                <label for="games-count">Games per page:</label>
                <select class="level-select" id="games-count" name="games_count" onchange="this.form.submit()">
                    <option value="10" <?php echo (isset($_POST['games_count']) && $_POST['games_count'] == 10) ? 'selected' : ''; ?>>10</option>
                    <option value="20" <?php echo (isset($_POST['games_count']) && $_POST['games_count'] == 20) ? 'selected' : ''; ?>>20</option>
                    <option value="40" <?php echo (isset($_POST['games_count']) && $_POST['games_count'] == 40) ? 'selected' : ''; ?>>40</option>
                </select>
            </form>


            <table>
                <thead>
                    <tr>
                        <th>Level</th>
                        <th>Time Taken</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['level']); ?></td>
                                <td><?php echo htmlspecialchars($row['time_taken']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No game history available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

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


</script>

</html>

<?php
$stmt->close();
$conn->close();
?>