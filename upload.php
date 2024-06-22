<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");

ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');

$servername = "localhost";
$username = "root";
$password = ""; 
$database = "project"; 
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $dailyRate = $conn->real_escape_string($_POST['dailyRate']);
    $languages = $conn->real_escape_string($_POST['languages']);
    $skills = $conn->real_escape_string($_POST['skills']);
    $area = $conn->real_escape_string($_POST['area']);

    $imagePath = '';
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $imagePath = $target_file;
        }
    }

    $sql = "SELECT * FROM upload WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $sql = "UPDATE upload SET name='$name', dailyRate='$dailyRate', languages='$languages', image_path='$imagePath', skills='$skills', area='$area' WHERE user_id='$user_id'";
    } else {
    
        $sql = "INSERT INTO upload (user_id, name, dailyRate, languages, image_path, skills, area)
                VALUES ('$user_id', '$name', '$dailyRate', '$languages', '$imagePath', '$skills', '$area')";
    }

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
