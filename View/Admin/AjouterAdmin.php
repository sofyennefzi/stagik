<?php
require_once("../../Model/Model.php");

$message = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['mot_de_passe'] ?? '';
    $telephone = $_POST['telephone'] ?? '';

    $pdo = Model::connect();

    // Vérifie si email déjà utilisé
    $check = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
    $check->execute([$email]);

    if ($check->fetchColumn() > 0) {
        $message = "❌ Cet email est déjà utilisé.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO utilisateur (email, mot_de_passe, role, telephone) VALUES (?, ?, 'admin', ?)");
        $stmt->execute([
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $telephone
        ]);
        $message = "✅ Administrateur ajouté avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../Navbar.php"); ?>

<div class="container py-5">
    <h2 class="mb-4">➕ Ajouter un administrateur</h2>

    <?php if (!empty($message)) : ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Adresse Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="mot_de_passe" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="telephone" class="form-control">
        </div>
        <input type="hidden" name="role" value="admin"> <!-- caché -->
        <button type="submit" class="btn btn-success">Créer l'administrateur</button>
    </form>
</div>

<?php include("../Footer.php"); ?>
</body>
</html>
