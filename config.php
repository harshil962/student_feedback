<?php
$servername = "sql211.infinityfree.com";  // Check your InfinityFree control panel for the correct SQL hostname
$username = "if0_40277481";              // Your InfinityFree MySQL username
$password = "WkzZ5PS8fdfaB";     // Your database password (from the InfinityFree panel)
$database = "if0_40277481_student_feedback";    // Your full database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: uncomment this line to test connection
// echo "Database connected successfully!";
?>
