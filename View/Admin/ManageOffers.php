<?php
// ListeOffres.php
require_once("../../Model/Model.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../Login.php");
    exit;
}

$pdo = Model::connect();
$stmt = $pdo->prepare("
    SELECT o.*, e.nom AS nom_entreprise
    FROM offre o
    JOIN entreprise e ON o.id_entreprise = e.id
");
$stmt->execute();
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Offres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../Navbar.php"); ?>
<div class="container py-5">
    <h2 class="mb-4">Liste des Offres de Stage</h2>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Titre</th>
                <th>Spécialité</th>
                <th>Entreprise</th>
                <th>Date publication</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($offres as $offre): ?>
            <tr>
                <td><?= htmlspecialchars($offre['titre']) ?></td>
                <td><?= htmlspecialchars($offre['specialite']) ?></td>
                <td><?= htmlspecialchars($offre['nom_entreprise']) ?></td>
                <td><?= htmlspecialchars($offre['date_publication']) ?></td>
                <td>
                    <a href="ModifierOffre.php?id=<?= $offre['id_offre'] ?>" class="btn btn-sm btn-success">Modifier</a>
                    <a href="SupprimerOffre.php?id=<?= $offre['id_offre'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer suppression ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include("../Footer.php"); ?>
</body>
</html>
