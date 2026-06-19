<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $page = max(1, (int) ($_GET['page'] ?? 1));
    $limit = 5;
    $offset = ($page - 1) * $limit;
    $search = '%' . trim($_GET['search'] ?? '') . '%';

    $where = 'WHERE p.no_rek LIKE ? OR p.nama LIKE ? OR t.periode LIKE ?';
    $count = $pdo->prepare("SELECT COUNT(*) total FROM tagihan t JOIN pelanggan p ON p.id_pelanggan=t.id_pelanggan $where");
    $count->execute([$search, $search, $search]);
    $total = (int) $count->fetch()['total'];

    $stmt = $pdo->prepare("
        SELECT t.*, p.no_rek, p.nama, p.kategori
        FROM tagihan t
        JOIN pelanggan p ON p.id_pelanggan = t.id_pelanggan
        $where
        ORDER BY t.periode DESC, t.id_tagihan DESC
        LIMIT ? OFFSET ?
    ");
    $stmt->bindValue(1, $search);
    $stmt->bindValue(2, $search);
    $stmt->bindValue(3, $search);
    $stmt->bindValue(4, $limit, PDO::PARAM_INT);
    $stmt->bindValue(5, $offset, PDO::PARAM_INT);
    $stmt->execute();

    json_response([
        'data' => $stmt->fetchAll(),
        'page' => $page,
        'pages' => max(1, (int) ceil($total / $limit)),
    ]);
}

$input = json_decode(file_get_contents('php://input'), true) ?: $_POST;
$action = $input['action'] ?? '';

if ($method === 'POST') {
    if ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM tagihan WHERE id_tagihan = ?');
        $stmt->execute([(int) $input['id_tagihan']]);
        json_response(['message' => 'Data tagihan dihapus.']);
    }

    $mbl = (int) ($input['mbl'] ?? 0);
    $mbi = (int) ($input['mbi'] ?? 0);
    $hpka = (int) ($input['hpka'] ?? 2000);
    $adm = (int) ($input['adm'] ?? 0);
    $pemakaian = max(0, $mbi - $mbl);
    $tagihan = ($pemakaian * $hpka) + $adm;
    $periode = ($_POST['periode'] ?? $input['periode'] ?? date('Y-m')) . '-01';

    $data = [
        (int) $input['id_pelanggan'],
        $periode,
        $input['tgl_tagih'],
        $hpka,
        $adm,
        $mbl,
        $mbi,
        $pemakaian,
        $tagihan,
    ];

    $id = (int) ($input['id_tagihan'] ?? 0);
    if ($id > 0) {
        $stmt = $pdo->prepare('UPDATE tagihan SET id_pelanggan=?, periode=?, tgl_tagih=?, hpka=?, adm=?, mbl=?, mbi=?, pemakaian=?, tagihan=? WHERE id_tagihan=?');
        $stmt->execute([...$data, $id]);
        json_response(['message' => 'Data tagihan diperbarui.']);
    }

    $stmt = $pdo->prepare('INSERT INTO tagihan (id_pelanggan, periode, tgl_tagih, hpka, adm, mbl, mbi, pemakaian, tagihan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute($data);
    json_response(['message' => 'Data tagihan ditambahkan.']);
}

json_response(['message' => 'Metode tidak valid.'], 405);
