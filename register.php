<?php
	require_once __DIR__ . '/config.php';

	// Passwords are hashed with password_hash() (bcrypt) before storage —
	// never store or compare plaintext passwords.
	$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

	$stmt = mysqli_prepare($connection, "INSERT INTO users (id, name, email, password, mobile, address) VALUES (NULL, ?, ?, ?, ?, ?)");
	mysqli_stmt_bind_param($stmt, "sssis", $_POST['name'], $_POST['email'], $hashed_password, $_POST['mobile'], $_POST['address']);
	mysqli_stmt_execute($stmt);
?>
<script type="text/javascript">
	alert("Registration successfully....You may login now.")
	window.location.href = "index.php";
</script>
