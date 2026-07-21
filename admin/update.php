<?php
	session_start();
	require_once __DIR__ . '/../config.php';

	// Original had no WHERE clause — every admin edit silently overwrote
	// every row in the admins table. Scoped to the logged-in admin now.
	$stmt = mysqli_prepare($connection, "UPDATE admins SET name = ?, email = ?, mobile = ? WHERE email = ?");
	mysqli_stmt_bind_param($stmt, "ssis", $_POST['name'], $_POST['email'], $_POST['mobile'], $_SESSION['email']);
	mysqli_stmt_execute($stmt);

	// Keep session in sync with the values just saved.
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['email'] = $_POST['email'];
?>
<script type="text/javascript">
	alert("Updated successfully...");
	window.location.href = "admin_dashboard.php";
</script>
