document.addEventListener('DOMContentLoaded', function() {
    // Sélection des éléments du DOM
    const form = document.getElementById('adhesionForm');
    const successMessage = document.getElementById('successMessage');
    const errors = {
        name: document.getElementById('nameError'),
        email: document.getElementById('emailError'),
        amount: document.getElementById('amountError'),
        consent: document.getElementById('consentError')
    };

    // Fonction de validation du formulaire
    function validateForm() {
        let isValid = true;

        // Validation du nom
        const name = document.getElementById('name').value.trim();
        if (name === '') {
            errors.name.classList.add('visible');
            isValid = false;
        } else {
            errors.name.classList.remove('visible');
        }

        // Validation de l'email
        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errors.email.classList.add('visible');
            isValid = false;
        } else {
            errors.email.classList.remove('visible');
        }

        // Validation du montant
        const amount = document.getElementById('amount').value;
        if (amount < 10) {
            errors.amount.classList.add('visible');
            isValid = false;
        } else {
            errors.amount.classList.remove('visible');
        }

        // Validation du consentement
        const consent = document.getElementById('consent').checked;
        if (!consent) {
            errors.consent.classList.add('visible');
            isValid = false;
        } else {
            errors.consent.classList.remove('visible');
        }

        return isValid;
    }

    // Fonction pour mettre à jour le texte du bouton
    function updateButtonText() {
        const typeSelect = document.getElementById('type');
        const submitButton = form.querySelector('button[type="submit"]');
        // Utilisation de guillemets doubles pour éviter les problèmes d'apostrophe
        submitButton.textContent = typeSelect.value === "adhesion" ? "Valider l'adhésion" : "Faire un don";
    }

    // Gestionnaire de soumission du formulaire
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        if (validateForm()) {
            // Création d'un objet avec les données du formulaire
            const formData = {
                name: document.getElementById('name').value.trim(),
                email: document.getElementById('email').value.trim(),
                type: document.getElementById('type').value,
                amount: document.getElementById('amount').value,
                consent: document.getElementById('consent').checked
            };

            // Simulation d'envoi au serveur
            console.log('Données du formulaire:', formData);

            // Affichage du message de succès
            setTimeout(() => {
                form.style.display = 'none';
                successMessage.style.display = 'block';
                // Réinitialiser le formulaire après 3 secondes
                setTimeout(() => {
                    form.reset();
                    form.style.display = 'block';
                    successMessage.style.display = 'none';
                }, 3000);
            }, 1000);
        }
    });

    // Validation en temps réel des champs
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', validateForm);
    });

    // Gestionnaire de changement pour le type d'adhésion
    const typeSelect = document.getElementById('type');
    typeSelect.addEventListener('change', updateButtonText);

    // Initialisation du texte du bouton au chargement
    updateButtonText();

    // Gestionnaire pour le montant minimum
    const amountInput = document.getElementById('amount');
    amountInput.addEventListener('input', function() {
        if (this.value < 10) {
            this.value = 10;
        }











        // Fonction pour formater le numéro de carte
        function formatCardNumber(input) {
            let value = input.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = '';

            for(let i = 0; i < value.length; i++) {
                if(i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }

            input.value = formattedValue;
        }

        // Fonction pour formater la date d'expiration
        function formatExpiry(input) {
            let value = input.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');

            if(value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }

            input.value = value;
        }

        // Validation de la carte
        function validateCard() {
            let isValid = true;
            const cardNumber = document.getElementById('cardNumber').value.replace(/\s+/g, '');
            const cardName = document.getElementById('cardName').value.trim();
            const cardExpiry = document.getElementById('cardExpiry').value;
            const cardCvc = document.getElementById('cardCvc').value;

            // Validation du numéro de carte (algorithme de Luhn simplifié)
            if(cardNumber.length !== 16 || !/^\d+$/.test(cardNumber)) {
                document.getElementById('cardNumberError').classList.add('visible');
                isValid = false;
            } else {
                document.getElementById('cardNumberError').classList.remove('visible');
            }

            // Validation du nom sur la carte
            if(cardName.length < 3) {
                document.getElementById('cardNameError').classList.add('visible');
                isValid = false;
            } else {
                document.getElementById('cardNameError').classList.remove('visible');
            }

            // Validation de la date d'expiration
            const [month, year] = cardExpiry.split('/');
            const now = new Date();
            const currentYear = now.getFullYear() % 100;
            const currentMonth = now.getMonth() + 1;

            if(!month || !year || month < 1 || month > 12 ||
                (year < currentYear || (year == currentYear && month < currentMonth))) {
                document.getElementById('cardExpiryError').classList.add('visible');
                isValid = false;
            } else {
                document.getElementById('cardExpiryError').classList.remove('visible');
            }

            // Validation du CVC
            if(!/^\d{3}$/.test(cardCvc)) {
                document.getElementById('cardCvcError').classList.add('visible');
                isValid = false;
            } else {
                document.getElementById('cardCvcError').classList.remove('visible');
            }

            return isValid;
        }

        // Gestionnaires d'événements pour le formatage
        document.getElementById('cardNumber').addEventListener('input', function() {
            formatCardNumber(this);
        });

        document.getElementById('cardExpiry').addEventListener('input', function() {
            formatExpiry(this);
        });

        // Modification de la validation du formulaire
        function validateForm() {
            const isBaseValid = validateBaseForm(); // La validation précédente
            const isCardValid = validateCard();
            return isBaseValid && isCardValid;
        }

        // Mise à jour du gestionnaire de soumission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if(validateForm()) {
                const formData = {
                    // ... Données précédentes ...
                    cardNumber: document.getElementById('cardNumber').value.replace(/\s+/g, ''),
                    cardName: document.getElementById('cardName').value,
                    cardExpiry: document.getElementById('cardExpiry').value,
                    cardCvc: document.getElementById('cardCvc').value
                };

                // Simulation de traitement du paiement
                console.log('Traitement du paiement...');

                setTimeout(() => {
                    form.style.display = 'none';
                    successMessage.style.display = 'block';
                }, 1500);
            }
        });
    });





});