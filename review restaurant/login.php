<?php

session_start();
if (isset($_SESSION['id'])) {
	header("location: index.php");
	exit();
}

include("includes/db.php");
if (isset($_POST['submit'])) {
	$email = $_POST["email"];
	$password = sha1($_POST["password"]);

	$req = $bdd->prepare("SELECT * FROM users WHERE email = :em AND password = :pa");
	$req->execute(array(
		"em" => $email,
		"pa" => $password
	));

	if ($req->rowCount() == 1) {
		while ($info = $req->fetch()) {
			$_SESSION["id"] = $info["id"];
			$_SESSION["type"] = $info["type"];
			$_SESSION["name"] = $info["name"];
			$_SESSION["email"] = $info["email"];
		}

		header("location: index.php");
		$req->closeCursor();
		exit();
	}else {
		$error = "Email / Password is / are Wrong/s";
	}

	$req->closeCursor();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="photos/logo.png" type="image/icon type">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Login to Restaurants Finder</title>
</head>
<body>

	<?php
		include("includes/header.php");
	?>

	<nav>
		<div class="form">
			<form method="post" action="">
				<h1>Login</h1>
				
				<?php
					if (isset($error)) {
						echo "<h2 style='color: red; font-family: sans-serif; text-align: center'>" . $error . "</h2>";
					}
				?>
				<label for="em">Email:</label>
				<input type="email" name="email" id="em" placeholder="Write your email..." class="input">
				<label for="ps">Password:</label>
				<input type="password" name="password" id="ps" placeholder="Write your password..." class="input">

				<input type="submit" name="submit" value="Log in" class="button">
			</form>
		</div>
	</nav>
</body>
</html>