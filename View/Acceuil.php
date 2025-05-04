
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stagik - Trouve ton stage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="accueil.css" rel="stylesheet">
    <link href="accueil.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
}
</style>

</head>
<body>
<?php include("Navbar.php"); ?>

    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="bg-white bg-opacity-85 p-5 rounded shadow">
                        <h1 class="display-4 fw-bold text-stagik mb-4">Trouve ton stage, développe ton avenir</h1>
                        <p class="lead mb-4">Plateforme créative dédiée aux étudiants ambitieux.</p>
                        <form class="row g-2" onsubmit="redirigerVersOffres(event)">
                            <div class="col-md-8">
                                <input id="searchInput" type="text" class="form-control" placeholder="Stage ou domaine" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-stagik w-100">Rechercher</button>
                            </div>
                            <input type="hidden" name="region" value="Tunis">
                        </form>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
     
    <!-- Domaines -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold" data-aos="fade-up">Domaines populaires</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card border-0 shadow-sm h-100 hover-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary mb-3">
                                <i class="bi bi-globe fs-3"></i>
                            </div>
                            <h5 class="card-title text-stagik">E-Business</h5>
                            <p class="card-text">Marketing digital, E-commerce et Web stratégique.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card border-0 shadow-sm h-100 hover-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-box bg-info bg-opacity-10 text-info mb-3">
                                <i class="bi bi-bar-chart fs-3"></i>
                            </div>
                            <h5 class="card-title text-stagik">Business Intelligence</h5>
                            <p class="card-text">Analyse de données avec Power BI, Tableau, et Excel avancé.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card border-0 shadow-sm h-100 hover-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-box bg-warning bg-opacity-10 text-warning mb-3">
                                <i class="bi bi-briefcase fs-3"></i>
                            </div>
                            <h5 class="card-title text-stagik">Systèmes d'info</h5>
                            <p class="card-text">ERP, CRM, automatisation des processus métiers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-5 bg-stagik text-white">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3" data-aos="zoom-in">
                    <h3 class="display-4 fw-bold">+100</h3>
                    <p>Étudiants inscrits</p>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                    <h3 class="display-4 fw-bold">+50</h3>
                    <p>Stages proposés</p>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                    <h3 class="display-4 fw-bold">+50</h3>
                    <p>Entreprises partenaires</p>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                    <h3 class="display-4 fw-bold">+100%</h3>
                    <p>Motivation 💪</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5 bg-white">
        <div class="container text-center">
            <h2 class="mb-4 fw-bold" data-aos="fade-up">Prêt à décrocher ton futur stage ?</h2>
            <a href="inscrit.html" class="btn btn-stagik btn-lg px-5" data-aos="fade-up" data-aos-delay="100">Créer un compte</a>
        </div>
    </section>

    <?php include("Footer.php"); ?>

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
function redirigerVersOffres(event) {
    event.preventDefault(); // Empêche l'envoi du formulaire

    const input = document.getElementById("searchInput").value.trim().toLowerCase();

    const specialitesConnues = {
        "business intelligence": "Business Intelligence",
        "e-business": "E-Business",
        "développement": "Développement",
        "developpement": "Développement", // au cas où sans accent
        "marketing digital": "Marketing Digital"
    };

    if (specialitesConnues.hasOwnProperty(input)) {
        const specialite = encodeURIComponent(specialitesConnues[input]);
        window.location.href = `Etudiant/ViewOffres.php?specialite=${specialite}`;
    } else {
        // Redirection sans filtre
        window.location.href = "Etudiant/ViewOffres.php";
    }
}
</script>

     
</body>
</html>