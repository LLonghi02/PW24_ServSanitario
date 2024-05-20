<?php
	$servername= "localhost";
	$username = "servsanitariopw9";
	$dbname= "my_servsanitariopw9";
	$password = null;
	$error = false;
	
	try {
		$conn = new PDO("mysql:host=" . $servername . ";" .	"dbname=" . $dbname, $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	} catch(PDOException$e) {
		echo "<p>DB Error on connection: " . $e->getMessage() . "</p>";
		$error = true;
	}
?>