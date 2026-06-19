<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$title = 'Laporan Pendapatan';
$active = 'laporan';
$pageTitle = 'Laporan Pendapatan';
$pageSubtitle = 'Cetak laporan periode, tahunan, dan pendapatan tertinggi';
require __DIR__ . '/includes/header.php';
?>
<section class="report-grid">
    <form class="panel report-card" action="print/laporan_periode.php" method="get" target="_blank">
        <h2>Per Periode</h2>
        <label>Dari <input type="month" name="dari" value="2025-01" required></label>
        <label>Sampai <input type="month" name="sampai" value="2025-12" required></label>
        <button>Cetak</button>
    </form>
    <form class="panel report-card" action="print/laporan_tahun.php" method="get" target="_blank">
        <h2>Per Tahun</h2>
        <label>Tahun <input type="number" name="tahun" value="2025" required></label>
        <button>Cetak</button>
    </form>
    <form class="panel report-card" action="print/laporan_tertinggi.php" method="get" target="_blank">
        <h2>Pendapatan Tertinggi</h2>
        <label>Tahun <input type="number" name="tahun" value="2025" required></label>
        <button>Cetak</button>
    </form>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
