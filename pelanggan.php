<?php
require_once __DIR__ . '/includes/auth.php';
require_login();
$title = 'Data Pelanggan';
$active = 'pelanggan';
$pageTitle = 'Data Pelanggan';
$pageSubtitle = 'Kelola nomor rekening, kategori, dan data pelanggan';
require __DIR__ . '/includes/header.php';
?>
<section class="layout-two">
    <form class="panel form-grid" id="pelangganForm">
        <input type="hidden" name="id_pelanggan" id="id_pelanggan">
        <h2>Form Pelanggan</h2>
        <label>No Rekening <input name="no_rek" id="no_rek" required></label>
        <label>Nama <input name="nama" id="nama" required></label>
        <label>Kategori
            <select name="kategori" id="kategori" required>
                <option value="RT">RT - Rumah Tangga</option>
                <option value="ID">ID - Industri</option>
                <option value="IP">IP - Instansi Pemerintah</option>
            </select>
        </label>
        <label>No HP <input name="no_hp" id="no_hp"></label>
        <label>Alamat <textarea name="alamat" id="alamat"></textarea></label>
        <div class="actions">
            <button type="submit">Simpan</button>
            <button type="button" class="secondary" id="resetPelanggan">Batal</button>
        </div>
    </form>

    <section class="panel">
        <div class="panel-head">
            <h2>Daftar Pelanggan</h2>
            <input type="search" id="searchPelanggan" placeholder="Cari pelanggan">
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>No Rek</th><th>Nama</th><th>Kategori</th><th>HP</th><th>Aksi</th></tr>
                </thead>
                <tbody id="pelangganRows"></tbody>
            </table>
        </div>
        <div class="pagination" id="pelangganPager"></div>
    </section>
</section>
<script>window.pageModule = 'pelanggan';</script>
<?php require __DIR__ . '/includes/footer.php'; ?>
