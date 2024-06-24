
<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
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

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : '';

if (!$user_id) {
    echo json_encode(['error' => 'User is not logged in']);
    $conn->close();
    exit();
}

$sql = "SELECT b.* FROM booking b JOIN register r ON b.client_id = r.id WHERE r.id = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$booking = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $booking[] = $row;
    }
}

echo json_encode($booking);

$conn->close();
?>
