<?php
$printTitle = 'Laporan Pendapatan Tahunan';
require __DIR__ . '/_print_header.php';

$tahun = (int) ($_GET['tahun'] ?? date('Y'));
$stmt = $pdo->prepare('SELECT * FROM v_pendapatan_pdam WHERE YEAR(periode) = ? ORDER BY periode, no_rek');
$stmt->execute([$tahun]);
$rows = $stmt->fetchAll();
$total = array_sum(array_column($rows, 'total_tagihan'));
?>
<section>
    <header class="report-title">
        <h1>PERUSAHAAN DAERAH AIR ZERNIH</h1>
        <h2>LAPORAN PENDAPATAN REKENING TAHUNAN</h2>
        <p>Tahun: <?= $tahun ?></p>
    </header>
    <?php require __DIR__ . '/table_pendapatan.php'; ?>
</section>
<?php require __DIR__ . '/_print_footer.php'; ?>
