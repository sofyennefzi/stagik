<?php
require_once("../../Model/Model.php");
require_once("../../Model/Offre.php");
require_once("../../Model/Entreprise.php");
session_start();

$pdo = Model::connect();
$specialite = $_GET['specialite'] ?? null;
$tri = $_GET['tri'] ?? null;

$sql = "SELECT o.*, e.nom AS entreprise_nom, e.image AS entreprise_image, e.adresse AS entreprise_adresse 
        FROM offre o
        JOIN entreprise e ON o.id_entreprise = e.id";

// WHERE spécialité
$params = [];
if ($specialite) {
    $sql .= " WHERE o.specialite = :specialite";
    $params['specialite'] = $specialite;
}

// ORDER BY tri
switch ($tri) {
    case 'recentes':
        $sql .= " ORDER BY o.date_publication DESC";
        break;
    case 'anciennes':
        $sql .= " ORDER BY o.date_publication ASC";
        break;
    case 'entreprise':
        $sql .= " ORDER BY e.nom ASC";
        break;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$offres = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Offres de Stage | Stagik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="offres.css" rel="stylesheet">
    <link href="offres.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <?php include("../Navbar.php"); ?>

    <!-- Hero Section -->
    <section class="hero-section bg-light py-5">
        <div class="container text-center py-4">
            <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">Trouver le stage parfait</h1>
            <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Découvrez des opportunités uniques en informatique de gestion</p>
            <div class="d-flex justify-content-center gap-3" data-aos="fade-up" data-aos-delay="200">
                <a href="#offres" class="btn btn-primary btn-lg px-4">Voir les offres</a>
                <a href="#categories" class="btn btn-outline-primary btn-lg px-4">Catégories</a>
            </div>
        </div>
    </section>

    <!-- Catégories -->
    <section id="categories" class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Explorez par domaine</h2>
            <div class="row g-4">
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                    <a href="ViewOffres.php?specialite=Business%20Intelligence" class="category-card bg-primary rounded-3 p-4 text-center text-white text-decoration-none hover-card">
                        <i class="bi bi-bar-chart fs-1 mb-3"></i>
                        <span class="fw-bold">Business Intelligence</span>
                    </a>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <a href="ViewOffres.php?specialite=E-Business" class="category-card bg-success rounded-3 p-4 text-center text-white text-decoration-none hover-card">
                        <i class="bi bi-globe fs-1 mb-3"></i>
                        <span class="fw-bold">E-Business</span>
                    </a>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                    <a href="ViewOffres.php?specialite=Développement" class="category-card bg-info rounded-3 p-4 text-center text-white text-decoration-none hover-card">
                        <i class="bi bi-code-square fs-1 mb-3"></i>
                        <span class="fw-bold">Développement</span>
                    </a>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="400">
                    <a href="ViewOffres.php?specialite=Marketing%20Digital" class="category-card bg-warning rounded-3 p-4 text-center text-white text-decoration-none hover-card">
                        <i class="bi bi-megaphone fs-1 mb-3"></i>
                        <span class="fw-bold">Marketing Digital</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Liste des offres -->
    <section id="offres" class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-up">
                <h2>Nos dernières offres</h2>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Trier par
                    </button>
                    <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="ViewOffres.php?tri=recentes<?= $specialite ? '&specialite=' . urlencode($specialite) : '' ?>">Plus récentes</a></li>
    <li><a class="dropdown-item" href="ViewOffres.php?tri=anciennes<?= $specialite ? '&specialite=' . urlencode($specialite) : '' ?>">Plus anciennes</a></li>
    <li><a class="dropdown-item" href="ViewOffres.php?tri=entreprise<?= $specialite ? '&specialite=' . urlencode($specialite) : '' ?>">Par entreprise</a></li>
</ul>

                </div>
            </div>
<!-- Offre 1 -->
<?php foreach ($offres as $offre): ?>
<div class="offers-container mb-4">
    <div class="offer-card">
        <div class="row align-items-center">
            <!-- Logo -->
            <div class="col-md-2 text-center">
            <?php
// Si l'image est définie et non vide, on construit le chemin correctement
$imagePath = !empty($offre['entreprise_image']) 
    ? "../../" . $offre['entreprise_image'] 
    : "../image/default.png";
?>
<img src="<?= $imagePath ?>" class="img-fluid company-logo" alt="Logo entreprise" style="max-height: 60px;">
            </div>

            <!-- Détails de l'offre -->
            <div class="col-md-8">
                <div class="offer-content">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h3 class="offer-title"><?= htmlspecialchars($offre['titre']) ?></h3>
                        <span class="badge bg-info"><?= htmlspecialchars($offre['specialite']) ?></span>
                    </div>
                    <p class="text-muted mb-2"><?= htmlspecialchars($offre['entreprise_nom']) ?> – <?= htmlspecialchars($offre['entreprise_adresse']) ?></p>
                    <p class="mb-2"><?= htmlspecialchars($offre['description']) ?></p>
                    <div class="d-flex gap-2">
                        <span class="badge bg-light text-dark"><i class="bi bi-calendar"></i> <?= htmlspecialchars($offre['date_publication']) ?></span>
                    </div>
                </div>
            </div>

            <!-- Bouton -->
            <div class="col-md-2 text-center">
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'etudiant'): ?>
    <a href="ViewPostuler.php?offre_id=<?= $offre['id_offre'] ?>" class="btn btn-primary mt-3">Postuler</a>
<?php else: ?>
    <a href="../Login.php?redirect=Etudiant/ViewPostuler.php&offre_id=<?= $offre['id_offre'] ?>" class="btn btn-primary mt-3">Postuler</a>
<?php endif; ?>


            </div>
        </div>
        <?php
    $imagePath = !empty($offre['entreprise_image']) 
        ? "../../" . $offre['entreprise_image'] 
        : "../image/default.png";
?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
            <div class="card flex-row shadow-lg border-0" style="border-radius: 20px; overflow: hidden; background: linear-gradient(90deg, #e0f7fa, #ffffff);">
                <div class="card-body d-flex flex-row align-items-center p-3">
                    <!-- Infos Entreprise -->
                    <div class="me-4">
                        <h5 class="card-title mb-2" style="font-weight: bold; color: #00796b;"><?= htmlspecialchars($offre['entreprise_nom']) ?></h5>
                        <p class="card-text" style="color: #555; font-size: 0.9rem;">
                            Adresse : <?= htmlspecialchars($offre['entreprise_adresse']) ?>
                        </p>
                    </div>

                    <!-- Bouton vers détails entreprise -->
                    <div class="ms-auto">
                        <a href="ViewDetailsEntreprise.php?id=<?= $offre['id_entreprise'] ?>" class="btn btn-outline-primary rounded-pill px-4">Voir détails</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    
</div>
<?php endforeach; ?>

    
    <!-- CTA -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="mb-4" data-aos="fade-up">Vous proposez des stages ?</h2>
            <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">Publiez vos offres sur notre plateforme et trouvez les meilleurs talents</p>
            <a href="contact.html" class="btn btn-light btn-lg px-4" data-aos="fade-up" data-aos-delay="200">Nous contacter</a>
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
        window.location.href = `ViewOffres.php?specialite=${specialite}`;
    } else {
        // Redirection sans filtre
        window.location.href = "ViewOffres.php";
    }
}
</script>

</body>
</html>