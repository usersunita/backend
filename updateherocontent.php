<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['title']) && isset($data['subtitle']) && isset($data['image_url'])) {
    $title = $conn->real_escape_string($data['title']);
    $subtitle = $conn->real_escape_string($data['subtitle']);
    $image_url = $conn->real_escape_string($data['image_url']);

    $sql = "UPDATE hero_content SET title='$title', subtitle='$subtitle', image_url='$image_url' WHERE id=1";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Content updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating content: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
}

$conn->close();
?>
