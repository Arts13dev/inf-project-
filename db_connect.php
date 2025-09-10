<?php
// db_connect.php
$host = 'localhost';
$db = 'smarttechandbeauty'; 
$user = 'root'; 
$pass = '';

// Create connection using the object-oriented style
$conn = new mysqli($host, $user, $pass, $db);

// Check connection and stop the script if it fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>