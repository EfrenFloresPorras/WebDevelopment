$(document).ready(function () {
    'use strict';

    // Typed.js initialization
    var typed = $(".typed");
    typed.typed({
        strings: ["Efren Flores.", "Mentor.", "Developer.", "Project Manager.", "Engineer."],
        typeSpeed: 100,
        loop: true,
    });

    // Section switching
    $('[data-section]').on('click', function (e) {
        e.preventDefault();
        var targetSection = $(this).data('section');
        $('.content-section').addClass('d-none');
        $('#' + targetSection).removeClass('d-none');

        // Update active state in navbar
        $('.nav-link').removeClass('active');
        $('[data-section="' + targetSection + '"]').addClass('active');

        // Show/hide navbar based on section
        if (targetSection === 'home') {
            $('#main-navbar').addClass('d-none');
            $('body').addClass('home-active');
        } else {
            $('#main-navbar').removeClass('d-none');
            $('body').removeClass('home-active');
        }

        // Scroll to the top of the section
        $('html, body').animate({
            scrollTop: $('#' + targetSection).offset().top
        }, 500);
    });

    // Show home section by default
    $('#home').removeClass('d-none');
    $('[data-section="home"]').addClass('active');
    $('body').addClass('home-active');

    // Navbar shrink on scroll
    $(window).scroll(function() {
        if ($(document).scrollTop() > 50) {
            $('.navbar').addClass('navbar-shrink');
        } else {
            $('.navbar').removeClass('navbar-shrink');
        }
    });

    // Collapse responsive navbar when toggler is visible
    $('.navbar-nav>li>a').on('click', function(){
        $('.navbar-collapse').collapse('hide');
    });
});

// Download Resume
function DownloadCV() {
    window.open('assets/docs/CV_English.pdf', '_blank');
}