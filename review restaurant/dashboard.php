<?php

session_start();
if (!isset($_SESSION['id']) or $_SESSION['type'] != "admin") {
	header("location: login.php");
	exit();
}

include("includes/db.php");

if (isset($_POST["delete"])) {
	$req = $bdd->prepare('DELETE FROM restaurant WHERE admin_id = :id');
	$req->execute(array(
		"id" => $_SESSION["id"]
	));

	$req->closeCursor();

	header("location: dashboard.php");
}

if (isset($_POST['submit'])) {
	$name = $_POST["name"];
	$location_real = $_POST["location_real"];
	$location_imag = $_POST["location_imag"];
	$menu = $_POST["menu"];
	$description = $_POST["description"];
	$photos = array("","","","","");


	for ($i=0; $i < 5; $i++) {
		if ($_FILES['photos']["name"][$i] != "") {
			$file = (string) count(glob("photos/rests/*.*")) + 1;
			$file .= ".jpg";

			move_uploaded_file($_FILES['photos']["tmp_name"][$i], 'photos/rests/' . $file);

		}else {
			$file = "";
		}
		$photos[$i] = $file;
		
	}

	
	$check = $bdd->prepare("SELECT * FROM restaurant WHERE admin_id = :id");
	$check->execute(array("id" => $_SESSION["id"]));

	if ($check->rowCount() == 0) {
		$req = $bdd->prepare("INSERT INTO restaurant (admin_id, name, description, location_real, location_imag, photos, menu) VALUES (:id, :n, :d, :lr, :li, :p, :m)");
		$photos_res = implode("||", $photos);
	}else {
		$req = $bdd->prepare("UPDATE restaurant set name = :n, description =:d, location_real = :lr, location_imag=:li, photos = :p, menu = :m WHERE admin_id = :id");

		$old = explode("||", $check->fetch()["photos"]);
		$photos_res = $photos;

		foreach ($photos_res as $key => $value) {
			if ($value == "") {
				$photos_res[$key] = $old[$key];
			}
		}
		$photos_res = implode("||", $photos_res);
	}
	$check->closeCursor();

	$req->execute(array(
		"id" => $_SESSION["id"],
		"n" => $name,
		"d" => $description,
		"lr" => $location_real,
		"li" => $location_imag,
		"p" => $photos_res,
		"m" => $menu
	));

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
	<title>Dashboard of Restaurants Finder</title>
</head>
<body>

	<?php
		include("includes/header.php");
	?>

	<nav>
		<?php

			$req = $bdd->prepare("SELECT * FROM restaurant WHERE admin_id = :id");
			$req->execute(array(
				"id" => $_SESSION["id"]
			));

			if ($req->rowCount() == 1) {
				while ($info = $req->fetch()) {
					$id = $info["id"];
					$name = $info["name"];
					$menu = $info["menu"];
					$description = $info["description"];
					$location_real = $info["location_real"];
					$location_imag = $info["location_imag"];
					$photos = explode("||", $info["photos"]);
				}
			}else{
				$id = "";
				$name = "";
				$menu = "";
				$description = "";
				$location_real = "";
				$location_imag = "";
				$photos = array("","","","","");
			}

			$req->closeCursor();

		?>
		<div class="form">
			<form method="post" action="" enctype="multipart/form-data">
				<h1>Restaurant Informations</h1>
				<?php
				if ($id != '') {
					echo "<h2><a href='restaurants.php?id=" . $id . "'>Restaurant Link</a></h2>";
				}
				?>
				

				<label for="rn">Restaurant name:</label>
				<input type="text" name="name" id="rn" required placeholder="Write restaurant name..." class="input" <?php
				if ($name != '') {
					echo "value='" . $name . "'";
				}
				?>>
				<label for="des">Restaurants description:</label>
				<textarea id="des" name='description' required placeholder="Write restaurant description..." class="input" style="height: 10em;"><?php
				if ($description != '') {
					echo $description;
				}
				?></textarea>
				<label>Write restaurant location, or get current location:</label>
				<br>
				<div>
					<input type="button" class="button" id="bl" value="Get current" >
					<input type="text" name="location_real" class="input" style="width: auto;" required placeholder="Write longtitude..." id="real"<?php
				if ($location_real != '') {
					echo "value='" . $location_real . "'";
				}
				?>>
					<input type="text" name="location_imag" class="input" style="width: auto;" required placeholder="Write latitide..." id="imag"<?php
				if ($location_imag != '') {
					echo "value='" . $location_imag . "'";
				}
				?>>
				</div>
				<br>
				<label for="mn">Restaurants menu:</label>
				<textarea id="mn" name="menu" required placeholder="Write restaurant menu..." class="input" style="height: 10em;"><?php
				if ($menu != '') {
					echo $menu;
				}
				?></textarea>
				
				<label>Restaurants Photos:</label>
				<div>
					<?php 
						foreach ($photos as $key => $photo) {
							?>
								<input type="file" name="photos[<?php echo $key;?>]"><?php
								if ($photo != '') {
									echo "<a href='photos/rests/" . $photo . "' target='_blank'>Current photo</a>";
								}
								?><br>
							<?php
						}
					?>
				</div>
				<br>

				<input type="submit" name="submit" value="Save" class="button">
			</form>
			<form method="post" action="">
				<br><br>
				<input type="submit" name="delete" value="Delete" class="button" style="background-color: red;">
				
			</form>
		</div>
	</nav>
	<script type="text/javascript">
		var sel = document.getElementById('bl');

		sel.onclick = function(){
			navigator.geolocation.getCurrentPosition(savegeo);
		}

		function savegeo(pos) {
			document.getElementById('real').value = pos.coords.longitude
			document.getElementById('imag').value = pos.coords.latitude

		}
	</script>
</body>
</html>