<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Community Carpooling</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <a class="nav-link" href="post_ride.html"><i class="fas fa-car"></i> Post a Ride</a>
                    <a class="nav-link" href="book_ride.html"><i class="fas fa-ticket-alt"></i> Book a Ride</a>
                </div>
              </div>
            </div>
        </nav>
    </header>

    <main class="container text-center my-5">
        <p>Hello, <span class="font-weight-bold"><?php echo htmlspecialchars($_SESSION['username']); ?>! 😊</span></p>
        <br><br>
        <h2>Welcome to Your Dashboard!</h2>
        <p>What would you like to do next?</p>

        <p>Have A Car?</p>
        <a href="post_ride.html" class="btn btn-primary btn-lg my-2"><i class="fas fa-car"></i> Post a Ride</a>
        <br><br>
        <p>Need A Car?</p>
        <a href="book_ride.html" class="btn btn-primary btn-lg my-2"><i class="fas fa-ticket-alt"></i> Book a Ride</a>
    </main>

    <footer class="bg-dark text-white text-center py-3 fixed-bottom">
        <p>&copy; 2024 Community Carpooling | <a href="#" class="text-white">Privacy Policy</a></p>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</body>
</html>
