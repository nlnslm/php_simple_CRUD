<?php
	//2.save regist info into database

	// เชื่อมต่อฐานข้อมูล
	include_once 'dbconnect.php';

	// ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
	if(isset($_POST['signup'])) {
		$name = $_POST['user-name'];
		$email = $_POST['user-email'];
		$password = $_POST['user-password'];
		$cpassword = $_POST['user-cpassword']; // ใช้ยืนยันรหัสผ่าน (ไม่ต้อง insert ลง database)

		// ตรวจสอบว่ารหัสผ่านตรงกันหรือไม่
		if ($password != $cpassword) {
			$cpassword_error = "Passwords do not match.";
			$err_flag = true;
		}

		// ตรวจสอบรูปแบบอีเมล
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email_error = "Invalid email format.";
			$err_flag = true;
		}

		// ตรวจสอบความยาวของรหัสผ่าน
		if(strlen($password) < 6) {
			$password_error = "Password must be at least 6 characters long.";
			$err_flag = true;
		}

		// ตรวจสอบว่ารหัสผ่านมีตัวอักษรพิมพ์ใหญ่หรือไม่
		if (!preg_match('/[A-Z]/', $password)) {
			$password_error = "Password must contain at least one uppercase letter.";
			$err_flag = true;
		}

		// 2.5 ถ้าไม่มีข้อผิดพลาด ให้ทำการบันทึกข้อมูลลงในฐานข้อมูล
		if(!err_flag) {
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);
			//$hashed_password = md5($password); // กรณีใช้ md5 แทน password_hash
			$SQL = "INSERT INTO users (user_name, user_email, user_password) VALUES ('$name', '$email', '$hashed_password')";
			// แสดงความสำเร็จหรือข้อผิดพลาดในการบันทึกข้อมูล
			if(mysqli_query($conn, $SQL)) {
				$success_message = "Registration successful!";
			} else {
				$error_message = "Error: " . mysqli_error($conn);
			}
		} else {

		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>User Registration</title>
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
				<li class="active"><a href="register.php">Sign Up</a></li>
				<li><a href="admin_login.php">Admin</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			// action ที่ไฟล์เดิม
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
				<fieldset>
					<legend>Sign Up</legend>

					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" placeholder="Enter Full Name" required value="" class="form-control" />
						// แสดงข้อความผิดพลาด ถ้ามี
						<span class="text-danger"><?php if(isset($name_error)) echo $name_error; ?></span>
					</div>

					<div class="form-group">
						<label for="name">Email</label>
						<input type="text" name="email" placeholder="Email" required value="" class="form-control" />
						// แสดงข้อความผิดพลาด ถ้ามี
						<span class="text-danger"><?php if(isset($email_error)) echo $email_error; ?></span>
					</div>

					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" name="password" placeholder="Password" required class="form-control" />
						// แสดงข้อความผิดพลาด ถ้ามี
						<span class="text-danger"><?php if(isset($password_error)) echo $password_error; ?></span>
					</div>

					<div class="form-group">
						<label for="name">Confirm Password</label>
						<input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
						// แสดงข้อความผิดพลาด ถ้ามี
						<span class="text-danger"><?php if(isset($cpassword_error)) echo $cpassword_error; ?></span>
					</div>

					<div class="form-group">
						<input type="submit" name="signup" value="Sign Up" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<!--3.display message -->

		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4 text-center">
		Already Registered? <a href="login.php">Login Here</a>
		</div>
	</div>
</div>
</body>
</html>
