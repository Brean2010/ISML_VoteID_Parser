<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

function getTextFromNode($Node, $Text = "")
{
	if ($Node->tagName == null)
		return $Text . $Node->textContent;

	$Node = $Node->firstChild;
	if ($Node != null)
		$Text = getTextFromNode($Node, $Text);

	while ($Node->nextSibling != null) {
		$Text = getTextFromNode($Node->nextSibling, $Text);
		$Node = $Node->nextSibling;
	}
	return $Text;
}

function getTextFromDocument($DOMDoc)
{
	return getTextFromNode($DOMDoc->documentElement);
}

$Doc = new DOMDocument();
$Doc->loadHTMLFile("ISML.html");
echo getTextFromDocument($Doc) . "\n";
?>