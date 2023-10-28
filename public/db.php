<?php

$host = "mysql"; //nombre del contenedor
$user = "root";
$pass = "root";
$dbname = "test";

$dsn = "mysql:host=$host;dbname=$dbname";

try {
	$pdo = new PDO($dsn, $user, $pass);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$stmt = $pdo->prepare("SELECT * FROM names LIMIT 5");
$stmt->execute();
while ($row = $stmt->fetch()) {
	echo $row['name']."<br />\n";
}

$pdo = null;
