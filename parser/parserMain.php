<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

include 'parserFunctions.php';

if (!isset($_POST["URL"]) || $_POST["URL"] == null) {
	echo 'REQUEST ERROR';
	exit();
}

$url = $_POST["URL"];

if (($FileID = runParser($url)) === FALSE) {
	echo 'PARSING ERROR';
	exit();
}

echo $FileID;
?>