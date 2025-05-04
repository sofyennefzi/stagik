<?php
require_once("../../Model/Model.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../Login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID de l'offre manquant.");
}

$pdo = Model::connect();
$stmt = $pdo->prepare("DELETE FROM offre WHERE id_offre = ?");
$stmt->execute([$id]);

header("Location: ManageOffers.php");
exit;
?>
