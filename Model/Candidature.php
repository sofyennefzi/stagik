<?php
require_once("Model.php");

class Candidature extends Model {

    private $id_candidature;
    private $id_etudiant;
    private $id_offre;
    private $date_postulation;
    private $statut;
    private $cv;
    private $lettre_motivation;

    protected static $table = 'candidature';
    protected static $primary = 'id_candidature';

    public function __construct($id_candidature = NULL, $id_etudiant = NULL, $id_offre = NULL, $date_postulation = NULL, $statut = NULL, $cv = NULL, $lettre_motivation = NULL) {
        if (!is_null($id_candidature)) {
            $this->id_candidature = $id_candidature;
            $this->id_etudiant = $id_etudiant;
            $this->id_offre = $id_offre;
            $this->date_postulation = $date_postulation;
            $this->statut = $statut;
            $this->cv = $cv;
            $this->lettre_motivation = $lettre_motivation;
        }
    }

    public function getIdCandidature() { return $this->id_candidature; }
    public function getIdEtudiant() { return $this->id_etudiant; }
    public function getIdOffre() { return $this->id_offre; }
    public function getDatePostulation() { return $this->date_postulation; }
    public function getStatut() { return $this->statut; }
    public function getCv() { return $this->cv; }
    public function getLettreMotivation() { return $this->lettre_motivation; }

    public function setId($id_candidature) {$this->id_candidature = $id_candidature;}
    public function setIdEtudiant($id) { $this->id_etudiant = $id; }
    public function setIdOffre($id) { $this->id_offre = $id; }
    public function setDatePostulation($date) { $this->date_postulation = $date; }
    public function setStatut($statut) { $this->statut = $statut; }
    public function setCv($cv) { $this->cv = $cv; }
    public function setLettreMotivation($lettre) { $this->lettre_motivation = $lettre; }

}
?>
