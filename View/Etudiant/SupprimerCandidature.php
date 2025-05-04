<?php
require_once("../../Model/Model.php");
session_start();

// Vérification si l'étudiant est connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'etudiant') {
    header("Location: ../Login.php");
    exit;
}

// Vérifie si un ID a été passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("❌ ID de candidature manquant.");
}

$idCandidature = $_GET['id'];
$pdo = Model::connect();

// Vérifie que la candidature appartient bien à l'étudiant connecté
$checkStmt = $pdo->prepare("
    SELECT c.id_candidature 
    FROM candidature c
    JOIN etudiant e ON c.id_etudiant = e.id
    WHERE c.id_candidature = ? AND e.user_id = ?
");

$checkStmt->execute([$idCandidature, $_SESSION['user_id']]);
$candidature = $checkStmt->fetch();

if (!$candidature) {
    die("❌ Candidature non trouvée ou vous n'avez pas le droit de la supprimer.");
}

// Supprimer la candidature
$deleteStmt = $pdo->prepare("DELETE FROM candidature WHERE id_candidature = ?");
$deleteStmt->execute([$idCandidature]);

// Redirection après suppression
header("Location: MesPostulations.php");
exit;
?>
