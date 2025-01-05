
<?php
session_start();
require_once 'config/database.php';
include 'includes/header.php';
?>


    <!-- Bannière avec titre et CTA -->
    <section id="accueil" class="banner">
        <div class="container">
            <h1>Bienvenue à la Fédération des Curistes Médicalisés</h1>
            <p>Des cures adaptées pour votre bien-être et santé.</p>
            <a href="#services" class="btn-primary">Découvrir nos services</a>
        </div>
    </section>
<!--FIN Bannière avec titre et CTA -->



    <!-- Section Actualités -->
    <section class="actualites">

    <div class="container">

        <h2>Les dernières actualités du thermalisme</h2>


        <div class="actualites-grid">
            <div class="actualite-card">
                <img src="imgs/ImgsAccueil/Actualites/inhalation-vernet-valvital-768x492.jpg" alt="Éducation Thérapeutique">
                <div class="actualite-content">
                    <span>Publié le 17/10/2024</span>
                    <h3>L’Éducation Thérapeutique du Patient pendant sa cure thermale. Pourquoi et pour qui ?</h3>
                    <p>[...]</p>
                </div>
            </div>
            <div class="actualite-card">
                <img src="imgs/ImgsAccueil/Actualites/1200x680_festayre_et_curiste.jpg" alt="Cure post-cancer">
                <div class="actualite-content">
                    <span>Publié le 15/10/2024</span>
                    <h3>Prise en charge de la cure post-cancer du sein de 12 jours</h3>
                    <p>Cure post-cancer</p>
                </div>
            </div>
            <div class="actualite-card">
                <img src="imgs/ImgsAccueil/Actualites/14645610.jpeg" alt="Octobre Rose">
                <div class="actualite-content">
                    <span>Publié le 09/10/2024</span>
                    <h3>Cure thermale et cancer du sein : l’importance d’Octobre Rose</h3>
                    <p>Lymphoedeme, post-cancer du sein</p>
                </div>
            </div>
            <!-- Ajouter d'autres cartes d'actualités -->
        </div>
        <br>

        <div class="actualites-grid">
            <div class="actualite-card">
                <img src="imgs/ImgsAccueil/Actualites/Aqua-curiste_large.jpg" alt="Éducation Thérapeutique">
                <div class="actualite-content">
                    <span>Publié le 17/10/2024</span>
                    <h3>L’Éducation Thérapeutique du Patient pendant sa cure thermale. Pourquoi et pour qui ?</h3>
                    <p>[...]</p>
                </div>
            </div>
            <div class="actualite-card">
                <img src="imgs/ImgsAccueil/Actualites/club de curistes.jpg" alt="Cure post-cancer">
                <div class="actualite-content">
                    <span>Publié le 15/10/2024</span>
                    <h3>Prise en charge de la cure post-cancer du sein de 12 jours</h3>
                    <p>Cure post-cancer</p>
                </div>
            </div>
            <div class="actualite-card">
                <img src="imgs/ImgsAccueil/Actualites/dax-maud-grincourt.jpg" alt="Octobre Rose">
                <div class="actualite-content">
                    <span>Publié le 09/10/2024</span>
                    <h3>Cure thermale et cancer du sein : l’importance d’Octobre Rose</h3>
                    <p>Lymphoedeme, post-cancer du sein</p>
                </div>
            </div>
            <!-- Ajouter d'autres cartes d'actualités -->
        </div>

        
        


        <button class="see-more-btn">Voir Plus</button>
    </div>


</section>






<!-- Section Statistiques -->
<section class="stats-section">
    <div class="container">
        <h2>Notre Impact en Chiffres</h2>
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number" data-target="45097">0</div>
                <div class="stat-label">Curistes engagés</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <div class="stat-number" data-target="120">0</div>
                <div class="stat-label">Établissements partenaires</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-number" data-target="25">0</div>
                <div class="stat-label">Années d'expérience</div>
            </div>

            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-certificate"></i>
                </div>
                <div class="stat-number" data-target="98">0</div>
                <div class="stat-label">% de satisfaction</div>
            </div>
        </div>
    </div>
</section>


<!-- FIN  Section Statistiques -->




   <!-- SECTION EVENEMENTS-->
   <section class="events-section">
    <h2>Nos Événements</h2>
    
    <div class="event-cards">
        <div class="event-card">
            <img src="imgs/ImgsAccueil/Evenements/fetecuriste.jpg" alt="Événement 1">
            <h3>Événement Actuel</h3>
            <p>Description de l'événement en cours...</p>
        </div>
        
        <div class="event-card">
            <img src="imgs/ImgsAccueil/Evenements/marche artisanal.jpg" alt="Événement 2">
            <h3>Événement à Venir</h3>
            <p>Description d'un événement futur...</p>
        </div>
        
        <div class="event-card">
            <img src="imgs/ImgsAccueil/Evenements/membresduffcm.webp" alt="Événement 3">
            <h3>Événement Passé</h3>
            <p>Description d'un événement passé...</p>
        </div>


        <div class="event-card">
            <img src="imgs/ImgsAccueil/Evenements/reunion-d-equipe.jpg" alt="Événement 2">
            <h3>Événement à Venir</h3>
            <p>Description d'un événement futur...</p>
        </div>


    </div>
    <br>

    <div class="event-cards">
        <div class="event-card">
            <img src="imgs/ImgsAccueil/Evenements/unepersonneavecrobe.jpg" alt="Événement 1">
            <h3>Événement Actuel</h3>
            <p>Description de l'événement en cours...</p>
        </div>
        
        <div class="event-card">
            <img src="imgs/ImgsAccueil/Evenements/cancer-sein-apres-les-traitements-cure-thermale-pour-vider-tete-scaled.jpg" alt="Événement 2">
            <h3>Événement à Venir</h3>
            <p>Description d'un événement futur...</p>
        </div>
        
        <div class="event-card">
            <img src="imgs/ImgsAccueil/Evenements/img-0064-854x645.jpg" alt="Événement 3">
            <h3>Événement Passé</h3>
            <p>Description d'un événement passé...</p>
        </div>


        <div class="event-card">
            <img src="imgs/ImgsAccueil/Evenements/guide-remboursement-cure-thermale-desktop.png" alt="Événement 2">
            <h3>Événement à Venir</h3>
            <p>Description d'un événement futur...</p>
        </div>


    </div>



    <button class="see-more-btn">Voir Plus</button>
   

</section>


   <!--FIN  SECTION EVENEMENT-->


    <!-- Section contact -->
    <section id="contact" class="contact">
        <div class="container">
            <h2>Contactez-nous</h2>
            <form>
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit" class="btn-primary">Envoyer</button>
            </form>
        </div>
    </section>

    <!-- FIN Section contact -->


<?php include 'includes/footer.php'; ?>
