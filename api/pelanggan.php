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

    $count = $pdo->prepare('SELECT COUNT(*) total FROM pelanggan WHERE no_rek LIKE ? OR nama LIKE ? OR kategori LIKE ?');
    $count->execute([$search, $search, $search]);
    $total = (int) $count->fetch()['total'];

    $stmt = $pdo->prepare('SELECT * FROM pelanggan WHERE no_rek LIKE ? OR nama LIKE ? OR kategori LIKE ? ORDER BY id_pelanggan DESC LIMIT ? OFFSET ?');
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
        $stmt = $pdo->prepare('DELETE FROM pelanggan WHERE id_pelanggan = ?');
        $stmt->execute([(int) $input['id_pelanggan']]);
        json_response(['message' => 'Data pelanggan dihapus.']);
    }

    $id = (int) ($input['id_pelanggan'] ?? 0);
    $data = [
        trim($input['no_rek'] ?? ''),
        trim($input['nama'] ?? ''),
        $input['kategori'] ?? 'RT',
        trim($input['no_hp'] ?? ''),
        trim($input['alamat'] ?? ''),
    ];

    if ($id > 0) {
        $stmt = $pdo->prepare('UPDATE pelanggan SET no_rek=?, nama=?, kategori=?, no_hp=?, alamat=? WHERE id_pelanggan=?');
        $stmt->execute([...$data, $id]);
        json_response(['message' => 'Data pelanggan diperbarui.']);
    }

    $stmt = $pdo->prepare('INSERT INTO pelanggan (no_rek, nama, kategori, no_hp, alamat) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute($data);
    json_response(['message' => 'Data pelanggan ditambahkan.']);
}

json_response(['message' => 'Metode tidak valid.'], 405);
