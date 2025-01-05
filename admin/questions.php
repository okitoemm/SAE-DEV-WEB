<?php
session_start();
require_once '../config/database.php';

// Vérification des droits admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}

// Gestion de l'ajout/modification de question
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $texte = filter_input(INPUT_POST, 'texte_question', FILTER_SANITIZE_STRING);
        $thematique = filter_input(INPUT_POST, 'thematique', FILTER_SANITIZE_NUMBER_INT);
        $type = filter_input(INPUT_POST, 'type_question', FILTER_SANITIZE_STRING);
        $obligatoire = isset($_POST['obligatoire']) ? 1 : 0;
        $ordre = filter_input(INPUT_POST, 'ordre', FILTER_SANITIZE_NUMBER_INT);

        if ($_POST['action'] === 'add') {
            $stmt = $conn->prepare("INSERT INTO question (texte_question, id_thematique, type_question, obligatoire, ordre) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$texte, $thematique, $type, $obligatoire, $ordre]);
        } elseif ($_POST['action'] === 'edit') {
            $id = filter_input(INPUT_POST, 'id_question', FILTER_SANITIZE_NUMBER_INT);
            $stmt = $conn->prepare("UPDATE question SET texte_question = ?, id_thematique = ?, type_question = ?, obligatoire = ?, ordre = ? WHERE id_question = ?");
            $stmt->execute([$texte, $thematique, $type, $obligatoire, $ordre, $id]);
        }
        header('Location: questions.php?message=Opération réussie');
        exit;
    }
}

// Suppression d'une question
if (isset($_POST['delete'])) {
    $id = filter_input(INPUT_POST, 'id_question', FILTER_SANITIZE_NUMBER_INT);
    $stmt = $conn->prepare("DELETE FROM question WHERE id_question = ?");
    $stmt->execute([$id]);
    header('Location: questions.php?message=Question supprimée');
    exit;
}

// Récupération des thématiques
$thematiques = $conn->query("SELECT * FROM thematique WHERE actif = 1 ORDER BY ordre")->fetchAll();

// Récupération des questions avec leurs thématiques
$questions = $conn->query("
    SELECT q.*, t.nom_thematique 
    FROM question q 
    JOIN thematique t ON q.id_thematique = t.id_thematique 
    WHERE q.actif = 1 
    ORDER BY t.ordre, q.ordre
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des questions - FFCM Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/admin-nav.php'; ?>

        <main class="admin-content">
            <h1>Gestion des questions</h1>

            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_GET['message']) ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire d'ajout/modification -->
            <div class="form-container">
                <h2>Ajouter une question</h2>
                <form method="POST" class="question-form">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id_question" value="">

                    <div class="form-group">
                        <label for="thematique">Thématique</label>
                        <select name="thematique" required>
                            <?php foreach ($thematiques as $thematique): ?>
                                <option value="<?= $thematique['id_thematique'] ?>">
                                    <?= htmlspecialchars($thematique['nom_thematique']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="texte_question">Question</label>
                        <textarea name="texte_question" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="type_question">Type de question</label>
                        <select name="type_question" required>
                            <option value="texte_libre">Texte libre</option>
                            <option value="choix_unique">Choix unique</option>
                            <option value="choix_multiple">Choix multiple</option>
                            <option value="nombre">Nombre</option>
                            <option value="echelle">Échelle</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="obligatoire">
                            Question obligatoire
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="ordre">Ordre d'affichage</label>
                        <input type="number" name="ordre" min="1" required>
                    </div>

                    <button type="submit" class="btn-primary">Ajouter la question</button>
                </form>
            </div>

            <!-- Liste des questions -->
            <div class="questions-list">
                <h2>Questions existantes</h2>
                <?php foreach ($thematiques as $thematique): ?>
                    <div class="thematique-section">
                        <h3><?= htmlspecialchars($thematique['nom_thematique']) ?></h3>
                        <?php
                        $thematique_questions = array_filter($questions, function($q) use ($thematique) {
                            return $q['id_thematique'] === $thematique['id_thematique'];
                        });
                        ?>
                        <?php foreach ($thematique_questions as $question): ?>
                            <div class="question-item">
                                <div class="question-content">
                                    <p class="question-text"><?= htmlspecialchars($question['texte_question']) ?></p>
                                    <p class="question-details">
                                        Type: <?= htmlspecialchars($question['type_question']) ?> |
                                        Ordre: <?= $question['ordre'] ?> |
                                        <?= $question['obligatoire'] ? 'Obligatoire' : 'Facultative' ?>
                                    </p>
                                </div>
                                <div class="question-actions">
                                    <button class="btn-edit" onclick="editQuestion(<?= htmlspecialchars(json_encode($question)) ?>)">
                                        Modifier
                                    </button>
                                    <form method="POST" class="delete-form">
                                        <input type="hidden" name="id_question" value="<?= $question['id_question'] ?>">
                                        <button type="submit" name="delete" class="btn-delete"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script>
    function editQuestion(question) {
        const form = document.querySelector('.question-form');
        form.querySelector('[name="action"]').value = 'edit';
        form.querySelector('[name="id_question"]').value = question.id_question;
        form.querySelector('[name="thematique"]').value = question.id_thematique;
        form.querySelector('[name="texte_question"]').value = question.texte_question;
        form.querySelector('[name="type_question"]').value = question.type_question;
        form.querySelector('[name="obligatoire"]').checked = question.obligatoire === "1";
        form.querySelector('[name="ordre"]').value = question.ordre;
        form.querySelector('button[type="submit"]').textContent = 'Modifier la question';
        form.scrollIntoView({ behavior: 'smooth' });
    }
    </script>
</body>
</html>
