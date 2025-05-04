<?php
require_once("../../model/Etudiant.php");
require_once("../../model/User.php");

header('Content-Type: application/json');

if (!isset($_GET['email'])) {
    echo json_encode(['success' => false, 'message' => 'Email manquant.']);
    exit;
}

$email = $_GET['email'];
$user = User::where('email', $email);

if ($user && count($user) > 0) {
    $user = $user[0];
    $etudiant = Etudiant::find($user->getId());

    if ($etudiant) {
        echo json_encode([
            'success' => true,
            'nom' => $etudiant->getNom(),
            'prenom' => $etudiant->getPrenom(),
            'universite' => $etudiant->getUniversite(),
            'niveau_etudes' => $etudiant->getNiveauEtudes()
        ]);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Étudiant non trouvé.']);
