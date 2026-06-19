<table>
    <thead>
        <tr>
            <th>No</th>
            <th>No Rek</th>
            <th>Tgl Tagih</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>HPKA</th>
            <th>Adm</th>
            <th>MBL</th>
            <th>MBI</th>
            <th>Pemakaian</th>
            <th>Tagihan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $index => $row): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($row['no_rek']) ?></td>
                <td><?= date('d/m/Y', strtotime($row['tgl_tagih'])) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= rupiah($row['hpka']) ?></td>
                <td><?= rupiah($row['adm']) ?></td>
                <td><?= (int) $row['mbl'] ?></td>
                <td><?= (int) $row['mbi'] ?></td>
                <td><?= (int) $row['pemakaian'] ?></td>
                <td><?= rupiah($row['total_tagihan']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="10">Total Tagihan</th>
            <th><?= rupiah($total) ?></th>
        </tr>
    </tfoot>
</table>
<div class="signature">
    <p>Padang, <?= date('d/m/Y') ?></p>
    <p>Kasir</p>
    <br><br>
    <p>NIK: 5512 / Rezky Subrata</p>
</div>
