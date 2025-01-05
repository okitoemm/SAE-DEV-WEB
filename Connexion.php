<?php
session_start();
require_once 'config/database.php';

if(isset($_SESSION['user_id'])) {
    if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        header('Location: admin/index.php');
    } else {
        header('Location: index.php');
    }
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    try {
        // Vérifier d'abord si c'est un admin
        $stmt = $conn->prepare("SELECT id_admin, mot_de_passe FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();
        
        if($admin && password_verify($password, $admin['mot_de_passe'])) {
            $_SESSION['user_id'] = $admin['id_admin'];
            $_SESSION['role'] = 'admin';
            header('Location: admin/index.php');
            exit;
        }
        
        // Si ce n'est pas un admin, vérifier si c'est un adhérent
        $stmt = $conn->prepare("SELECT id_adherent, mot_de_passe FROM adherent WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id_adherent'];
            $_SESSION['role'] = 'adherent';
            header('Location: index.php');
            exit;
        } else {
            $error = "Identifiants incorrects";
        }
    } catch(PDOException $e) {
        $error = "Erreur de connexion";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - FFCM</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/Connexion.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="auth-container">
        <div class="auth-box">
            <div class="auth-header">
                <h1>Connexion</h1>
                <p>Accédez à votre espace personnel</p>
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



            <form id="loginForm" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <div class="password-input-container">
                        <input type="password" id="password" name="password" required>
                        <button type="button" class="toggle-password">
                            <img src="/imgs/ImgsAccueil/logoSite/Icons/closed-eyes.png" alt="Voir/Masquer">
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Se souvenir de moi</label>
                    </div>
                    <a href="reset-password.php">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="auth-button">Se connecter</button>

                <div class="auth-footer">
                    <p>Vous n'avez pas de compte ?</p>
                    <a href="inscription.php">Créer un compte</a>
                </div>
            </form>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
    
    <script src="js/script.js"></script>
</body>
</html>
