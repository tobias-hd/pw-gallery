<?php namespace ProcessWire;

// home.php (homepage) template file.
// See README.txt for more information

// Primary content is the page body copy and navigation to children.
// See the _func.php file for the renderNav() function example
$content = $page->body . renderNav($page->children);

$content .= "<h2>Neue Alben</h2>";
$content .= "<span class='w3-bar'>"
         .   "<button class='w3-bar-item w3-button w3-right w3-hover-light-blue w3-light-grey'>angelegt</button>"
         .   "<button class='w3-bar-item w3-button w3-right w3-hover-light-blue w3-light-grey'>geändert</button>"
         .   "<a class='w3-bar-item w3-button w3-right w3-hover-light-blue w3-blue' href='$page->url'>Referenz-Datum</a>"
         .   "<span class='w3-bar-item w3-right'>Sortierung: </span>"
         . "</span>";
$content .= renderAlbumList($page->find("template=album,sort=-date,limit=20"));
