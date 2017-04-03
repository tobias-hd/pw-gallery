<?php namespace ProcessWire;

// Primary content is the page's body copy
$content = $page->body;

if($page->hasChildren) {
	$content .= renderNavToAlbum($page->children("sort=-date"));
}
