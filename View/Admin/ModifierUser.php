<?php
require_once("../../Model/Model.php");
require_once("../../Model/User.php");
require_once("../../Model/Etudiant.php");
require_once("../../Model/Entreprise.php");

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../Login.php");
    exit;
}

$pdo = Model::connect();
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID manquant");
}

$user = User::find($id);
if (!$user) {
    die("Utilisateur introuvable");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nouvelEmail = trim($_POST['email']);
    $ancienEmail = $user->getEmail();
    
    // Si l'email a changé, vérifier qu'il n'est pas utilisé
    if ($nouvelEmail !== $ancienEmail) {
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
        $checkStmt->execute([$nouvelEmail]);
        $emailExiste = $checkStmt->fetchColumn();
    
        if ($emailExiste > 0) {
            echo "<div class='alert alert-danger text-center'>Cet email est déjà utilisé par un autre utilisateur.</div>";
            exit;
        }
    
        $user->setEmail($nouvelEmail); // On met à jour seulement ici
    }
        $telephone = $_POST['telephone'];
    $role = $_POST['role'];

    // Vérifier si l'email est déjà utilisé par un autre utilisateur
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ? AND id != ?");
    $checkStmt->execute([$nouvelEmail, $user->getId()]);
    $emailExiste = $checkStmt->fetchColumn();

    if ($emailExiste > 0) {
        echo "<div class='alert alert-danger text-center'>Cet email est déjà utilisé par un autre utilisateur.</div>";
        exit;
    }
    $user->setTelephone($telephone);
    $user->setRole($role);
    $user->save();

    // Mise à jour spécifique selon le rôle
    if ($role === 'etudiant') {
        $etudiant = Etudiant::where('id', $id)[0];
        $etudiant->setNom($_POST['nom']);
        $etudiant->setPrenom($_POST['prenom']);
        $etudiant->setUniversite($_POST['universite']);
        $etudiant->setNiveauEtudes($_POST['niveau_etudes']);
        $etudiant->setDomaineEtudes($_POST['domaine_etudes']);
        $etudiant->save();
    } elseif ($role === 'entreprise') {
        $entreprise = Entreprise::where('id_utilisateur', $id)[0];
        $entreprise->setNom($_POST['nom']);
        $entreprise->setSecteur($_POST['secteur']);
        $entreprise->setTaille($_POST['taille']);
        $entreprise->setAdresse($_POST['adresse']);
        $entreprise->setDescription($_POST['description']);
        $entreprise->save();
    }

    header("Location: UserList.php");
    exit;
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier utilisateur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../Navbar.php"); ?>
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card p-4 shadow-sm">
          <h2 class="text-center mb-4">Modifier un utilisateur</h2>

          <form method="POST">
            <div class="row g-3">

              <!-- Email -->
              <div class="col-12">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user->getEmail()) ?>" required>
              </div>

              <!-- Téléphone -->
              <div class="col-12">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($user->getTelephone()) ?>">
              </div>

              <input type="hidden" name="role" value="<?= $user->getRole() ?>">

              <?php if ($user->getRole() === 'etudiant'):
                $etudiant = Etudiant::where('id', $id)[0]; ?>
                <!-- Nom -->
                <div class="col-md-6">
                  <label class="form-label">Nom</label>
                  <input type="text" name="nom" class="form-control" value="<?= $etudiant->getNom() ?>">
                </div>

                <!-- Prénom -->
                <div class="col-md-6">
                  <label class="form-label">Prénom</label>
                  <input type="text" name="prenom" class="form-control" value="<?= $etudiant->getPrenom() ?>">
                </div>

                <!-- Université -->
                <div class="col-md-6">
                  <label class="form-label">Université</label>
                  <input type="text" name="universite" class="form-control" value="<?= $etudiant->getUniversite() ?>">
                </div>

                <!-- Niveau d'études -->
                <div class="col-md-6">
                  <label class="form-label">Niveau d'études</label>
                  <input type="text" name="niveau_etudes" class="form-control" value="<?= $etudiant->getNiveauEtudes() ?>">
                </div>

                <!-- Domaine -->
                <div class="col-12">
                  <label class="form-label">Domaine d'études</label>
                  <input type="text" name="domaine_etudes" class="form-control" value="<?= $etudiant->getDomaineEtudes() ?>">
                </div>

              <?php elseif ($user->getRole() === 'entreprise'):
                $entreprise = Entreprise::where('user_id', $id)[0]; ?>

                <!-- Nom entreprise -->
                <div class="col-12">
                  <label class="form-label">Nom de l'entreprise</label>
                  <input type="text" name="nom" class="form-control" value="<?= $entreprise->getNom() ?>">
                </div>

                <!-- Secteur -->
                <div class="col-md-6">
                  <label class="form-label">Secteur</label>
                  <input type="text" name="secteur" class="form-control" value="<?= $entreprise->getSecteur() ?>">
                </div>

                <!-- Taille -->
                <div class="col-md-6">
                  <label class="form-label">Taille</label>
                  <input type="text" name="taille" class="form-control" value="<?= $entreprise->getTaille() ?>">
                </div>

                <!-- Adresse -->
                <div class="col-12">
                  <label class="form-label">Adresse</label>
                  <input type="text" name="adresse" class="form-control" value="<?= $entreprise->getAdresse() ?>">
                </div>

                <!-- Description -->
                <div class="col-12">
                  <label class="form-label">Description</label>
                  <textarea name="description" class="form-control" rows="3"><?= $entreprise->getDescription() ?></textarea>
                </div>

              <?php endif; ?>

              <!-- Boutons -->
              <div class="col-12 text-center pt-3">
                <button type="submit" class="btn btn-success">Enregistrer</button>
                <a href="UserList.php" class="btn btn-secondary">Retour</a>
              </div>

            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>
<?php include("../Footer.php"); ?>
</body>
</html>
