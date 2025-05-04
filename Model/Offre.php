<?php
require_once("Model.php");

class Offre extends Model {

    private $id_offre;
    private $titre;
    private $description;
    private $specialite;
    private $date_publication;
    private $id_entreprise;

    protected static $table = 'offre';
    protected static $primary = 'id_offre';

    public function __construct($id_offre = NULL, $titre = NULL, $description = NULL, $specialite = NULL, $date_publication = NULL,$id_entreprise = NULL) {
        if (!is_null($id_offre)) {
            $this->id_offre = $id_offre;
            $this->titre = $titre;
            $this->description = $description;
            $this->specialite = $specialite;
            $this->date_publication = $date_publication;
            $this->$id_entreprise = $$id_entreprise;

        }
    }

    public function getIdOffre() { return $this->id_offre; }
    public function getTitre() { return $this->titre; }
    public function getDescription() { return $this->description; }
    public function getSpecialite() { return $this->specialite; }
    public function getDatePublication() { return $this->date_publication; }
    public function getIdEntreprise() { return $this->id_entreprise; }
    
    public function setId($id_offre) {$this->id_offre = $id_offre;}
    public function setTitre($titre) { $this->titre = $titre; }
    public function setDescription($desc) { $this->description = $desc; }
    public function setSpecialite($spec) { $this->specialite = $spec; }
    public function setDatePublication($date) { $this->date_publication = $date; }
    public function setIdEntreprise($id_entreprise) {$this->id_entreprise = $id_entreprise; }
}
?>
