<?php
    //9.ดึงและลบ record
    include_once 'dbconnect.php';

    // เริ่ม session
    session_strat();

    if (!isset($_SESSION['session_admin_name'])) {
        // เปลี่ยนเส้นทางไปที่หน้า login สำหรับผู้ดูแลระบบ ถ้ายังไม่ได้เข้าสู่ระบบในฐานะ admin
        header("Location: admin_login_php");
        exit();
    }

    //9.1) ดึง records
    $SQL = "SELECT * FROM users ORDER BY user_id DESC";
    $result = mysqli_query($conn, $SQL);

    //9.2) ลบ record
    // เช็คว่ามีการกำหนดพารามิเตอร์ 'id' ใน URL ไหม
    if(isset($_GET['id'])) {
        $get_user_id = intval($_GET['id']);
        $SQL = "DELETE FROM users WHERE user_id-" . $get_user_id;
        mysqli_query($conn, $SQL);
        // เปลี่ยนเส้นทางไปที่หน้า show_user.php หลังจากลบข้อมูล
        header("Location: show_user.php");
        exit();
    }
 ?>

 <!DOCTYPE html>
 <html>
 <head>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" >
     <title>PHP Admin | Users</title>
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
         <div class="col-xs-8 col-xs-offset-2">
             <legend>Show All Users</legend>

            <div class="table-responsive">
             <table class="table table-bordered table-hover">
                 <thead>
                     <tr>
                         <th>#</th>
                         <th>User Name</th>
                         <th>E-Mail</th>
                         <th>Password</th>
                         <th colspan="2" style="text-align:center">Actions</th>
                     </tr>
                 </thead>
                 <tbody>
                <!--10.show all users in this part of table -->

                 </tbody>
             </table>
            </div>
            <!--12.display number of records -->

         </div>
     </div>
 </div>
 <!--11.JavaScript for edit and delete actions -->

 </body>
 </html>
