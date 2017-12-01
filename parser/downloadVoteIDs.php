<?php
if (!isset($_GET["FileID"])) {
	echo 'ERROR';
	exit();
}

$FileID = $_GET["FileID"];
$FilePath = 'VoteIDs_files/' . $FileID . '.csv';

if (!file_exists($FilePath)) {
	echo 'ERROR';
	exit();
}

date_default_timezone_set('UTC');
header('Cache-Control: public');
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename=Vote_ID-'.date("Y-m-d_H-i-s").'.csv');
header('Content-Type: text/csv');
header('Content-Transfer-Encoding: binary');
/*actually download*/
readfile($FilePath);

/*delete the file since you said temporally*/
unlink($FilePath);
return "";
?>