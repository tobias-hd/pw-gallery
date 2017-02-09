<?php namespace ProcessWire;

// Primary content is the page's body copy
$content = $page->body;

// If the page has children, then render navigation to them under the body.
// See the _func.php for the renderNav example function.
if($page->hasChildren) {
	$content .= renderNavToAlbum($page->children("sort=-date"));
}
