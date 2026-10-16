<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Product Item</title>
	<?php include "parts/meta.php"; ?>
</head>
<body>

	<?php include "parts/navbar.php"; ?>

	<div class="container">
		<div class="card soft">
			<h2>Product Detail</h2>
			<p>This is item # <?= isset($_GET['id']) ? $_GET['id'] : '1' ?></p>
			<p><a href="cart.php">Add to Cart</a></p>
		</div>
	</div>

	<?php include "parts/footer.php"; ?>

</body>
</html>