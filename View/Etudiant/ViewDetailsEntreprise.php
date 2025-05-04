<?php
require_once("../../Model/Entreprise.php");
require_once("../../Model/User.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $entreprise = Entreprise::find($id);
    if (!$entreprise) die("Entreprise introuvable.");
    $user = User::find($entreprise->getIdUtilisateur());
} else {
    die("Aucun identifiant fourni.");
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stagik - Description de l'Entreprise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="../accueil.css" rel="stylesheet">
    <link href="../accueil.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
}
</style>
 

</head>
<body>
<?php include("../Navbar.php"); ?>

    <main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-4 rounded-3 overflow-hidden shadow-lg bg-light">
                <div class="row g-0">
                    <div class="col-md-4 d-flex align-items-center justify-content-center p-3">
                    <img src="/ProjetPHP/<?= htmlspecialchars($entreprise->getImage()) ?>" class="img-fluid rounded-circle company-logo" alt="<?= htmlspecialchars($entreprise->getNom()) ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h1 class="card-title text-primary"><?= htmlspecialchars($entreprise->getNom()) ?></h1>
                            <p class="card-text text-muted">
                                <strong>Secteur :</strong> <?= htmlspecialchars($entreprise->getSecteur()) ?><br>
                                <strong>Taille :</strong> <?= htmlspecialchars($entreprise->getTaille()) ?>
                            </p>
                            <div class="mb-3">
                            <strong class="text-dark">📞 Téléphone :</strong>
<span class="text-info">
    <?= isset($user) && $user ? htmlspecialchars($user->getTelephone() ?? "Non renseigné") : "Non renseigné" ?>
</span>

                                <strong class="text-dark">📍 Localisation :</strong>
                                <span class="text-info"><?= htmlspecialchars($entreprise->getAdresse()) ?></span>
                            </div>
                            <h3 class="text-success">Description de l'Entreprise</h3>
                            <p class="text-justify">
                                <?= htmlspecialchars($entreprise->getDescription() ?? "Description non fournie.") ?>
                            </p>
                            <a href="ViewOffres.php" class="btn btn-success shadow-sm">Retour aux offres</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            try {
                // Vérifier si l'URL contient des paramètres
                const urlParams = new URLSearchParams(window.location.search);
                
                // Si l'ID de l'entreprise existe dans l'URL, le récupérer
                const entrepriseId = urlParams.get('id'); // id=1 par exemple
                
                if (entrepriseId) {
                    console.log('ID de l\'entreprise:', entrepriseId);
                    // Vous pouvez maintenant utiliser cet ID pour charger dynamiquement les détails de l'entreprise
                    // Exemple : faire une requête API pour récupérer les informations de l'entreprise par ID
                } else {
                    console.log('Aucun ID d\'entreprise trouvé dans l\'URL.');
                }
            } catch (error) {
                console.error('Erreur lors de la récupération de l\'ID:', error);
            }
        });
       

    </script>
    

    <?php include("../Footer.php"); ?>

</body>
</html>
