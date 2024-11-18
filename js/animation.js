document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes au chargement
    function animateCards() {
        const cards = document.querySelectorAll('.service-card, .actualite-card, .event-card');
        cards.forEach((card, index) => {
            card.style.animation = `fadeInUp 0.8s ease ${index * 0.2}s forwards`;
        });
    }

    // Animation au défilement
    function animateOnScroll() {
        const elements = document.querySelectorAll('.scroll-animate');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        elements.forEach(element => {
            observer.observe(element);
        });
    }

    // Animation du texte lettre par lettre
    function animateText(element) {
        const text = element.textContent;
        element.textContent = '';
        
        for (let i = 0; i < text.length; i++) {
            const span = document.createElement('span');
            span.textContent = text[i];
            span.style.animationDelay = `${i * 0.05}s`;
            span.classList.add('animate-letter');
            element.appendChild(span);
        }
    }

    // Initialisation des animations
    function initAnimations() {
        animateCards();
        animateOnScroll();
        
        // Animation des titres
        const titles = document.querySelectorAll('.animate-text');
        titles.forEach(title => animateText(title));
    }

    // Animations au chargement de la page
    window.addEventListener('load', initAnimations);
});