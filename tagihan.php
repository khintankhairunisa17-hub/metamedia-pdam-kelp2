<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';
require_login();
$title = 'Tagihan Rekening';
$active = 'tagihan';
$pageTitle = 'Tagihan Rekening';
$pageSubtitle = 'Input meter air, hitung pemakaian, dan cetak rekening';
$pelanggan = $pdo->query('SELECT id_pelanggan, no_rek, nama, kategori FROM pelanggan ORDER BY nama')->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="layout-two">
    <form class="panel form-grid" id="tagihanForm">
        <input type="hidden" name="id_tagihan" id="id_tagihan">
        <h2>Form Tagihan</h2>
        <label>Pelanggan
            <select name="id_pelanggan" id="id_pelanggan_select" required>
                <option value="">Pilih pelanggan</option>
                <?php foreach ($pelanggan as $row): ?>
                    <option value="<?= $row['id_pelanggan'] ?>" data-kategori="<?= $row['kategori'] ?>">
                        <?= htmlspecialchars($row['no_rek'] . ' - ' . $row['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Periode <input type="month" name="periode" id="periode" value="2025-05" required></label>
        <label>Tanggal Tagih <input type="date" name="tgl_tagih" id="tgl_tagih" required></label>
        <label>HPKA <input type="number" name="hpka" id="hpka" value="2000" required></label>
        <label>Administrasi <input type="number" name="adm" id="adm" readonly></label>
        <label>Meter Bulan Lalu <input type="number" name="mbl" id="mbl" min="0" required></label>
        <label>Meter Bulan Ini <input type="number" name="mbi" id="mbi" min="0" required></label>
        <label>Pemakaian <input type="number" name="pemakaian" id="pemakaian" readonly></label>
        <label>Tagihan <input type="number" name="tagihan" id="tagihan" readonly></label>
        <div class="actions">
            <button type="submit">Simpan</button>
            <button type="button" class="secondary" id="resetTagihan">Batal</button>
        </div>
    </form>

    <section class="panel">
        <div class="panel-head">
            <h2>Daftar Tagihan</h2>
            <input type="search" id="searchTagihan" placeholder="Cari tagihan">
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Periode</th><th>No Rek</th><th>Nama</th><th>Pakai</th><th>Tagihan</th><th>Aksi</th></tr>
                </thead>
                <tbody id="tagihanRows"></tbody>
            </table>
        </div>
        <div class="pagination" id="tagihanPager"></div>
    </section>
</section>
<script>window.pageModule = 'tagihan';</script>
<?php require __DIR__ . '/includes/footer.php'; ?>
