<?php
session_start();
require 'db.php'; // Include database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

// Fetch all carbon calculator results for the logged-in user
$results_stmt = $conn->prepare("SELECT electricity, gas, miles, total_emissions, created_at FROM carbon_results WHERE user_id = ? ORDER BY created_at DESC");
$results_stmt->bind_param("i", $user_id);
$results_stmt->execute();
$results_stmt->store_result();
$results_stmt->bind_result($electricity, $gas, $miles, $total_emissions, $created_at);

// Fetch bookings for the logged-in user
$bookings_stmt = $conn->prepare("SELECT type, first_name, last_name, address_line1, address_line2, date FROM bookings WHERE user_id = ? ORDER BY date DESC");
$bookings_stmt->bind_param("i", $user_id);
$bookings_stmt->execute();
$bookings_stmt->store_result();

if ($bookings_stmt->num_rows > 0) {
    $bookings_stmt->bind_result($type, $first_name, $last_name, $address_line1, $address_line2, $date);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Rolsa Technologies</title>
  <link rel="stylesheet" href="../styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa; /* Light grey background */
      color: #212529; /* Dark grey text */
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background-color: var(--outer-space);
      border-radius: 10px;
    }

    .navbar-brand {
      font-family: 'Lora', serif; /* Use the same font as the second image */
      font-weight: bold; /* Make it bold */
      font-size: 2rem; /* Adjust the font size */
      color: white; /* Ensure the text color matches */
      text-transform: none; /* Remove any text transformation */
    }

    .nav-link {
      font-family: 'Poppins', sans-serif; /* Use the same font as the second image */
      font-size: 1rem; /* Adjust the font size */
      font-weight: 500; /* Use medium weight for better readability */
      color: white; /* Ensure the text color matches */
      text-transform: none; /* Remove any text transformation */
    }

    .nav-link:hover {
      color: #28a745; /* Add a hover effect with green color */
      text-decoration: underline; /* Optional: underline on hover */
    }

    .dashboard-container {
      padding: 40px 20px;
    }

    .dashboard-container h1 {
      color: #28a745; /* Green color */
      font-family: 'Lora', serif;
      font-size: 2.5rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 40px;
    }

    .hero-section {
      background-color: #2f4f4f;
      color: white;
      padding: 50px 0;
    }

    .hero-section h1 {
      font-family: 'Lora', serif;
      font-size: 2.5rem;
      font-weight: bold;
    }

    .hero-section p {
      font-family: 'Poppins', sans-serif;
      font-size: 1.2rem;
    }

    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
      background-color: #28a745;
      border: none;
    }

    .btn-primary:hover {
      background-color: #1e7e34;
      color: white;
    }

    footer {
      background-color: var(--outer-space);
      color: white;
      padding: 20px 0;
      margin-top: 40px;
    }

    footer p {
      margin: 0;
      font-size: 0.9rem;
    }

    .table {
      width: 100%;
      margin-bottom: 1rem;
      color: #212529;
      border-collapse: collapse;
    }

    .table th,
    .table td {
      padding: 0.75rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
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

  <!-- Hero Section -->
  <div class="hero-section text-center text-white py-5">
    <div class="container">
      <h1 class="display-4">Welcome to Your Dashboard</h1>
      <p class="lead">Manage your account, track your carbon footprint, and view your bookings all in one place.</p>
    </div>
  </div>

  <!-- Dashboard Section -->
  <div class="container dashboard-container mt-5">
    <div class="row">
      <!-- Account Management -->
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <h2 class="h5">Account Management</h2>
            <form action="update_account.php" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">New Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
              </div>
              <button type="submit" class="btn btn-primary w-100">Update Account</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Carbon Footprint History -->
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-body">
            <h2 class="h5 mb-4">Carbon Footprint History</h2>
            <?php if ($results_stmt->num_rows > 0): ?>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Electricity Usage (kWh)</th>
                    <th>Gas Usage (therms)</th>
                    <th>Miles Driven</th>
                    <th>Total Emissions (kg CO<sub>2</sub>)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($results_stmt->fetch()): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($created_at); ?></td>
                      <td><?php echo htmlspecialchars($electricity); ?></td>
                      <td><?php echo htmlspecialchars($gas); ?></td>
                      <td><?php echo htmlspecialchars($miles); ?></td>
                      <td><?php echo htmlspecialchars($total_emissions); ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p>No results found. <a href="../carbon-calculator.html">Calculate now</a>.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- User Bookings -->
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <div class="card-body">
            <h2 class="h5">Your Bookings</h2>
            <?php if ($bookings_stmt->num_rows > 0): ?>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($bookings_stmt->fetch()): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($type); ?></td>
                      <td><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></td>
                      <td><?php echo htmlspecialchars($address_line1 . ', ' . $address_line2); ?></td>
                      <td><?php echo htmlspecialchars($date); ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p>No bookings found. <a href="../booking.html">Make a booking</a>.</p>
            <?php endif; ?>
            <form action="php/booking.php" method="POST">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-center mt-5">
    <p>&copy; 2025 Rolsa Technologies. All rights reserved.</p>
  </footer>
</body>
</html>