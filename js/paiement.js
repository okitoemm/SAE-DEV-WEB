// Créer une instance de Stripe avec ta clé publique
var stripe = Stripe('ta_cle_publique_stripe');

// Créer un objet de paiement pour Stripe Elements
var elements = stripe.elements();
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Créer un champ de carte bancaire avec Stripe Elements
var card = elements.create('card', {style: style});
card.mount('#card-element');

// Gérer les erreurs en temps réel sur le champ de carte bancaire
card.on('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Gérer la soumission du formulaire
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();

    // Créer un token Stripe
    stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Informer l'utilisateur des erreurs
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Envoyer le token au serveur
            stripeTokenHandler(result.token);
        }
    });
});

// Envoyer le token au serveur
function stripeTokenHandler(token) {
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Soumettre le formulaire avec le token
    form.submit();
}
