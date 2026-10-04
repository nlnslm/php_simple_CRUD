<?php
	//16. clear sessions
	// เริ่ม session
	session_start();

	// เช็คว่าผู้ใช้ login ยัง (check if the user is logged in)
	if(isset($_SESSION['session_user_id'])) {
		// ล้าง session และเปลี่ยนเส้นทางไปที่หน้า login (destroy the session and redirect to login page)
		session_destroy();
		unset($_SESSION['session_user_id']);
		unset($_SESSION['session_user_name']);
		header("Location: login.php");
		exit();
	}
?>
