<?php
/*
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    
    if (isset($data->username) && isset($data->email) && isset($data->date) && isset($data->time) && isset($data->days) && isset($data->destination) && isset($data->person) && isset($data->type) && isset($data->message)) {
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO booking (username, email, date, time, days, destination, person, type, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisiss", $data->username, $data->email, $data->date, $data->time, $data->days, $data->destination, $data->person, $data->type, $data->message);
        if ($conn->query($sql) === TRUE) {
            echo "Form data saved successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>*/
/*
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Decode the JSON data from the request body
    $data = json_decode(file_get_contents("php://input"));

    // Check if all required fields are present
    $required_fields = ['to', 'from', 'date', 'time', 'days', 'destination', 'person', 'type', 'status', 'message'];
    $missing_fields = [];
    foreach ($required_fields as $field) {
        if (!isset($data->$field)) {
            $missing_fields[] = $field;
        }
    }

    // If any required field is missing, return an error
    if (!empty($missing_fields)) {
        $response = array(
            "error" => "Missing required fields",
            "missing_fields" => $missing_fields
        );
        echo json_encode($response);
        exit();
    }

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO booking (`to`, `from`, `date`, `time`, `days`, `destination`, `person`, `type`, `status`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssisisss", $data->to, $data->from, $data->date, $data->time, $data->days, $data->destination, $data->person, $data->type, $data->status, $data->message);

    // Execute the SQL statement
    if ($stmt->execute()) {
        $response = ["message" => "Form data saved successfully"];
        echo json_encode($response);
    } else {
        $response = ["error" => "Error saving form data: " . $stmt->error];
        echo json_encode($response);
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} 
?>*/

session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Decode the JSON data from the request body
    $data = json_decode(file_get_contents("php://input"));

    // Check if all required fields are present
    $required_fields = ['client_id', 'guide_id', 'date', 'time', 'days', 'destination', 'person', 'type', 'status', 'message'];
    $missing_fields = [];
    foreach ($required_fields as $field) {
        if (!isset($data->$field)) {
            $missing_fields[] = $field;
        }
    }

    // If any required field is missing, return an error
    if (!empty($missing_fields)) {
        $response = array(
            "error" => "Missing required fields",
            "missing_fields" => $missing_fields
        );
        echo json_encode($response);
        exit();
    }

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
        exit();
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO booking (`client_id`, `guide_id`, `date`, `time`, `days`, `destination`, `person`, `type`, `status`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(["error" => "Error preparing statement: " . $conn->error]);
        $conn->close();
        exit();
    }

    $stmt->bind_param("iissisisss", $data->client_id, $data->guide_id, $data->date, $data->time, $data->days, $data->destination, $data->person, $data->type, $data->status, $data->message);

    // Execute the SQL statement
    if ($stmt->execute()) {
        $response = ["message" => "Form data saved successfully"];
        echo json_encode($response);
    } else {
        $response = ["error" => "Error saving form data: " . $stmt->error];
        echo json_encode($response);
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["error" => "Invalid request method"]);
}
?>
