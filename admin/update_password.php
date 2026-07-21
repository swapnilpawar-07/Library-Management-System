<?php
	session_start();
	require_once __DIR__ . '/../config.php';

	$stmt = mysqli_prepare($connection, "SELECT password FROM admins WHERE email = ?");
	mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);

	if ($row && password_verify($_POST['old_password'], $row['password'])) {
		$new_hashed_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
		$update_stmt = mysqli_prepare($connection, "UPDATE admins SET password = ? WHERE email = ?");
		mysqli_stmt_bind_param($update_stmt, "ss", $new_hashed_password, $_SESSION['email']);
		mysqli_stmt_execute($update_stmt);
		?>
		<script type="text/javascript">
			alert("Updated successfully...");
			window.location.href = "admin_dashboard.php";
		</script>
		<?php
	} else {
		?>
		<script type="text/javascript">
			alert("Current password is incorrect.");
			window.location.href = "change_password.php";
		</script>
		<?php
	}
?>
