<?php

session_start();


include("includes/db.php");

function deg_to_km($x, $y)
{
	return array(
		$y*110.574,
		$x*(111.32*cos(($y*pi())/180))
	);
}

function module($x1, $x2, $y1, $y2)
{
	#لوجود معلم متعامد ومتجانس
	# لأن cos(pi/2) = 0
	return sqrt(pow(($x1 - $x2), 2) + pow(($y1 - $y2), 2));
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="photos/logo.png" type="image/icon type">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Search in Restaurants Finder</title>
	<style type="text/css">
		section{
			justify-content: center;
		}
	</style>
</head>
<body>

	<?php
		include("includes/header.php");
	?>

	<nav>
		<div class="form">
			<form method="get" action="">
				<h1>Search</h1>

				<label for="sp">Food in menu:</label>
				<input type="text" name="food" id="sp" placeholder="Write food name..." class="input">
				<label for="lr">Location range (km):</label>
				<input type="number" name="location" id="lr" placeholder="Select location max range by km" class="input">
				<input type="hidden" name="geolocation" id="geo">
				<label for="rs">Minimum average rating stars:</label>
				<select name="stars" class="input" id="rs">
					<option selected value="0">-- -- --</option>
					<option value="1">1 Star</option>
					<option value="2">2 Stars</option>
					<option value="3">3 Stars</option>
					<option value="4">4 Stars</option>
					<option value="5">5 Stars</option>
				</select>

				<input type="submit" name="submit" value="Search" class="button">
			</form>
		</div>
	</nav>
	<section>
		<?php

			$sql = "SELECT * FROM restaurant WHERE 1=1";
			$exec = array();

			if (isset($_GET['food']) and strlen(trim($_GET['food'])) > 0) {
				$sql .= ' AND (menu LIKE "%":food"%" or name LIKE "%":food"%" or description LIKE "%":food"%")';
				$exec["food"] = $_GET['food'];
			}

			$req = $bdd->prepare($sql);
			$req->execute($exec);

			while ($info = $req->fetch()) {
				if (isset($_GET["location"], $_GET['geolocation']) and (int) $_GET["location"] <> null and !in_array($_GET['geolocation'], array("", "||"))) {
					
					$rest_loc = deg_to_km($info["location_real"], $info["location_imag"]);
					$current_loc = deg_to_km(explode("||", $_GET['geolocation'])[0], explode("||", $_GET['geolocation'])[1]);

					$dist = module(
						$rest_loc[0],
						$current_loc[0],

						$rest_loc[1],
						$current_loc[1]
					);

					if ($dist > (int) $_GET["location"]) {
						continue;
					}
				}

				if (isset($_GET["stars"]) and (int) $_GET["stars"] <> null) {
					$stars = (int) $_GET["stars"];

					$check = $bdd->prepare("SELECT AVG(star) as m FROM reviews WHERE restaurant_id = :id");
					$check->execute(array(
						"id" => $info["id"]
					));

					if ($check->fetch()["m"] < $stars) {
						$check->closeCursor();
						continue;
					}

					$check->closeCursor();
				}
				?>

					<div class="poster">
						<div class="poster_img">
							<img src="photos/rests/<?php echo explode("||", $info["photos"])[0] ?>">
						</div>
						<div class="poster_desc">
							<h1><?php echo $info["name"]; ?></h1>
							<p><?php echo $info["description"]; ?></p>
							<?php
								if (isset($dist)) {
									echo '<p style="color:#5c5c5c">' . round($dist) . 'km away</p>';
								}
							?>
							<button class="button"><a href="restaurants.php?id=<?php echo $info["id"]; ?>">Info</a></button>
						</div>
					</div>

				<?php
			}

			$req->closeCursor();

		?>
		
	</section>
	<script type="text/javascript">
		var sel = document.getElementById('lr');
		var geo = document.getElementById('geo');

		sel.oninput = function(){
			navigator.geolocation.getCurrentPosition(savegeo);
		}

		function savegeo(pos) {
			res = pos.coords.longitude + "||" + pos.coords.latitude;
			geo.value = res
		}
	</script>
</body>
</html>