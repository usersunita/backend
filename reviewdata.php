<?php
header("Access-Control-Allow-Origin: http://localhost:3000"); // Update to match your frontend's origin
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Check if guide_id is set in session
if (!isset($_SESSION['guide_id'])) {
    echo json_encode(['error' => 'User is not logged in']);
    $conn->close();
    exit();
}

$user_id = intval($_SESSION['guide_id']); // Ensure it's an integer for security

$sql = "SELECT r.*
        FROM review r
        JOIN upload u ON r.guide_id = u.id
        WHERE u.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

echo json_encode($reviews);

$conn->close();
?>
