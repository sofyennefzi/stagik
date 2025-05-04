<?php
session_start();
$entreprise = isset($_GET['entreprise']) ? htmlspecialchars($_GET['entreprise']) : "Entreprise inconnue";
$statut = isset($_GET['statut']) ? htmlspecialchars($_GET['statut']) : "En attente";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirmation de Postulation | Stagik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link href="../version 3/accueil.css" rel="stylesheet">
  <link href="css/accueil.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { background: #f8f9fa; font-family: 'Poppins', sans-serif; }
    .navbar { background: #ffffff; }
    .card {
      border-radius: 20px;
      padding: 30px;
      background: #ffffff;
      box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.05);
      border: 1px solid #ddd;
    }
    .btn-primary {
      background-color: #0e866e;
      border: none;
      padding: 12px 30px;
      font-size: 18px;
      border-radius: 10px;
      transition: all 0.3s ease;
    }
    .btn-primary:hover { background-color: #0e6e5a; }
    footer { background: #0e7a65; }
  </style>
</head>
<body>
<?php include("../Navbar.php"); ?>


<!-- Confirmation de postulation -->
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card">
          <h2 class="text-center mb-4 text-success">✅ Merci pour votre postulation !</h2>
          <p class="text-center">Vous avez postulé à l'offre de : <strong><?= $entreprise ?></strong></p>
          <p class="text-center">Statut de votre candidature : 
            <span class="badge bg-warning text-dark"><?= $statut ?></span>
          </p>
          <div class="text-center d-flex flex-column gap-3 mt-4">
            <a href="../Acceuil.php" class="btn btn-primary">🏠 Retour à l'accueil</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'etudiant'): ?>
              <a href="MesPostulations.php" class="btn btn-outline-success">📄 Voir mes postulations</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include("../Footer.php"); ?>

</body>
</html>
