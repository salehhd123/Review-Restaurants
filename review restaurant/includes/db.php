<?php

$host = 'localhost';
$db = 'rest';
$login = 'root';
$pass = '';
try {
	$bdd = new PDO('mysql:host=' . $host . ';dbname=' . $db . '', $login, $pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
}

?>