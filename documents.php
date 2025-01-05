<?php
session_start();
require_once 'config/database.php';
include 'includes/header.php';

// Vérification si l'utilisateur est connecté 
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}
?>

    <!-- SECTION DOCUMENTS-->
    <section class="events-section-doc">
        <h2>Nos Documents</h2>

        <div class="event-cards-doc">
            <div id="card1" class="event-card-doc">
                <img src="../img/ImgdDocuments/cure-pratique.jpg" alt="La cure en pratique">
                <h3>La cure en pratique </h3>

            </div>

            <div id="card2" class="event-card-doc">
                <img src="../img/ImgdDocuments/nos-actions.jpg" alt="Nos actions">
                <h3>Nos actions</h3>

            </div>

            <div id="card3" class="event-card-doc">
                <img src="../img/ImgdDocuments/divers.png" alt="Divers">
                <h3>Divers</h3>

            </div>

            <div id="card4" class="event-card-doc">
                <img src="../img/ImgdDocuments/logoffcm.png" alt="Vie de la FFCM">
                <h3>Vie de la FFCM</h3>

            </div>
        </div>
    </section>

    <!--Début des accordéons-->
    <div class="container-doc">
        <div id="container-doc-content-1" class="container-doc-content">
            <div class="accordion-header">
                <h3 id="accordion-1" class="accordion">La cure en pratique</h3>
                <button class="toggle-btn" id="button-1">+</button>
            </div>
            <div  class="accordion-content">
                <ul>
                    <li><a href="https://www.medecinethermale.fr/curistes/les-stations/annuaire-des-stations-thermales.html">Destinations Thermales</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_876f2f53e9964f6f84f8292fc83cfc5f.pdf">Réservations de cure</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_a5d56d81833d4ed89b2fbcaf216c063a.pdf">Droits des curistes 05/2019</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_367049c0f5124ac0bb14d056f931e79b.pdf">Guide des Bonnes Pratiques</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_4e6fd7d9cc504791bf42ac7f46933001.pdf">Exts Code déontologie médicale</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_89207aa2fcb64e708c86b6323229bcf0.pdf">Complément Tarifaire 2024</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_6e0813b03bc345ed9bceb0dec365e846.pdf">AQUAE visite de milieu de cure</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_3dc1a59bb79a4b69b6b2905e2cc22183.pdf">Imprimé prise en charge</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_1f274dafc1e1477dab60d732e4bb2b6e.pdf">Prise En Charge: 1 mois maxi</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_1f274dafc1e1477dab60d732e4bb2b6e.pdf">Prise En Charge immédiate</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_7232ebc93be64424b44300f12c3cc607.pdf">Copie d’une Prise En Charge</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_90b9106e74df41caba437c49bdce2e43.pdf">Relevé de remboursement</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_098086f9449343a0a3a28a1603b1aecc.pdf">Hébergement et transport</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_f1e4063808bd496cbe243dcdf4965e12.pdf">3 visites de cure obligatoires</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_dc1bf3ee2d684e498539ffa5168d1aa8.pdf">Grille des Soins V 2023</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_42167340a2d44ae1bdbaf3a580e07844.pdf">Grille des Soins V 2021</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_498d45ffe9fc407c9feed50970d6988e.pdf">Grille des Soins V 2018</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_8a165ebd5e014bd9bb95cb26326b4dfd.pdf">Grille des Soins V 2005</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_bc65361f00da44f0aec5a8d357fa24f4.pdf">Charte du curiste V 2023</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_7699cc7158684e6aadada3aff421bf19.pdf">Utiliser la Charte curiste</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_55db959a994b4f8585c08a5a101d3dc0.pdf">Questionnaire satisfaction curiste</a></li>
                </ul>
            </div>

        </div>
        <div id="container-doc-content-2" class="container-doc-content">
            <div class="accordion-header">
                <h3 id="accordion-2" class="accordion">Nos actions</h3>
                <button class="toggle-btn" id="button-2">+</button>
            </div>
            <div  class="accordion-content">
                <ul>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_012ed77a88414b48877fd1f66941daa4.pdf">Nos principales actions</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_754ca2127c7142b19c60b2a2ff248402.pdf">Tiers-Payant Ministre Santé</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_6b005e9721014f8e9b84aa719ad610f2.pdf">Alerte FFCM 2015</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_7d2fb47becc945d0ba13113db3158dee.pdf">À propos des fraudes</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_12758ac1df61405b942f0953b4a87813.pdf">Délégué Tiers-Payant CAMIEG</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_889b5d300dd04d049aeee54cdf8e0f86.pdf">Oui aux 3 visites médicales</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_7a8c7443ec7f40e19c7d5f7986ff67fa.pdf">Tiers-Payant - Lettres Type</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_59cfd311bc5a4b38a2ef2c86c1a47de7.pdf">Délégué pour le Handicap</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_8784cab9cfbc40f3bdba2fc0f2ead630.pdf">Plainte CPNT du 03/12/2015</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_e506853b5f1a4ef8b7617d978ef12acc.pdf">2 cures/an c'est possible</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_4da072e636bb4754b0e10a76540ade18.pdf">Vigilance mars 2024</a></li>
                </ul>
            </div>
        </div>
        <div id="container-doc-content-3" class="container-doc-content">
            <div class="accordion-header">
                <h3 id="accordion-3" class="accordion">Divers</h3>
                <button class="toggle-btn" id="button-3">+</button>
            </div>
            <div  class="accordion-content">
                <ul>
                    <li><a href="http://campus.cerimes.fr/maieutique/UE-sante-societe-humanite/droit_patient/site/html/cours.pdf">Loi (droits des malades)</a></li>
                    <li><a href="http://www.medecinethermale.fr/videos">Vidéos diverses</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_fb6feb5ca87244f59390f74e7ada0efb.pdf">Charte Parcours de Santé</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_31b8ba09825c464a935b7476b2592a43.pdf">Décret n° 2014-1025</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_49de7404ba0b45b8b51773b44ad9cd81.pdf">Rapport patient-médecin</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_58a24ac9f8cd445ba41dfb17f2d81797.pdf">Données économiques (CNETh)</a></li>
                </ul>
            </div>
        </div>
        <div id="container-doc-content-4" class="container-doc-content">
            <div class="accordion-header">
                <h3 id="accordion-4" class="accordion">La vie de la FFCM</h3>
                <button class="toggle-btn" id="button-4">+</button>
            </div>
            <div  class="accordion-content">
                <ul>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_c1a67369d12941358587535fb64b88e8.pdf">Règlement Intérieur</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_7a6fb1187e2c4bf8a188c2589a9e0ac1.pdf">Statuts (02/05/2024)</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_86ef717cb8164ae88e6672b6de1c98d1.pdf">QUI SOMMES NOUS?</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_b10361b9cddd40e1b7f07f6aede3e7f1.pdf">Renouvel Agreement 2022</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_74e4c9b49cae43d496a8c4a5dd83e953.pdf">2017 - Fondation de l'UNASS</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_e779a1057aab4262b479debaa31024fe.pdf">Élus au Bureau et au CA</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_fd1d5741190448d8a647be305f3d2251.pdf">2016 - Loi - Adoption GSC Assemblée Nationale</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_7be20a74fe23410ab23c61da7be8468c.pdf">2017 - Certificat de naissance de l'ENTEC</a></li>
                    <li><a href="https://www.ffcm.info/_files/ugd/cdd428_c598c21818e449ba907add336445687a.pdf">2019 - Avis Antidopage de l'UNASS</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--Fin des accordéons-->
    <?php include 'includes/footer.php'; ?>
