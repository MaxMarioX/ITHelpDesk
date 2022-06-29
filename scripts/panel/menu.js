$(document).ready(function() {
    $('ul.navigation li').hover(function() {
        $(this).find('.subnav').slideDown('slow');
        $(this).find('a').addClass('active');
    }, function() {
        $(this).find('.subnav').slideUp('fast');
        $(this).find('a').removeClass("active");
    });
    $('ul.navigationlogin li').hover(function() {
        $(this).find('.subnav').slideDown('slow');
        $(this).find('a').addClass('active');
    }, function() {
        $(this).find('.subnav').slideUp('fast');
        $(this).find('a').removeClass("active");
    });
});