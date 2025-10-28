<?php
$servername = "sql204.infinityfree.com";  
$username   = "if0_40277481";            
$password   = "WkzZ5PS8fdfaB";           
$database   = "if0_40277481_student_feedback";  

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
