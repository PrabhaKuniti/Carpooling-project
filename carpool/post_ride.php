<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carpooling";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origin = $conn->real_escape_string($_POST['origin']);
    $destination = $conn->real_escape_string($_POST['destination']);
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);
    $seats = intval($_POST['seats']);

    $sql = "INSERT INTO rides (origin, destination, date, time, available_seats) VALUES ('$origin', '$destination', '$date', '$time', '$seats')";
    if ($conn->query($sql) === TRUE) {
        // Redirect to ride details page
        $ride_id = $conn->insert_id;
        header("Location: ride_details.php?ride_id=" . $ride_id);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

