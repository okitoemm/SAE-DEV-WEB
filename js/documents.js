/**
 * Ajoute un événement de clic à une vignette pour faire défiler la page vers un accordéon avec une animation fluide.
 * Affiche un message d'erreur dans la console si l'élément ou la cible n'est pas trouvé.
 *
 * @param {string} cardId - L'ID de la vignette sur laquelle l'utilisateur clique.
 * @param {string} targetId - L'ID de l'accordéon vers lequel la page doit défiler.
 */
function addScrollListener(cardId, targetId) {
    const card = document.getElementById(cardId);
    if (card) {
        card.addEventListener('click', function() {
            const target = document.getElementById(targetId);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            } else {
                console.error(`Element with ID "${targetId}" not found.`);
            }
        });
    } else {
        console.error(`Element with ID "${cardId}" not found.`);
    }
}

// Ajout d'écouteurs de clic pour chaque vignette qui déclenchera le défilement vers un accordéon spécifique.
document.addEventListener("DOMContentLoaded", function() {
    addScrollListener('card1', 'container-doc-content-1');
    addScrollListener('card2', 'container-doc-content-2');
    addScrollListener('card3', 'container-doc-content-3');
    addScrollListener('card4', 'container-doc-content-4');
});

/**
 * Gestion des accordéons : ajoute un événement de clic à chaque bouton d'accordéon
 * pour afficher ou masquer le contenu associé.
 * Lorsque l'accordéon est ouvert, son contenu est entièrement visible.
 * Lorsque l'accordéon est fermé, le contenu est masqué.
 */
document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll('.toggle-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const parent = button.parentElement.parentElement;
            const content = parent.querySelector('.accordion-content');

            if (parent.classList.contains('active')) {
                // Ferme l'accordéon en réinitialisant la hauteur maximale
                content.style.maxHeight = null;
                parent.classList.remove('active');
                button.querySelector('button').textContent = "-";
            } else {
                // Ouvre l'accordéon en réglant la hauteur maximale sur la hauteur réelle du contenu
                content.style.maxHeight = content.scrollHeight + "px";
                parent.classList.add('active');
                button.querySelector('button').textContent = "+";
            }
        });
    });
});
