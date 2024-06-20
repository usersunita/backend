<?php
header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
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
    die("Connection failed: " . $conn->connect_error);
}

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if (!$userId) {
    echo json_encode(['error' => 'User is not logged in']);
    $conn->close();
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM booking WHERE id=$id AND client_id=$userId";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Booking with ID $id deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error deleting booking: " . $conn->error]);
    }
    $conn->close();
    exit();
}

if ($action === 'accept' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "UPDATE booking SET status='Accepted' WHERE id=$id AND client_id=$userId";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Booking with ID $id accepted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error accepting booking: " . $conn->error]);
    }
    $conn->close();
    exit();
}

$sql = "SELECT * FROM booking WHERE guide_id=$user_id";
$result = $conn->query($sql);

$booking = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $booking[] = $row;
    }
}

echo json_encode($booking);

$conn->close();
?>
