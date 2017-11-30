<?php
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