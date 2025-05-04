<?php
require_once("../../Model/Model.php");
require_once("../../Model/Candidature.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: ../Login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCandidature = $_POST['id_candidature'] ?? null;
    if (!$idCandidature) {
        die("ID de candidature manquant.");
    }

    $pdo = Model::connect();

    // Récupérer l’ancienne candidature
    $stmt = $pdo->prepare("SELECT * FROM candidature WHERE id_candidature = ?");
    $stmt->execute([$idCandidature]);
    $candidature = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$candidature) {
        die("Candidature introuvable.");
    }

    // Traitement du nouveau CV
    $cvPath = $candidature['cv'];
    if (!empty($_FILES['cv']['name'])) {
        $cvPath = "uploads/" . basename($_FILES['cv']['name']);
        move_uploaded_file($_FILES["cv"]["tmp_name"], $cvPath);
    }

    // Traitement de la lettre
    $lettrePath = $candidature['lettre_motivation'];
    if (!empty($_FILES['lettre']['name'])) {
        $lettrePath = "uploads/" . basename($_FILES['lettre']['name']);
        move_uploaded_file($_FILES["lettre"]["tmp_name"], $lettrePath);
    }

    // Mettre à jour la base
    $update = $pdo->prepare("UPDATE candidature SET cv = ?, lettre_motivation = ? WHERE id_candidature = ?");
    $update->execute([$cvPath, $lettrePath, $idCandidature]);

    // Rediriger vers MesPostulations
    header("Location: MesPostulations.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("ID de candidature manquant.");
}

$pdo = Model::connect();
$idCandidature = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM candidature WHERE id_candidature = ?");
$stmt->execute([$idCandidature]);
$candidature = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$candidature) {
    die("Candidature introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier ma candidature | Stagik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      border-radius: 20px;
      padding: 30px;
      background: #ffffff;
      box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.05);
      border: 1px solid #ddd;
    }
    h2 {
      font-weight: bold;
      color: #158d75;
    }
    .btn-success {
      background-color: #0e866e;
      border: none;
      padding: 12px 30px;
      font-size: 18px;
      border-radius: 10px;
      transition: all 0.3s ease;
    }
    .btn-success:hover {
      background-color: #0e6e5a;
    }
    .form-control {
      border-radius: 10px;
    }
  </style>
</head>
<body>

<?php include("../Navbar.php"); ?>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card">
          <h2 class="text-center mb-4">✏️ Modifier ma candidature</h2>
          <form action="ModifierCandidature.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_candidature" value="<?= htmlspecialchars($candidature['id_candidature']) ?>">

            <div class="mb-3">
              <label for="cv" class="form-label">CV (PDF uniquement, max 2MB)</label>
              <input type="file" class="form-control" id="cv" name="cv" accept=".pdf">
              <small class="form-text text-muted">Actuel : <?= htmlspecialchars(basename($candidature['cv'])) ?></small>
            </div>

            <div class="mb-3">
              <label for="lettre" class="form-label">Lettre de motivation (laisser vide si inchangée)</label>
              <input type="file" class="form-control" id="lettre" name="lettre" accept=".pdf,.doc,.docx">
              <small class="form-text text-muted">
                Actuelle : <?= $candidature['lettre_motivation'] ? htmlspecialchars(basename($candidature['lettre_motivation'])) : 'Aucune' ?>
              </small>
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="conditions" required>
              <label class="form-check-label" for="conditions">
                J'accepte les <a href="#">conditions de modification</a>
              </label>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-success">Enregistrer les modifications</button>
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
