<?php namespace ProcessWire;

// Primary content is the page's body copy
$content = $page->body;

// if($page->image) {
// 	$image = $page->image;
// 	$image = $image->width(400);
// 	$content .= "<img src='$image->url' alt='$image->description' />";
// }

// If the page has children, then render navigation to them under the body.
// See the _func.php for the renderNav example function.
if($page->hasChildren("template=album")) {
	$content .= "<h2>Alben</h2>";
	$content .= renderNavToAlbum($page->children("template=album"));
}

// image gallery
if(count($page->images) > 1) {
	$content .= "<div class='my-gallery w3-row' itemscope itemtype='http://schema.org/ImageGallery'>";

	$index = 0;
	foreach($page->images as $image) {
	  $thumbnail = $image->size(250,167);
		$content .= "<figure class='w3-col s6 m3 l2 w3-margin-0' itemprop='associatedMedia' itemscope itemtype='http://schema.org/ImageObject'>"
	           .    "<a href='{$image->url}' itemprop='contentUrl' data-size='{$image->width}x{$image->height}' data-index='{$index}'>"
	           .      "<img src='{$thumbnail->url}' itemprop='thumbnail' alt='{$thumbnail->description}' style='width:100%' />"
	           .    "</a>"
	           .    "<figcaption itemprop='caption description'>{$image->description}</figcaption>"
	           . "</figure>";
	  $index++;
	}
	$content .= "</div>";
}

// videos
if(count($page->videos)) {
	$content .= "<h2>Videos</h2>"
           .  "<div class='w3-row'>";

	foreach($page->videos as $video) {
		$content .= "<p class='w3-col s12 m6 l4'>"
						 .    "<video width='320' height='240' controls><source src='$video->url' type='video/$video->ext'>Your browser does not support the video tag.</video>"
						 .  "</p>";
	}
	$content .= "</div>";
}
