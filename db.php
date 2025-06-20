<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hospital_site';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die('Помилка підключення: ' . $conn->connect_error);
}
?>
