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
$sql = "SELECT * FROM upload";
$result = $conn->query($sql);

$guides = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $guides[] = $row;
    }
}

$conn->close();
echo json_encode($guides);
?>
