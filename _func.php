<?php namespace ProcessWire;

/**
 * /site/templates/_func.php
 *
 * Example of shared functions used by template files
 *
 * This file is currently included by _init.php
 *
 * For more information see README.txt
 *
 */

/**
 * Given a group of pages, render a simple <ul> navigation
 *
 * This is here to demonstrate an example of a simple shared function.
 * Usage is completely optional.
 *
 * @param PageArray $items
 * @return string
 *
 */
function renderNav(PageArray $items) {

	// $out is where we store the markup we are creating in this function
	$out = '';

	// cycle through all the items
	foreach($items as $item) {

		// render markup for each navigation item as an <li>
		if($item->id == wire('page')->id) {
			// if current item is the same as the page being viewed, add a "current" class to it
			$out .= "<li class='current'>";
		} else {
			// otherwise just a regular list item
			$out .= "<li>";
		}

		// markup for the link
		$out .= "<a href='$item->url'>$item->title</a> ";

		// if the item has summary text, include that too
		if($item->summary) $out .= "<div class='summary'>$item->summary</div>";

		// close the list item
		$out .= "</li>";
	}

	// if output was generated above, wrap it in a <ul>
	if($out) $out = "<ul class='nav'>$out</ul>\n";

	// return the markup we generated above
	return $out;
}


/**
 * Given a group of pages, render a <ul> navigation tree
 *
 * This is here to demonstrate an example of a more intermediate level
 * shared function and usage is completely optional. This is very similar to
 * the renderNav() function above except that it can output more than one
 * level of navigation (recursively) and can include other fields in the output.
 *
 * @param array|PageArray $items
 * @param int $maxDepth How many levels of navigation below current should it go?
 * @param string $fieldNames Any extra field names to display (separate multiple fields with a space)
 * @param string $class CSS class name for containing <ul>
 * @return string
 *
 */
function renderNavTree($items, $maxDepth = 0, $fieldNames = '', $class = 'nav') {

	// if we were given a single Page rather than a group of them, we'll pretend they
	// gave us a group of them (a group/array of 1)
	if($items instanceof Page) $items = array($items);

	// $out is where we store the markup we are creating in this function
	$out = '';

	// cycle through all the items
	foreach($items as $item) {

		// markup for the list item...
		// if current item is the same as the page being viewed, add a "current" class to it
		$out .= $item->id == wire('page')->id ? "<li class='current'>" : "<li>";

		// markup for the link
		$out .= "<a href='$item->url'>$item->title</a>";

		// if there are extra field names specified, render markup for each one in a <div>
		// having a class name the same as the field name
		if($fieldNames) foreach(explode(' ', $fieldNames) as $fieldName) {
			$value = $item->get($fieldName);
			if($value) $out .= " <div class='$fieldName'>$value</div>";
		}

		// if the item has children and we're allowed to output tree navigation (maxDepth)
		// then call this same function again for the item's children
		if($item->hasChildren() && $maxDepth) {
			if($class == 'nav') $class = 'nav nav-tree';
			$out .= renderNavTree($item->children, $maxDepth-1, $fieldNames, $class);
		}

		// close the list item
		$out .= "</li>";
	}

	// if output was generated above, wrap it in a <ul>
	if($out) $out = "<ul class='$class'>$out</ul>\n";

	// return the markup we generated above
	return $out;
}


/**
 * Given a group of pages, render a simple <ul> navigation with image
 * @param PageArray $items
 * @return string
 */
function renderNavToAlbum(PageArray $items) {
	// $out is where we store the markup we are creating in this function
	$out = "<div class='w3-row'>";
	// cycle through all the items
	foreach($items as $item) {
		// render markup for each navigation item as an <li>
		//if($item->id == wire('page')->id) {
			// if current item is the same as the page being viewed, add a "current" class to it
			//$out .= "<div class='current w3-card-4 w3-margin-bottom' style='width:30%'>";
		//} else {
			// otherwise just a regular list item
		$out .= "<div class='w3-col s6 m4 l2 w3-card-4 w3-margin-bottom'>";
		//}

		if($item->image) {
			$image = $item->image;
			$image = $image->size(300, 300);
			$out .= "<a href='$item->url'><img src='$image->url' alt='$image->description' title='$image->description' style='width:100%' /></a>";
		}

		$out .=   "<div class='w3-container'>"
				 .      "<h4><a href='$item->url'>$item->title</a></h4>";

		// markup for the link
		//$out .= "<a href='$item->url'>$item->title</a> ";

		// if the item has summary text, include that too
		//if($item->summary) $out .= "<div class='summary'>$item->summary</div>";
    if($item->summary) {
			$out .=   "<p>$item->summary</p>";
		}

		// close the list item
		$out .=   "</div>"
		     .  "</div>";
	}
  $out .= "</div>";

	// if output was generated above, wrap it in a <ul>
	//if($out) $out = "<ul class='nav'>$out</ul>\n";
	// return the markup we generated above
	return $out;
}


/**
 * Given a group of pages, render a button navigation with image
 * @param PageArray $items
 * @return string
 */
function renderButtonImageNav(PageArray $items) {
	// $out is where we store the markup we are creating in this function
	$out = '';
	// cycle through all the items
	foreach($items as $item) {
		// render markup for each navigation item as an <li>
		if($item->id == wire('page')->id) {
			// if current item is the same as the page being viewed, add a "current" class to it
			$out .= "<button class='current' ";
		} else {
			// otherwise just a regular list item
			$out .= "<button ";
		}
		$out .= "type='button' onclick=\"location.href='$item->url'\">";

		if($item->image) {
			$image = $item->image;
			$image = $image->width(200);
			$out .= "<img src='$image->url' alt='$image->description' title='$image->description' /><br>";
		}
		$out .= "'$item->title'";
		// markup for the link
		//$out .= "<a href='$item->url'>$item->title</a> ";

		// if the item has summary text, include that too
		if($item->summary) $out .= "<div class='summary'>$item->summary</div>";

		// close the list item
		$out .= "</button>";
	}

	// if output was generated above, wrap it in a <ul>
	//if($out) $out = "<ul class='nav'>$out</ul>\n";
	// return the markup we generated above
	return $out;
}


/**
 * Given a group of pages, render a simple <ul> navigation with first image of an array of images
 * @param PageArray $items
 * @return string
 */
function renderFirstImageNav(PageArray $items) {
	// $out is where we store the markup we are creating in this function
	$out = '';
	// cycle through all the items
	foreach($items as $item) {
		// render markup for each navigation item as an <li>
		if($item->id == wire('page')->id) {
			// if current item is the same as the page being viewed, add a "current" class to it
			$out .= "<li class='current'>";
		} else {
			// otherwise just a regular list item
			$out .= "<li>";
		}

		if(count($item->images)) {
			$image = $item->images->first;
			$image = $image->width(200);
			$out .= "<img src='$image->url' alt='$image->description' title='$image->description' />";
		}

		// markup for the link
		$out .= "<a href='$item->url'>$item->title</a> ";

		// if the item has summary text, include that too
		if($item->summary) $out .= "<div class='summary'>$item->summary</div>";

		// close the list item
		$out .= "</li>";
	}

	// if output was generated above, wrap it in a <ul>
	if($out) $out = "<ul class='nav'>$out</ul>\n";
	// return the markup we generated above
	return $out;
}
