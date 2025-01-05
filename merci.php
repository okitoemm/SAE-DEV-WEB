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



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci pour votre participation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="merci-container">
        <h1>Merci pour votre participation !</h1>
        <p>Vos réponses ont été enregistrées avec succès. Elles nous aideront à améliorer nos services.</p>
        <a href="index.php" class="btn-retour">Retour à l'accueil</a>
    </div>
</body>
</html>
