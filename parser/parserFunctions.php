<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

function getVoteIDsFromNode($Node, $Text = "")
{
	if ($Node->tagName == null) {
		if (preg_match(
				'/Vote ID: (?<voteIDs>[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12})/',
				$Node->textContent,
				$matches
			) === 1) {
			return $Text . implode(';', array('voteIDs' => $matches['voteIDs'])) . ';';
		}
		return $Text;
	}

	$Node = $Node->firstChild;
	if ($Node != null)
		$Text = getVoteIDsFromNode($Node, $Text);

	while ($Node->nextSibling != null) {
		$Text = getVoteIDsFromNode($Node->nextSibling, $Text);
		$Node = $Node->nextSibling;
	}
	return $Text;
}

function getVoteIDsFromDocument($DOMDoc)
{
	return getVoteIDsFromNode($DOMDoc->documentElement);
}

function getElementsByClassName(&$parentNode, $tagName, $className)
{
	$nodes = array();

	$childNodeList = $parentNode->getElementsByTagName($tagName);
	for ($i = 0; $i < $childNodeList->length; $i++) {
		$temp = $childNodeList->item($i);
		if (stripos($temp->getAttribute('class'), $className) !== false) {
			$nodes[] = $temp;
		}
	}

	return $nodes;
}

function getMessageNumber($DOMDoc)
{
	$nodes = getElementsByClassName($DOMDoc, 'div', 'pagination');
	foreach ($nodes as $node) {
		if (preg_match('/([0-9]+) post/', $node->textContent, $matches) === 1) {
			return intval($matches[1]);
		}
	}
	return 0;
}

function initPagesToParse($Path)
{
	define('MESSAGES_BY_PAGE', 20);
	$Docs[0] = new DOMDocument();
	$Docs[0]->loadHTMLFile($Path);
	$numberOfPages = ceil(getMessageNumber($Docs[0]) / MESSAGES_BY_PAGE);
	error_log('DEBUG: ' . $numberOfPages);
	if ($numberOfPages > 1) {
		for ($i = 1; $i < $numberOfPages; $i++) {
			$startPost = $i * MESSAGES_BY_PAGE;
			$pagesPath = $Path . '&start=' . $startPost;
			$Docs[$i] = new DOMDocument();
			$Docs[$i]->loadHTMLFile($pagesPath);
		}
	}
	return $Docs;
}

function runParser($Path)
{
	$Result = '';
	foreach (initPagesToParse($Path) as $Doc) {
		$pageMatches = getVoteIDsFromDocument($Doc);
		$Result = $Result . $pageMatches;
	}
	if ($Result == '') {
		return FALSE;
	}
	$FileID = uniqid('VoteIDs', FALSE);
	if (file_put_contents('VoteIDs_files/' . $FileID . '.csv', $Result, LOCK_EX) === FALSE) {
		return FALSE;
	}
	return $FileID;
}

?>