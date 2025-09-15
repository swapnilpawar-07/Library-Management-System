<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
  	<script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
  	<script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
  	<style type="text/css">
		body{
			margin: 10px;
			background-image: url("./images/index.jpg");
			background-repeat: no-repeat;
			background-size: 100% 110%;
		}
		
  		#side_bar{
  			background-color: #E7DFD1;
  			padding: 50px;
  			width: 300px;
  			height: 490px;
  		}
  	</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #E7DFD1;">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">
				<img src="./images/symbol.png" width="40" height="40" class="d-inline-block align-top" alt="">	
				Library Management System</a>
			</div>
			<ul class="nav navbar-nav navbar-right">
				<li class="nav-item">
					<a class="nav-link" href="index.php">Admin Login</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../index.php">User Login</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../signup.php">User Register</a>
				</li>
			</ul>
		</div>
	</nav><br>
	<span><marquee>!!! Welcome To The Library Management System !!!</marquee></span><br><br>
	<div class="row">		
		<div class="col-md-8" id="main_content">
			<center><h3>Admin Login Form</h3></center>
			<form action="" method="post">
				<div class="form-group">
					<label for="name">Email ID:</label>
					<input type="text" name="email" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="name">Password:</label>
					<input type="password" name="password" class="form-control" required>
				</div>
				<button type="submit" name="login" class="btn" style="background-color: #964B00; color:white">Login</button>
			</form>

			<?php
				session_start();
				if(isset($_POST['login'])){
					$connection = mysqli_connect("localhost","root","");
					$db = mysqli_select_db($connection,"lms");
					$query = "select * from admins where email = '$_POST[email]'";
					$query_run = mysqli_query($connection,$query);
					while($row = mysqli_fetch_assoc($query_run)){
						if($row['email'] == $_POST['email']){
							if($row['password'] == $_POST['password']){
								$_SESSION['name'] = $row['name'];
								$_SESSION['email'] = $row['email'];
								header("Location:admin_dashboard.php");
							}
							else{
								?>
								<br><br><center><span class="alert-danger">Wrong Password</span></center>
								<?php
							}
						}
					}
				}
			?>
		</div>
		<div class="col-md-4" id="side_bar">
			<ul>
				<li>A Library Management System is software that is designed to manage all the functions of a library. It helps librarian/admin to maintain the database of new books and the books that are borrowed by members along with their due dates.</li>
				<li>The best way to maintain, organize, and handle countless books systematically is to implement a lms software</li>
				<li>It tracks the records of the number of books in the library, how many books are issued or how many books have been returned, etc.</li>
				<br><li>
				<h5>Library Timing</h5>
				<ul>
					<li>Opening Timing: 7:00 AM</li>
					<li>Closing Timing: 10:00 PM</li>
					<li>(Holiday on Sunday)</li>
				</ul></li>
			</ul>
		</div>	
	</div>
</body>
</html>