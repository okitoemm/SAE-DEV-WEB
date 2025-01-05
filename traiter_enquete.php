<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['reponse'])) {
    header('Location: enquete_form.php');
    exit;
}

try {
    // Démarrer la transaction avant toute opération
    $conn->beginTransaction();
    
    // Vérification si l'enquête a déjà été remplie
    $stmt = $conn->prepare("SELECT COUNT(*) FROM reponse WHERE id_adherent = ?");
    $stmt->execute([$_SESSION['user_id']]);
    if ($stmt->fetchColumn() > 0) {
        throw new Exception("Vous avez déjà répondu à cette enquête.");
    }

    // Récupération des questions obligatoires
    $stmt = $conn->query("SELECT id_question FROM question WHERE obligatoire = 1");
    $obligatoires = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Vérification des réponses obligatoires
    foreach ($obligatoires as $question_id) {
        if (!isset($_POST['reponse'][$question_id]) || empty($_POST['reponse'][$question_id])) {
            throw new Exception("Veuillez répondre à toutes les questions obligatoires.");
        }
    }

    // Insertion des réponses
    $stmt = $conn->prepare("INSERT INTO reponse (id_adherent, id_question, valeur_reponse, date_reponse) VALUES (?, ?, ?, NOW())");

    foreach ($_POST['reponse'] as $question_id => $reponse) {
        // Traitement des réponses multiples
        if (is_array($reponse)) {
            $reponse = implode(',', $reponse);
        }
        
        // Nettoyage et validation de la réponse
        $reponse = trim(htmlspecialchars($reponse));
        
        // Validation du type de question
        $stmt_check = $conn->prepare("SELECT type_question FROM question WHERE id_question = ?");
        $stmt_check->execute([$question_id]);
        $type = $stmt_check->fetchColumn();
        
        switch ($type) {
            case 'nombre':
                if (!is_numeric($reponse)) {
                    throw new Exception("Format de réponse invalide pour une question numérique.");
                }
                break;
            case 'echelle':
                if (!is_numeric($reponse) || $reponse < 1 || $reponse > 5) {
                    throw new Exception("Valeur d'échelle invalide.");
                }
                break;
            case 'choix_unique':
            case 'choix_multiple':
                $stmt_check = $conn->prepare("SELECT COUNT(*) FROM option_reponse WHERE id_option = ? AND id_question = ?");
                $options = explode(',', $reponse);
                foreach ($options as $option) {
                    $stmt_check->execute([$option, $question_id]);
                    if ($stmt_check->fetchColumn() == 0) {
                        throw new Exception("Option de réponse invalide.");
                    }
                }
                break;
        }
        
        // Insertion de la réponse
        if (!$stmt->execute([$_SESSION['user_id'], $question_id, $reponse])) {
            throw new Exception("Erreur lors de l'enregistrement des réponses.");
        }
    }

    // Si tout s'est bien passé, on valide la transaction
    $conn->commit();
    
    // Enregistrement de la date de complétion
    $stmt = $conn->prepare("UPDATE adherent SET derniere_enquete = NOW() WHERE id_adherent = ?");
    $stmt->execute([$_SESSION['user_id']]);
    
    // Redirection vers la page de remerciement
    header('Location: merci.php');
    exit;

} catch (Exception $e) {
    // On ne fait le rollback que si une transaction est active
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    $_SESSION['error'] = $e->getMessage();
    header('Location: enquete_form.php');
    exit;
}
?>
