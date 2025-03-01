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

$review_id = isset($_GET['review_id']) ? $conn->real_escape_string($_GET['review_id']) : 0;
$sql = "SELECT reviews.review_id, reviews.ride_id, reviews.user_id, reviews.rating, reviews.review, reviews.review_time, rides.origin, rides.destination, rides.date, rides.time FROM reviews JOIN rides ON reviews.ride_id = rides.ride_id WHERE reviews.review_id='$review_id'";
$result = $conn->query($sql);

if ($result === FALSE) {
    die("Error executing query: " . $conn->error);
}

$review = $result->fetch_assoc();
if (!$review) {
    die("No review found with review_id $review_id");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Details - Community Carpooling</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
        }
        .review-table th {
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
        .rating {
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
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
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5 animated">
        <p>Hello, <span class="font-weight-bold"><?php echo htmlspecialchars($_SESSION['username']); ?>! 😊</span></p>
        <h2>Review Details</h2>
        <?php if ($review): ?>
            <table class="table table-striped table-bordered review-table">
                <tr><th><i class="fas fa-comment-dots"></i> Review ID</th><td><?php echo htmlspecialchars($review['review_id']); ?></td></tr>
                <tr><th><i class="fas fa-car"></i> Ride ID</th><td><?php echo htmlspecialchars($review['ride_id']); ?></td></tr>
                <tr><th><i class="fas fa-user"></i> User ID</th><td><?php echo htmlspecialchars($review['user_id']); ?></td></tr>
                <tr><th><i class="fas fa-star"></i> Rating</th><td class="rating"><?php echo str_repeat('⭐', htmlspecialchars($review['rating'])); ?></td></tr>
                <tr><th><i class="fas fa-pencil-alt"></i> Review</th><td><?php echo htmlspecialchars($review['review']); ?></td></tr>
                <tr><th><i class="fas fa-clock"></i> Review Time</th><td><?php echo htmlspecialchars($review['review_time']); ?></td></tr>
                <tr><th><i class="fas fa-map-marker-alt"></i> Origin</th><td><?php echo htmlspecialchars($review['origin']); ?></td></tr>
                <tr><th><i class="fas fa-map-marker-alt"></i> Destination</th><td><?php echo htmlspecialchars($review['destination']); ?></td></tr>
                <tr><th><i class="fas fa-calendar-alt"></i> Date</th><td><?php echo htmlspecialchars($review['date']); ?></td></tr>
                <tr><th><i class="fas fa-clock"></i> Time</th><td><?php echo htmlspecialchars($review['time']); ?></td></tr>
            </table>
        <?php else: ?>
            <p>No review found.</p>
        <?php endif; ?>

        <h3 class="my-4">Instructions</h3>
        <p>1. Share your experience to help others. 📝</p>
        <p>2. Respect community guidelines while writing reviews. 📜</p>
            <br> <br>
        <div class="d-flex justify-content-between my-4">
            <p>Wanna Go Back?</p>
            <a href="dashboard.php" class="btn btn-custom btn-primary">Go to Dashboard <i class="fas fa-arrow-right"></i></a>
            <br>
            <p>WannaBook Another Ride?</p>
            <a href="book_ride.html" class="btn btn-custom btn-warning">Book Another Ride <i class="fas fa-car-side"></i></a>
        </div>
    </main>

    <footer class="text-white text-center py-3 fixed-bottom">
        <p>&copy; 2024 Community Carpooling | <a href="#" class="text-white">Privacy Policy</a></p>
    </footer>
</body>
</html>

