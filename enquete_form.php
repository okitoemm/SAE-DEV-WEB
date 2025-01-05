<?php
session_start();
require_once 'config/database.php';

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Vérification si l'enquête a déjà été remplie
$stmt = $conn->prepare("SELECT COUNT(*) FROM reponse WHERE id_adherent = ?");
$stmt->execute([$_SESSION['user_id']]);
if ($stmt->fetchColumn() > 0) {
    header('Location: merci.php');
    exit;
}

// Récupération des questions et thématiques
$questions = [];
$stmt = $conn->query("SELECT q.*, t.nom_thematique 
                      FROM question q 
                      JOIN thematique t ON q.id_thematique = t.id_thematique 
                      WHERE q.actif = true AND t.actif = true
                      ORDER BY t.ordre, q.ordre");
                      
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Si la question a des options (choix unique/multiple), on les récupère
    if ($row['type_question'] === 'choix_unique' || $row['type_question'] === 'choix_multiple') {
        $options = $conn->query("SELECT * FROM option_reponse 
                                WHERE id_question = {$row['id_question']} 
                                ORDER BY ordre")->fetchAll();
        $row['options'] = $options;
    }
    $questions[$row['nom_thematique']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquête FFCM</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/enquete.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="enquete-container">
        <h1>Enquête sur les besoins des curistes</h1>
        
        <form id="enqueteForm" method="POST" action="traiter_enquete.php">
            <?php foreach ($questions as $thematique => $thematique_questions): ?>
                <section class="thematique">
                    <h2><?= htmlspecialchars($thematique) ?></h2>
                    
                    <?php foreach ($thematique_questions as $question): ?>
                        <div class="question-block">
                            <label for="q_<?= $question['id_question'] ?>">
                                <?= htmlspecialchars($question['texte_question']) ?>
                                <?php if ($question['obligatoire']): ?>
                                    <span class="required">*</span>
                                <?php endif; ?>
                            </label>

                            <?php switch($question['type_question']): 
                                case 'choix_unique': ?>
                                    <select name="reponse[<?= $question['id_question'] ?>]" 
                                            id="q_<?= $question['id_question'] ?>"
                                            <?= $question['obligatoire'] ? 'required' : '' ?>>
                                        <option value="">Choisir une réponse</option>
                                        <?php foreach ($question['options'] as $option): ?>
                                            <option value="<?= $option['id_option'] ?>">
                                                <?= htmlspecialchars($option['texte_option']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php break; ?>
<?php case 'choix_multiple': ?>
                                    <div class="checkbox-group">
                                        <?php foreach ($question['options'] as $option): ?>
                                            <label class="checkbox-label">
                                                <input type="checkbox" 
                                                       name="reponse[<?= $question['id_question'] ?>][]" 
                                                       value="<?= $option['id_option'] ?>">
                                                <?= htmlspecialchars($option['texte_option']) ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php break; ?>
<?php case 'texte_libre': ?>
                                    <textarea 
                                        name="reponse[<?= $question['id_question'] ?>]"
                                        id="q_<?= $question['id_question'] ?>"
                                        <?= $question['obligatoire'] ? 'required' : '' ?>
                                    ></textarea>
                                    <?php break; ?>
<?php case 'nombre': ?>
                                    <input type="number" 
                                           name="reponse[<?= $question['id_question'] ?>]"
                                           id="q_<?= $question['id_question'] ?>"
                                           <?= $question['obligatoire'] ? 'required' : '' ?>>
                                    <?php break; ?>
<?php case 'echelle': ?>
                                    <div class="echelle">
                                        <input type="range" 
                                               name="reponse[<?= $question['id_question'] ?>]"
                                               min="1" max="5" step="1"
                                               <?= $question['obligatoire'] ? 'required' : '' ?>>
                                        <div class="echelle-labels">
                                            <span>1</span>
                                            <span>2</span>
                                            <span>3</span>
                                            <span>4</span>
                                            <span>5</span>
                                        </div>
                                    </div>
                                    <?php break; ?>
<?php endswitch; ?>
                        </div>
                    <?php endforeach; ?>
                </section>
            <?php endforeach; ?>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Envoyer mes réponses</button>
            </div>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
    document.getElementById('enqueteForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let valid = true;

        requiredFields.forEach(field => {
            if (!field.value) {
                valid = false;
                field.classList.add('error');
            } else {
                field.classList.remove('error');
            }
        });

        if (!valid) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs obligatoires');
        }
    });
    </script>
        <?php include 'includes/footer.php'; ?>
</body>
</html>
