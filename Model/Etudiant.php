<?php
require_once("Model.php");

class Etudiant extends Model {

    private $id;
    private $nom;
    private $prenom;
    private $universite;
    private $niveau_etudes;
    private $domaine_etudes;
    
    protected static $table = 'etudiant'; // ✅ STATIC
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
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getUniversite() { return $this->universite; }
    public function getNiveauEtudes() { return $this->niveau_etudes; }
    public function getDomaineEtudes() { return $this->domaine_etudes; }
    
    public function setId($id) {$this->id = $id;}
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setUniversite($universite) { $this->universite = $universite; }
    public function setNiveauEtudes($niveau) { $this->niveau_etudes = $niveau; }
    public function setDomaineEtudes($domaine) { $this->domaine_etudes = $domaine; }    

}
?>
