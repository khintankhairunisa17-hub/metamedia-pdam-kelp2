<?php
$printTitle = 'Laporan Pendapatan Per Periode';
require __DIR__ . '/_print_header.php';

$dari = ($_GET['dari'] ?? date('Y-m')) . '-01';
$sampai = ($_GET['sampai'] ?? date('Y-m')) . '-31';
$stmt = $pdo->prepare('SELECT * FROM v_pendapatan_pdam WHERE periode BETWEEN ? AND ? ORDER BY periode, no_rek');
$stmt->execute([$dari, $sampai]);
$rows = $stmt->fetchAll();
$total = array_sum(array_column($rows, 'total_tagihan'));
?>
<section>
    <header class="report-title">
        <h1>PERUSAHAAN DAERAH AIR ZERNIH</h1>
        <h2>LAPORAN PENDAPATAN REKENING</h2>
        <p>Periode: <?= date('m/Y', strtotime($dari)) ?> - <?= date('m/Y', strtotime($sampai)) ?></p>
    </header>
    <?php require __DIR__ . '/table_pendapatan.php'; ?>
</section>
<?php require __DIR__ . '/_print_footer.php'; ?>
