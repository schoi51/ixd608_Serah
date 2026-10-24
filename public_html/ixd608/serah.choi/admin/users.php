<?php

include "../lib/php/functions.php";

$users = file_get_json("../data/users.json");

if (isset($_GET['id']) && isset($_GET['action'])) {
	$id = $_GET['id'];
	$action = $_GET['action'];

	if ($action == 'update') {
		$users[$id]->name = $_POST['name'];
		$users[$id]->type = $_POST['type'];
		$users[$id]->email = $_POST['email'];
		$users[$id]->classes = explode(", ", $_POST['classes']);

		file_put_contents("../data/users.json", json_encode($users, JSON_PRETTY_PRINT));

		header("location: /ixd608/serah.choi/admin/users.php?id=$id");
		exit;
	}
}

function showUserPage($user, $id) {
	$classes = implode(", ", $user->classes);
	echo <<<HTML
	<div>
		<h2>$user->name</h2>
		<div style="margin-bottom: 1rem;">
			<strong>Type:</strong>
			<span>$user->type</span>
		</div>
		<div style="margin-bottom: 1rem;">
			<strong>Email:</strong>
			<span>$user->email</span>
		</div>
		<div style="margin-bottom: 1rem;">
			<strong>Classes:</strong>
			<span>$classes</span>
		</div>
		<div style="margin-top: 20px; display: flex; gap: 10px; align-items: center;">
			<a href="/ixd608/serah.choi/admin/users.php?id=$id&action=edit" class="form-button" style="display: inline-block; text-align: center; text-decoration: none; padding: 0.5em 1em;">Edit User</a>
			<a href="/ixd608/serah.choi/admin/users.php" class="form-button" style="display: inline-block; text-align: center; text-decoration: none; padding: 0.5em 1em; background-color: #777;">Back to List</a>
		</div>
	</div>
	HTML;
}

function showUserEditPage($user, $id) {
	$classes = implode(", ", $user->classes);
	echo <<<HTML
	<form method="post" action="/ixd608/serah.choi/admin/users.php?id=$id&action=update">
		<h2>Edit User</h2>
		<div class="form-control" style="margin-bottom: 1rem;">
			<label class="form-label" for="name" style="display: block; margin-bottom: 0.5em; font-weight: bold;">Name</label>
			<input class="form-input" type="text" name="name" value="$user->name" id="name" style="width: 100%; box-sizing: border-box; padding: 0.5em; font-size: 1rem;">
		</div>
		<div class="form-control" style="margin-bottom: 1rem;">
			<label class="form-label" for="type" style="display: block; margin-bottom: 0.5em; font-weight: bold;">Type</label>
			<input class="form-input" type="text" name="type" value="$user->type" id="type" style="width: 100%; box-sizing: border-box; padding: 0.5em; font-size: 1rem;">
		</div>
		<div class="form-control" style="margin-bottom: 1rem;">
			<label class="form-label" for="email" style="display: block; margin-bottom: 0.5em; font-weight: bold;">Email</label>
			<input class="form-input" type="text" name="email" value="$user->email" id="email" style="width: 100%; box-sizing: border-box; padding: 0.5em; font-size: 1rem;">
		</div>
		<div class="form-control" style="margin-bottom: 1rem;">
			<label class="form-label" for="classes" style="display: block; margin-bottom: 0.5em; font-weight: bold;">Classes</label>
			<input class="form-input" type="text" name="classes" value="$classes" id="classes" style="width: 100%; box-sizing: border-box; padding: 0.5em; font-size: 1rem;">
		</div>
		<div style="margin-top: 20px; display: flex; gap: 10px; align-items: center;">
			<input type="submit" class="form-button" value="Save Changes" style="padding: 0.5em 1em;">
			<a href="/ixd608/serah.choi/admin/users.php?id=$id" class="form-button" style="display: inline-block; text-align: center; text-decoration: none; padding: 0.5em 1em; background: #777;">Cancel</a>
		</div>
	</form>
	HTML;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>User Admin Page</title>
	<?php include "../parts/meta.php"; ?>
</head>
<body>

<header class="navbar">
<div class="container display-flex">
<div class="flex-none">
<h1>User Admin</h1>
</div>
<div class="flex-stretch"></div>
<nav class="nav nav-flex flex-none">
<ul>
<li><a href="/ixd608/serah.choi/admin/users.php">User List</a></li>
</ul>
</nav>
</div>
</header>

	<div class="container">
		<div class="card soft">

		<?php
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
			$action = isset($_GET['action']) ? $_GET['action'] : "";

			if($action == 'edit') {
				showUserEditPage($users[$id], $id);
			} else {
				showUserPage($users[$id], $id);
			}
		} else {
		?>
			<h2>Users List</h2>

			<nav class="nav">
				<ul>
				<?php
				for($i=0; $i<count($users); $i++){
					echo "<li>
					<a href='/ixd608/serah.choi/admin/users.php?id=$i'>{$users[$i]->name}</a>
					 </li>";
				}
				?>
				</ul>
			</nav>
		<?php 
		} 
		?>

		</div>
	</div>

	<?php include "../parts/footer.php"; ?>

</body>
</html>