 <?php
// session_start();

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
//     $data = json_decode(file_get_contents("php://input"), true);

//     $servername = "localhost";
//     $username = "root";
//     $password = "";
//     $dbname = "project";

//     $conn = new mysqli($servername, $username, $password, $dbname);
//     if ($conn->connect_error) {
//         echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
//         exit();
//     }

//     // Prepare the SQL statement
//     $stmt = $conn->prepare("INSERT INTO booking (`client_id`, `guide_id`, `date`, `time`, `days`, `destination`, `person`, `type`, `status`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
//     if ($stmt === false) {
//         echo json_encode(["error" => "Error preparing statement: " . $conn->error]);
//         $conn->close();
//         exit();
//     }

//     $guide_id = intval($data['guide_id']);
//     $client_id = intval($data['client_id']);
//     $days = intval($data['days']);
//     $person = intval($data['person']);
//     $date=$data['date'];
//     $time=$data['time'];
//     $destination=$data['destination'];
//     $type=$data['type'];
//     $status=$data['status'];
//     $message=$data['message'];

//     $stmt->bind_param("iissisisss", $client_id, $guide_id, $date, $time, $days, $destination, $person, $type, $status, $message);

//     // Execute the SQL statement
//     if ($stmt->execute()) {
//         $response = ["message" => "Form data saved successfully"];
//         echo json_encode($response);
//     } else {
//         $response = ["error" => "Error saving form data: " . $stmt->error];
//         echo json_encode($response);
//     }

//     // Close the statement and the database connection
//     $stmt->close();
//     $conn->close();
// } else {
//     echo json_encode(["error" => "Invalid request method"]);
// }

session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $data = json_decode(file_get_contents("php://input"), true);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
        exit();
    }

    
    $date = $data['date'];
    $inputDate = DateTime::createFromFormat('Y-m-d', $date);
    if (!$inputDate) {
        echo json_encode(["error" => "Invalid date format"]);
        $conn->close();
        exit();
    }

    $today = new DateTime();
    $futureDate = (clone $today)->add(new DateInterval('P5M'));

    if ($inputDate < $today || $inputDate > $futureDate) {
        echo json_encode(["error" => "Date must be between today and 5 months from today"]);
        $conn->close();
        exit();
    }
    $stmt = $conn->prepare("INSERT INTO booking (`client_id`, `guide_id`, `date`, `time`, `days`, `destination`, `person`, `type`, `status`, `message`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(["error" => "Error preparing statement: " . $conn->error]);
        $conn->close();
        exit();
    }

    $guide_id = intval($data['guide_id']);
    $client_id = intval($data['client_id']);
    $days = intval($data['days']);
    $person = intval($data['person']);
    $time = $data['time'];
    $destination = $data['destination'];
    $type = $data['type'];
    $status = $data['status'];
    $message = $data['message'];

    $stmt->bind_param("iissisisss", $client_id, $guide_id, $date, $time, $days, $destination, $person, $type, $status, $message);

    if ($stmt->execute()) {
        $response = ["message" => "Form data saved successfully"];
        echo json_encode($response);
    } else {
        $response = ["error" => "Error saving form data: " . $stmt->error];
        echo json_encode($response);
    }
    $stmt->close();
    $conn->close();
} 
?>
