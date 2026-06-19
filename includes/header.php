<?php
require_once __DIR__ . '/auth.php';
$user = current_user();
$active = $active ?? '';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title ?? 'PDAM Zernih') ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<aside class="sidebar">
    <div class="brand">
        <span class="brand-mark">AZ</span>
        <div>
            <strong>PDAM Zernih</strong>
            <small>Rekening Air</small>
        </div>
    </div>
    <nav>
        <a class="<?= $active === 'dashboard' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
        <a class="<?= $active === 'pelanggan' ? 'active' : '' ?>" href="pelanggan.php">Pelanggan</a>
        <a class="<?= $active === 'tagihan' ? 'active' : '' ?>" href="tagihan.php">Tagihan</a>
        <a class="<?= $active === 'laporan' ? 'active' : '' ?>" href="laporan.php">Laporan</a>
    </nav>
    <a class="logout" href="logout.php">Logout</a>
</aside>
<main class="main">
    <header class="topbar">
        <div>
            <h1><?= htmlspecialchars($pageTitle ?? 'Dashboard') ?></h1>
            <p><?= htmlspecialchars($pageSubtitle ?? 'Sistem Informasi PDAM') ?></p>
        </div>
        <div class="user-chip"><?= htmlspecialchars($user['nama'] ?? 'Admin') ?></div>
    </header>
