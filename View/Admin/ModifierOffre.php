<?php
require_once("../../Model/Model.php");
session_start();

// Vérification des rôles autorisés
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'entreprise'])) {
    header("Location: ../../Login.php");
    exit;
}

$pdo = Model::connect();
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID de l'offre manquant.");
}

// Récupérer l'offre
$stmt = $pdo->prepare("SELECT * FROM offre WHERE id_offre = ?");
$stmt->execute([$id]);
$offre = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$offre) {
    die("Offre introuvable.");
}

// Vérifier si entreprise connectée est bien propriétaire de l'offre
if ($_SESSION['role'] === 'entreprise') {
    $entrepriseId = $_SESSION['entreprise_id'] ?? null;
    if ($offre['id_entreprise'] != $entrepriseId) {
        die("⛔ Vous ne pouvez modifier que vos propres offres.");
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = $_POST['titre'];
    $specialite = $_POST['specialite'];
    $description = $_POST['description'];
    $date_publication = $_POST['date_publication'];

    $stmt = $pdo->prepare("UPDATE offre SET titre = ?, specialite = ?, description = ?, date_publication = ? WHERE id_offre = ?");
    $stmt->execute([$titre, $specialite, $description, $date_publication, $id]);

    // Redirection différente selon le rôle
    if ($_SESSION['role'] === 'admin') {
        header("Location: ManageOffers.php");
    } else {
        header("Location: ../Entreprise/Mesoffres.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier Offre</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../Navbar.php"); ?>
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card p-4 shadow-sm">
          <h2 class="text-center mb-4">Modifier une Offre</h2>
          <form method="POST">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($offre['titre']) ?>" required>
              </div>
              <div class="col-12">
                <label class="form-label">Spécialité</label>
                <input type="text" name="specialite" class="form-control" value="<?= htmlspecialchars($offre['specialite']) ?>" required>
              </div>
              <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($offre['description']) ?></textarea>
              </div>
              <div class="col-12">
                <label class="form-label">Date de publication</label>
                <input type="date" name="date_publication" class="form-control" value="<?= htmlspecialchars($offre['date_publication']) ?>" required>
              </div>
              <div class="col-12 text-center pt-3">
                <button type="submit" class="btn btn-success">Enregistrer</button>
                <a href="ListeOffres.php" class="btn btn-secondary">Retour</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include("../Footer.php"); ?>
</body>
</html>
