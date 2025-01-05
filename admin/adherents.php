<?php
session_start();
require_once '../config/database.php';

// Vérification des droits admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}

// Gestion de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id) {
        try {
            $stmt = $conn->prepare("DELETE FROM adherent WHERE id_adherent = ?");
            $stmt->execute([$id]);
            $_SESSION['success'] = "Adhérent supprimé avec succès.";
        } catch(PDOException $e) {
            $_SESSION['error'] = "Erreur lors de la suppression : " . $e->getMessage();
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Pagination
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Recherche - Utiliser FILTER_SANITIZE_FULL_SPECIAL_CHARS au lieu de FILTER_SANITIZE_STRING
$search = trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
$whereClause = $search ? "WHERE nom LIKE :search OR prenom LIKE :search OR email LIKE :search OR region LIKE :search" : "";

try {
    // Récupération du nombre total d'adhérents
    $countQuery = "SELECT COUNT(*) FROM adherent " . $whereClause;
    $stmt = $conn->prepare($countQuery);
    if ($search) {
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam);
    }
    $stmt->execute();
    $total = $stmt->fetchColumn();
    $pages = ceil($total / $limit);

    // Récupération des adhérents
    $query = "
        SELECT 
            id_adherent,
            COALESCE(nom, '') as nom,
            COALESCE(prenom, '') as prenom,
            COALESCE(email, '') as email,
            COALESCE(region, '') as region,
            date_inscription
        FROM adherent 
        $whereClause 
        ORDER BY date_inscription DESC 
        LIMIT :limit OFFSET :offset
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    if ($search) {
        $stmt->bindParam(':search', $searchParam);
    }
    $stmt->execute();
    $adherents = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $_SESSION['error'] = "Erreur lors de la récupération des données : " . $e->getMessage();
    $adherents = [];
    $pages = 0;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des adhérents - FFCM Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/admin-nav.php'; ?>

        <main class="admin-content">
            <h1>Gestion des adhérents</h1>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire de recherche -->
            <div class="search-section">
                <form method="GET" class="search-form">
                    <input type="text" name="search" 
                           value="<?= htmlspecialchars($search) ?>" 
                           placeholder="Rechercher un adhérent..." 
                           class="search-input">
                    <button type="submit" class="btn-primary">Rechercher</button>
                </form>
            </div>

            <!-- Tableau des adhérents -->
            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Région</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($adherents as $adherent): ?>
                            <tr>
                                <td><?= htmlspecialchars($adherent['nom']) ?></td>
                                <td><?= htmlspecialchars($adherent['prenom']) ?></td>
                                <td><?= htmlspecialchars($adherent['email']) ?></td>
                                <td><?= htmlspecialchars($adherent['region']) ?></td>
                                <td><?= date('d/m/Y', strtotime($adherent['date_inscription'])) ?></td>
                                <td class="actions">
                                    <a href="edit_adherent.php?id=<?= $adherent['id_adherent'] ?>" 
                                       class="btn-edit">Modifier</a>
                                    <form method="POST" class="delete-form" style="display: inline;">
                                        <input type="hidden" name="id" value="<?= $adherent['id_adherent'] ?>">
                                        <button type="submit" name="delete" class="btn-delete"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet adhérent ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($adherents)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Aucun adhérent trouvé</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($pages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <a href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>" 
                           class="page-link <?= $i === $page ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
    // Confirmation de suppression
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet adhérent ?')) {
                e.preventDefault();
            }
        });
    });
    </script>
</body>
</html>
