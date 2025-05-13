# Rolsa Technologies Web Application

Rolsa Technologies is a web application designed to promote sustainable living through tools like a carbon calculator, booking services for consultations and installations, and a marketplace for eco-friendly products.

## Table of Contents
- [Features](#features)
- [Setup Instructions](#setup-instructions)
- [Database Schema](#database-schema)
- [Technologies Used](#technologies-used)
- [Usage](#usage)

---

## Features
1. **Carbon Calculator**: Calculate your carbon footprint based on electricity, gas, and miles driven.
2. **Booking System**: Book consultations or installations for sustainable solutions.
3. **Marketplace**: Browse and purchase eco-friendly products.
4. **User Authentication**: Register and log in to access personalized features.
5. **Dynamic Animations**: Smooth animations for an engaging user experience.
6. **Responsive Design**: Optimized for desktop and mobile devices.


## Setup Instructions

### Prerequisites
1. **Web Server**: Install [XAMPP](https://www.apachefriends.org/) or any LAMP/WAMP stack.
2. **Database**: Install MySQL or MariaDB.
3. **PHP**: Ensure PHP 7.4 or higher is installed.

### Steps
1. Clone or download the project folder into your web server's root directory (e.g., `htdocs` for XAMPP).
2. Import the database:
   - Open phpMyAdmin or your preferred database management tool.
   - Create a new database named `rolsa_technologies`.
   - Import the `rolsa_technologies (1).sql` file into the database.
3. Configure the database connection:
   - Open `php/db.php` and update the database credentials:
     ```php
     <?php
     $host = 'localhost';
     $user = 'root';
     $password = '';
     $database = 'rolsa_technologies';

     $conn = new mysqli($host, $user, $password, $database);

     if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
     }
     ?>
     ```
4. Start the web server and navigate to `http://localhost/Task2Main_1394484_Blackmore_A/` in your browser.

---

## Database Schema
The database consists of the following tables:

### `users`
| Column         | Type         | Description                     |
|----------------|--------------|---------------------------------|
| `id`           | INT(11)      | Primary key, auto-increment     |
| `email`        | VARCHAR(255) | User's email address            |
| `password_hash`| VARCHAR(255) | Hashed password                 |
| `created_at`   | TIMESTAMP    | Account creation timestamp      |

### `bookings`
| Column         | Type         | Description                     |
|----------------|--------------|---------------------------------|
| `id`           | INT(11)      | Primary key, auto-increment     |
| `user_id`      | INT(11)      | Foreign key referencing `users` |
| `type`         | ENUM         | Booking type (`consultation`, `installation`) |
| `first_name`   | VARCHAR(100) | User's first name               |
| `last_name`    | VARCHAR(100) | User's last name                |
| `address_line1`| VARCHAR(255) | Address line 1                  |
| `address_line2`| VARCHAR(255) | Address line 2 (optional)       |
| `date`         | DATE         | Booking date                    |
| `created_at`   | TIMESTAMP    | Booking creation timestamp      |

### `carbon_results`
| Column         | Type         | Description                     |
|----------------|--------------|---------------------------------|
| `id`           | INT(11)      | Primary key, auto-increment     |
| `user_id`      | INT(11)      | Foreign key referencing `users` |
| `electricity`  | FLOAT        | Electricity usage (kWh)         |
| `gas`          | FLOAT        | Gas usage (therms)              |
| `miles`        | FLOAT        | Miles driven                    |
| `total_emissions` | FLOAT     | Total carbon emissions (kg CO2) |
| `created_at`   | DATETIME     | Record creation timestamp       |

---

## Technologies Used
- **Frontend**:
  - HTML5, CSS3, JavaScript
  - Bootstrap 5
  - Google Fonts (`Poppins`, `Lora`)
- **Backend**:
  - PHP 8.0
  - MySQL/MariaDB
- **Tools**:
  - phpMyAdmin for database management
  - XAMPP for local development

---

## Usage
1. **Home Page**:
   - Navigate to `index.html` to explore the website.
2. **Carbon Calculator**:
   - Use `carbon-calculator.html` to calculate your carbon footprint.
3. **Booking**:
   - Visit `booking.html` to book consultations or installations.
4. **Marketplace**:
   - Browse eco-friendly products on `market.html`.
5. **User Authentication**:
   - Register on `register.html` and log in via `login.html`.
