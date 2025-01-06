<?php
// includes/header.php

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/updatestyle.css">
    <link rel="stylesheet" href="css/footer-modern.css">
    <link rel="stylesheet" href="css/adhesion.css">
    <link rel="stylesheet" href="css/actualites.css">
    <link rel="stylesheet" href="css/documents.css">
    <link rel="stylesheet" href="css/merci.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="imgs/ImgsAccueil/logoSite/logoffcm.png" alt="Logo FFCM"></a>
            </div>

            <div class="auth-buttons">
                <?php if(isset($_SESSION['user_id'])): ?>
                   <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                         <a href="admin/index.php" class="btn-auth">Admin</a>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'adherent'): ?>
                        <a href="enquete_form.php" class="btn-auth">Enquête</a>
                    <?php endif; ?>
                    <a href="logout.php" class="btn-auth">Déconnexion</a>
                <?php else: ?>
                    <a href="connexion.php" class="btn-auth">Connexion</a>
                <?php endif; ?>
            </div>

            <div id="mobile-menu" class="menu-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>

            <nav>
                <ul id="nav-links">
                    <li><a href="index.php">Accueil</a></li>
                    </li>
                    <li class="dropdown">
                            <a href="documents.php">Documents</a>
                            <div class="dropdown-menu">
                                <a href="https://www.ffcm.info/liens-utiles">Liens Utiles</a>
                                <a href="https://www.ffcm.info/statistiques">Statistiques</a>
                                <a href="https://www.ffcm.info/copie-de-medias">Médias</a>
                                <a href="https://www.ffcm.info/archives-c10uc">Archives</a>
                                <a href="https://www.ffcm.info/livres-conseills">Livres conseillés</a>
                            </div>
                        </li>
                    <li><a href="Actualites.php">Actualités</a></li>
                    <li><a href="https://www.ffcm.info/annonceurs">Annonceurs</a></li>
                    <li><a href="Adhesion.php">Adhésion</a></li>
                    <li><a href="Aproposdenous.php">À propos</a></li>
                </ul>
            </nav>

            <form class="search-form">
                <input type="search" class="search-input" placeholder="Rechercher...">
                <button type="submit" class="search-button">Rechercher</button>
                <button type="button" class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                </button>
            </form>
        </div>
    </header>
