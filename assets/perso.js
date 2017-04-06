$( document ).ready(function() {

  // Scroll to section
  $('*[href*="#"]:not([href="#"])').click(function() {
    var target = $(this.hash);
    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
    if (target.length) {
      $('html, body').animate({
        scrollTop: target.offset().top
      }, 700);
      return false;
    }
  });

  // Carousel
  $('.car1').flickity({
    // options
    cellAlign: 'center',
    contain: true,
    wrapAround: true,
    groupCells: false,
    imagesLoaded: true
  });

  // Google analytics
  (function(i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] ||
    function() {
      (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o), m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
  })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

  ga('create', 'UA-42953836-1', 'scenesenchantier.fr');
  ga('send', 'pageview');

});