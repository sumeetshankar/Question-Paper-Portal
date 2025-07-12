<?php
$servername = "sql304.infinityfree.com";
$username = "if0_39175851";
$password = "monu2580";
$dbname = "if0_39175851_question_paper_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
