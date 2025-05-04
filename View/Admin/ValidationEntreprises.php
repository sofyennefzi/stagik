<?php
session_start();
require_once("../../Model/Model.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../Login.php");
    exit;
}

$pdo = Model::connect();
$stmt = $pdo->prepare("
    SELECT e.id, e.nom, e.secteur, e.taille, e.adresse, u.email
    FROM entreprise e
    LEFT JOIN utilisateur u ON e.user_id = u.id
    WHERE e.statut_validation = 'pending' AND e.user_id IS NOT NULL
");

$stmt->execute();
$entreprises = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation des Entreprises</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../Navbar.php"); ?>
<div class="container py-5">
    <h2 class="mb-4">📝 Entreprises en attente de validation</h2>
    
    <?php if (count($entreprises) === 0): ?>
        <div class="alert alert-info text-center">Aucune entreprise en attente de validation.</div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Secteur</th>
                    <th>Taille</th>
                    <th>Adresse</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entreprises as $e): ?>
                    <tr>
                        <td><?= htmlspecialchars($e['nom']) ?></td>
                        <td><?= htmlspecialchars($e['secteur']) ?></td>
                        <td><?= htmlspecialchars($e['taille']) ?></td>
                        <td><?= htmlspecialchars($e['adresse']) ?></td>
                        <td><?= htmlspecialchars($e['email']) ?></td>
                        <td>
                            <a href="ValiderEntreprise.php?id=<?= $e['id'] ?>" class="btn btn-success btn-sm me-2" onclick="return confirm('Confirmer validation ?')">✅</a>
                            <a href="RefuserEntreprise.php?id=<?= $e['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer refus ?')">❌</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php include("../Footer.php"); ?>
</body>
</html>
