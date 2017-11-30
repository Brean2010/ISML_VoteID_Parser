<!DOCTYPE html>
<html>
<head>
	<title>ISML Vote-IDs Parser</title>
	<meta charset="utf-8">
	<meta name="description" content="ISML Vote-IDs parser and result downloader">
	<meta name="author" content="Brean2010">

	<script type="text/javascript">
		"use strict";

		Element.prototype.remove = function() {
			this.parentElement.removeChild(this);
		}
		NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
			for(var i = this.length - 1; i >= 0; i--) {
				if(this[i] && this[i].parentElement) {
					this[i].parentElement.removeChild(this[i]);
				}
			}
		}

		function sendUrlToParser() {
			var handleResponse = function (status, response) {
				document.getElementById("loading_image").remove();
				document.getElementById("submit_URL").removeAttribute("disabled");
				if(response == "REQUEST ERROR"){
					alert("REQUEST ERROR: check your URL");
					return false;
				}
				if(response == "PARSING ERROR"){
					alert("PARSING ERROR: check your URL");
					return false;
				}
				var id;
				if((id = document.getElementById("result_download")) != null){
					id.remove();
				}

				var aResult = document.createElement("a");
				aResult.setAttribute("href", "downloadVoteIDs.php?FileID=" + response);
				aResult.setAttribute("id", "result_download");
				aResult.innerHTML = "Download Vote-IDs";
				var elementResult = document.getElementById("result");
				elementResult.appendChild(aResult);
				return true;
			}

			var handleStateChange = function () {
				switch (xmlhttp.readyState) {
					case 0 : // UNINITIALIZED
					case 1 : // LOADING
					case 2 : // LOADED
					case 3 : // INTERACTIVE
						break;
					case 4 : // COMPLETED
						handleResponse(xmlhttp.status, xmlhttp.responseText);
						break;
					default:
						alert("error");
				}
			}

			document.getElementById("submit_URL").setAttribute("disabled", "");
			var loadingImage = document.createElement("img");
			loadingImage.setAttribute("src", "ressources/loading.gif");
			loadingImage.setAttribute("alt", "Loading");
			loadingImage.setAttribute("width", "32");
			loadingImage.setAttribute("height", "32");
			loadingImage.setAttribute("id", "loading_image");
			document.getElementById("parser").appendChild(loadingImage);

			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = handleStateChange;
			xmlhttp.open("POST", "parserMain.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("URL=" + encodeURIComponent(document.getElementById("URL").value));
		}
	</script>
</head>

<body>
<h1>ISML Vote-IDs Parser</h1>
<h2>Parser:</h2>
<form id ="parser" method="POST" onsubmit="sendUrlToParser(); return false;">
	<label for="URL">URL from ISML forum</label>
	<input type="text" id="URL" name="URL" title="URL from ISML forum:"/>
	<input type="submit" id="submit_URL" value="Parse"/>
</form>
<h2>Result:</h2>
<div id="result"></div>
</body>
</html>