<?php

session_start();
if (isset($_SESSION['id'])) {
	header("location: index.php");
	exit();
}

include("includes/db.php");

if (isset($_POST['submit'])) {
	$name = $_POST["name"];
	$email = $_POST["email"];
	$password1 = $_POST["password"];
	$password2 = $_POST["password1"];
	$type = $_POST["type"];

	if ($password1 === $password2) {
		$password = sha1($password1);
		if (in_array($type, array("user", "admin"))) {
			$req = $bdd->prepare("SELECT * FROM users WHERE email = :em");
			$req->execute(array("em" => $email));

			if ($req->rowCount() == 0) {
				$req1 = $bdd->prepare("INSERT INTO users (name, email, password, type) VALUES (:n, :e, :p, :t)");
				$req1->execute(array(
					"n" => $name,
					"e" => $email,
					"p" => $password,
					"t" => $type
				));

				$req1->closeCursor();

				#get info

				$req1 = $bdd->prepare("SELECT * FROM users WHERE email = :em");
				$req1->execute(array("em" => $email));

				$_SESSION['id'] = $req1->fetch()["id"];
				$_SESSION["type"] = $type;
				$_SESSION["email"] = $email;
				$_SESSION["name"] = $name;

				$req1->closeCursor();


				header("location: index.php");
			}else {
				$error = "Email already exists!";
			}

			$req->closeCursor();
		}else {
			$error = "Not a valid type!";
		}
	}else{
		$error = "Passwords does not match!";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="photos/logo.png" type="image/icon type">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Register to Restaurants Finder</title>
</head>
<body>

	<?php
		include("includes/header.php");
	?>

	<nav>
		<div class="form">
			<form method="post" action="">
				<h1>Register</h1>

				<?php
					if (isset($error)) {
						echo "<h2 style='color: red; font-family: sans-serif; text-align: center'>" . $error . "</h2>";
					}
				?>
				<label for="nm">Name:</label>
				<input type="text" name="name" class="input" placeholder="Write your name..." id="nm">
				<label for="em">Email:</label>
				<input type="email" name="email" id="em" placeholder="Write your email..." class="input">
				<label for="ps">Password:</label>
				<input type="password" name="password" id="ps" placeholder="Write your password..." class="input">
				<label for="ps1">Confirme the password:</label>
				<input type="password" name="password1" id="ps1" placeholder="Confirme your password..." class="input">
				<label for="tp">Type of user:</label>
				<div>
					<input type="radio" name="type" value="user" id="user">
					<label for="user">Customer</label>
				</div>
				<div>
					<input type="radio" name="type" value="admin" id="admin">
					<label for="admin">Restaurants owner</label>
				</div>
				<br>
				<input type="submit" name="submit" value="Register" class="button">
			</form>
		</div>
	</nav>
</body>
</html>