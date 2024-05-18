<?php
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
?>
