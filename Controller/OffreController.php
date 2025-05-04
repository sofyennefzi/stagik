<?php
require_once("model/Offre.php");

class OffreController {

    public function index() {
        $offres = Offre::all();
        require("view/offre/index.php");
    }

    public function show($id) {
        $offre = Offre::find($id);
        require("view/offre/show.php");
    }

    public function create() {
        require("view/offre/create.php");
    }

    public function store() {
        $offre = new Offre();
        $offre->setTitre($_POST['titre']);
        $offre->setDescription($_POST['description']);
        $offre->setSpecialite($_POST['specialite']);
        $offre->setDatePublication($_POST['date_publication']);
        $offre->save();
        header("Location: index.php?controller=offre&action=index");
    }

    public function edit($id) {
        $offre = Offre::find($id);
        require("view/offre/edit.php");
    }

    public function update($id) {
        $offre = Offre::find($id);
        $offre->setTitre($_POST['titre']);
        $offre->setDescription($_POST['description']);
        $offre->setSpecialite($_POST['specialite']);
        $offre->setDatePublication($_POST['date_publication']);
        $offre->save();
        header("Location: index.php?controller=offre&action=index");
    }

    public function delete($id) {
        $offre = Offre::find($id);
        $offre->delete();
        header("Location: index.php?controller=offre&action=index");
    }
}
?>
