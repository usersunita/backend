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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $conn->real_escape_string($_POST['name']);
    $dailyRate = $conn->real_escape_string($_POST['dailyRate']);
    $languages = $conn->real_escape_string($_POST['languages']);
    $skills = $conn->real_escape_string($_POST['skills']);

    // $image = $_FILES['image'];
    // $imagePath = '';
    // if ($image['error'] == UPLOAD_ERR_OK) {
    //     $imagePath = 'uploads/' . basename($image['name']);
    //     move_uploaded_file($image['tmp_name'], $imagePath);
    // }
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $target_dir = "/uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = dirname(__FILE__) . $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $imagePath = $target_file;
        }
    }

    $sql = "INSERT INTO upload (name, dailyRate, languages, image_path, skills)
            VALUES ('$name', '$dailyRate', '$languages','$imagePath', '$skills' )";

    if ($conn->query($sql) === TRUE) {
        $response = array('success' => true, 'message' => 'Record updated successfully');
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'error' => 'Error: ' . $sql . "<br>" . $conn->error);
        echo json_encode($response);
    }
}

$conn->close();
?>
