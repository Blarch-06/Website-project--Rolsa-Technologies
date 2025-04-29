<!-- filepath: c:\xampp\htdocs\Task2Main_1394484_Blackmore_A\php\booking_success.php -->
<?php
session_start();
if (!isset($_SESSION['success'])) {
    header("Location: booking.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FAF0E6; /* Linen background */
            color: #343a40; /* Dark text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .navbar {
            background-color: #2f4f4f; /* Dark green navbar */
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .navbar-brand {
            font-family: 'Lora', serif;
            font-weight: bold;
            font-size: 1.8rem;
            color: #fff;
        }

        .navbar-nav .nav-link {
            color: #fff;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: #63c89a; /* Green hover effect */
        }

        .success-container {
            background-color: #63c89a; /* Green background */
            color: #fff; /* White text */
            padding: 40px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .success-container h1 {
            font-family: 'Lora', serif;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .success-container p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn-primary {
            font-family: 'Poppins', sans-serif;
            background-color: #2f4f4f; /* Dark green button */
            color: #fff; /* White text */
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #52b885; /* Slightly lighter green on hover */
            color: #fff; /* Ensure text stays white */
        }
    </style>
</head>
<body>
    <!-- Success Message -->
    <div class="success-container">
        <h1>Booking Successful!</h1>
        <p>Your booking has been successfully created!</p>
        <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
    </div>
</body>
</html>

<?php unset($_SESSION['success']); ?>