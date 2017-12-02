<!DOCTYPE html>
<html>
<head>
	<title>ISML Vote-IDs Parser</title>
	<meta charset="utf-8">
	<meta name="description" content="ISML Vote-IDs parser and result downloader">
	<meta name="author" content="Brean2010">
</head>
<body>
<div id="ISML_VoteID_Parser">
	<h1>ISML Vote-IDs Parser</h1>
	<div id="Tool">
		<script type="text/javascript" src="resources/index.js"></script>
		<h2>Parser:</h2>
		<form id="Parser_Form" method="POST" onsubmit="sendUrlToParser(); return false;">
			<label for="URL">URL from ISML forum: </label>
			<input type="text" id="URL" name="URL" title="URL from ISML forum:"/>
			<input type="submit" id="submit_URL" value="Parse"/>
		</form>
	</div>
	<div id="Result">
		<h2>Result:</h2>
	</div>
	<div id="Source_Code">
		<h2>Source code:</h2>
		<a href="https://github.com/Brean2010/ISML_VoteID_Parser">https://github.com/Brean2010/ISML_VoteID_Parser</a> (In case of error, use copy paste)
	</div>
</div>
</body>
</html>