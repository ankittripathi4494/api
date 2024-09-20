<?php
$host = "localhost"; // Use 'localhost' for local XAMPP
$db_name = "test_db"; // Replace with the name of your local database
$username = "root"; // Default username for XAMPP MySQL
$password = ""; // Default password is empty for XAMPP MySQL

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Optionally, uncomment the next line to check connection success
    // echo "Connected successfully";
} catch(PDOException $exception) {
    // Log the error for debugging (optional)
    error_log("Database connection error: " . $exception->getMessage());

    // Display a generic error message
    echo "Connection error: Unable to connect to the database.";
}
?>
