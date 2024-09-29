<?php
// Include database connection
include 'authentication/config.php';
include 'authentication/session.php';

session_start();

// Retrieve user ID from the session
$user_id = $_SESSION['user_id'];

$data = json_decode(file_get_contents('php://input'), true);

if (isset($user_id, $data['level'], $data['time_taken'])) {
    $level = $data['level'];
    $time_taken = $data['time_taken'];
    $created_at = $data['created_at'];

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO user_scores (user_id, level, time_taken, created_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $level, $time_taken, $created_at);

    if ($stmt->execute()) {
        // Send a success response
        echo json_encode(['success' => true]);
    } else {
        // Send an error response
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
}

$conn->close();
?>
