// photoswipe
// coding from: https://webdesign.tutsplus.com/tutorials/the-perfect-lightbox-using-photoswipe-with-jquery--cms-23587
$( document ).ready( function(){
  $('.my-gallery').each(function() {
      var $pswp = $('.pswp')[0];

      var $pic = $(this);
      var getItems = function() {
          var items = [];
          $pic.find('a').each(function() {
              var $href = $(this).attr('href'),
                  $size = $(this).data('size').split('x'),
                  $width = $size[0],
                  $height = $size[1];
              var caption = $(this).parent().find("figcaption").text();

              var item = {
                  src: $href,
                  w: $width,
                  h: $height,
                  title: caption
              };

              items.push(item);
          });
          return items;
      };

      var items = getItems();

      $pic.on('click', 'figure', function(event) {
          event.preventDefault();

          var $index = $(this).index();
          var options = {
              index: $index,
              bgOpacity: 0.7,
              showHideOpacity: true
          };

          // Initialize PhotoSwipe
          var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
          lightBox.init();
      });
  });
} )
