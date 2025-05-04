
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir votre type de compte - Stagik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/accueil.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
}

</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir votre type de compte - Stagik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/accueil.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .card-custom {
            border: 2px solid #dee2e6; /* Couleur bordure grise claire */
            border-radius: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            border-color: #0d6efd; /* Couleur bordure bleue au survol */
        }

        h2, h3, p, a {
            font-weight: 500;
        }

        .btn-stagik {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 30px;
            transition: background-color 0.3s;
        }

        .btn-stagik:hover {
            background-color: #084298;
        }

    </style>
    
    
</head>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="accueil.html">
                <img src="image/12-removebg-preview.png" alt="Stagik" height="40">
            </a>
        </div>
    </nav>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="mb-4 fw-bold">Choisissez votre type de compte</h2>
                    <p class="lead mb-5">Sélectionnez le type de compte qui correspond à votre profil</p>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100 hover-card">
                                <div class="card-body p-5 text-center">
                                    <i class="bi bi-person fs-1 text-primary mb-3"></i>
                                    <h3 class="h4">Étudiant</h3>
                                    <p class="mb-4">Je cherche un stage pour développer mes compétences</p>
                                    <a href="Etudiant/ViewRegisterStudent.php" class="btn btn-stagik">S'inscrire comme étudiant</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100 hover-card">
                                <div class="card-body p-5 text-center">
                                    <i class="bi bi-building fs-1 text-warning mb-3"></i>
                                    <h3 class="h4">Entreprise</h3>
                                    <p class="mb-4">Je veux proposer des stages et trouver des talents</p>
                                    <a href="Entreprise/ViewRegisterEntreprise.php" class="btn btn-stagik">S'inscrire comme entreprise</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <p>Déjà un compte ? <a href="Login.php">Connectez-vous</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Stagik. Tous droits réservés.</p>
        </div>
    </footer>

   
</html>