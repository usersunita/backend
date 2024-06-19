<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = ""; 
$database = "project"; 
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $user_id = $conn->real_escape_string($_GET['user_id']);
    
    $sql = "SELECT name, dailyRate, languages, image_path, skills, area FROM upload WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $response = array('success' => true, 'name' => $data['name'], 'dailyRate' => $data['dailyRate'], 'languages' => $data['languages'], 'image_path' => $data['image_path'], 'skills' => $data['skills'], 'area' => $data['area']);
    } else {
        $response = array('success' => false, 'error' => 'No data found');
    }
    
    echo json_encode($response);
} else {
    $response = array('success' => false, 'error' => 'Invalid request method or missing user_id');
    echo json_encode($response);
}

$conn->close();
?>
