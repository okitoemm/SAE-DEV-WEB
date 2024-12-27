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


document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('input-box');
    const resultBox = document.getElementById('result-box');
    const searchButton = document.querySelector('.search-button');

    // Map des termes de recherche avec leurs URLs associées
    const searchMap = {
        "Cure thermale": "cure-thermale.html",
        "Cancer": "cancer.html",
        "Bien-être": "bien-etre.html",
        "Santé": "sante.html",
        "Éducation thérapeutique": "education-therapeutique.html",
        "Thermalisme": "thermalisme.html",
        "Octobre Rose": "octobre-rose.html",
        "Post-cancer": "post-cancer.html",
        "Lymphoedème": "lymphoedeme.html",
        "Annonceurs": "https://www.ffcm.info/annonceurs"
    };

    // Filtre les suggestions en fonction de la saisie
    function filterResults(query) {
        return Object.keys(searchMap).filter(term =>
            term.toLowerCase().includes(query.toLowerCase())
        );
    }

    // Affiche les résultats dans la boîte de suggestions
    function displayResults(results) {
        resultBox.innerHTML = "";  // Efface les résultats précédents
        if (results.length === 0) {
            resultBox.style.display = "none";
            return;
        }

        results.forEach(result => {
            const resultItem = document.createElement('li');
            resultItem.textContent = result;
            resultItem.classList.add('result-item');
            resultBox.appendChild(resultItem);

            // Ajouter un comportement au clic pour chaque suggestion
            resultItem.addEventListener('click', () => {
                searchInput.value = result;
                resultBox.style.display = "none";
                redirectToPage(result);
            });
        });

        resultBox.style.display = "block";
    }

    // Fonction de redirection vers l'URL associée
    function redirectToPage(query) {
        const url = searchMap[query];
        if (url) {
            window.location.href = url;  // Redirection vers l'URL associée
        } else {
            alert("Aucun résultat trouvé pour cette recherche.");
        }
    }

    // Gère l'événement de saisie
    searchInput.addEventListener('input', () => {
        const query = searchInput.value;
        if (query.length > 0) {
            const filteredResults = filterResults(query);
            displayResults(filteredResults);
        } else {
            resultBox.style.display = "none";
        }
    });

    // Gère l'événement du bouton de recherche
    searchButton.addEventListener('click', () => {
        const query = searchInput.value;
        redirectToPage(query);
    });

    // Cache la boîte de suggestions si on clique en dehors
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.search-box')) {
            resultBox.style.display = "none";
        }
    });
});
