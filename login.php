<?php
session_start();
require_once __DIR__ . '/config/database.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare('SELECT * FROM `user` WHERE username = ? LIMIT 1');
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = [
        'id' => $user['id_user'],
        'nama' => $user['nama'],
        'username' => $user['username'],
    ];
    header('Location: dashboard.php');
    exit;
}

header('Location: index.php?error=1');
