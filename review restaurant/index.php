<?php

session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="photos/logo.png" type="image/icon type">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Restaurants Finder</title>
</head>
<body>

	<?php
		include("includes/header.php");
	?>

	<nav>
		<h1 class="middle">Restaurants Finder</h1>
		<h2 class="middle">Find the best restaurants in your area just from your browser...</h2>
	</nav>

	<section>
		<div class="gallery photo">
			<img src="https://images.pexels.com/photos/6270541/pexels-photo-6270541.jpeg">
		</div>
		<div class="gallery description">
			<p>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</p>
		</div>
		<div class="gallery description">
			<p>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</p>
		</div>
		<div class="gallery photo">
			<img src="https://images.pexels.com/photos/343871/pexels-photo-343871.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940">
		</div>
	</section>
</body>
</html>