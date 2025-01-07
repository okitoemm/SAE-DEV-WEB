<?php

use PHPUnit\Framework\TestCase;

class InscriptionTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        // Simule une connexion à une base de données SQLite en mémoire pour les tests
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Crée une table pour simuler `adherent`
        $this->pdo->exec("
            CREATE TABLE adherent (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                prenom TEXT,
                nom TEXT,
                email TEXT UNIQUE,
                mot_de_passe TEXT,
                date_inscription TEXT
            )
        ");
    }

    public function testEmailAlreadyExists()
    {
        // Insère un utilisateur existant
        $this->pdo->exec("
            INSERT INTO adherent (prenom, nom, email, mot_de_passe, date_inscription)
            VALUES ('Jean', 'Dupont', 'test@example.com', 'hashed_password', datetime('now'))
        ");

        // Simule une soumission d'email déjà existant
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM adherent WHERE email = ?");
        $stmt->execute(['test@example.com']);
        $count = $stmt->fetchColumn();

        $this->assertEquals(1, $count, "L'email devrait déjà exister.");
    }

    public function testSuccessfulRegistration()
    {
        // Simule l'insertion d'un utilisateur valide
        $stmt = $this->pdo->prepare("
            INSERT INTO adherent (prenom, nom, email, mot_de_passe, date_inscription)
            VALUES (?, ?, ?, ?, datetime('now'))
        ");
        $result = $stmt->execute(['Alice', 'Doe', 'alice@example.com', password_hash('SecureP@ss123', PASSWORD_DEFAULT)]);

        $this->assertTrue($result, "L'utilisateur devrait être ajouté avec succès.");

        // Vérifie que l'utilisateur est dans la base
        $stmt = $this->pdo->prepare("SELECT * FROM adherent WHERE email = ?");
        $stmt->execute(['alice@example.com']);
        $user = $stmt->fetch();

        $this->assertNotEmpty($user, "L'utilisateur devrait exister dans la base de données.");
    }

    public function testInvalidPassword()
    {
        $password = "short";
        $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

        $this->assertFalse(preg_match($passwordRegex, $password) === 1, "Le mot de passe ne respecte pas les critères.");
    }

    public function testRedirectIfLoggedIn()
    {
        $_SESSION['user_id'] = 1;
        $this->expectOutputRegex('/Location: index\.php/');

        // Simule le code de redirection
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php');
            exit;
        }
    }
}
