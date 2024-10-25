document.addEventListener("DOMContentLoaded", function() {
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    hamburger.addEventListener('click', function() {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    })
    document.querySelectorAll(".nav-menu").forEach(nav => {
        nav.addEventListener('click', ()=> {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        })
    })
});
