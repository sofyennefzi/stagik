<?php
require_once("model/Entreprise.php");

class EntrepriseController {

    public function index() {
        $entreprises = Entreprise::all();
        require("view/entreprise/index.php");
    }

    public function show($id) {
        $entreprise = Entreprise::find($id);
        require("view/entreprise/show.php");
    }

    public function create() {
        require("view/entreprise/create.php");
    }

    public function store() {
        $entreprise = new Entreprise();
        $entreprise->setNom($_POST['nom']);
        $entreprise->setSecteur($_POST['secteur']);
        $entreprise->setTaille($_POST['taille']);
        $entreprise->setAdresse($_POST['adresse']);
        $entreprise->save();        
        header("Location: index.php?controller=entreprise&action=index");
    }

    public function edit($id) {
        $entreprise = Entreprise::find($id);
        require("view/entreprise/edit.php");
    }

    public function update($id) {
        $entreprise = Entreprise::find($id);
        $entreprise->setNom($_POST['nom']);
        $entreprise->setSecteur($_POST['secteur']);
        $entreprise->setTaille($_POST['taille']);
        $entreprise->setAdresse($_POST['adresse']);
        
        header("Location: index.php?controller=entreprise&action=index");
    }

    public function delete($id) {
        $entreprise = Entreprise::find($id);
        $entreprise->delete();
        header("Location: index.php?controller=entreprise&action=index");
    }
    public function register() {
        // Vérifier les mots de passe
        if ($_POST['password'] !== $_POST['confirm_password']) {
            echo "Les mots de passe ne correspondent pas.";
            return;
        }
    
        // Vérifier si l'email est déjà utilisé
        $existingUser = User::where('email', $_POST['email']);
        if ($existingUser) {
            echo "Cet email est déjà utilisé.";
            return;
        }
    
        // Créer le compte utilisateur
        $user = new User();
        $user->setEmail($_POST['email']);
        $user->setMotDePasse(password_hash($_POST['password'], PASSWORD_DEFAULT));
        $user->setRole("entreprise");
        $user->setTelephone($_POST['telephone']);
        $user->save();
    
        // Récupérer l'ID généré
        $idUser = User::lastInserted(); // méthode lastInserted() à avoir dans Model
    
        // Créer l’entreprise liée à ce compte
        $entreprise = new Entreprise();
        $entreprise->setIdUtilisateur($idUser); 
        $entreprise->setNom($_POST['nom_entreprise']);
        $entreprise->setSecteur($_POST['secteur']);
        $entreprise->setTaille($_POST['taille']);
        $entreprise->setAdresse($_POST['adresse']);
        $imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $imageName = basename($_FILES["image"]["name"]);
    $imagePath = $uploadDir . $imageName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    $imagePath = "uploads/" . $imageName;
}

$entreprise->setImage($imagePath);
        $entreprise->save();
    
        // Rediriger après succès
        header("Location: index.php?controller=user&action=login");
    }
    
}
?>
