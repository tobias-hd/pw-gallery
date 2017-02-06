<?php namespace ProcessWire;

// basic-page.php template file
// See README.txt for more information

// Primary content is the page's body copy
$content = $page->body;

// If the page has children, then render navigation to them under the body.
// See the _func.php for the renderNav example function.
if($page->hasChildren) {
	$content .= renderNav($page->children);
}

// if the rootParent (section) page has more than 1 child, then render
// section navigation in the sidebar
if($page->rootParent->hasChildren > 1) {
	$sidebar = renderNavTree($page->rootParent, 3) . $page->sidebar;
}

if(count($page->images)) {
	/*
	// if the page has images on it, grab one of them randomly...
	$image = $page->images->getRandom();
	// resize it to 400 pixels wide
	$image = $image->width(400);
	// output the image at the top of the sidebar...
	$content .= "<img src='$image->url' alt='$image->description' />";
	// ...and append sidebar text under the image
	//$sidebar .= $page->sidebar;
*/
	$content .= "<div class='my-gallery' itemscope itemtype='http://schema.org/ImageGallery'>";

	$index = 0;
	foreach($page->images as $key=>$image) {
	  $thumbnail = $image->size(150,100);
	  //$content .= "<p><a href='{$image->url}'><img src='{$thumbnail->url}' alt='{$thumbnail->description}' ></a></p>";
		$content .= "<figure itemprop='associatedMedia' itemscope itemtype='http://schema.org/ImageObject'>"
	           .  "<a href='{$image->url}' itemprop='contentUrl' data-size='{$image->width}x{$image->height}' data-index='{$index}'>"
	           .     "<img src='{$thumbnail->url}' itemprop='thumbnail' alt='{$thumbnail->description}' />"
	           .   "</a>"
	           .   "<figcaption itemprop='caption description'>{$image->description}</figcaption>"
	           . "</figure>";
	  $index++;
	}
	$content .= "</div>";
}

if(count($page->videos)) {
	$video = $page->videos->first();
	//$content .= "<br><a href='$video->url'>$video->description</a>";
	$content .= "<br><video width='320' height='240' controls><source src='$video->url' type='video/mp4'>Your browser does not support the video tag.</video>";
}
