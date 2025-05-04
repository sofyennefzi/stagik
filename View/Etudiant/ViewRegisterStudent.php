<?php
require_once("../../model/User.php");
require_once("../../model/Etudiant.php");
// Activer affichage d'erreurs
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Si formulaire soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if ($_POST['password'] !== $_POST['confirm_password']) {
        $message = "❌ Les mots de passe ne correspondent pas.";
    } else {
        // Connexion PDO
        $pdo = new PDO("mysql:host=localhost;dbname=stagi", "root", "");

        // Vérifier email
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$_POST['email']]);
        if ($stmt->rowCount() > 0) {
            $message = "❌ Cet email est déjà utilisé.";
        } else {
            // Créer utilisateur
            $stmt = $pdo->prepare("INSERT INTO utilisateur (email, mot_de_passe, role, telephone) VALUES (?, ?, 'etudiant', ?)");
$stmt->execute([
    $_POST['email'],
    password_hash($_POST['password'], PASSWORD_DEFAULT),
    $_POST['telephone']
]);

            $idUser = $pdo->lastInsertId();

            // Créer étudiant
            // Créer étudiant
            $stmt = $pdo->prepare("INSERT INTO etudiant (id, nom, prenom, universite, niveau_etudes, domaine_etudes, user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $idUser, // clé primaire (id)
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['universite'],
                $_POST['niveau_etudes'],
                $_POST['domaine_etudes'],
                $idUser  // clé étrangère user_id
            ]);
            


            $message = "✅ Inscription réussie !";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Étudiant - Stagik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/accueil.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .card-custom-border {
            border: 2px solid #0d6efd;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .btn-stagik {
            background-color: #0d6efd;
            color: white;
            font-weight: 600;
            border-radius: 30px;
        }
        .btn-stagik:hover {
            background-color: #084298;
        }
        h2.title-inscription {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0d6efd;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="../image/12-removebg-preview.png" alt="Stagik" height="40">
        </a>
    </div>
</nav>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-custom-border">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4 title-inscription">Inscription Étudiant</h2>

                        <form action="ViewRegisterStudent.php" method="POST">
    <div class="row g-3">
        <div class="col-md-6">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="col-md-6">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="col-12">
    <label for="telephone" class="form-label">Téléphone</label>
    <input type="text" class="form-control" id="telephone" name="telephone" required>
</div>
        <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="col-12">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="col-12">
            <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="col-12">
            <label for="universite" class="form-label">Université</label>
            <input type="text" class="form-control" id="universite" name="universite" required>
        </div>
        <div class="col-md-6">
            <label for="niveau" class="form-label">Niveau d'études</label>
            <select class="form-select" id="niveau" name="niveau_etudes" required>
                <option value="">Sélectionner...</option>
                <option value="licence">Licence</option>
                <option value="master">Master</option>
                <option value="bts">BTS</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="domaine" class="form-label">Domaine d'études</label>
            <input type="text" class="form-control" id="domaine" name="domaine_etudes" required>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="conditions" required>
                <label class="form-check-label" for="conditions">
                    J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a>
                </label>
            </div>
        </div>
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-stagik w-100">S'inscrire</button>
        </div>
    </div>

    <?php if (isset($message)) : ?>
        <div class="mt-3 alert alert-info text-center">
            <?= $message ?>
        </div>
    <?php endif; ?>
</form>

                        <div class="mt-3 text-center">
                            <p>Déjà un compte ? <a href="../Login.php">Connectez-vous</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-dark text-white py-4">
    <div class="container text-center">
        <p class="mb-0">&copy; 2025 Stagik. Tous droits réservés.</p>
    </div>
</footer>

</body>
</html>
