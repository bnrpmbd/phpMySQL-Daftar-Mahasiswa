<?php
// Nama: Banar Pambudi
// NIM : 21060123140160

$host = "localhost";
$user = "root";
$pass = "";
$db = "kampus";

// First connect without database to create it if not exists
$conn_check = new mysqli($host, $user, $pass);
if ($conn_check->connect_error) {
    die("Koneksi gagal: " . $conn_check->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $db";
if ($conn_check->query($sql) === TRUE) {
    // Database created or already exists
} else {
    die("Error creating database: " . $conn_check->error);
}
$conn_check->close();

// Connect to the database
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");

// Create table if not exists
$sql = "CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(15) NOT NULL UNIQUE,
    nama VARCHAR(50) NOT NULL,
    prodi VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}
?>