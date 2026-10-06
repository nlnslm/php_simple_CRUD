<?php
    //1. เชื่อม php เข้ากับฐานข้อมูล MySQL
    // กำหนดที่อยู่ของฐานข้อมูลเป็น localhost
    $host = "localhost";
    // กำหนดชื่อผู้ใช้ฐานข้อมูลเป็น root
    $user = "root";
    // กำหนดรหัสผ่านฐานข้อมูลเป็นค่าว่าง
    $password = "";
    // กำหนดชื่อฐานข้อมูลเป็น userDB
    $database = "userDB";
    // สร้างการเชื่อมต่อกับฐานข้อมูล MySQL
    $conn = mysqli_connect($host, $user, $password, $database);
    // ตรวจสอบว่าการเชื่อมต่อสำเร็จหรือไม่
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>
