<?php
session_start();
require_once 'config/database.php';

if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    try {
        // Vérification si l'email existe déjà
        $stmt = $conn->prepare("SELECT COUNT(*) FROM adherent WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->fetchColumn() > 0) {
            $error = "Cet email est déjà utilisé";
        } else {
            // Insertion du nouvel adhérent
            $stmt = $conn->prepare("INSERT INTO adherent (prenom, nom, email, mot_de_passe, date_inscription) VALUES (?, ?, ?, ?, NOW())");
            if($stmt->execute([$firstname, $lastname, $email, $password])) {
                $_SESSION['success'] = "Compte créé avec succès";
                header('Location: connexion.php');
                exit;
            }
        }
    } catch(PDOException $e) {
        $error = "Erreur lors de l'inscription";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - FFCM</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/connexion.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Créer un compte</h1>
                <p>Rejoignez la communauté FFCM</p>
            </div>

            <?php if(isset($error)): ?>
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?php echo htmlspecialchars($_SESSION['success']); ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>


            <form id="registerForm" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" id="firstname" name="firstname" required 
                           value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>">
                    <div class="error" id="firstnameError"></div>
                </div>

                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input type="text" id="lastname" name="lastname" required
                           value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>">
                    <div class="error" id="lastnameError"></div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <div class="error" id="emailError"></div>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="password-input-container">
                        <input type="password" id="password" name="password" required>
                        <button type="button" class="toggle-password">
                            <img src="imgs/eye.svg" alt="Voir/Masquer">
                        </button>
                    </div>
                    <div class="password-requirements">
                        <ul>
                            <li id="length">8 caractères minimum</li>
                            <li id="uppercase">Une majuscule</li>
                            <li id="lowercase">Une minuscule</li>
                            <li id="number">Un chiffre</li>
                            <li id="special">Un caractère spécial</li>
                        </ul>
                    </div>
                    <div class="error" id="passwordError"></div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirmer le mot de passe</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                    <div class="error" id="confirmPasswordError"></div>
                </div>

                <div class="form-options">
                    <div class="terms">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">J'accepte les conditions d'utilisation et la politique de confidentialité</label>
                    </div>
                </div>

                <button type="submit" class="auth-button">S'inscrire</button>

                <div class="auth-footer">
                    <p>Vous avez déjà un compte ?</p>
                    <a href="connexion.php" class="switch-auth">Se connecter</a>
                </div>
            </form>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script>
        /*
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        let isValid = true;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // Validation mot de passe
        if(password !== confirmPassword) {
            document.getElementById('confirmPasswordError').textContent = "Les mots de passe ne correspondent pas";
            isValid = false;
        }

        // Validation complexité mot de passe
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if(!passwordRegex.test(password)) {
            document.getElementById('passwordError').textContent = "Le mot de passe ne respecte pas les critères";
            isValid = false;
        }

        if(!isValid) {
            e.preventDefault();
        }
    });*/
    </script>


<?php include 'includes/footer.php'; ?>
</body>
</html>
