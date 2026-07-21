<?php
	require_once __DIR__ . '/../config.php';
	$stmt = mysqli_prepare($connection, "DELETE FROM category WHERE cat_id = ?");
	mysqli_stmt_bind_param($stmt, "i", $_GET['cid']);
	mysqli_stmt_execute($stmt);
?>
<script type="text/javascript">
	alert("Category Deleted...");
	window.location.href = "manage_cat.php";
</script>
