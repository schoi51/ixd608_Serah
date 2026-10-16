<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Checkout</title>
	<?php include "parts/meta.php"; ?>
</head>
<body>

	<?php include "parts/navbar.php"; ?>

	<div class="container">
		<div class="card soft">
			<h2>Checkout</h2>
			<form action="confirmation.php" method="get">
				<p>Enter your shipping & payment details.</p>
				<button type="submit" class="form-button primary">Place Order</button>
			</form>
		</div>
	</div>

	<?php include "parts/footer.php"; ?>

</body>
</html>