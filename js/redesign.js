// Webfurious Designs — 2026 redesign interactivity (header shadow + mobile nav)
(function () {
  var header = document.querySelector('.wf-header');
  var burger = document.querySelector('.wf-burger');
  var mobileNav = document.querySelector('.wf-mobile-nav');

  if (header) {
    var onScroll = function () {
      if (window.scrollY > 20) {
        header.classList.add('wf-scrolled');
      } else {
        header.classList.remove('wf-scrolled');
      }
    };
    window.addEventListener('scroll', onScroll);
    onScroll();
  }

  if (burger && mobileNav) {
    burger.addEventListener('click', function () {
      mobileNav.classList.toggle('wf-open');
    });
    mobileNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mobileNav.classList.remove('wf-open');
      });
    });
  }
})();
