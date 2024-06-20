<?php
/*
session_start();
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Connection failed: " . $conn->connect_error
    ]));
}

$postData = file_get_contents("php://input");
$data = json_decode($postData, true);

if (isset($data['email']) && isset($data['password'])) {
    $email = $data['email'];
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT id, role, password FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $role, $hashedPassword);
    
    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        echo json_encode(["message" => "Login successful", "role" => $role, "user_id" => $user_id]);
    } else {
        echo json_encode(["message" => "Invalid credentials"]);
    }
    $stmt->close();
} else {
    echo json_encode(["message" => "Email and password required"]);
}

$conn->close();
?>
*/
/*
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Connection failed: " . $conn->connect_error
    ]));
}

$postData = file_get_contents("php://input");
$data = json_decode($postData, true);

if (isset($data['email']) && isset($data['password'])) {
    $email = $data['email'];
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT id, role FROM  register WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->bind_result($user_id, $role);
    if ($stmt->fetch()) {
        echo json_encode(["message" => "Login successful", "role" => $role, "user_id" => $user_id   ]);
    } else {
        echo json_encode(["message" => "Invalid credentials"]);
    }
    $stmt->close();
} else {
    echo json_encode(["message" => "Email and password required"]);
}

$conn->close();
?>
*/

session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Connection failed: " . $conn->connect_error
    ]));
}

$postData = file_get_contents("php://input");
$data = json_decode($postData, true);

if (isset($data['email']) && isset($data['password'])) {
    $email = $data['email'];
    $password = $data['password'];

    $stmt = $conn->prepare("SELECT id, role FROM register WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $stmt->bind_result($user_id, $role);
    if ($stmt->fetch()) { 
        $_SESSION['guide_id'] = $user_id;  // Store guide_id in session
        echo json_encode(["message" => "Login successful", "role" => $role, "user_id" => $user_id]);
    } else {
        echo json_encode(["message" => "Invalid credentials"]);
    }
    $stmt->close();
} else {
    echo json_encode(["message" => "Email and password required"]);
}

$conn->close();
?>
