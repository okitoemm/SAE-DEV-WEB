<?php
session_start();
require_once '../config/database.php';

// Vérification des droits admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
    $filter = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_STRING);

    try {
        // Sélection des destinataires selon le filtre
        $query = "SELECT email, nom, prenom FROM adherent WHERE 1=1";
        
        switch($filter) {
            case 'no_response':
                $query .= " AND id_adherent NOT IN (SELECT DISTINCT id_adherent FROM reponse)";
                break;
            case 'inactive':
                $query .= " AND id_adherent NOT IN (SELECT id_adherent FROM reponse WHERE date_reponse > DATE_SUB(NOW(), INTERVAL 3 MONTH))";
                break;
        }

        $stmt = $conn->query($query);
        $recipients = $stmt->fetchAll();

        if (count($recipients) > 0) {
            foreach ($recipients as $recipient) {
                // Personnalisation du message
                $personalizedContent = str_replace(
                    ['[NOM]', '[PRENOM]'],
                    [$recipient['nom'], $recipient['prenom']],
                    $content
                );

                // Configuration de l'email
                $to = $recipient['email'];
                $headers = [
                    'From' => 'noreply@ffcm.fr',
                    'Reply-To' => 'contact@ffcm.fr',
                    'X-Mailer' => 'PHP/' . phpversion(),
                    'Content-Type' => 'text/html; charset=utf-8'
                ];

                // Envoi de l'email
                if (mail($to, $subject, $personalizedContent, $headers)) {
                    $message = "Les emails ont été envoyés avec succès.";
                } else {
                    throw new Exception("Erreur lors de l'envoi des emails.");
                }
            }
        } else {
            $error = "Aucun destinataire trouvé pour les critères sélectionnés.";
        }
    } catch(Exception $e) {
        $error = "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi d'emails - FFCM Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/admin-nav.php'; ?>

        <main class="admin-content">
            <h1>Envoi d'emails aux adhérents</h1>

            <?php if ($message): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div class="mail-form-container">
                <form method="POST" class="mail-form">
                    <div class="form-group">
                        <label for="filter">Destinataires</label>
                        <select name="filter" id="filter" required>
                            <option value="all">Tous les adhérents</option>
                            <option value="no_response">Sans réponse à l'enquête</option>
                            <option value="inactive">Inactifs depuis 3 mois</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Sujet</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Message</label>
                        <textarea id="content" name="content" rows="10" required></textarea>
                        <p class="help-text">
                            
                        </p>
                    </div>

                    <div class="form-preview">
                        <h3>Aperçu du message</h3>
                        <div id="preview-content"></div>
                    </div>

                    <button type="submit" class="btn-primary">Envoyer les emails</button>
                </form>
            </div>
        </main>
    </div>

    <script>
    document.getElementById('content').addEventListener('input', function() {
        const preview = document.getElementById('preview-content');
        let content = this.value;
        
        // Remplacer les variables par des exemples
        content = content.replace('[NOM]', 'Dupont')
                        .replace('[PRENOM]', 'Jean');
        
        preview.innerHTML = content;
    });
    </script>
</body>
</html>
