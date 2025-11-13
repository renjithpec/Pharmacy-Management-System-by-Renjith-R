<?php
// This file connects the application to the MySQL database.

// Database connection credentials
$servername = "localhost"; // Server is on the same computer
$username = "root";        // Default username for XAMPP MySQL
$password = "";            // Default password for XAMPP MySQL is empty
$dbname = "pharmacy_db";   // The name of our database from Step 1

// Create connection using the mysqli procedural approach
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    // If the connection fails, stop the script and display an error message.
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set character set to utf8mb4 for better compatibility
mysqli_set_charset($conn, "utf8mb4");

?>