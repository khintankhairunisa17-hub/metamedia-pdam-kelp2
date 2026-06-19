<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($printTitle ?? 'Laporan PDAM') ?></title>
    <link rel="stylesheet" href="../assets/css/print.css">
</head>
<body>
