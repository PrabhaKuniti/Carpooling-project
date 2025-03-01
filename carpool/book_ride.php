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
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $seats_to_book = intval($_POST['seats_to_book']);

    // Check if the user_id exists in the users table
    $user_check_query = "SELECT * FROM users WHERE user_id='$user_id'";
    $user_result = $conn->query($user_check_query);

    if ($user_result->num_rows > 0) {
        // Check available seats
        $seat_check_query = "SELECT available_seats FROM rides WHERE ride_id='$ride_id'";
        $seat_result = $conn->query($seat_check_query);
        $ride = $seat_result->fetch_assoc();

        if ($ride && $ride['available_seats'] >= $seats_to_book) {
            // Insert booking if seats are available
            $sql = "INSERT INTO bookings (ride_id, user_id, seats_booked) VALUES ('$ride_id', '$user_id', '$seats_to_book')";
            if ($conn->query($sql) === TRUE) {
                // Capture the booking ID correctly
                $booking_id = $conn->insert_id;
                error_log("Captured Booking ID: " . $booking_id); // Log captured booking ID

                // Ensure the booking_id is valid before redirecting
                if ($booking_id > 0) {
                    // Update available seats
                    $new_seat_count = $ride['available_seats'] - $seats_to_book;
                    $update_seats_query = "UPDATE rides SET available_seats='$new_seat_count' WHERE ride_id='$ride_id'";
                    if ($conn->query($update_seats_query) === TRUE) {
                        // Redirect to booking details page with the captured ID
                        header("Location: booking_details.php?booking_id=" . $booking_id);
                        exit();
                    } else {
                        error_log("SQL Error (update): " . $update_seats_query . " - " . $conn->error);
                        echo "Error: " . $update_seats_query . "<br>" . $conn->error;
                    }
                } else {
                    error_log("Error: Invalid booking ID captured.");
                    echo "Error: Invalid booking ID captured.";
                }
            } else {
                error_log("SQL Error (insert): " . $sql . " - " . $conn->error);
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            error_log("Error: Not enough seats available.");
            echo "Error: Not enough seats available.";
        }
    } else {
        error_log("Error: User does not exist.");
        echo "Error: User does not exist.";
    }
}

$conn->close();
?>
