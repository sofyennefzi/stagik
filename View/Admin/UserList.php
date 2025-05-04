<?php
require_once("../../Model/Model.php");
require_once("../../Model/User.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../Login.php");
    exit;
}
$pdo = Model::connect();
$stmt = $pdo->query("SELECT * FROM utilisateur");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
<?php include("../Navbar.php"); ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">👥 Utilisateurs (Étudiants & Entreprises)</h2>
    <a href="AjouterAdmin.php" class="btn btn-primary"><i class="bi bi-plus" style="color: white;"></i> Ajouter un admin</a>
</div>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><?= htmlspecialchars($user['telephone']) ?></td>
                    <td>
                        <a href="ModifierUser.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-success">Modifier</a>
                        <a href="SupprimerUser.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include("../Footer.php"); ?>
</body>
</html>
