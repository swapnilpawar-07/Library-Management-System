<?php
	require_once __DIR__ . '/../config.php';
	$stmt = mysqli_prepare($connection, "DELETE FROM authors WHERE author_id = ?");
	mysqli_stmt_bind_param($stmt, "i", $_GET['aid']);
	mysqli_stmt_execute($stmt);
?>
<script type="text/javascript">
	alert("Author Deleted...");
	window.location.href = "manage_author.php";
</script>
