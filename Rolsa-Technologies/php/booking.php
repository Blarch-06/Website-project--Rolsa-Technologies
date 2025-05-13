<?php
session_start();
require 'db.php'; // Include database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

// Navigation Bar
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow mb-3">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Rolsa Technologies</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="../index.html">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="../reduction-info.html">Info</a></li>
        <li class="nav-item"><a class="nav-link" href="../booking.html">Booking</a></li>
        <li class="nav-item"><a class="nav-link" href="../market.html">Market</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="../login.html">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $type = $_POST['type'] ?? null;
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $address_line1 = trim($_POST['address_line1'] ?? '');
    $address_line2 = trim($_POST['address_line2'] ?? ''); // Optional field
    $date = $_POST['date'] ?? null;

    // Validate input
    if (!$type || !$first_name || !$last_name || !$address_line1 || !$date) {
        $error_message = urlencode("All required fields must be filled.");
        header("Location: ../booking.html?error=$error_message");
        exit;
    }

    // Insert booking into the database
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, type, first_name, last_name, address_line1, address_line2, date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        $error_message = urlencode("Database error: " . $conn->error);
        header("Location: ../booking.html?error=$error_message");
        exit;
    }

    $stmt->bind_param("issssss", $_SESSION['user_id'], $type, $first_name, $last_name, $address_line1, $address_line2, $date);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Your booking has been successfully created!";
        header("Location: booking_success.php");
        exit;
    } else {
        $error_message = urlencode("An error occurred while processing your booking. Please try again.");
        header("Location: ../booking.html?error=$error_message");
        exit;
    }
}

// Display error message if it exists
if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger text-center">
        <?php echo htmlspecialchars($_SESSION['error']); ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form action="booking.php" method="POST">
  <div class="mb-3">
    <label for="first_name" class="form-label">First Name:</label>
    <input type="text" class="form-control" id="first_name" name="first_name" required>
  </div>
  <div class="mb-3">
    <label for="last_name" class="form-label">Last Name:</label>
    <input type="text" class="form-control" id="last_name" name="last_name" required>
  </div>
  <div class="mb-3">
    <label for="address_line1" class="form-label">Address Line 1:</label>
    <input type="text" class="form-control" id="address_line1" name="address_line1" required>
  </div>
  <div class="mb-3">
    <label for="address_line2" class="form-label">Address Line 2 (Optional):</label>
    <input type="text" class="form-control" id="address_line2" name="address_line2">
  </div>
  <div class="mb-3">
    <label for="date" class="form-label">Date:</label>
    <input type="date" class="form-control" id="date" name="date" required>
  </div>
  <div class="mb-3">
    <label for="type" class="form-label">Booking Type:</label>
    <select class="form-control" id="type" name="type" required>
      <option value="consultation">Consultation</option>
      <option value="installation">Installation</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Book</button>
</form>