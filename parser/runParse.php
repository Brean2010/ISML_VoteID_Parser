<?php
	include 'parser.php';
	if(runParser('http://www.internationalsaimoe.com/forum/viewtopic.php?f=8&t=8352') === FALSE){
		echo 'ERROR';
	}
?>