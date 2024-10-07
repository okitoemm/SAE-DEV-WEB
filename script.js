// Select the hamburger menu and the nav links
const menuToggle = document.getElementById('mobile-menu');
const navLinks = document.getElementById('nav-links');

// Add event listener to toggle the 'active' class on nav-links when hamburger is clicked
menuToggle.addEventListener('click', function() {
    navLinks.classList.toggle('active');
});
