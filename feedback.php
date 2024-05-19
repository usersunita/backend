<?php
/*
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$postData = file_get_contents("php://input");
$data = json_decode($postData, true);

$rating = $data['rating'];
$feedback = $data['feedback'];

$stmt = $conn->prepare("INSERT INTO feedback (rating, feedback) VALUES (?, ?)");
$stmt->bind_param("is", $rating, $feedback);

if ($stmt->execute()) {
    echo json_encode(["message" => "Feedback submitted successfully"]);
} else {
    echo json_encode(["message" => "Error submitting feedback"]);
}
$stmt->close();
$conn->close();
?>*/

session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Connection failed: " . $conn->connect_error
    ]));
}

// Get the posted data
$postData = file_get_contents("php://input");
$data = json_decode($postData, true);

// Check if all required data is set
if (isset($data['rating']) && isset($data['feedback']) && isset($data['guide_id']) && isset($_SESSION['user_id'])) {
    $rating = $data['rating'];
    $feedback = $data['feedback'];
    $guide_id = $data['guide_id'];
    $user_id = $_SESSION['user_id'];

    // Prepare and execute the insert statement
    $stmt = $conn->prepare("INSERT INTO review ( rating, feedback,user_id, guide_id ) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $rating, $feedback,$user_id, $guide_id );

    if ($stmt->execute()) {
        echo json_encode(["message" => "Feedback submitted successfully"]);
    } else {
        echo json_encode(["message" => "Error submitting feedback"]);
    }
    $stmt->close();
} else {
    echo json_encode(["message" => "Invalid input or session not set"]);
}

$conn->close();
?>
