<?php
// admin/index.php
session_start();
require_once '../config/database.php';

// Vérification des droits admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../Connexion.php');
    exit;
}

// Récupération des statistiques générales
$stats = [
    'total_adherents' => $conn->query("SELECT COUNT(*) FROM adherent")->fetchColumn(),
    'total_reponses' => $conn->query("SELECT COUNT(DISTINCT id_adherent) FROM reponse")->fetchColumn(),
    'derniere_reponse' => $conn->query("SELECT MAX(date_reponse) FROM reponse")->fetchColumn()
];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - FFCM</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.0.0/d3.min.js"></script>
</head>
<body>
    <div class="admin-container">
        <nav class="admin-nav">
            <div class="admin-profile">
                <img src="../imgs/admin/adminIcon.jpeg" alt="Admin">
                <span>Administrateur</span>
            </div>
            <ul>
                <li><a href="index.php" class="active">Tableau de bord</a></li>
                <li><a href="stats.php">Statistiques</a></li>
                <li><a href="adherents.php">Gestion adhérents</a></li>
                <li><a href="questions.php">Gestion questions</a></li>
                <li> <a href="/index.php">Retour à l'accueil</a></li>
                <li><a href="../logout.php">Déconnexion</a></li>
            </ul>
        </nav>

        <main class="admin-content">
            <h1>Tableau de bord</h1>
            
            <div class="stats-overview">
                <div class="stat-card">
                    <h3>Total Adhérents</h3>
                    <p class="stat-number"><?= $stats['total_adherents'] ?></p>
                </div>
                <div class="stat-card">
                    <h3>Réponses à l'enquête</h3>
                    <p class="stat-number"><?= $stats['total_reponses'] ?></p>
                </div>
                <div class="stat-card">
                    <h3>Dernière réponse</h3>
                    <p class="stat-date"><?= date('d/m/Y H:i', strtotime($stats['derniere_reponse'])) ?></p>
                </div>
            </div>

            <section class="quick-actions">
                <h2>Actions rapides</h2>
                <div class="action-buttons">
                <a href="export.php?format=xlsx" class="btn-action">Exporter les résultats</a>
                    <a href="mail.php" class="btn-action">Envoyer un rappel</a>
                    <a href="rapport.php" class="btn-action">Générer un rapport</a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
