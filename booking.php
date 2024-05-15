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

// Handle delete request
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM booking WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Booking with ID $id deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error deleting booking: " . $conn->error]);
    }
    exit; 
}

// Handle accept request
if (isset($_GET['action']) && $_GET['action'] === 'accept' && isset($_GET['id'])) {
    $id = $_GET['id'];
    // Update the status of the booking to "Accepted" in the database
    $sql = "UPDATE booking SET status='Accepted' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Booking with ID $id accepted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error accepting booking: " . $conn->error]);
    }
    exit;
}

// Fetch bookings
$sql = "SELECT * FROM booking";
$result = $conn->query($sql);

$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

echo json_encode($bookings);

$conn->close();
?>
