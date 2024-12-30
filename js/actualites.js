// Sélection des éléments du DOM pour le carrousel et les boutons de navigation
const carousel = document.querySelector('.carousel');
const leftButton = document.querySelector('.carousel-btn.left');
const rightButton = document.querySelector('.carousel-btn.right');

/**
 * Défilement du carrousel vers la droite.
 * Lorsque l'utilisateur clique sur le bouton de droite, le carrousel défile
 * de 300 pixels vers la droite avec un effet de défilement fluide.
 */
rightButton.addEventListener('click', () => {
    carousel.scrollBy({
        left: 300,  // Défilement de 300 pixels vers la droite
        behavior: 'smooth'  // Effet de défilement fluide
    });
});

/**
 * Défilement du carrousel vers la gauche.
 * Lorsque l'utilisateur clique sur le bouton de gauche, le carrousel défile
 * de 300 pixels vers la gauche avec un effet de défilement fluide.
 */
leftButton.addEventListener('click', () => {
    carousel.scrollBy({
        left: -300,  // Défilement de 300 pixels vers la gauche
        behavior: 'smooth'  // Effet de défilement fluide
    });
});