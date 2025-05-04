<?php
require_once("../../Model/Model.php");
require_once("../../Model/Offre.php");
session_start();

// Vérification de la connexion et du rôle
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'entreprise') {
    header("Location: ../Login.php");
    exit;
}

$pdo = Model::connect();

$stmt = $pdo->prepare("SELECT id FROM entreprise WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$entreprise = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$entreprise) {
    die("⚠️ Aucune entreprise liée à cet utilisateur.");
}

$_SESSION['entreprise_id'] = $entreprise['id'];

// Récupérer les offres liées à cette entreprise
$stmt = $pdo->prepare("SELECT * FROM offre WHERE id_entreprise = ?");
$stmt->execute([$entreprise['id']]);
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Offres | Stagik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body style="font-family: 'Poppins', sans-serif; background-color: #f8f9fa;">

<?php include("../Navbar.php"); ?>

<div class="container py-5">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">📋 Mes Offres de Stage</h2>
    <a href="ViewAjouterOffre.php" class="btn" style="background-color: #0d6efd; border: 1px solid #0d6efd; color: white;">
    <i class="bi bi-plus" style="color: white;"></i> Ajouter une offre
</a>

</div>

    <?php if (empty($offres)): ?>
        <div class="alert alert-info">Vous n'avez encore publié aucune offre.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>📌 Titre</th>
                        <th>📚 Spécialité</th>
                        <th>📝 Description</th>
                        <th>📅 Date de publication</th>
                        <th>⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($offres as $offre): ?>
                        <tr>
                            <td><?= htmlspecialchars($offre['titre']) ?></td>
                            <td><?= htmlspecialchars($offre['specialite']) ?></td>
                            <td><?= htmlspecialchars($offre['description']) ?></td>
                            <td><?= htmlspecialchars($offre['date_publication']) ?></td>
                            <td>
              <a href="CandidaturesOffre.php?id_offre=<?= $offre['id_offre'] ?>" class="btn btn-sm btn-outline-primary">
                📄 Candidatures
              </a>
                                <a href="../Admin/ModifierOffre.php?id=<?= $offre['id_offre'] ?>" class="btn btn-sm btn-outline-success">
                                    ✏️ Modifier
                                </a>
                                <a href="../Admin/SupprimerOffre.php?id=<?= $offre['id_offre'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Confirmer la suppression ?');">
                                    🗑️ Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include("../Footer.php"); ?>

</body>
</html>
