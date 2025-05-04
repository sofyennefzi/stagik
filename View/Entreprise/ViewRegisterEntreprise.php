<?php
require_once("../../model/User.php");
require_once("../../model/Entreprise.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 1. Sécuriser l'accès aux champs avec `?? null`
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $confirm_password = $_POST['confirm_password'] ?? null;
    $telephone = $_POST['telephone'] ?? null;
    $nom_entreprise = $_POST['nom_entreprise'] ?? null;
    $secteur = $_POST['secteur'] ?? null;
    $taille = $_POST['taille'] ?? null;
    $adresse = $_POST['adresse'] ?? null;
    $description = $_POST['description'] ?? null;

    // 2. Vérification mot de passe
    if ($password !== $confirm_password) {
        $message = "❌ Les mots de passe ne correspondent pas.";
    } else {
        // 3. Connexion à la base
        $pdo = new PDO("mysql:host=localhost;dbname=stagi", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 4. Vérifier si email déjà utilisé
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetchColumn() > 0) {
            $message = "❌ Cet email est déjà utilisé.";
        } else {
            // 5. Créer compte utilisateur
            $stmt = $pdo->prepare("INSERT INTO utilisateur (email, mot_de_passe, role, telephone) VALUES (?, ?, 'entreprise', ?)");
            $stmt->execute([
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $telephone
            ]);

            $idUser = $pdo->lastInsertId();

            // 6. Gérer l'image
            $imagePath = null;
            if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
                $uploadDir = "../../uploads/";
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $imageName = uniqid() . "_" . basename($_FILES["image"]["name"]);
                $fullPath = $uploadDir . $imageName;

                move_uploaded_file($_FILES["image"]["tmp_name"], $fullPath);
                $imagePath = "uploads/" . $imageName;
            }

            // 7. Créer entreprise
            $stmt = $pdo->prepare("INSERT INTO entreprise (nom, secteur, taille, adresse, image, description, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $nom_entreprise,
                $secteur,
                $taille,
                $adresse,
                $imagePath,
                $description,
                $idUser
            ]);

            $message = "✅ Inscription réussie ! Vous pouvez maintenant vous connecter.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Entreprise - Stagik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/accueil.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
}
</style>
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
    
    /* Style pour la carte du formulaire */
    .card-custom-border {
        border: 2px solid #0d6efd; /* Bordure bleue moderne */
        border-radius: 15px; /* Coins arrondis */
        padding: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); /* Légère ombre */
        background-color: #fff; /* Fond blanc */
    }
    
    /* Bouton personnalisé */
    .btn-stagik {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 10px 20px;
        font-weight: 600;
        border-radius: 30px;
        transition: background-color 0.3s;
    }
    
    .btn-stagik:hover {
        background-color: #084298;
    }
    </style>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Style du titre Inscription Étudiant */
        h2.title-inscription {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem; /* Taille du texte */
            font-weight: 700; /* Gras */
            color: #0d6efd; /* Bleu Stagik */
            text-transform: uppercase; /* Majuscules élégantes */
            letter-spacing: 2px; /* Espacement entre les lettres */
            margin-bottom: 30px; /* Marge en dessous */
        }
        </style>
        
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="accueil.html">
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
                            <h2 class="text-center mb-4 title-inscription">Inscription Entreprise</h2>
                            
                            <form action="ViewRegisterEntreprise.php" method="POST" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="nom_entreprise" class="form-label">Nom de l'entreprise</label>
                                        <input type="text" class="form-control" id="nom_entreprise" name="nom_entreprise" required>
                                    </div>
                                    <div class="col-12">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone" required>
                                    </div>

                                    <div class="col-12">
                                        <label for="email" class="form-label">Email professionnel</label>
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
                                    <div class="col-md-6">
                                        <label for="secteur" class="form-label">Secteur d'activité</label>
                                        <select class="form-select" id="secteur" name="secteur" required>
                                            <option value="">Sélectionner...</option>
                                            <option value="informatique">Informatique</option>
                                            <option value="finance">Finance</option>
                                            <option value="commerce">Commerce</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="taille" class="form-label">Taille de l'entreprise</label>
                                        <select class="form-select" id="taille" name="taille" required>
                                            <option value="">Sélectionner...</option>
                                            <option value="petite">Petite (1-50 employés)</option>
                                            <option value="moyenne">Moyenne (51-250 employés)</option>
                                            <option value="grande">Grande (+250 employés)</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="adresse" class="form-label">Adresse</label>
                                        <input type="text" class="form-control" id="adresse" name="adresse" required>
                                    </div>
                                    <div class="col-12">
    <label for="description" class="form-label">Description de l'entreprise (optionnel)</label>
    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Parlez-nous un peu de votre entreprise..."></textarea>
</div>

                                    <div class="col-12">
    <label for="image" class="form-label">Logo / Image de l'entreprise (optionnel)</label>
    <input type="file" class="form-control" id="image" name="image" accept="image/*">
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
                                <?php if (!empty($message)) : ?>
    <div class="alert alert-info mt-3 text-center">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>