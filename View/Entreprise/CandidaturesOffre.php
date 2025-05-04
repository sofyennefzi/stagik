<?php
require_once("../../Model/Model.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'entreprise') {
    header("Location: ../Login.php");
    exit;
}

if (!isset($_GET['id_offre'])) {
    die("ID de l'offre manquant.");
}

$pdo = Model::connect();
$idOffre = $_GET['id_offre'];
$stmt = $pdo->prepare("
    SELECT c.*, 
           CONCAT(e.prenom, ' ', e.nom) AS nom_complet, 
           e.universite, 
           e.niveau_etudes, 
           o.titre AS titre_offre
    FROM candidature c
    JOIN etudiant e ON c.id_etudiant = e.id
    JOIN offre o ON c.id_offre = o.id_offre
    WHERE c.id_offre = ?
");




$stmt->execute([$idOffre]);
$candidatures = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement des actions (accepter / refuser)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'], $_POST['id_candidature'])) {
    $newStatut = ($_POST['action'] === 'accepter') ? 'accepted' : 'rejected';
    $updateStmt = $pdo->prepare("UPDATE candidature SET statut = ? WHERE id_candidature = ?");
    $updateStmt->execute([$newStatut, $_POST['id_candidature']]);

    // Redirection pour éviter le re-post
    header("Location: CandidaturesOffre.php?id_offre=" . urlencode($idOffre));
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Candidatures à l'offre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../Navbar.php"); ?>

<div class="container py-5">
    <h2 class="mb-4">📄 Candidatures pour l'offre n°<?= htmlspecialchars($idOffre) ?></h2>

    <?php if (empty($candidatures)): ?>
        <div class="alert alert-warning">Aucune candidature trouvée.</div>
    <?php else: ?>
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nom complet</th>
                    <th>Université</th>
                    <th>Niveau</th>
                    <th>CV</th>
                    <th>Lettre</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($candidatures as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['nom_complet']) ?></td>
                        <td><?= htmlspecialchars($c['universite']) ?></td>
                        <td><?= htmlspecialchars($c['niveau_etudes']) ?></td>
                        <td>
                            <a href="../../<?= $c['cv'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">📄 Voir CV</a>
                        </td>
                        <td>
                            <?php if ($c['lettre_motivation']): ?>
                                <a href="../../<?= $c['lettre_motivation'] ?>" target="_blank" class="btn btn-sm btn-outline-secondary">📜 Voir</a>
                            <?php else: ?>
                                <span class="text-muted">Aucune</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge 
                                <?= $c['statut'] === 'pending' ? 'bg-warning' : 
                                    ($c['statut'] === 'accepted' ? 'bg-success' : 'bg-danger') ?>">
                                <?= htmlspecialchars($c['statut']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($c['statut'] === 'pending'): ?>
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="id_candidature" value="<?= $c['id_candidature'] ?>">
                                    <button type="submit" name="action" value="accepter" class="btn btn-success btn-sm">✅</button>
                                    <button type="submit" name="action" value="refuser" class="btn btn-danger btn-sm">❌</button>
                                </form>
                            <?php else: ?>
                                <em>Aucune action</em>
                            <?php endif; ?>
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
