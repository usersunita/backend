<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["formType"])) {

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($_POST["formType"] === "Guide" || $_POST["formType"] === "Client") {
        $stmt = $conn->prepare(
            "INSERT INTO `register` (firstName, lastName, email, password, phonenumber, qualification, experience, photo, role, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if ($stmt) {
            $stmt->bind_param(
                "sssssssssi",
                $firstName,
                $lastName,
                $email,
                $password,
                $phonenumber,
                $qualification,
                $experience,
                $photo_path,
                $role,
                $user_id
            );

            $firstName = $_POST["firstName"];
            $lastName = $_POST["lastName"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $phonenumber = $_POST["phonenumber"];
            $qualification =
                $_POST["formType"] === "Guide" ? $_POST["qualification"] : null;
            $experience =
                $_POST["formType"] === "Guide" ? $_POST["experience"] : null;

            // Handle photo upload
            $photo_path = null;
            if (
                isset($_FILES["photo"]) &&
                $_FILES["photo"]["error"] === UPLOAD_ERR_OK
            ) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                if (
                    move_uploaded_file(
                        $_FILES["photo"]["tmp_name"],
                        $target_file
                    )
                ) {
                    $photo_path = $target_file;
                }
            }
            $role = $_POST["formType"] === "Guide" ? "guide" : "client";

            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

            if ($stmt->execute()) {
                echo json_encode([
                    "success" => true,
                    "message" => $_POST["formType"] . " data inserted properly",
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" =>
                        $_POST["formType"] .
                        " data not inserted: " .
                        $stmt->error,
                ]);
            }
            $stmt->close();
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to prepare statement",
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Invalid formType.",
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
