<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlUsers = "SELECT * FROM register";
$resultUsers = $conn->query($sqlUsers);

$users = [];
if ($resultUsers->num_rows > 0) {
    while ($row = $resultUsers->fetch_assoc()) {
        $users[] = $row;
    }
}
echo json_encode($users);
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sqlDelete = "DELETE FROM register WHERE id=$id";
    if ($conn->query($sqlDelete) === TRUE) {
        echo json_encode(["success" => true, "message" => "Booking with ID $id deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error deleting booking: " . $conn->error]);
    }
}
$conn->close();
?>

