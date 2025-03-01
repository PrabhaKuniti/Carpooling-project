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
    $ride_id = $conn->real_escape_string($_POST['ride_id']);
    $rating = $conn->real_escape_string($_POST['rating']);
    $review = $conn->real_escape_string($_POST['review']);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    // Check if the user_id exists in the users table
    $user_check_query = "SELECT * FROM users WHERE user_id='$user_id'";
    $user_result = $conn->query($user_check_query);

    if ($user_result->num_rows > 0) {
        // Insert review if user exists
        $sql = "INSERT INTO reviews (ride_id, user_id, rating, review) VALUES ('$ride_id', '$user_id', '$rating', '$review')";
        if ($conn->query($sql) === TRUE) {
            header("Location: review_details.php?review_id=" . $conn->insert_id);
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: User does not exist.";
    }
}

$conn->close();
?>
