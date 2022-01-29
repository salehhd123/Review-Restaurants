<?php
	
	if (!isset($_SESSION['id'])) {
		?>
			<header>
				<div class="left">
					<a href="index.php">
						<img src="photos/logo.png">
					</a>
				</div>
				<div class="right">
					<div class="btn">
						<a href="login.php">Login</a>
					</div>
					<div class="btn">
						<a href="register.php">Register</a>
					</div>
					<div class="btn">
						<a href="search.php">Search</a>
					</div>
				</div>
			</header>
		<?php
	}elseif ($_SESSION["type"] == "user") {
		?>
			<header>
				<div class="left">
					<a href="index.php">
						<img src="photos/logo.png">
					</a>
				</div>
				<div class="right">
					<div class="btn">
						<a href="search.php">Search</a>
					</div>
					<div class="btn">
						<a href="logout.php">Logout</a>
					</div>
				</div>
			</header>
		<?php
	}elseif ($_SESSION["type"] == "admin") {
		?>
			<header>
				<div class="left">
					<a href="index.php">
						<img src="photos/logo.png">
					</a>
				</div>
				<div class="right">
					<div class="btn">
						<a href="dashboard.php">Dashboard</a>
					</div>
					<div class="btn">
						<a href="logout.php">Logout</a>
					</div>
				</div>
			</header>
		<?php
	}

?>
