/*global $, jQuery, alert*/
$(document).ready(function () {

  'use strict';

  // ========================================================================= //
  //  //SMOOTH SCROLL
  // ========================================================================= //


  $(document).on("scroll", onScroll);

  $('a[href^="#"]').on('click', function (e) {
    e.preventDefault();
    $(document).off("scroll");

    $('a').each(function () {
      $(this).removeClass('active');
      if ($(window).width() < 768) {
        $('.nav-menu').slideUp();
      }
    });

    $(this).addClass('active');

    var target = this.hash;

    target = $(target);
    $('html, body').stop().animate({
      'scrollTop': target.offset().top - 80
    }, 500, 'swing', function () {
      window.location.hash = target.selector;
      $(document).on("scroll", onScroll);
    });

  });

  function onScroll() {
    if ($('.home').length) {
      $(document).scrollTop();
      $('nav ul li a').each(function () {
        $(this).attr("href");
      });
    }
  }

  // ========================================================================= //
  //  //NAVBAR SHOW - HIDE
  // ========================================================================= //


  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll > 200) {
      $("#main-nav, #main-nav-subpage").slideDown(700);
      $("#main-nav-subpage").removeClass('subpage-nav');
    } else {
      $("#main-nav").slideUp(700);
      $("#main-nav-subpage").hide();
      $("#main-nav-subpage").addClass('subpage-nav');
    }
  });

  // ========================================================================= //
  //  // RESPONSIVE MENU
  // ========================================================================= //

  $('.responsive').on('click', function (e) {
    $('.nav-menu').slideToggle();
  });

  // ========================================================================= //
  //  Typed Js
  // ========================================================================= //

  var typed = $(".typed");

  $(function () {
    typed.typed({
      strings: ["Efren Flores.", "Mentor.", "Developer.", "Project Manager.", "Engineer."],
      typeSpeed: 100,
      loop: true,
    });
  });

  // ========================================================================= //
  /**
   * Initiate Pure Counter
   */
  new PureCounter();

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

    /**
   * Init isotope layout and filters
   */
    document.querySelectorAll('.isotope-layout').forEach(function (isotopeItem) {
      let layout = isotopeItem.getAttribute('data-layout') ?? 'masonry';
      let filter = isotopeItem.getAttribute('data-default-filter') ?? '*';
      let sort = isotopeItem.getAttribute('data-sort') ?? 'original-order';

      let initIsotope;
      imagesLoaded(isotopeItem.querySelector('.isotope-container'), function () {
        initIsotope = new Isotope(isotopeItem.querySelector('.isotope-container'), {
          itemSelector: '.isotope-item',
          layoutMode: layout,
          filter: filter,
          sortBy: sort
        });
      });

      isotopeItem.querySelectorAll('.isotope-filters li').forEach(function (filters) {
        filters.addEventListener('click', function () {
          isotopeItem.querySelector('.isotope-filters .filter-active').classList.remove('filter-active');
          this.classList.add('filter-active');
          initIsotope.arrange({
            filter: this.getAttribute('data-filter')
          });
          if (typeof aosInit === 'function') {
            aosInit();
          }
        }, false);
      });
    });

});

// ========================================================================= //
// Download Resume
// ========================================================================= //

function DownloadCV() {
  window.open('assets/docs/CV_English.pdf', '_blank');
}

// ========================================================================= //
// Changing Text
// ========================================================================= //
document.addEventListener('DOMContentLoaded', (event) => {
  const textElement = document.getElementById('changingText');
  const textArray = [
    "Conoceme!",
    "Welcome to my portfolio!",
    "I am a Data Intelligence and Cybersecurity Engineer!",
    "I love learning new languages and musical instruments!",
    "Let's collaborate and build something amazing!"
  ];
  let index = 0;
  let charIndex = 0;
  let currentText = '';
  let isDeleting = false;

  function typeText() {
    textElement.textContent = currentText;

    if (!isDeleting && charIndex < textArray[index].length) {
      currentText += textArray[index].charAt(charIndex);
      charIndex++;
      setTimeout(typeText, 100);
    } else if (isDeleting && charIndex > 0) {
      currentText = currentText.substring(0, currentText.length - 1);
      charIndex--;
      setTimeout(typeText, 50);
    } else if (!isDeleting && charIndex === textArray[index].length) {
      isDeleting = true;
      setTimeout(typeText, 2000); // wait for 2 seconds before deleting
    } else if (isDeleting && charIndex === 0) {
      isDeleting = false;
      index = (index + 1) % textArray.length;
      setTimeout(typeText, 500); // start typing next text after a short delay
    }
  }

  typeText();
});


