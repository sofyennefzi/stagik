<?php
require_once("model/User.php");

class UserController {

    public function index() {
        $users = User::all();
        require("view/user/index.php");
    }

    public function show($id) {
        $user = User::find($id);
        require("view/user/show.php");
    }

    public function create() {
        require("view/user/create.php");
    }

    public function store() {
        $user = new User();
        $user->setEmail($_POST['email']);
        $user->setMotDePasse($_POST['mot_de_passe']);
        $user->setRole($_POST['role']);
        $user->setTelephone($_POST['telephone']);
        $user->save();
        header("Location: index.php?controller=user&action=index");
    }

    public function edit($id) {
        $user = User::find($id);
        require("view/user/edit.php");
    }

    public function update($id) {
        $user = User::find($id);
        $user->setEmail($_POST['email']);
        $user->setMotDePasse($_POST['mot_de_passe']);
        $user->setRole($_POST['role']);
        $user->setTelephone($_POST['telephone']);
        $user->save();
        header("Location: index.php?controller=user&action=index");
    }

    public function delete($id) {
        $user = User::find($id);
        $user->delete();
        header("Location: index.php?controller=user&action=index");
    }
}
?>
