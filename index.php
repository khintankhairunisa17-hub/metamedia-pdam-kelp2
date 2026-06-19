<?php
session_start();
if (!empty($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
$error = $_GET['error'] ?? '';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login PDAM Zernih</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <section class="login-panel">
        <div class="login-hero">
            <span class="brand-mark large">AZ</span>
            <h1>PDAM Zernih</h1>
            <p>Sistem Informasi Rekening Air dan Laporan Pendapatan</p>
        </div>
        <form class="login-card" action="login.php" method="post">
            <h2>Masuk Aplikasi</h2>
            <?php if ($error): ?>
                <div class="alert">Username atau password salah.</div>
            <?php endif; ?>
            <label>Username
                <input type="text" name="username" value="admin" required>
            </label>
            <label>Password
                <input type="password" name="password" value="admin123" required>
            </label>
            <button type="submit">Login</button>
        </form>
    </section>
</body>
</html>
