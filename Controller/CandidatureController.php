<?php
require_once("model/Candidature.php");

class CandidatureController {

    public function index() {
        $candidatures = Candidature::all();
        require("view/candidature/index.php");
    }

    public function show($id) {
        $candidature = Candidature::find($id);
        require("view/candidature/show.php");
    }

    public function create() {
        require("view/candidature/create.php");
    }

    public function store() {
        $candidature = new Candidature();
        $candidature->setIdEtudiant($_POST['id_etudiant']);
        $candidature->setIdOffre($_POST['id_offre']);
        $candidature->setDatePostulation($_POST['date_postulation']);
        $candidature->setStatut($_POST['statut']);
        $candidature->setCv($_POST['cv']); // attention à la gestion de fichier dans le vrai cas
        $candidature->save();
        header("Location: index.php?controller=candidature&action=index");
    }

    public function edit($id) {
        $candidature = Candidature::find($id);
        require("view/candidature/edit.php");
    }

    public function update($id) {
        $candidature = Candidature::find($id);
        $candidature->setIdEtudiant($_POST['id_etudiant']);
        $candidature->setIdOffre($_POST['id_offre']);
        $candidature->setDatePostulation($_POST['date_postulation']);
        $candidature->setStatut($_POST['statut']);
        $candidature->setCv($_POST['cv']);
        $candidature->save();
        header("Location: index.php?controller=candidature&action=index");
    }

    public function delete($id) {
        $candidature = Candidature::find($id);
        $candidature->delete();
        header("Location: index.php?controller=candidature&action=index");
    }
}
?>
