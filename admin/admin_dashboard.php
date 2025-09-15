<?php
	require('functions.php');
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Dashboard</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
  	<script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
  	<script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
  	<style type="text/css">
		body{
			background-image: url("./images/dashboard.jpg");
			background-repeat: no-repeat;
			background-size: 100% 150%;
		}
  		#side_bar{
  			background-color: #CEC0A7;
  			padding: 50px;
  			width: 300px;
  			height: 450px;
  		}
		.row{
			padding-top: 50px;
		}
		.card{
			margin-left: 30px;
			margin-bottom:30px;
		}
  	</style>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #E7DFD1;">
		<div class="container-fluid">
			<div class="navbar-header">
				<img src="./images/symbol.png" width="40" height="40" class="d-inline-block align-top" alt="">
				<a class="navbar-brand" href="index.php">Library Management System</a>
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
				<li class="nav-item"><a class="nav-link" href="../logout1.php">Logout</a></li>
			</ul>
		</div>
	</nav>
	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fffbe8">
		<div class="container-fluid">
			<ul class="nav navbar-nav navbar-center">
				<li class="nav-item">
					<a href="admin_dashboard.php" class="nav-link">Dashboard</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown">Book</a>
					<div class="dropdown-menu">
						<a href="add_book.php" class="dropdown-item">Add New Book</a>
						<a href="manage_book.php" class="dropdown-item">Manage Books</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown">Category</a>
					<div class="dropdown-menu">
						<a href="add_cat.php" class="dropdown-item">Add New Category</a>
						<a href="manage_cat.php" class="dropdown-item">Manage Category</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown">Author</a>
					<div class="dropdown-menu">
						<a href="add_author.php" class="dropdown-item">Add New Author</a>
						<a href="manage_author.php" class="dropdown-item">Manage Authors</a>
					</div>
				</li>
				<li class="nav-item">
					<a href="issue_book.php" class="nav-link">Issue Book</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="row">
		<div class="col-md-3">
			<div class="card " style="width: 300px; background-color: #fcfbf7">
				<div class="card-header">Registered Users:</div>
				<div class="card-body">
					<p class="card-text">No. of total users registered: <?php echo get_user_count();?></p>
					<a href="regusers.php" class="btn" style="background-color: #964B00; color:white" target="_blank">View Registered Users</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card " style="width: 300px; background-color: #fcfbf7">
				<div class="card-header">Available Books:</div>
				<div class="card-body">
					<p class="card-text">No. of availbale books: <?php echo get_book_count();?></p>
					<a href="books.php" class="btn" style="background-color: #964B00; color:white" target="_blank">View Available Books</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card " style="width: 300px; background-color: #fcfbf7">
				<div class="card-header">Book's Category:</div>
				<div class="card-body">
					<p class="card-text">No. of book's category: <?php echo get_category_count();?></p>
					<a href="bcateg.php" class="btn" style="background-color: #964B00; color:white" target="_blank">View Categories</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card " style="width: 300px; background-color: #fcfbf7">
				<div class="card-header">Book's Authors:</div>
				<div class="card-body">
					<p class="card-text">No. of book's authors: <?php echo get_author_count();?></p>
					<a href="bookauth.php" class="btn" style="background-color: #964B00; color:white" target="_blank">View Authors</a>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card " style="width: 300px; background-color: #fcfbf7">
				<div class="card-header">Issued Books:</div>
				<div class="card-body">
					<p class="card-text">No. of issued books: <?php echo get_issued_book_count();?></p>
					<a href="view_issued_book.php" class="btn" style="background-color: #964B00; color:white" target="_blank">View Issued books</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>