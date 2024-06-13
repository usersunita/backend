<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  $title = $data['title'];
  $description = $data['description'];
  $image = $data['image'];

  $sql = "INSERT INTO trip (title, description, image) VALUES ('$title', '$description', '$image')";

  if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "New record created successfully"]);
  } else {
    echo json_encode(["message" => "Error: " . $sql . "<br>" . $conn->error]);
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $sql = "SELECT * FROM trip";
  $result = $conn->query($sql);

  $trip = [];

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $trips[] = $row;
    }
  }

  echo json_encode($trip);
}

$conn->close();
?>
