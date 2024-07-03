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


});

// ========================================================================= //
// Download Resume
// ========================================================================= //

function DownloadCV() {
    window.open('assets/docs/CV_English.pdf', '_blank');
}