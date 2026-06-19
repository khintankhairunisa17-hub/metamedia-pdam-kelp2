<?php
$printTitle = 'Cetak Rekening Pelanggan';
require __DIR__ . '/_print_header.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM v_pendapatan_pdam WHERE id_tagihan = ?');
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) {
    exit('Data rekening tidak ditemukan.');
}
?>
<section class="receipt">
    <header>
        <h1>PERUSAHAAN DAERAH AIR ZERNIH</h1>
        <h2>REKENING AIR PELANGGAN</h2>
        <p>Periode: <?= date('F Y', strtotime($row['periode'])) ?></p>
    </header>
    <table class="plain">
        <tr><td>No Rekening</td><td>: <?= htmlspecialchars($row['no_rek']) ?></td></tr>
        <tr><td>Nama</td><td>: <?= htmlspecialchars($row['nama']) ?></td></tr>
        <tr><td>Kategori</td><td>: <?= htmlspecialchars($row['kategori']) ?></td></tr>
        <tr><td>Tanggal Tagih</td><td>: <?= date('d/m/Y', strtotime($row['tgl_tagih'])) ?></td></tr>
        <tr><td>Meter Bulan Lalu</td><td>: <?= (int) $row['mbl'] ?> m3</td></tr>
        <tr><td>Meter Bulan Ini</td><td>: <?= (int) $row['mbi'] ?> m3</td></tr>
        <tr><td>Pemakaian</td><td>: <?= (int) $row['pemakaian'] ?> m3</td></tr>
        <tr><td>HPKA</td><td>: <?= rupiah($row['hpka']) ?></td></tr>
        <tr><td>Administrasi</td><td>: <?= rupiah($row['adm']) ?></td></tr>
        <tr class="total"><td>Total Tagihan</td><td>: <?= rupiah($row['total_tagihan']) ?></td></tr>
    </table>
    <div class="signature">
        <p>Padang, <?= date('d/m/Y') ?></p>
        <p>Kasir</p>
        <br><br>
        <p>NIK: 5512 / Rezky Subrata</p>
    </div>
</section>
<?php require __DIR__ . '/_print_footer.php'; ?>
