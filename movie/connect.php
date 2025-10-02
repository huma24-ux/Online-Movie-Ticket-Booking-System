<?php
$host = "localhost";      // Database host
$user = "root";           // Database username (default in XAMPP/WAMP is root)
$pass = "";               // Database password (leave empty in XAMPP/WAMP by default)
$db   = "movies_ticketing_system"; // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Optional: Success message
// echo "Connected successfully!";
?>

