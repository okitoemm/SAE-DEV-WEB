<?php
session_start();
require_once '../config/database.php';
require_once '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Vérification des droits admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../connexion.php');
    exit;
}

try {
    // Récupération des données
    $query = "
        SELECT 
            a.nom,
            a.prenom,
            a.email,
            a.region,
            t.nom_thematique,
            q.texte_question,
            r.valeur_reponse,
            DATE_FORMAT(r.date_reponse, '%d/%m/%Y %H:%i') as date_reponse
        FROM reponse r
        JOIN adherent a ON r.id_adherent = a.id_adherent
        JOIN question q ON r.id_question = q.id_question
        JOIN thematique t ON q.id_thematique = t.id_thematique
        ORDER BY a.id_adherent, t.ordre, q.ordre
    ";
    
    $stmt = $conn->query($query);
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $format = $_GET['format'] ?? 'xlsx';
    
    switch($format) {
        case 'xlsx':
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Style pour les en-têtes
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['rgb' => '4F81BD']
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN
                    ]
                ]
            ];

            // En-têtes
            $headers = array_keys($resultats[0]);
            foreach ($headers as $col => $header) {
                $sheet->setCellValueByColumnAndRow($col + 1, 1, $header);
            }
            $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray($headerStyle);

            // Données
            foreach ($resultats as $row => $data) {
                foreach ($data as $col => $value) {
                    $sheet->setCellValueByColumnAndRow(
                        array_search($col, array_keys($data)) + 1,
                        $row + 2,
                        $value
                    );
                }
            }

            // Auto-dimensionnement des colonnes
            foreach (range('A', $sheet->getHighestColumn()) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // En-têtes HTTP
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="resultats_enquete.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            break;

        case 'csv':
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="resultats_enquete.csv"');
            
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
            
            // En-têtes
            fputcsv($output, array_keys($resultats[0]), ';');
            
            // Données
            foreach ($resultats as $row) {
                fputcsv($output, $row, ';');
            }
            fclose($output);
            break;
    }

} catch(Exception $e) {
    $_SESSION['error'] = "Erreur lors de l'export : " . $e->getMessage();
    header('Location: index.php');
    exit;
}
?>
