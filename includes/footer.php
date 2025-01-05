<?php
// includes/footer.php
?>
<footer class="footer-modern">
    <div class="footer-top">
        <div class="container">
            <div class="footer-section mission-section">
                <div class="footer-logo">
                    <img src="imgs/ImgsAccueil/logoSite/logoffcm.png" alt="FFCM Logo">
                    <div class="certification-badges">
                        <span class="certification-badge">Association Loi 1901</span>
                        <span class="certification-badge">Agréée Ministère de la Santé</span>
                    </div>
                </div>
                <p class="mission-text">La Fédération Française des Curistes Médicalisés œuvre pour la défense des droits des curistes et la promotion du thermalisme médical en France.</p>
            </div>

            <div class="footer-section links-section">
                <div class="footer-col">
                    <h4>Services</h4>
                    <ul>
                        <li><a href="adhesion.php">Devenir adhérent</a></li>
                        <li><a href="documents.php">Documents utiles</a></li>
                        <li><a href="actualites.php">Actualités thermales</a></li>
                        <li><a href="guide-cure.php">Guide des cures</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Informations</h4>
                    <ul>
                        <li><a href="aproposdenous.php">Qui sommes-nous ?</a></li>
                        <li><a href="partenaires.php">Nos partenaires</a></li>
                        <li><a href="temoignages.php">Témoignages</a></li>
                        <li><a href="contact.php">Nous contacter</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Espace membre</h4>
                    <ul>
                        <li><a href="connexion.php">Se connecter</a></li>
                        <li><a href="inscription.php">Créer un compte</a></li>
                        <li><a href="espace-membre.php">Mon espace</a></li>
                        <li><a href="faq.php">Aide & FAQ</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-section contact-section">
                <div class="contact-info">
                    <h4>Contact</h4>
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <p>2 rue des Frères Rodriguez<br>72700 Allonnes</p>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <p>06.83.27.22.80<br>02.43.21.65.78</p>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <p>ffcm@libertysurf.fr</p>
                        </div>
                    </div>
                </div>

                <div class="newsletter-box">
                    <h4>Restez informé</h4>
                    <p>Recevez nos actualités et informations importantes</p>
                    <form class="newsletter-form">
                        <div class="form-group">
                            <input type="email" placeholder="Votre adresse email" required>
                            <button type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <label class="consent-checkbox">
                            <input type="checkbox" required>
                            <span>J'accepte de recevoir la newsletter de la FFCM</span>
                        </label>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="partners-section">
        <div class="container">
            <div class="partners-slider">
                <div class="partner-logos">
                    <img src="imgs/logopartenaires/franceassologo.png" alt="Partenaire 1">
                    <img src="imgs/logopartenaires/LOGOP1.jpeg" alt="Partenaire 2">
                    <img src="imgs/logopartenaires/LOGOP2.jpeg" alt="Partenaire 3">
                    <img src="imgs/logopartenaires/LOGOP3.jpeg" alt="Partenaire 4">
                </div>
            </div>
        </div>
    </div>

    <div class="social-section">
        <div class="container">
            <div class="social-links">
                <a href="https://facebook.com/FFCM" target="_blank" class="social-link">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/FFCM" target="_blank" class="social-link">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://linkedin.com/company/ffcm" target="_blank" class="social-link">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://youtube.com/FFCM" target="_blank" class="social-link">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <div class="copyright">
                    <p>&copy; <?php echo date('Y'); ?> FFCM - Tous droits réservés</p>
                </div>
                <div class="legal-links">
                    <a href="mentions-legales.php">Mentions légales</a>
                    <a href="confidentialite.php">Politique de confidentialité</a>
                    <a href="cookies.php">Gestion des cookies</a>
                    <a href="accessibilite.php">Accessibilité</a>
                </div>
                <div class="security-badges">
                    <img src="imgs/ImgsAccueil/logoSite/RGPDHome.jpg" alt="RGPD Compliant">
                    <img src="imgs/ImgsAccueil/logoSite/6472048.png" alt="SSL Secure">
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="js/script.js"></script>
