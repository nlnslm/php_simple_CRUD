<?php
	//13. แสดงข้อมูลเดิมของผู้ใช้ในฟอร์มแก้ไข
    include_once 'dbconnect.php';

	// 
	if(isset($_GET['id'])) {
        $get_user_id = intval($_GET['id']);
        $SQL = "SELECT * FROM users WHERE user_id=" . $get_user_id;
        $result = mysqli_query($conn, $SQL);

		// ตรวจสอบว่ามีผู้ใช้ที่ตรงกับ ID หรือไม่
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "User not found.";
            exit();
        }
    } else {
        echo "No user ID specified.";
        exit();
    }

	//13.1) อัปเดตข้อมูลผู้ใช้
    if(isset($_POST['update'])) {
        $get_user_id = intval($_POST['user-id-update']);
        $user_name = mysqli_real_escape_string($conn, trim($_POST['user-name-update']));
        $user_email = mysqli_real_escape_string($conn, trim($_POST['user-email-update']));
        $user_password = $_POST['user-password-update'] ?? '';
        $user_cpassword = $_POST['user-cpassword-update'] ?? '';
        $err_flag = false;

		// เช็คความถูกต้องของข้อมูลที่ผู้ใช้กรอก
        if(!preg_match("/^[a-zA-Z ]+$/", $user_name)) {
            $error_message = "Name must contain only letters and spaces.";
            $err_flag = true;
        }

		// เช็คความถูกต้องของอีเมล
        if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format.";
            $err_flag = true;
        }

		// เช็คความยาวของรหัสผ่าน
        if(strlen($user_password) < 6) {
            $error_message = "Password must be at least 6 characters long.";
            $err_flag = true;
        }

		// เช็คว่ารหัสผ่านและรหัสผ่านยืนยันตรงกันหรือไม่
        if($user_password !== $user_cpassword) {
            $error_message = "Passwords do not match.";
            $err_flag = true;
        }

		// ถ้าไม่มีข้อผิดพลาด ให้ทำการอัปเดตข้อมูลผู้ใช้ในฐานข้อมูล
        if(!$err_flag) {
            $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
            $SQL = "UPDATE users SET user_name='" . $user_name . "', user_email='" . $user_email . "', user_password='" . $hashed_password . "' WHERE user_id=" . $get_user_id;

            if (mysqli_query($conn, $SQL)) {
                header("Location: show_user.php");
                exit();
            } else {
                $error_message = "Error updating user: " . mysqli_error($conn);
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Update User</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- add header -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">PHP Simple CRUD</a>
		</div>
		<!-- menu items -->
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Sign Up</a></li>
				<li class="active"><a href="admin_login.php">Admin</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="updateform">
				<fieldset>
					<legend>Update</legend>

					<!--14.display old info in text field -->
					<div class="form-group">
						<input type="hidden" name="id" value="" />
						<label for="name">Name</label>
						<input type="text" name="name" placeholder="Enter Full Name" required value="" class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Email</label>
						<input type="text" name="email" placeholder="Email" required value="" class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" name="password" placeholder="Password" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Confirm Password</label>
						<input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
					</div>

					<div class="form-group">
						<input type="submit" name="update" value="Update" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<!--15.display message -->

		</div>
	</div>
</div>
</body>
</html>
