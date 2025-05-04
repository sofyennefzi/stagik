<?php
session_start();
require_once("../Model/Model.php");
require_once("../Model/User.php");

$error = '';
if (isset($_GET['redirect']) && isset($_GET['offre_id'])) {
    $_SESSION['redirect_to'] = $_GET['redirect'] . '?offre_id=' . $_GET['offre_id'];
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    $pdo = Model::connect();
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email LIMIT 1");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] === 'entreprise') {
            $stmt = $pdo->prepare("SELECT * FROM entreprise WHERE user_id = ?");
            $stmt->execute([$user['id']]);
            $entreprise = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($entreprise) {
                // Vérifie le statut de validation
                if ($entreprise['statut_validation'] === 'pending') {
                    header("Location: /ProjetPHP/View/Entreprise/EnAttenteValidation.php");
                    exit;
                } elseif ($entreprise['statut_validation'] === 'refuse') {
                    header("Location: /ProjetPHP/View/Entreprise/RefuseValidation.php");
                    exit;
                }
        
                // Si tout est ok, stocke l'id entreprise dans la session
                $_SESSION['entreprise_id'] = $entreprise['id'];
            }
        }
        
        if ($user['role'] === 'admin') {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'admin';
            header("Location: Admin/Dashboard.php");
            exit;
        }
        
        // Si redirection vers une offre après login
        if (isset($_SESSION['redirect_to'])) {
            $redirect = $_SESSION['redirect_to'];
            unset($_SESSION['redirect_to']);
            header("Location: $redirect");
            exit;
        }

        header("Location: Acceuil.php");
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion | Stagik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/accueil.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border-radius: 16px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e2e2;
            padding: 30px;
        }
        .btn-primary {
            background-color: #0e866e;
            border: none;
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 8px;
        }
        .btn-primary:hover {
            background-color: #0c6d58;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<?php include("Navbar.php"); ?>

<!-- Formulaire stylisé -->
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card">
          <h2 class="text-center mb-4">Connexion</h2>

          <?php if ($error): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Adresse email</label>
              <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
              <label for="mot_de_passe" class="form-label">Mot de passe</label>
              <input type="password" class="form-control" name="mot_de_passe" required>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </div>
          </form>

          <div class="text-center mt-4">
              <?php if (isset($_GET['redirect']) && $_GET['redirect'] === 'Etudiant/ViewPostuler.php'): ?>
                  <p>Pas encore de compte ? 
                      <a href="/ProjetPHP/View/Etudiant/ViewRegisterStudent.php">Inscrivez-vous comme étudiant</a>
                  </p>
              <?php else: ?>
                  <p>Pas encore de compte ? 
                      <a href="/ProjetPHP/View/Inscrit.php">Créer un compte</a>
                  </p>
              <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<?php include("Footer.php"); ?>
</body>
</html>
