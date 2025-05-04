<?php
require_once("Model.php");

class Entreprise extends Model {

    private $id;
    private $nom;
    private $secteur;
    private $taille;
    private $adresse;
    private $image;
    private $description;
    private $id_utilisateur;
    private $statut_validation;
    protected static $table = 'entreprise';
    protected static $primary = 'id';

    public function __construct($id = NULL, $nom = NULL, $secteur = NULL, $taille = NULL, $adresse = NULL, $image = NULL, $description = NULL, $id_utilisateur = NULL) {
        if (!is_null($id)) {
            $this->id = $id;
            $this->nom = $nom;
            $this->secteur = $secteur;
            $this->taille = $taille;
            $this->adresse = $adresse;
            $this->image = $image;
            $this->description = $description;
            $this->id_utilisateur = $id_utilisateur;
        }
    }
    
    
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getSecteur() { return $this->secteur; }
    public function getTaille() { return $this->taille; }
    public function getAdresse() { return $this->adresse; }
    public function getImage() {return $this->image; }
    public function getDescription() { return $this->description; }
    public function getIdUtilisateur() { return $this->id_utilisateur; }
    public function getStatutValidation() {return $this->statut_validation;}
    public function setId($id) {$this->id = $id;}
    public function setNom($nom) { $this->nom = $nom; }
    public function setSecteur($secteur) { $this->secteur = $secteur; }
    public function setTaille($taille) { $this->taille = $taille; }
    public function setAdresse($adresse) { $this->adresse = $adresse; }
    public function setImage($image) {$this->image = $image;}
    public function setDescription($description) { $this->description = $description; }
    public function setIdUtilisateur($id) { $this->id_utilisateur = $id; }
    public function setStatutValidation($statut) {$this->statut_validation = $statut;}
    
}
?>
