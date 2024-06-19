<?php
/* 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["formType"])) {
    $stmt = $conn->prepare(
        "INSERT INTO `register` (firstName, lastName, email, password, phonenumber, qualification, experience, photo, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if ($stmt) {
        $stmt->bind_param(
            "sssssssss",
            $firstName,
            $lastName,
            $email,
            $password,
            $phonenumber,
            $qualification,
            $experience,
            $photo_path,
            $role
        );

        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $phonenumber = $_POST["phonenumber"];
        $qualification = $_POST["formType"] === "Guide" ? $_POST["qualification"] : null;
        $experience = $_POST["formType"] === "Guide" ? $_POST["experience"] : null;

        // Handle photo upload
        $photo_path = null;
        if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
            $target_dir = "/uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = dirname(__FILE__) . $target_dir . basename($_FILES["photo"]["name"]);
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo_path = $target_file;
            }
        }

        $role = $_POST["formType"] === "Guide" ? "guide" : "client";

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => $_POST["formType"] . " data inserted properly",
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => $_POST["formType"] . " data not inserted: " . $stmt->error,
            ]);
        }
        $stmt->close();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to prepare statement: " . $conn->error,
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method or missing formType.",
    ]);
}

$conn->close();
?>
*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["formType"])) {
    $stmt = $conn->prepare(
        "INSERT INTO `register` (firstName, lastName, email, password, phonenumber, qualification, experience, photo, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    if ($stmt) {
        $stmt->bind_param(
            "sssssssss",
            $firstName,
            $lastName,
            $email,
            $hashedPassword,
            $phonenumber,
            $qualification,
            $experience,
            $photo_path,
            $role
        );

        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $phonenumber = $_POST["phonenumber"];
        $qualification = $_POST["formType"] === "Guide" ? $_POST["qualification"] : null;
        $experience = $_POST["formType"] === "Guide" ? $_POST["experience"] : null;

        // Handle photo upload
        $photo_path = null;
        if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo_path = $target_file;
            }
        }

        $role = $_POST["formType"] === "Guide" ? "guide" : "client";

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => $_POST["formType"] . " data inserted properly",
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => $_POST["formType"] . " data not inserted: " . $stmt->error,
            ]);
        }
        $stmt->close();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to prepare statement: " . $conn->error,
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method or missing formType.",
    ]);
}

$conn->close();
?>
