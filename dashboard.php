<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
require_login();

$title = 'Dashboard PDAM Zernih';
$active = 'dashboard';
$pageTitle = 'Dashboard';
$pageSubtitle = 'Ringkasan pendapatan dan tagihan rekening air';

$summary = $pdo->query("
    SELECT
        COUNT(DISTINCT p.id_pelanggan) total_pelanggan,
        COUNT(t.id_tagihan) total_tagihan,
        COALESCE(SUM(t.tagihan), 0) total_pendapatan,
        COALESCE(MAX(t.tagihan), 0) tagihan_tertinggi
    FROM pelanggan p
    LEFT JOIN tagihan t ON t.id_pelanggan = p.id_pelanggan
")->fetch();

$chart = $pdo->query("
    SELECT DATE_FORMAT(periode, '%Y-%m') bulan, SUM(tagihan) total
    FROM tagihan
    GROUP BY DATE_FORMAT(periode, '%Y-%m')
    ORDER BY bulan
")->fetchAll();

require __DIR__ . '/includes/header.php';
?>
<section class="stats-grid">
    <article><span>Pelanggan</span><strong><?= (int) $summary['total_pelanggan'] ?></strong></article>
    <article><span>Tagihan</span><strong><?= (int) $summary['total_tagihan'] ?></strong></article>
    <article><span>Pendapatan</span><strong><?= rupiah($summary['total_pendapatan']) ?></strong></article>
    <article><span>Tertinggi</span><strong><?= rupiah($summary['tagihan_tertinggi']) ?></strong></article>
</section>

<section class="panel">
    <div class="panel-head">
        <h2>Grafik Pendapatan Rekening Air</h2>
    </div>
    <div class="chart" id="incomeChart" data-chart='<?= json_encode($chart) ?>'></div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
