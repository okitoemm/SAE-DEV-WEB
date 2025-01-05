<?php
session_start();
require_once 'config/database.php';
include 'includes/header.php';

// Vérification si l'utilisateur est connecté pour l'adhésion
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}
?>
    <!-- Main Content -->
    <main class="main-content">
        <div class="form-wrapper">
            <div class="form-container">
                <div class="form-header">
                    <h1>Formulaire d'Adhésion</h1>
                    <p>Rejoignez la Fédération Française des Curistes Médicalisés</p>
                </div>

                <form id="adhesionForm">
                    <div class="form-section">
                        <h2>Informations personnelles</h2>
                        
                        <div class="form-group">
                            <label for="name">Nom complet</label>
                            <input type="text" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="type">Type</label>
                            <select id="type" name="type" required>
                                <option value="adhesion">Adhésion</option>
                                <option value="don">Don</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="amount">Montant (€)</label>
                            <input type="number" id="amount" name="amount" min="10" value="10" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2>Informations de paiement</h2>
                        
                        <div class="card-icons">
                            <img src="imgs/ImgsAccueil/logoSite/Icons/visa.png" alt="Visa">
                            <img src="imgs/ImgsAccueil/logoSite/Icons/Mastercard-logo.svg.png" alt="Mastercard">
                            <img src="imgs/ImgsAccueil/logoSite/Icons/cb.svg" alt="CB">
                        </div>

                        <div class="form-group">
                            <label for="cardNumber">Numéro de carte</label>
                            <input type="text" id="cardNumber" name="cardNumber" maxlength="19" placeholder="1234 5678 9012 3456" required>
                        </div>

                        <div class="form-group">
                            <label for="cardName">Nom sur la carte</label>
                            <input type="text" id="cardName" name="cardName" placeholder="JEAN DUPONT" required>
                        </div>

                        <div class="date-cvc-container">
                            <div class="form-group">
                                <label for="expiryDate">Date d'expiration</label>
                                <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/AA" required>
                            </div>

                            <div class="form-group">
                                <label for="cvc">CVC</label>
                                <input type="text" id="cvc" name="cvc" placeholder="123" maxlength="3" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group checkbox">
                        <input type="checkbox" id="consent" name="consent" required>
                        <label for="consent">Je consens à la collecte et au traitement de mes données personnelles conformément à la politique de confidentialité</label>
                    </div>

                    <button type="submit" class="submit-button">Valider l'adhésion</button>

                    <div class="secure-payment">
                        <img src="imgs/ImgsAccueil/logoSite/6472048.png" alt="Paiement sécurisé">
                        <p>Paiement sécurisé avec cryptage SSL</p>
                    </div>
                </form>
            </div>
        </div>
    </main>

<?php include 'includes/footer.php'; ?>
