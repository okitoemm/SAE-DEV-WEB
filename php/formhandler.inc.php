<?php


global $pdo;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userfirstname = $_POST["firstname"];
    $userlastname = $_POST["lastname"];
    $useremail = $_POST["email"];
    $userpassword = $_POST["password"];
    $userconfirmpassword = $_POST["confirm-password"];
    $userterms = $_POST["terms"];
    try {
        require_once "dbh.inc.php";

        $query ="INSERT INTO adherent (email, mot_de_passe, nom, prenom, date_naissance, region, ville, statut) 
       VALUES (:email, :mot_de_passe, :nom, :prenom, :date_naissance, :region, :ville, :statut)";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':email', $useremail);
        $stmt->bindParam(':mot_de_passe', $userpassword);
        $stmt->bindParam(':nom', $userfirstname);
        $stmt->bindParam(':prenom', $userlastname);
        $stmt->bindParam(':date_naissance', $userdate);
        $stmt->bindParam(':region', $userregion);
        $stmt->bindParam(':ville', $userville);
        $stmt->bindParam(':statut', $userstat);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location:../html/index.html");
        die();


    }catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
    }
}else{
    header("Location:../html/index.html");
}