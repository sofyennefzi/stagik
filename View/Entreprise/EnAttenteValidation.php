<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Compte en attente | Stagik</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #fffde7;
      font-family: 'Poppins', sans-serif;
    }
    .pending-box {
      background: #fff;
      border: 1px solid #ffeeba;
      border-left: 5px solid #ffc107;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(255, 193, 7, 0.1);
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
  <div class="pending-box text-center">
    <h2 class="text-warning"><i class="bi bi-hourglass-split"></i> Compte en attente de validation</h2>
    <p class="mt-3">Votre compte entreprise est en cours de traitement. Vous recevrez une notification dès sa validation.</p>
    <a href="/ProjetPHP/View/Logout.php" class="btn btn-secondary mt-4">Se déconnecter</a>
  </div>
</div>
</body>
</html>
