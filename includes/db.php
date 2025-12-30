<?php
$servername = "localhost";   // ✅ use this for XAMPP
$username = "root";          // ✅ default username
$password = "";              // ✅ default password is blank
$dbname = "student_feedback"; // ✅ your actual database name

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
