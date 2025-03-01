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

// Get booking_id from URL
$booking_id = isset($_GET['booking_id']) ? $conn->real_escape_string($_GET['booking_id']) : null;

if ($booking_id === null || $booking_id <= 0) {
    die("Invalid booking ID. Please provide a valid booking ID in the URL.");
}

// Prepare SQL statement to retrieve booking details
$sql = "SELECT bookings.booking_id, bookings.ride_id, bookings.user_id, bookings.seats_booked, bookings.booking_time, 
        rides.origin, rides.destination, rides.date, rides.time, rides.available_seats 
        FROM bookings 
        JOIN rides ON bookings.ride_id = rides.ride_id 
        WHERE bookings.booking_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();

$booking = $result->fetch_assoc();
if (!$booking) {
    die("No booking found with booking_id: $booking_id");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - Community Carpooling</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #e9ecef, #f8f9fa);
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        footer {
            background-color: #343a40;
        }
        .btn-custom {
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .animated {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top d-flex flex-row">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="https://uploads.mesym.com/wp-content/uploads/mesym/2014/09/tripda-icon-1.png" alt="Logo" width="50" height="50">
                    Community Carpooling
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ml-auto">
                        <a class="nav-link" href="index.html"><i class="fas fa-home"></i> Home</a>
                        <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        <a class="nav-link" href="book_ride.html"><i class="fas fa-ticket-alt"></i> Book a Ride</a>
                        <a class="nav-link" href="review.html"><i class="fas fa-star"></i> Leave a Review</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5 animated">
        <p>Hello, <span class="font-weight-bold"><?php echo htmlspecialchars($_SESSION['username']); ?>! 😊</span></p>
        <br>
        
        <h2>Booking Details</h2>
        <?php if ($booking): ?>
            <table class="table table-striped table-bordered">
                <tr><th><i class="fas fa-id-card"></i> Booking ID</th><td><?php echo htmlspecialchars($booking['booking_id']); ?></td></tr>
                <tr><th><i class="fas fa-bus"></i> Ride ID</th><td><?php echo htmlspecialchars($booking['ride_id']); ?></td></tr>
                <tr><th><i class="fas fa-user"></i> User ID</th><td><?php echo htmlspecialchars($booking['user_id']); ?></td></tr>
                <tr><th><i class="fas fa-users"></i> Seats Booked</th><td><?php echo htmlspecialchars($booking['seats_booked']); ?></td></tr>
                <tr><th><i class="fas fa-calendar-alt"></i> Booking Time</th><td><?php echo htmlspecialchars($booking['booking_time']); ?></td></tr>
                <tr><th><i class="fas fa-map-marker-alt"></i> Origin</th><td><?php echo htmlspecialchars($booking['origin']); ?></td></tr>
                <tr><th><i class="fas fa-map-marker-alt"></i> Destination</th><td><?php echo htmlspecialchars($booking['destination']); ?></td></tr>
                <tr><th><i class="fas fa-calendar-day"></i> Date</th><td><?php echo htmlspecialchars($booking['date']); ?></td></tr>
                <tr><th><i class="fas fa-clock"></i> Time</th><td><?php echo htmlspecialchars($booking['time']); ?></td></tr>
                <tr><th><i class="fas fa-signal"></i> Available Seats</th><td><?php echo htmlspecialchars($booking['available_seats']); ?></td></tr>
            </table>
        <?php else: ?>
            <p>No booking found.</p>
        <?php endif; ?>

        <h3 class="my-4">Instructions</h3>
        <p>1. Ensure you arrive at the pickup location 10 minutes before the scheduled time. ⏰</p>
        <p>2. Carry a valid ID for verification. 🆔</p>
        <p>3. Contact the driver in case of any delays or changes. 📞</p>

        <div class="d-flex justify-content-between my-4">
            <p>Wanna Go Back?</p>
            <a href="dashboard.php" class="btn btn-custom btn-primary">Go to Dashboard <i class="fas fa-arrow-right"></i></a>
            <br>    
            <p>Leave a Review</p>
            <a href="review.html" class="btn btn-custom btn-warning">Review here 🚀</a>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-4">
            <h3 class="mb-3">✨ Creative Minds of ✨</h3>
            <p class="mb-2"><i class="fas fa-user-graduate"></i> Mangireddygari Reshma: <span class="text-warning">22102A040916</span> 🎓</p>
            <p class="mb-2"><i class="fas fa-user-graduate"></i> Kuniti Prabhavati: <span class="text-warning">22102A040887</span> 🎓</p>
            <p class="mb-2"><i class="fas fa-user-graduate"></i> Majjiga Sai Kavya: <span class="text-warning">22102A040907</span> 🎓</p>
            <p class="mb-2"><i class="fas fa-user-graduate"></i> Kukkati Nikhitha: <span class="text-warning">22102A040884</span> 🎓</p>
            <p class="mb-2"><i class="fas fa-user-graduate"></i> Mallineni Nandini: <span class="text-warning">22102A040910</span> 🎓</p>
            <div class="mt-4">
                <a href="https://github.com" class="text-white  mr-3 ml-3" aria-label="GitHub"><i class="fab fa-github fa-2x"></i></a>
                <a href="https://linkedin.com" class="text-white  mr-3 ml-3" aria-label="LinkedIn"><i class="fab fa-linkedin fa-2x"></i></a>
                <a href="https://twitter.com" class="text-white mr-3 ml-3" aria-label="Twitter"><i class="fab fa-twitter fa-2x"></i></a>
            </div>
            <p class="mt-3 text-muted">Made with <i class="fas fa-heart text-danger animated heartBeat infinite"></i> by the Team</p>
        </footer>
</body>
</html>
