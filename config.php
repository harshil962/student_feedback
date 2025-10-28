<?php
$servername = "sql211.infinityfree.com";  
$username   = "if0_40277481";            
$password   = "WkzZ5PS8fdfaB";           
$database   = "if0_40277481_student_feedback";  

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
