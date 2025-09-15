<?php
	session_start();
	function get_user_issue_book_count(){
		$connection = mysqli_connect("localhost","root","");
		$db = mysqli_select_db($connection,"lms");
		$user_issue_book_count = 0;
		$query = "select count(*) as user_issue_book_count from issued_books where student_id = $_SESSION[id]";
		$query_run = mysqli_query($connection,$query);
		while($row = mysqli_fetch_assoc($query_run)){
			$user_issue_book_count = $row['user_issue_book_count'];
	}
	return($user_issue_book_count);
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
		body{
			background-image: url("./images/dashboard.jpg");
			background-repeat: no-repeat;
			background-size: 100% 220%;
		}
  		#side_bar{
  			background-color: whitesmoke;
  			padding: 50px;
  			width: 300px;
  			height: 450px;
  		}
		.row{
			padding-top: 50px;
		}
		.card{
			margin-top: 30px;
			margin-left: 100px;
		}
  	</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #E7DFD1;">
		<div class="container-fluid">
			<div class="navbar-header">
				<img src="./images/symbol.png" width="40" height="40" class="d-inline-block align-top" alt="">
				<a class="navbar-brand" href="admin_dashboard.php">Library Management System</a>
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

	<div class="row">
		<div class="col-md-3">
			<div class="card bg-light" style="width: 300px">
				<div class="card-header">Issued Books:</div>
				<div class="card-body">
					<p class="card-text">No. of Issued Books: <?php echo get_user_issue_book_count();?> </p>
					<a href="view_issued_book.php" class="btn" style="background-color: #964B00; color:white" target="_blank">View Issued Books</a>
				</div>
			</div>
		</div>
		
	</div>
</body>
</html>