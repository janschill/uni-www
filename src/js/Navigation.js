$(document).ready(function() {
    $('.nav--toggle').click(function(e) {
        console.log('clicked');
        $(this).toggleClass('nav--active');
        $('.nav ul').toggleClass('nav--active');

        e.preventDefault();
    });
});