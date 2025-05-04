<?php
require_once("Model.php");

class User extends Model {

    private $id;
    private $email;
    private $mot_de_passe;
    private $role;
    private $telephone;

    protected static $table = 'utilisateur'; 
    protected static $primary = 'id';

    public function __construct($id = NULL, $nom = NULL, $prenom = NULL, $universite = NULL, $niveau_etudes = NULL, $domaine_etudes = NULL) {
        if (!is_null($id)) {
            $this->id = $id;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->universite = $universite;
            $this->niveau_etudes = $niveau_etudes;
            $this->domaine_etudes = $domaine_etudes;
        }
    }
    

    public function getId() { return $this->id; }
    public function getEmail() { return $this->email; }
    public function getMotDePasse() { return $this->mot_de_passe; }
    public function getRole() { return $this->role; }
    public function getTelephone() {return $this->telephone; }

    public function setId($id) {$this->id = $id;}
    public function setEmail($email) { $this->email = $email; }
    public function setMotDePasse($mot) { $this->mot_de_passe = $mot; }
    public function setRole($role) { $this->role = $role; }
    public function setTelephone($tel) {$this->telephone = $tel;}


}
?>
