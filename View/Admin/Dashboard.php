<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin | Stagik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }
    .sidebar {
      background-color: #ffffff;
      box-shadow: 2px 0 5px rgba(0,0,0,0.1);
      min-height: 100vh;
    }
    .sidebar a {
      color: #333;
      font-weight: 500;
      padding: 15px;
      display: block;
      transition: background 0.3s;
      text-decoration: none;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #e9ecef;
      border-left: 4px solid #0e866e;
    }
    .content {
      padding: 30px;
    }
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.05);
    }
  </style>
</head>
<body>
  <?php include("../Navbar.php"); ?>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 sidebar py-4">
        <h4 class="text-center mb-4">👑 Admin Panel</h4>
        <a href="UserList.php" class="active"><i class="bi bi-people"></i> Gestion des utilisateurs</a>
        <a href="ValidationEntreprises.php"><i class="bi bi-building-check"></i> Validation des entreprises</a>
        <a href="ManageOffers.php"><i class="bi bi-journal-check"></i> Gestion des offres</a>
      </div>

      <!-- Main content -->
      <div class="col-md-9 content">
  <h2 class="mb-4">Bienvenue sur votre tableau de bord, Admin 🧑‍💻</h2>
  
  <div class="row g-4">
    
    <!-- Carte 1 -->
    <div class="col-md-4">
      <a href="UserList.php" style="text-decoration: none; color: inherit;">
        <div class="card p-4 text-center shadow-sm">
          <i class="bi bi-people fs-1 text-primary"></i>
          <h5 class="mt-3">Utilisateurs inscrits</h5>
          <p class="text-muted">Gérez les étudiants et entreprises</p>
        </div>
      </a>
    </div>

    <!-- Carte 2 -->
    <div class="col-md-4">
  <a href="ValidationEntreprises.php" class="text-decoration-none text-dark">
    <div class="card p-4 text-center shadow-sm">
      <i class="bi bi-building fs-1 text-success"></i>
      <h5 class="mt-3">Entreprises en attente</h5>
      <p class="text-muted">Validez les nouvelles entreprises</p>
    </div>
  </a>
</div>


    <!-- Carte 3 -->
    <div class="col-md-4">
      <a href="ManageOffers.php" class="text-decoration-none text-dark">
        <div class="card p-4 text-center shadow-sm">
          <i class="bi bi-briefcase fs-1 text-warning"></i>
          <h5 class="mt-3">Offres à vérifier</h5>
          <p class="text-muted">Contrôlez les stages proposés</p>
        </div>
      </a>
    </div>

  </div> <!-- fin .row -->

</div> <!-- fin .content -->

    </div>
  </div>

  <?php include("../Footer.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
