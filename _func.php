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
  $out = "<div class='w3-row'>";
  // cycle through all the items
  foreach($items as $item) {
    $out .= "<div class='w3-col s6 m4 l3 w3-margin-bottom w3-padding-small'>"
         .    "<div class='w3-card-8'>";

    if(count($item->images)) {
      $image = $item->images->first;
      $image = $image->size(350, 350);
      $out .=   "<a href='$item->url'><img src='$image->url' alt='$image->description' title='$image->description' style='width:100%' /></a>";
    }

    $out .=     "<div class='w3-container'>"
         .        "<h4><a href='$item->url'>$item->title</a></h4>";

    if($item->summary) {
      $length = strlen($item->summary);
      // if summary is too long, only display its first characters, and add a tooltip
      // with the full text
      if ($length > 25) {
        $beginning_of_summary = substr($item->summary, 0, 24) . "...";
        $out .=   "<p class='w3-tooltip'>$beginning_of_summary"
             .    "<span class='albumsummary-tooltip w3-text w3-tag'>$item->summary</span></p>";
      } else {
        $out .=   "<p>$item->summary</p>";
      }

    } else {
      // non-breaking space, to add empty line
      $out .=     "<p>&nbsp</p>";
    }

    $out .=     "</div>"
         .    "</div>"
         .  "</div>";
  }
  $out .= "</div>";

  return $out;
}

function renderAlbumList(PageArray $items) {
  $out = "<ul class='w3-ul w3-card-4 w3-hoverable w3-row'>";

  foreach($items as $item) {
    $out .= "<li class='resp-listitem-w-image'>";

    // first column
    if(count($item->images)) {
      $image = $item->images->first;
      $image = $image->size(350,150);
      $out .= "<div class='w3-third w3-container'>"
           .    "<a href='$item->url'><img src='$image->url' alt='$image->description' title='$image->description' style='width:100%' /></a>"
           .  "</div>";
    }

    // second column
    $out .= "<div class='w3-third w3-container'>"
         .    "<h4><a href='$item->url'>$item->title</a></h4>"
         .    "<p>$item->summary</p>"
         .  "</div>";

    // third column
    $out .= "<div class='w3-third w3-container'>"
         .    "<i>Referenz-Datum:</i> $item->date<br>"
         .    "<i>angelegt:</i> " . date("d.n.Y, H:i:s", $item->created) . " Uhr<br>"
         .    "<i>zuletzt geändert:</i> " . date("d.n.Y, H:i:s", $item->modified) . " Uhr<br>"
         .    count($item->images) . " Bild";
    if (count($item->images) > 1) {
      $out .= "er";
    }
    $out .=   "<br>" . count($item->videos) . " Video";
    if (count($item->videos) > 1) {
      $out .= "s";
    }
    $out .=  "</div>"
         . "</li>";
  }
  $out .= "</ul>";

  return $out;
}
