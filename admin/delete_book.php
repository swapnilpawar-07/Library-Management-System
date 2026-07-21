<?php
	require_once __DIR__ . '/../config.php';
	$stmt = mysqli_prepare($connection, "DELETE FROM books WHERE book_no = ?");
	mysqli_stmt_bind_param($stmt, "i", $_GET['bn']);
	mysqli_stmt_execute($stmt);
?>
<script type="text/javascript">
	alert("Book Deleted...");
	window.location.href = "manage_book.php";
</script>
