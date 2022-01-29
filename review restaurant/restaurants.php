<?php

session_start();
include("includes/db.php");

if (isset($_SESSION['id'])) {
	if (isset($_POST["submit"])) {
		$review = $_POST['review'];
		$star = (int) $_POST["stars"];

		$req = $bdd->prepare("INSERT INTO reviews (restaurant_id, user_id, review, star) VALUES (:rid, :id, :r, :s)");
		$req->execute(array(
			"rid" => $_GET["id"],
			"id" => $_SESSION['id'],
			"r" => $review,
			"s" => $star
		));


		$req->closeCursor();

		header("location: restaurants.php?id=".$_GET['id']);
		exit();
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
	<title>Restaurants Finder</title>
</head>
<body>

	<?php
		include("includes/header.php");

		$req = $bdd->prepare("SELECT * FROM restaurant WHERE id = :id");
		$req->execute(array(
			"id" => $_GET['id']
		));

		if ($req->rowCount() == 1) {
			while ($info = $req->fetch()) {
				$photos = array_filter(explode("||", $info["photos"]));
				?>

				<nav>
					<h1 class="middle"><?php echo $info["name"]; ?></h1>
				</nav>

				<section>

				<?php

				if (isset($photos[0])) {
					?>
						<div class="gallery photo">
							<img src="photos/rests/<?php echo $photos[0]; ?>">
						</div>
					<?php
				}

				?>
					<div class="gallery description">
						<p>
							<?php
								echo $info["description"];
							?>
						</p>
						<br>
						<a href="https://www.google.com/maps/@<?php echo $info["location_real"] . "," . $info["location_imag"]; ?>,15z" class="button" target="_blank">Location</a>
					</div>
					<div class="gallery description">
						<h1>Menu</h1>
						<ul>
							<?php

							foreach (explode("\n", $info["menu"]) as $line) {
								echo '<li>' . $line . '</li>';
							}

							?>
						</ul>
					</div>

				<?php

				for ($i=1; $i < count($photos); $i++) { 
					?>
						<div class="gallery photo">
							<img src="photos/rests/<?php echo $photos[$i]; ?>">
						</div>
					<?php
				}
			}
		}else {
			header("location: index.php");
		}

		$req->closeCursor();

	?>
	</section>
	<nav class="second">
		<div class="reviews">
			<?php

				if (isset($_SESSION["id"])) {
					?>
						<div class="review">
							<form method="post" action="">
								<textarea placeholder="Write review" name="review" class="input"></textarea>
								<select name="stars">
									<option value="1">1 Star</option>
									<option value="2">2 Stars</option>
									<option value="3">3 Stars</option>
									<option value="4">4 Stars</option>
									<option value="5" selected>5 Stars</option>
								</select>

								<input type="submit" name="submit" value="Review" class="button">
							</form>
						</div>
					<?php
				}
				

			$req = $bdd->prepare("SELECT review, star, name FROM reviews LEFT JOIN users on reviews.user_id = users.id WHERE restaurant_id = :id");
			$req->execute(array(
				"id" => $_GET["id"]
			));

			while($info = $req->fetch()){
				?>
					<div class="review">
					<h1><?php echo $info["name"] ?></h1>
					<h2>(<?php echo $info["star"] ?>) Stars</h2>
					<p><?php echo $info["review"] ?></p>
				</div>
				<?php
			}

			$req->closeCursor();

			?>
		</div>
	</nav>
</body>
</html>