<?php
require_once("../../Model/Model.php");
require_once("../../Model/Candidature.php");
require_once("../../Model/Offre.php");
session_start();

// Vérification si l'utilisateur est connecté en tant qu'étudiant
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: ../Login.php");
    exit;
}

// Récupération des candidatures de l'étudiant
$pdo = Model::connect();
$stmt = $pdo->prepare("
    SELECT c.*, o.titre, o.specialite, o.description
    FROM candidature c
    JOIN offre o ON c.id_offre = o.id_offre
    WHERE c.id_etudiant = (
        SELECT id_etudiant FROM etudiant WHERE user_id = ?
    )
");
$stmt->execute([$_SESSION['user_id']]);
$candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Postulations | Stagik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/accueil.css" rel="stylesheet">
</head>
<body>
<?php include("../Navbar.php"); ?>

<div class="container py-5">
    <h2 class="mb-4">📄 Mes Postulations</h2>

    <?php if (empty($candidatures)): ?>
        <div class="alert alert-info">Vous n'avez encore postulé à aucune offre.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>📌 Titre de l'offre</th>
                        <th>📚 Spécialité</th>
                        <th>📝 Description</th>
                        <th>📅 Date de postulation</th>
                        <th>📊 Statut</th>
                        <th>⚙️ Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($candidatures as $candidature): ?>
                        <tr>
                            <td><?= htmlspecialchars($candidature['titre']) ?></td>
                            <td><?= htmlspecialchars($candidature['specialite']) ?></td>
                            <td><?= htmlspecialchars($candidature['description']) ?></td>
                            <td><?= htmlspecialchars($candidature['date_postulation']) ?></td>
                            <td>
                                <span class="badge <?= $candidature['statut'] === 'pending' ? 'bg-warning' : 'bg-success' ?>">
                                    <?= htmlspecialchars($candidature['statut']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($candidature['statut'] === 'pending'): ?>
                                    <a href="ModifierCandidature.php?id=<?= $candidature['id_candidature'] ?>" class="btn btn-sm btn-outline-success custom-hover-green">
    ✏️ Modifier
</a>
                                    <a href="SupprimerCandidature.php?id=<?= $candidature['id_candidature'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Confirmer la suppression ?');">
                                        🗑️ Supprimer
                                    </a>
                                <?php else: ?>
                                    <em>Aucune action possible</em>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<style>.custom-hover-green:hover {
    background-color: #198754 !important; /* couleur verte Bootstrap */
    color: white !important;
    border-color: #198754 !important;
}
</style>
<?php include("../Footer.php"); ?>
</body>
</html>
