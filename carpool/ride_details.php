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

$ride_id = isset($_GET['ride_id']) ? $conn->real_escape_string($_GET['ride_id']) : 0;
$sql = "SELECT * FROM rides WHERE ride_id='$ride_id'";
$result = $conn->query($sql);

if ($result === FALSE) {
    die("Error executing query: " . $conn->error);
}

$ride = $result->fetch_assoc();
if (!$ride) {
    die("No ride found with ride_id $ride_id");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Details - Community Carpooling</title>
    <link rel="stylesheet" href="styles.css">
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
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5 animated">
        <h2>Ride Details</h2>
        <?php if ($ride): ?>
            <table class="table table-striped table-bordered">
                <tr><th><i class="fas fa-id-card"></i> Ride ID</th><td><?php echo htmlspecialchars($ride['ride_id']); ?></td></tr>
                <tr><th><i class="fas fa-map-marker-alt"></i> Origin</th><td><?php echo htmlspecialchars($ride['origin']); ?></td></tr>
                <tr><th><i class="fas fa-map-marker-alt"></i> Destination</th><td><?php echo htmlspecialchars($ride['destination']); ?></td></tr>
                <tr><th><i class="fas fa-calendar-alt"></i> Date</th><td><?php echo htmlspecialchars($ride['date']); ?></td></tr>
                <tr><th><i class="fas fa-clock"></i> Time</th><td><?php echo htmlspecialchars($ride['time']); ?></td></tr>
                <tr><th><i class="fas fa-users"></i> Available Seats</th><td><?php echo htmlspecialchars($ride['available_seats']); ?></td></tr>
            </table>
        <?php else: ?>
            <p>No ride found.</p>
        <?php endif; ?>

        <h3 class="my-4">Instructions</h3>
        <br>
        <p>1. Ensure you arrive at the pickup location 10 minutes before the scheduled time. ⏰</p>
        <p>2. Carry a valid ID for verification. 🆔</p>
        <p>3. Contact the passengers in case of any delays or changes. 📞</p>
<br>
        <div class="d-flex justify-content-between my-4">
            <p>Wanna go back?</p>
            <a href="dashboard.php" class="btn btn-custom btn-primary">Go to Dashboard <i class="fas fa-arrow-right"></i></a>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 fixed-bottom">
        <p>&copy; 2024 Community Carpooling | <a href="#" class="text-white">Privacy Policy</a></p>
    </footer>
</body>
</html>
