<?php
require_once("../../Model/Model.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../../Login.php");
    exit;
}

$pdo = Model::connect();
$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: UserList.php");
exit;
?>
    