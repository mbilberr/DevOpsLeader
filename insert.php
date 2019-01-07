<?php

include('db_info.php');

try {
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$stmt = $conn->prepare("INSERT INTO users (username, password, email, hash) VALUES (:username, :password, :email, :hash)");
	$stmt->bindParam(':username', $username);
	$stmt->bindParam(':password', $password);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':hash', $hash);

	$username = $_POST["username"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	$hash = md5( rand(0,1000) );
	$stmt->execute();
	echo "Record successfully inserted";
	include ('index.html');
}
catch (PDOException $e) {
	echo "Error: " . $e->getMessage();
}
$conn = null;
header('Location: verification.php');
?>
