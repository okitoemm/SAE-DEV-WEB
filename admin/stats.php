<?php
session_start();
require_once '../config/database.php';

// Vérification des droits admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}

// Récupération des statistiques générales
try {
    // Stats globales
    $stats = [
        'total_adherents' => $conn->query("SELECT COUNT(*) FROM adherent")->fetchColumn(),
        'total_reponses' => $conn->query("SELECT COUNT(DISTINCT id_adherent) FROM reponse")->fetchColumn(),
        'derniere_reponse' => $conn->query("SELECT MAX(date_reponse) FROM reponse")->fetchColumn()
    ];

    // Stats par région
    $query_region = "
        SELECT a.region, COUNT(*) as nombre
        FROM adherent a 
        JOIN reponse r ON a.id_adherent = r.id_adherent
        GROUP BY a.region
        ORDER BY nombre DESC
    ";
    $stats_region = $conn->query($query_region)->fetchAll();

    // Stats par thématique
    $query_thematique = "
        SELECT t.nom_thematique, COUNT(DISTINCT r.id_adherent) as nombre_reponses
        FROM thematique t
        JOIN question q ON t.id_thematique = q.id_thematique
        JOIN reponse r ON q.id_question = r.id_question
        GROUP BY t.id_thematique
    ";
    $stats_thematique = $conn->query($query_thematique)->fetchAll();

} catch(PDOException $e) {
    die("Erreur lors de la récupération des statistiques : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - FFCM Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <script src="https://d3js.org/d3.v7.min.js"></script>
</head>
<body>
    <div class="admin-container">
        <?php include 'includes/admin-nav.php'; ?>

        <main class="admin-content">
            <h1>Statistiques de l'enquête</h1>

            <!-- Vue d'ensemble -->
            <div class="stats-overview">
                <div class="stat-card">
                    <h3>Total Adhérents</h3>
                    <div class="stat-number"><?= $stats['total_adherents'] ?></div>
                </div>
                <div class="stat-card">
                    <h3>Réponses à l'enquête</h3>
                    <div class="stat-number"><?= $stats['total_reponses'] ?></div>
                </div>
                <div class="stat-card">
                    <h3>Taux de participation</h3>
                    <div class="stat-number">
                        <?= round(($stats['total_reponses'] / $stats['total_adherents']) * 100, 1) ?>%
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="stats-charts">
                <div class="chart-container">
                    <h2>Répartition par région</h2>
                    <div id="region-chart"></div>
                </div>
                
                <div class="chart-container">
                    <h2>Participation par thématique</h2>
                    <div id="theme-chart"></div>
                </div>
            </div>
        </main>
    </div>

    <script>
    // Données pour les graphiques
    const regionData = <?= json_encode($stats_region) ?>;
    const themeData = <?= json_encode($stats_thematique) ?>;

    // Configuration des graphiques
    const margin = {top: 20, right: 20, bottom: 60, left: 60};
    const width = 600 - margin.left - margin.right;
    const height = 400 - margin.top - margin.bottom;

    // Graphique des régions
    const regionSvg = d3.select('#region-chart')
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
    y.domain([0, d3.max(regionData, d => d.nombre)]);

    // Axes
    regionSvg.append('g')
        .attr('transform', `translate(0,${height})`)
        .call(d3.axisBottom(x))
        .selectAll('text')
        .style('text-anchor', 'end')
        .attr('dx', '-.8em')
        .attr('dy', '.15em')
        .attr('transform', 'rotate(-45)');

    regionSvg.append('g')
        .call(d3.axisLeft(y));

    // Barres
    regionSvg.selectAll('rect')
        .data(regionData)
        .enter()
        .append('rect')
        .attr('x', d => x(d.region))
        .attr('width', x.bandwidth())
        .attr('y', d => y(d.nombre))
        .attr('height', d => height - y(d.nombre))
        .attr('fill', '#4682B4');

    // graphique thématique à faire 
    </script>
</body>
</html>
