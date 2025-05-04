<?php
require_once("../../Model/Model.php");

if (!isset($_GET['id'])) {
    die("ID manquant.");
}

$pdo = Model::connect();
$stmt = $pdo->prepare("UPDATE entreprise SET statut_validation = 'refuse' WHERE id = ?");
$stmt->execute([$_GET['id']]);

header("Location: ValidationEntreprises.php");
exit;
