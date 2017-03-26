<?php namespace ProcessWire;

/**
 * _main.php
 * Main markup file
 *
 * This file contains all the main markup for the site and outputs the regions
 * defined in the initialization (_init.php) file. These regions include:
 *
 *   $title: The page title/headline
 *   $content: The markup that appears in the main content/body copy column
 *   $sidebar: The markup that appears in the sidebar column
 *
 * Of course, you can add as many regions as you like, or choose not to use
 * them at all! This _init.php > [template].php > _main.php scheme is just
 * the methodology we chose to use in this particular site profile, and as you
 * dig deeper, you'll find many others ways to do the same thing.
 *
 * This file is automatically appended to all template files as a result of
 * $config->appendTemplateFile = '_main.php'; in /site/config.php.
 *
 * In any given template file, if you do not want this main markup file
 * included, go in your admin to Setup > Templates > [some-template] > and
 * click on the "Files" tab. Check the box to "Disable automatic append of
 * file _main.php". You would do this if you wanted to echo markup directly
 * from your template file or if you were using a template file for some other
 * kind of output like an RSS feed or sitemap.xml, for example.
 *
 * See the README.txt file for more information.
 *
 */
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $title; ?></title>
  <meta name="description" content="<?php echo $page->summary; ?>" />
  <link href='//fonts.googleapis.com/css?family=Lusitana:400,700|Quattrocento:400,700' rel='stylesheet' type='text/css' />
  <!--
  <link rel="stylesheet" type="text/css" href="<?php echo $config->urls->templates?>styles/main-orig.css" />
  -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates?>styles/w3.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $config->urls->templates?>styles/main.css" />
</head>
<body class="<?php if($sidebar) echo "has-sidebar "; ?>">

  <!-- top navigation -->
  <!-- Header -->
  <header class="w3-display-container w3-content" style="max-width:1500px">
    <img class="w3-image" src="<?php echo $config->urls->templates?>img/HeidelbergImDunst2015_0022_web-header.jpg" alt="Heidelberg" width="1500" height="335">
    <div class="header-text w3-display-middle w3-padding-xlarge w3-border w3-text-shadow w3-text-light-grey w3-center">
      <h1 class="w3-hide-medium w3-hide-small w3-xxlarge">HEIDELBERGER MUNKS</h1>
      <h3 class="w3-hide-large" style="white-space:nowrap">HEIDELBERGER MUNKS</h3>
      <h3 class="w3-hide-medium w3-hide-small">Familienalbum</h3>
    </div>

    <!-- Navbar (placed at the bottom of the header image) -->
    <div class="w3-navbar w3-light-grey w3-round w3-display-bottommiddle w3-hide-small" style="bottom:-16px"><?php
      // top navigation consists of homepage and its visible children
      foreach($homepage->and($homepage->children) as $item) {
        echo "<a class='";
        if($item->id == $page->rootParent->id) {
          echo "w3-blue ";
        }
        echo "w3-bar-item w3-button w3-hover-light-blue' href='$item->url'>$item->title</a>";
      }
      // output an "Edit" link if this page happens to be editable by the current user
      if($page->editable()) echo "<a class='w3-bar-item w3-button w3-hover-light-blue' href='$page->editUrl'>Edit</a>";
    ?></div>
  </header>

  <!-- Navbar on small screens -->
  <ul class="w3-navbar w3-light-grey w3-hide-large w3-hide-medium"><?php
    // top navigation consists of homepage and its visible children
    foreach($homepage->and($homepage->children) as $item) {
      echo "<li><a class='";
      if($item->id == $page->rootParent->id) {
        echo "w3-blue ";
      }
      echo "w3-bar-item w3-button w3-hover-light-blue' href='$item->url'>$item->title</a></li>";
    }
    // output an "Edit" link if this page happens to be editable by the current user
    if($page->editable()) echo "<li><a class='w3-bar-item w3-button w3-hover-light-blue' href='$page->editUrl'>Edit</a></li>";
  ?></ul>

  <div id='main' class='w3-container w3-padding-8'>

    <div class="w3-row w3-padding-12">
      <!-- breadcrumbs -->
      <div class='breadcrumbs w3-threequarter w3-padding-8'><?php
        // breadcrumbs are the current page's parents
        foreach($page->parents() as $item) {
          echo "<span><a href='$item->url'>$item->title</a></span> ";
        }
        // optionally output the current page as the last item
        echo "<span>$page->title</span> ";
      ?></div>

      <!-- search form-->
      <form class='search w3-quarter' action='<?php echo $pages->get('template=search')->url; ?>' method='get'>
        <input type='text' name='q' class='w3-input w3-animate-input search' style='width:30%' placeholder='Search' value='<?php echo $sanitizer->entities($input->whitelist('q')); ?>' />
        <button type='submit' name='submit'>Search</button>
      </form>
    </div>

    <!-- main content -->
    <div id='content'>
      <h1><?php echo $title; ?></h1>
      <?php echo $content; ?>
    </div>

    <!-- sidebar content -->
    <?php if($sidebar): ?>
    <div id='sidebar'>
      <?php echo $sidebar; ?>
    </div>
    <?php endif; ?>

  </div>

  <!-- footer -->
  <footer id='footer' class='w3-container'>
    <p>
    Powered by <a href='http://processwire.com'>ProcessWire CMS</a>  &nbsp; / &nbsp;
    <?php
    if($user->isLoggedin()) {
      // if user is logged in, show a logout link
      echo "<a href='{$config->urls->admin}login/logout/'>Logout ($user->name)</a>";
    } else {
      // if user not logged in, show a login link
      echo "<a href='{$config->urls->admin}'>Admin Login</a>";
    }
    ?>
    </p>
  </footer>

  <?php if($page->template=='album'): ?>
  <!-- photoswipe gallery -->
  <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">

        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                      <div class="pswp__preloader__cut">
                        <div class="pswp__preloader__donut"></div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha256-/SIrNqv8h6QGKDuNoLGA4iret+kyesCkHGzVUUV0shc=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="<?php echo $config->urls->templates?>styles/photoswipe.css">
  <!-- Skin CSS file (styling of UI - buttons, caption, etc.)
       In the folder of skin CSS file there are also:
       - .png and .svg icons sprite,
       - preloader.gif (for browsers that do not support CSS animations) -->
  <link rel="stylesheet" href="<?php echo $config->urls->templates?>styles/default-skin/default-skin.css">
  <script src="<?php echo $config->urls->templates?>scripts/photoswipe.min.js"></script>
  <script src="<?php echo $config->urls->templates?>scripts/photoswipe-ui-default.min.js"></script>
  <script src="<?php echo $config->urls->templates?>scripts/lightbox.js"></script>
  <?php endif; ?>
</body>
</html>
