document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('mobile-menu');
    const nav = document.querySelector('nav');
    const searchIcon = document.querySelector('.search-icon');
    const searchInput = document.querySelector('.search-input');
    
    // Toggle menu
    menuToggle.addEventListener('click', function() {
        this.classList.toggle('active');
        nav.classList.toggle('active');
        // Close search when menu is opened
        searchInput.classList.remove('active');
    });

    // Toggle search on mobile
    if (searchIcon) {
        searchIcon.addEventListener('click', function(e) {
            e.preventDefault();
            searchInput.classList.toggle('active');
            // Close menu when search is opened
            menuToggle.classList.remove('active');
            nav.classList.remove('active');
        });
    }

    // Close menu and search when clicking outside
    document.addEventListener('click', function(e) {
        if (!nav.contains(e.target) && !menuToggle.contains(e.target)) {
            nav.classList.remove('active');
            menuToggle.classList.remove('active');
        }

        if (!searchInput.contains(e.target) && !searchIcon.contains(e.target)) {
            searchInput.classList.remove('active');
        }
    });

    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            nav.classList.remove('active');
            menuToggle.classList.remove('active');
            searchInput.classList.remove('active');
        }
    });
});




//Code pour ANIMATION  stastitique 

document.addEventListener('DOMContentLoaded', () => {
    // Fonction pour vérifier si un élément est visible dans la fenêtre
    const isElementInViewport = (el) => {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    };

    // Fonction pour animer un compteur
    const animateCounter = (element) => {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000; // Durée de l'animation en ms
        const step = target / 200; // Nombre d'étapes
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current > target) {
                element.textContent = target.toLocaleString();
            } else {
                element.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            }
        };
        
        updateCounter();
    };

    // Observer pour déclencher l'animation au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                const counters = entry.target.querySelectorAll('.stat-number');
                counters.forEach(counter => animateCounter(counter));
                entry.target.classList.add('counted');
            }
        });
    }, { threshold: 0.5 });

    // Observer la section de statistiques
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        observer.observe(statsSection);
    }

    // Animation de l'icône
    const icons = document.querySelectorAll('.stat-icon i');
    icons.forEach(icon => {
        icon.addEventListener('mouseover', () => {
            icon.style.transform = 'scale(1.2) rotate(10deg)';
            icon.style.transition = 'transform 0.3s ease';
        });

        icon.addEventListener('mouseout', () => {
            icon.style.transform = 'scale(1) rotate(0)';
        });
    });
});
//FIN Code pour stastitique 



//CODE POUR ANIMATIONN ENTIERE DE LA PAGE D'ACCUEIL

document.addEventListener('DOMContentLoaded', function() {
    // Animation au scroll
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observer les éléments avec la classe scroll-animate
    document.querySelectorAll('.scroll-animate').forEach(element => {
        observer.observe(element);
    });

    // Animation des statistiques au scroll
    document.querySelectorAll('.stats-section').forEach(section => {
        observer.observe(section);
    });

    // Animation des cartes au scroll
    document.querySelectorAll('.actualite-card, .event-card').forEach(card => {
        observer.observe(card);
    });
});
//FIN CODE POUR ANIMATIONN ENTIERE DE LA PAGE D'ACCUEIL