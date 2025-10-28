<?php
include '../includes/auth.php';
include '../includes/db.php';

if (!isset($_GET['id'])) {
  header("Location: admin.php");
  exit;
}

$id = (int)$_GET['id'];

$user = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();

if ($user && $user['role'] !== 'admin') {
  $conn->query("DELETE FROM users WHERE id = $id");
}

header("Location: admin.php");
exit;
