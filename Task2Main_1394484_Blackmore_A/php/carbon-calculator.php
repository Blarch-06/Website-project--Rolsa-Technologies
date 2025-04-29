<?php
// filepath: c:\xampp\htdocs\Task2Main_1394484_Blackmore_A\php\carbon-calculator.php

session_start();
require 'db.php'; // Include database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

// Initialize variables for results
$electricity_emissions = $gas_emissions = $miles_emissions = $total_emissions = null;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $electricity = floatval($_POST['electricity']);
    $gas = floatval($_POST['gas']);
    $miles = floatval($_POST['miles']);

    // Define emission factors (kg CO2 per unit)
    $electricity_factor = 0.233; // Example: 0.233 kg CO2 per kWh
    $gas_factor = 2.20462; // Example: 2.20462 kg CO2 per therm
    $miles_factor = 0.404; // Example: 0.404 kg CO2 per mile

    // Calculate emissions
    $electricity_emissions = $electricity * $electricity_factor;
    $gas_emissions = $gas * $gas_factor;
    $miles_emissions = $miles * $miles_factor;

    // Total emissions
    $total_emissions = $electricity_emissions + $gas_emissions + $miles_emissions;

    // If the user is logged in, store the results in the database
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Insert the results into the database
        $stmt = $conn->prepare("INSERT INTO carbon_results (user_id, electricity, gas, miles, total_emissions) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idddd", $user_id, $electricity, $gas, $miles, $total_emissions);
        $stmt->execute();
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carbon Calculator Results</title>
  <link rel="stylesheet" href="../styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background-color: var(--linen);
      color: var(--outer-space);
      font-family: 'Poppins', sans-serif;
    }

    .results-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .results-container h1 {
      text-align: center;
      color: var(--mint);
    }

    .btn-primary {
      background-color: var(--mint);
      border: none;
    }

    .btn-primary:hover {
      background-color: var(--outer-space);
      color: white;
    }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded shadow mb-3">
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

  <div class="results-container">
    <h1>Carbon Calculator Results</h1>
    <?php if ($total_emissions !== null): ?>
      <p><strong>Electricity Emissions:</strong> <?php echo htmlspecialchars($electricity_emissions); ?> kg CO<sub>2</sub></p>
      <p><strong>Gas Emissions:</strong> <?php echo htmlspecialchars($gas_emissions); ?> kg CO<sub>2</sub></p>
      <p><strong>Miles Emissions:</strong> <?php echo htmlspecialchars($miles_emissions); ?> kg CO<sub>2</sub></p>
      <p><strong>Total Emissions:</strong> <?php echo htmlspecialchars($total_emissions); ?> kg CO<sub>2</sub></p>
    <?php else: ?>
      <p>No data submitted. Please go back to the <a href="../carbon-calculator.html">Carbon Calculator</a>.</p>
    <?php endif; ?>
    <div class="text-center mt-4">
      <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
    </div>
  </div>
</body>
</html>