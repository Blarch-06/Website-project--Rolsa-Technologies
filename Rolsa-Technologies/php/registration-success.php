<?php
// filepath: c:\xampp\htdocs\Task2Main_1394484_Blackmore_A\php\registration-success.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Successful</title>
  <link rel="stylesheet" href="../styles.css"> <!-- Include your styles.css file -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Lora:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--linen); /* Light beige background */
      color: var(--outer-space); /* Dark grey text */
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .card {
      background-color: var(--mint); /* Match the website's theme */
      color: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      padding: 30px;
      text-align: center;
      max-width: 400px;
      width: 100%;
    }

    .card h1 {
      font-family: 'Lora', serif;
      font-size: 2rem;
      font-weight: bold;
    }

    .card p {
      font-size: 1rem;
      margin-bottom: 20px;
    }

    .btn-primary {
      background-color: var(--outer-space);
      border: none;
      font-family: 'Poppins', sans-serif;
      padding: 10px 20px;
      font-size: 1rem;
    }

    .btn-primary:hover {
      background-color: var(--mint-dark); /* Slightly darker mint color */
      color: white;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Registration Successful!</h1>
    <p>Your account has been created. You can now log in to your account.</p>
    <a href="../login.html" class="btn btn-primary">Go to Login</a>
  </div>
</body>
</html>