var toggleNav, nav, navVisible;
document.addEventListener("DOMContentLoaded", function(event) {
    console.log('ready');
    toggleNav = document.querySelector('.toggle-navigation');
    nav = document.querySelector('.nav.nav--regular');
    navVisible = ' nav--visible';

    toggleNav.addEventListener('click', toggle, false);
});

function toggle(e) {
    console.log('clicked');

    if (nav.className === 'nav nav--regular') {
        nav.className += navVisible;
    } else {
        nav.className = 'nav nav--regular';
    }
    console.log(nav.className);
}


// $(document).ready(function() {
//     $('.nav--toggle').click(function(e) {
//         console.log('clicked');
//         $(this).toggleClass('nav--active');
//         $('.nav ul').toggleClass('nav--active');

//         e.preventDefault();
//     });
// });