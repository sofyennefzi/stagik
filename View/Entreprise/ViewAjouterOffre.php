<?php
require_once("../../model/Offre.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'entreprise') {
    header("Location: ../Login.php");
    exit;
}

if (!isset($_SESSION['entreprise_id'])) {
    echo "⚠️ ID entreprise non disponible en session.";
    exit;
}

if (
    isset($_POST['titre_offre']) &&
    isset($_POST['description_offre']) &&
    isset($_POST['specialite'])
) {
    $offre = new Offre();
    $offre->setTitre($_POST['titre_offre']);
    $offre->setDescription($_POST['description_offre']);
    $offre->setSpecialite($_POST['specialite']);
    $offre->setDatePublication(date('Y-m-d')); // date d'aujourd'hui
    $offre->setIdEntreprise($_SESSION['entreprise_id']);

    if ($offre->save()) {
        echo "✅ Offre ajoutée avec succès.";
    } else {
        echo "❌ Une erreur s’est produite lors de l’enregistrement.";
    }
} else {
    echo "⚠️ Données incomplètes.";
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
          <h2 class="text-center mb-4">Ajouter une offre</h2>
          <form action="ViewAjouterOffre.php" method="POST">
    <div class="row g-3">

        <!-- Titre de l'offre -->
        <div class="col-12">
            <label for="titre_offre" class="form-label">Titre de l'offre</label>
            <input type="text" class="form-control" id="titre_offre" name="titre_offre" required>
        </div>

        <!-- Description -->
        <div class="col-12">
            <label for="description_offre" class="form-label">Description de l'offre</label>
            <textarea class="form-control" id="description_offre" name="description_offre" rows="4" required></textarea>
        </div>

        <!-- Spécialité -->
        <div class="col-12">
            <label for="specialite" class="form-label">Spécialité</label>
            <select class="form-select" id="specialite" name="specialite" required>
                <option value="">-- Sélectionnez une spécialité --</option>
                <option value="Business Intelligence">Business Intelligence</option>
                <option value="E-Business">E-Business</option>
                <option value="Développement">Développement</option>
                <option value="Marketing Digital">Marketing Digital</option>
            </select>
        </div>

        <!-- Bouton -->
        <div class="text-center">
              <button type="submit" class="btn btn-primary">Ajouter l'offre</button>
            </div>
    </div>
</form>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="text-white text-center py-4">
  <p class="mb-0">&copy; 2025 Stagik. Tous droits réservés.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 <!-- Footer -->
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
<script>
document.getElementById('email').addEventListener('blur', function() {
    const email = this.value;
    if (email.trim() === "") return;

    fetch("fetch_etudiant.php?email=" + encodeURIComponent(email))
    .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('nom').value = data.nom + " " + data.prenom;
                document.getElementById('ecole').value = data.universite;
                document.getElementById('niveau').value = data.niveau_etudes;

                // Les rendre read-only
                document.getElementById('nom').readOnly = true;
                document.getElementById('ecole').readOnly = true;
                document.getElementById('niveau').disabled = true;
            } else {
                alert("Aucun étudiant trouvé avec cet email.");
            }
        });
});
</script>

</body>
</html>