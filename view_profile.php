<?php
	session_start();
	require_once __DIR__ . '/config.php';
	$name = "";
	$email = "";
	$mobile = "";
	$address = "";

	$stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE id = ?");
	mysqli_stmt_bind_param($stmt, "i", $_SESSION['id']);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($result)) {
		$name = $row['name'];
		$email = $row['email'];
		$mobile = $row['mobile'];
		$address = $row['address'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Dashboard</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
  	<script type="text/javascript" src="bootstrap-4.4.1/js/juqery_latest.js"></script>
  	<script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
  	<style type="text/css">
  		#side_bar{
  			background-color: whitesmoke;
  			padding: 50px;
  			width: 300px;
  			height: 450px;
  		}
  	</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #E7DFD1;">
		<div class="container-fluid">
			<div class="navbar-header">
				<img src="./images/symbol.png" width="40" height="40" class="d-inline-block align-top" alt="">
				<a class="navbar-brand" href="user_dashboard.php">Library Management System</a>
			</div>
			<font style="color: #222541"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font>
			<font style="color: #222541"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></span></font>
			<ul class="nav navbar-nav navbar-right">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="view_profile.php">View Profile</a>
						<a class="dropdown-item" href="edit_profile.php"> Edit Profile</a>
						<a class="dropdown-item" href="change_password.php">Change Password</a>
					</div>
				</li>
				<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
			</ul>
		</div>
	</nav><br>
	<span><marquee>!!! Welcome To The Library Management System !!!</marquee></span><br><br>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<form>
				<div class="form-group">
					<label>Name:</label>
					<input type="text" class="form-control" value="<?php echo htmlspecialchars($name);?>" disabled>
				</div>
				<div class="form-group">
					<label>Email:</label>
					<input type="text" class="form-control" value="<?php echo htmlspecialchars($email);?>" disabled>
				</div>
				<div class="form-group">
					<label>Mobile:</label>
					<input type="text" class="form-control" value="<?php echo htmlspecialchars($mobile);?>" disabled>
				</div>
				<div class="form-group">
					<label>Address:</label>
					<textarea rows="3" cols="40" disabled="" class="form-control"><?php echo htmlspecialchars($address);?></textarea>
				</div>
			</form>
		</div>
		<div class="col-md-4"></div>
	</div>
</body>
</html>
