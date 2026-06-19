<?php
$printTitle = 'Laporan Pendapatan Tertinggi';
require __DIR__ . '/_print_header.php';

$tahun = (int) ($_GET['tahun'] ?? date('Y'));
$stmt = $pdo->prepare('SELECT * FROM v_pendapatan_pdam WHERE YEAR(periode) = ? ORDER BY total_tagihan DESC LIMIT 10');
$stmt->execute([$tahun]);
$rows = $stmt->fetchAll();
$total = array_sum(array_column($rows, 'total_tagihan'));
?>
<section>
    <header class="report-title">
        <h1>PERUSAHAAN DAERAH AIR ZERNIH</h1>
        <h2>LAPORAN PENDAPATAN TERTINGGI</h2>
        <p>Tahun: <?= $tahun ?></p>
    </header>
    <?php require __DIR__ . '/table_pendapatan.php'; ?>
</section>
<?php require __DIR__ . '/_print_footer.php'; ?>
