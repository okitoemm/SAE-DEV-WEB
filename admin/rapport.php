<?php
session_start();
require_once '../config/database.php';

// Vérification des droits admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}

try {
    // Statistiques générales
    $stats = [
        'total_adherents' => $conn->query("SELECT COUNT(*) FROM adherent")->fetchColumn(),
        'total_reponses' => $conn->query("SELECT COUNT(DISTINCT id_adherent) FROM reponse")->fetchColumn(),
        'derniere_reponse' => $conn->query("SELECT MAX(date_reponse) FROM reponse")->fetchColumn()
    ];
    
    // Calcul du taux de participation
    $stats['taux_participation'] = $stats['total_adherents'] > 0 
        ? round(($stats['total_reponses'] / $stats['total_adherents']) * 100, 1) 
        : 0;

    // Statistiques par région
    $region_query = "
        SELECT 
            COALESCE(a.region, 'Non spécifié') as region,
            COUNT(DISTINCT r.id_adherent) as nombre_reponses,
            COUNT(DISTINCT a.id_adherent) as total_adherents
        FROM adherent a
        LEFT JOIN reponse r ON a.id_adherent = r.id_adherent
        GROUP BY a.region
        ORDER BY nombre_reponses DESC
    ";
    $region_stats = $conn->query($region_query)->fetchAll(PDO::FETCH_ASSOC);

    // Statistiques par thématique
    $theme_query = "
        SELECT 
            t.nom_thematique,
            q.texte_question,
            q.type_question,
            COUNT(DISTINCT r.id_adherent) as nombre_reponses,
            GROUP_CONCAT(r.valeur_reponse SEPARATOR '|') as reponses
        FROM thematique t
        JOIN question q ON t.id_thematique = q.id_thematique
        LEFT JOIN reponse r ON q.id_question = r.id_question
        WHERE t.actif = 1
        GROUP BY t.id_thematique, q.id_question
        ORDER BY t.ordre, q.ordre
    ";
    $theme_stats = $conn->query($theme_query)->fetchAll(PDO::FETCH_GROUP);

} catch(PDOException $e) {
    $_SESSION['error'] = "Erreur lors de la récupération des statistiques : " . $e->getMessage();
    header('Location: index.php');
    exit;
}

// Fonction pour générer une couleur aléatoire
function getRandomColor() {
    $colors = ['#4682B4', '#5F9EA0', '#6495ED', '#4169E1', '#1E90FF', '#00BFFF'];
    return $colors[array_rand($colors)];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport - FFCM Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <style>
        .report-section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
        }
        .stat-number {
            font-size: 2.5rem;
            color: #004080;
            font-weight: bold;
        }
        .theme-block {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        .question-block {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1rem 0;
        }
        .response-bar {
            margin-bottom: 1rem;
        }
        .bar-container {
            background: #f1f1f1;
            border-radius: 4px;
            height: 24px;
            margin-top: 0.5rem;
        }
        .bar {
            background: #4682B4;
            height: 100%;
            border-radius: 4px;
            display: flex;
            align-items: center;
            padding: 0 0.5rem;
            color: white;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/admin-nav.php'; ?>

        <main class="admin-content">
            <div class="report-header">
                <h1>Rapport de l'enquête</h1>
                <div class="report-actions">
                    <a href="export.php?format=csv" class="btn-primary">Exporter CSV</a>
                </div>
            </div>

            <!-- Statistiques générales -->
            <div class="report-section">
                <h2>Vue d'ensemble</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Adhérents</h3>
                        <p class="stat-number"><?= $stats['total_adherents'] ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Réponses reçues</h3>
                        <p class="stat-number"><?= $stats['total_reponses'] ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Taux de participation</h3>
                        <p class="stat-number"><?= $stats['taux_participation'] ?>%</p>
                    </div>
                </div>
            </div>

            <!-- Statistiques par région -->
            <div class="report-section">
                <h2>Répartition géographique</h2>
                <div id="region-chart"></div>
            </div>

            <!-- Résultats par thématique -->
            <div class="report-section">
                <h2>Résultats détaillés</h2>
                <?php foreach ($theme_stats as $theme => $questions): ?>
                    <div class="theme-block">
                        <h3><?= htmlspecialchars($theme) ?></h3>
                        <?php foreach ($questions as $question): ?>
                            <div class="question-block">
                                <h4><?= htmlspecialchars($question['texte_question']) ?></h4>
                                <?php if (!empty($question['reponses'])): ?>
                                    <?php
                                    $reponses = array_filter(explode('|', $question['reponses']));
                                    if (!empty($reponses)):
                                        $reponses_count = array_count_values($reponses);
                                        arsort($reponses_count);
                                    ?>
                                    <div class="responses-chart">
                                        <?php foreach ($reponses_count as $reponse => $count): ?>
                                            <div class="response-bar">
                                                <div class="bar-label">
                                                    <?= htmlspecialchars($reponse) ?>
                                                    <span class="count">(<?= $count ?>)</span>
                                                </div>
                                                <div class="bar-container">
                                                    <div class="bar" style="width: <?= ($count / count($reponses) * 100) ?>%">
                                                        <?= round(($count / count($reponses) * 100), 1) ?>%
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php else: ?>
                                        <p class="no-data">Aucune réponse pour cette question</p>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script>
    // Configuration du graphique D3.js pour les régions
    const regionData = <?= json_encode($region_stats) ?>;
    
    const margin = {top: 20, right: 30, bottom: 60, left: 60};
    const width = 800 - margin.left - margin.right;
    const height = 400 - margin.top - margin.bottom;

    const svg = d3.select('#region-chart')
        .append('svg')
        .attr('width', width + margin.left + margin.right)
        .attr('height', height + margin.top + margin.bottom)
        .append('g')
        .attr('transform', `translate(${margin.left},${margin.top})`);

    const x = d3.scaleBand()
        .range([0, width])
        .padding(0.1);

    const y = d3.scaleLinear()
        .range([height, 0]);

    x.domain(regionData.map(d => d.region));
    y.domain([0, d3.max(regionData, d => +d.nombre_reponses)]);

    // Axe X
    svg.append('g')
        .attr('transform', `translate(0,${height})`)
        .call(d3.axisBottom(x))
        .selectAll('text')
        .style('text-anchor', 'end')
        .attr('dx', '-.8em')
        .attr('dy', '.15em')
        .attr('transform', 'rotate(-45)');

    // Axe Y
    svg.append('g')
        .call(d3.axisLeft(y));

    // Barres
    svg.selectAll('rect')
        .data(regionData)
        .enter()
        .append('rect')
        .attr('x', d => x(d.region))
        .attr('width', x.bandwidth())
        .attr('y', d => y(+d.nombre_reponses))
        .attr('height', d => height - y(+d.nombre_reponses))
        .attr('fill', '#4682B4');
    </script>
</body>
</html>
