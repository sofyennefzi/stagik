<?php
require_once("model/Etudiant.php");

class EtudiantController {

    public function index() {
        $etudiants = Etudiant::all();
        require("view/etudiant/index.php");
    }

    public function show($id) {
        $etudiant = Etudiant::find($id);
        require("view/etudiant/show.php");
    }

    public function create() {
        require("view/etudiant/create.php");
    }

    public function store() {
        $etudiant = new Etudiant();
        $etudiant->setNom($_POST['nom']);
        $etudiant->setPrenom($_POST['prenom']);
        $etudiant->setUniversite($_POST['universite']);
        $etudiant->setNiveauEtudes($_POST['niveau_etudes']);
        $etudiant->setDomaineEtudes($_POST['domaine_etudes']);
        $etudiant->save();
        
        header("Location: index.php?controller=etudiant&action=index");
    }

    public function edit($id) {
        $etudiant = Etudiant::find($id);
        require("view/etudiant/edit.php");
    }

    public function update($id) {
        $etudiant = Etudiant::find($id);
        $etudiant->setNom($_POST['nom']);
        $etudiant->setPrenom($_POST['prenom']);
        $etudiant->setUniversite($_POST['universite']);
        $etudiant->setNiveauEtudes($_POST['niveau_etudes']);
        $etudiant->setDomaineEtudes($_POST['domaine_etudes']);
        $etudiant->save();
        header("Location: index.php?controller=etudiant&action=index");
    }

    public function delete($id) {
        $etudiant = Etudiant::find($id);
        $etudiant->delete();
        header("Location: index.php?controller=etudiant&action=index");
    }
    public function register() {
        // 1. Vérifier que les deux mots de passe correspondent
        if ($_POST['password'] !== $_POST['confirm_password']) {
            echo "⚠️ Les mots de passe ne correspondent pas.";
            return;
        }
    
        // 2. Vérifier si l'email est déjà utilisé
        $existingUser = User::where('email', $_POST['email']);
        if ($existingUser) {
            echo "⚠️ Cet email est déjà utilisé.";
            return;
        }
    
        // 3. Créer le compte utilisateur
        $user = new User();
        $user->setEmail($_POST['email']);
        $user->setMotDePasse(password_hash($_POST['password'], PASSWORD_DEFAULT));
        $user->setRole("etudiant");
        $user->setTelephone($_POST['telephone']);
        $user->save();
    
        // 4. Créer l'étudiant en réutilisant le même ID
       // 4. Récupérer le dernier ID inséré
$lastInsertedUser = User::lastInserted(); // à créer dans Model.php

$etudiant = new Etudiant();
$etudiant->setNom($_POST['nom']);
$etudiant->setPrenom($_POST['prenom']);
$etudiant->setUniversite($_POST['universite']);
$etudiant->setNiveauEtudes($_POST['niveau_etudes']);
$etudiant->setDomaineEtudes($_POST['domaine_etudes']);
$etudiant->setUserId($lastInsertedUser); // 🔗 Lien avec utilisateur
$etudiant->save();


        
        // 5. Redirection vers la page de connexion
        header("Location: index.php?controller=user&action=login");
    }
    
}
?>
