<?php
session_start();
require_once("../../model/User.php");
require_once("../../model/Etudiant.php");
require_once("../../model/Candidature.php");
$isEntreprise = (isset($_SESSION['role']) && $_SESSION['role'] === 'entreprise');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'etudiant') {
        die("⚠️ Vous devez être connecté en tant qu'étudiant.");
    }

    // On récupère l'étudiant correspondant à l'utilisateur connecté
    $etudiant = Etudiant::where('user_id', $_SESSION['user_id']);
    if (!$etudiant || count($etudiant) === 0) {
        die("⚠️ Étudiant introuvable.");
    }
    $etudiant = $etudiant[0];
// Vérifier si une candidature existe déjà pour cette offre
$offreId = $_POST['offre_id'] ?? 1;
$checkStmt = Model::connect()->prepare("SELECT COUNT(*) FROM candidature WHERE id_etudiant = :id_etudiant AND id_offre = :id_offre");
$checkStmt->execute([
    'id_etudiant' => $etudiant->getId(),
    'id_offre' => $offreId
]);
$alreadyApplied = $checkStmt->fetchColumn();

if ($alreadyApplied > 0) {
    echo "<div style='color: red; font-weight: bold; text-align: center;'>⚠️ Vous avez déjà postulé à cette offre.</div>";
    exit;
}
$uploadDir = "../../uploads/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (isset($_FILES['cv']) && $_FILES['cv']['error'] === 0) {
    $cvName = basename($_FILES["cv"]["name"]);
    $cvPath = $uploadDir . $cvName;
    move_uploaded_file($_FILES["cv"]["tmp_name"], $cvPath);
    $cvDBPath = "uploads/" . $cvName; // à stocker dans la BDD
} else {
    die("❌ Erreur lors de l'envoi du CV.");
}

$lettreDBPath = null;
if (isset($_FILES['lettre']) && $_FILES['lettre']['error'] === 0) {
    $lettreName = basename($_FILES["lettre"]["name"]);
    $lettrePath = $uploadDir . $lettreName;
    move_uploaded_file($_FILES["lettre"]["tmp_name"], $lettrePath);
    $lettreDBPath = "uploads/" . $lettreName; // à stocker dans la BDD
}

    // Enregistrement de la candidature
    $candidature = new Candidature();
    $candidature->setIdEtudiant($etudiant->getId());
    $candidature->setIdOffre($_POST['offre_id'] ?? 1);
    $candidature->setDatePostulation(date("Y-m-d"));
    $candidature->setStatut("pending");
    $candidature->setCv($cvDBPath);
$candidature->setLettreMotivation($lettreDBPath);
    $candidature->save();

// Récupérer le nom de l'entreprise pour l'afficher dans la page de confirmation
$offreStmt = Model::connect()->prepare("SELECT e.nom FROM offre o JOIN entreprise e ON o.id_entreprise = e.id WHERE o.id_offre = ?");
$offreStmt->execute([$offreId]);
$nomEntreprise = $offreStmt->fetchColumn();

header("Location: MessageConfirmationP.php?entreprise=" . urlencode($nomEntreprise) . "&statut=En%20attente");
exit;
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSTULER A UN STAGE | Stagik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="offres.css" rel="stylesheet">
  <link href="offres.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background: #ffffff;
    }

    .card {
      border-radius: 20px;
      padding: 30px;
      background: #ffffff;
      box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.05);
      border: 1px solid #ddd;  /* Bordure ajoutée autour de la carte */
    }

    h2 {
      font-weight: bold;
      color: #158d75;
    }

    .btn-primary {
      background-color: #0e866e;
      border: none;
      padding: 12px 30px;
      font-size: 18px;
      border-radius: 10px;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0e6e5a;
    }

    .form-control, .form-select {
      border-radius: 10px;
      border: 1px solid #ccc; /* Bordure ajoutée sur les champs de formulaire */
      box-shadow: none;
    }

    .form-control:focus, .form-select:focus {
      border-color: #146857;
      box-shadow: 0 0 5px rgba(20, 163, 135, 0.4);
    }

    .form-check-input:checked {
      background-color: #14a387;
      border-color: #14a387;
    }

    footer {
      background: #0e7a65;
    }

    /* Bordure autour du formulaire */
    .card-body {
      border: 1px solid #ddd;
      border-radius: 10px;
    }

    .form-check-label a {
      color: #21816e;
    }

  </style>
</head>
<body>
<!-- Navigation -->
<?php include("../Navbar.php"); ?>


<!-- Formulaire -->
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card">
          <h2 class="text-center mb-4">Postuler à un stage</h2>
          <?php if ($isEntreprise): ?>
            <div class="alert alert-danger text-center">
              🚫 Vous êtes connecté en tant qu'entreprise. Vous ne pouvez pas postuler à une offre de stage.
            </div>
          <?php endif; ?>
          <form action="ViewPostuler.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="offre_id" value="<?= htmlspecialchars($_GET['offre_id'] ?? 1) ?>">

        
            <div class="mb-3">
              <label for="cv" class="form-label">CV (PDF uniquement, max 2MB)</label>
              <input type="file" class="form-control" id="cv" name="cv" accept=".pdf" required>
            </div>

            <div class="mb-3">
              <label for="lettre" class="form-label">Lettre de motivation (optionnelle)</label>
              <input type="file" class="form-control" id="lettre" name="lettre" accept=".pdf,.doc,.docx">
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="conditions" required>
              <label class="form-check-label" for="conditions">
                J'accepte les <a href="#">conditions d'utilisation</a>
              </label>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">Envoyer ma candidature</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include("../Footer.php"); ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
</script>


</body>
</html>