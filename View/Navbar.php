<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="accueil.html">
            <img src="/ProjetPHP/View/image/12-removebg-preview.png" alt="Stagik" height="40">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="/ProjetPHP/View/Acceuil.php"><span class="nav-text">🏠 Accueil</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ProjetPHP/View/Etudiant/ViewOffres.php"><span class="nav-text">💼 Offres</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ProjetPHP/View/Apropos.php"><span class="nav-text">📜 À propos</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ProjetPHP/View/Contact.php"><span class="nav-text">📞 Contact</span></a>
                </li>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
    <li class="nav-item">
        <a class="nav-link" href="/ProjetPHP/View/Admin/dashboard.php">
            <span class="nav-text">📊 Dashboard</span>
        </a>
    </li>
<?php endif; ?>

                <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'etudiant'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProjetPHP/View/Etudiant/MesPostulations.php">
                            <span class="nav-text">📄 Mes Postulations</span>
                        </a>
                    </li>
                <?php elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === 'entreprise'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProjetPHP/View/Entreprise/Mesoffres.php">
                            <span class="nav-text">📂 Mes Offres</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProjetPHP/View/Logout.php"><span class="nav-text">🚪 Se déconnecter</span></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/ProjetPHP/View/Login.php"><span class="nav-text">🔐 Se connecter</span></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
