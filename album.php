<?php namespace ProcessWire;

// Primary content is the page's body copy
$content = $page->body;

if($page->image) {
	$image = $page->image;
	$image = $image->width(400);
	$content .= "<img src='$image->url' alt='$image->description' />";
}

// If the page has children, then render navigation to them under the body.
// See the _func.php for the renderNav example function.
if($page->hasChildren("template=album")) {
	$content .= renderNavToAlbum($page->children("template=album"));
}

if($page->hasChildren("template=album-page")) {
	$content .= renderFirstImageNav($page->children("template=album-page"));
}
