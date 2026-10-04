<?php
    //1. เชื่อมต่อฐานข้อมูล MySQL
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "userDB";
    $conn = mysqli_connect($host, $user, $password, $database);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
