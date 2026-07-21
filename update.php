<?php
	session_start();
	require_once __DIR__ . '/config.php';

	// Original version had no WHERE clause at all, so saving any one user's
	// profile silently overwrote every row in the users table. Scoping the
	// update to the logged-in user's own id fixes that.
	$stmt = mysqli_prepare($connection, "UPDATE users SET name = ?, email = ?, mobile = ?, address = ? WHERE id = ?");
	mysqli_stmt_bind_param($stmt, "sssii", $_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['address'], $_SESSION['id']);
	mysqli_stmt_execute($stmt);

	// Keep session in sync with the values the user just saved.
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['email'] = $_POST['email'];
?>
<script type="text/javascript">
	alert("Updated successfully...");
	window.location.href = "user_dashboard.php";
</script>
