<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpooling";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    echo json_encode(["error" => "Database connection failed."]);
    exit();
}

$pickup_location = isset($_GET['pickup_location']) ? $conn->real_escape_string($_GET['pickup_location']) : '';
$ride_date = isset($_GET['ride_date']) ? $conn->real_escape_string($_GET['ride_date']) : '';

// Add debugging statements
error_log("Fetching rides for location: $pickup_location, date: $ride_date");

if (empty($pickup_location) || empty($ride_date)) {
    echo json_encode(["error" => "Pickup location and ride date are required."]);
    exit();
}

// Fetch available rides based on location and date
$sql = "SELECT ride_id, origin, destination, time, available_seats 
        FROM rides 
        WHERE origin='$pickup_location' AND date='$ride_date' AND available_seats > 0";
$result = $conn->query($sql);

if (!$result) {
    error_log("SQL error: " . $conn->error);
    echo json_encode(["error" => "Database query failed."]);
    exit();
}

$rides = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $rides[] = $row;
    }
} else {
    error_log("No rides found for location: $pickup_location, date: $ride_date");
    echo json_encode(["error" => "No rides found for the given criteria."]);
    exit();
}

echo json_encode($rides);

$conn->close();
?>
