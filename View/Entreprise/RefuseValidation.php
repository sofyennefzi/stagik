<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Compte refusé | Stagik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff4f4;
      font-family: 'Poppins', sans-serif;
    }
    .refuse-box {
      background: #fff;
      border: 1px solid #f5c2c7;
      border-left: 5px solid #dc3545;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(220, 53, 69, 0.1);
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="refuse-box text-center">
    <h2 class="text-danger"><i class="bi bi-x-circle-fill"></i> Votre demande a été refusée</h2>
    <p class="mt-3">Nous sommes désolés, votre compte a été <strong>rejeté</strong> par l'administrateur.</p>
    <a href="/ProjetPHP/View/Logout.php" class="btn btn-danger mt-4">Se déconnecter</a>
  </div>
</div>
</body>
</html>
