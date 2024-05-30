<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// SQL query to fetch data from the review table
$sql = "SELECT * FROM review ORDER BY id";

// Execute query
$result = $conn->query($sql);

// Initialize an array to store the results
$inquiries = [];

if ($result->num_rows > 0) {
    // Fetch data and store in the array
    while ($row = $result->fetch_assoc()) {
        $inquiries[] = $row;
    }
    // Encode the array to JSON and output it
    echo json_encode($inquiries);
} else {
    // If no data found, output an empty array
    echo json_encode($inquiries);
}

// Close the database connection
$conn->close();
?>
