var nav = document.querySelector('.nav-website');

window.onscroll = function() {
    if (scrollY >= 100) {
        nav.classList.add('nav-shadow');
    } else {
        nav.classList.remove('nav-shadow');
    }
}