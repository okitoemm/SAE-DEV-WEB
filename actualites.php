<?php
session_start();
require_once 'config/database.php';
include 'includes/header.php';

// Vérification si l'utilisateur est connecté 
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}
?>



<!-- Section Actualités -->
<div class="carousel-wrapper">
  <button class="carousel-btn left" onclick="scrollCarousel(-1)">&#10094;</button>

  <div class="carousel actualites-grid">
    <!-- Actualité 1-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image1.jpg" alt="Éducation Thérapeutique">
      <div class="actualite-content">
        <span>Publié le 17/10/2024</span>
        <h3>L’Éducation Thérapeutique du Patient pendant sa cure thermale</h3>
        <p>Découvrez comment l’éducation Thérapeutique en cure thermale aide les patients à mieux gérer leur maladie et à améliorer leur autonomie.</p>
      </div>
    </div>

    <!-- Actualité 2-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image2.jpg" alt="Cure post-cancer">
      <div class="actualite-content">
        <span>Publié le 15/10/2024</span>
        <h3>Prise en charge de la cure post-cancer</h3>
        <p>Cure post-cancer</p>
      </div>
    </div>
    <!-- Actualité 3-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image3.jpg" alt="Éducation Thérapeutique">
      <div class="actualite-content">
        <span>Publié le 08/10/2024</span>
        <h3>Suis-je éligible à une cure thermale conventionée ?</h3>
        <p>Découvrez les critères pour bénéficier d’une prise en charge.</p>
      </div>
    </div>
    <!-- Actualité 4-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image4.jpg" alt="Éducation Thérapeutique">
      <div class="actualite-content">
        <span>Publié le 02/10/2024</span>
        <h3>Cure thermale pour voies respiratoires</h3>
        <p>Un traitement naturel pour améliorer votre santé respiratoire.</p>
      </div>
    </div>
    <!-- Actualité 5-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image5.jpg" alt="Cure post-cancer">
      <div class="actualite-content">
        <span>Publié le 29/09/2024</span>
        <h3>Arthrose : où faire une cure thermale ?</h3>
        <p>Cure post-cancer</p>
      </div>
    </div>
    <!-- Actualité 6-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image3.jpg" alt="Éducation Thérapeutique">
      <div class="actualite-content">
        <span>Publié le 17/10/2024</span>
        <h3>L’Éducation Thérapeutique du Patient pendant sa cure thermale</h3>
        <p>Découvrez les bienfaits et l'importance de l'éducation thérapeutique en cure thermale.</p>
      </div>
    </div>
    <!-- Actualité 7-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image1.jpg" alt="Éducation Thérapeutique">
      <div class="actualite-content">
        <span>Publié le 17/10/2024</span>
        <h3>L’Éducation Thérapeutique du Patient pendant sa cure thermale</h3>
        <p>[...]</p>
      </div>
    </div>

    <!-- Actualité 8-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image2.jpg" alt="Cure post-cancer">
      <div class="actualite-content">
        <span>Publié le 15/10/2024</span>
        <h3>Prise en charge de la cure post-cancer</h3>
        <p>Cure post-cancer</p>
      </div>
    </div>
    <!-- Actualité 9-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image3.jpg" alt="Éducation Thérapeutique">
      <div class="actualite-content">
        <span>Publié le 17/10/2024</span>
        <h3>L’Éducation Thérapeutique du Patient pendant sa cure thermale</h3>
        <p>Découvrez les bienfaits et l'importance de l'éducation thérapeutique en cure thermale.</p>
      </div>
    </div>
    <!-- Actualité 10-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image1.jpg" alt="Éducation Thérapeutique">
      <div class="actualite-content">
        <span>Publié le 17/10/2024</span>
        <h3>L’Éducation Thérapeutique du Patient pendant sa cure thermale</h3>
        <p>[...]</p>
      </div>
    </div>
    <!-- Actualité 11-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image2.jpg" alt="Cure post-cancer">
      <div class="actualite-content">
        <span>Publié le 15/10/2024</span>
        <h3>Prise en charge de la cure post-cancer</h3>
        <p>Cure post-cancer</p>
      </div>
    </div>
    <!-- Actualité 12-->
    <div class="actualite-card">
      <img src="../img/ImgsActualites/image3.jpg" alt="Éducation Thérapeutique">
      <div class="actualite-content">
        <span>Publié le 17/10/2024</span>
        <h3>L’Éducation Thérapeutique du Patient pendant sa cure thermale</h3>
        <p>Découvrez les bienfaits et l'importance de l'éducation thérapeutique en cure thermale.</p>
      </div>
    </div>

  </div>

  <button class="carousel-btn right" onclick="scrollCarousel(1)">&#10095;</button>
</div>


<?php include 'includes/footer.php'; ?>
