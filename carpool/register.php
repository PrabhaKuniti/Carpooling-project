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
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        $user_id = $conn->insert_id; // Get the newly created user_id
        $_SESSION['user_id'] = $user_id; // Set the user_id in the session
        header('Location: dashboard.php'); // Redirect to the dashboard after successful registration
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
        header('Location: register.html');
        exit();
    }

    $conn->close();
}
?>
