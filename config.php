<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'RbexTSE2zqdSL9');
define('DB_NAME', 'Code Explorer');

try{
	$pdo = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOEXCEPTION $e){
	echo 'Exception -> ';
	var_dump($e->getMessage());
	die("ERROR: Could not connect ".$e->getMessage());
}
?>
