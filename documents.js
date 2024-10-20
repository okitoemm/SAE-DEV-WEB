document.addEventListener("DOMContentLoaded", function() {
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
    addScrollListener('card1', 'container-doc-content-1');
    addScrollListener('card2', 'container-doc-content-2');
    addScrollListener('card3', 'container-doc-content-3');
    addScrollListener('card4', 'container-doc-content-4');
});