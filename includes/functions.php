<?php

function rupiah(float|int $value): string
{
    return 'Rp' . number_format((float) $value, 0, ',', '.');
}

function json_response(array $payload, int $status = 200): void
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload);
    exit;
}

function kategori_label(string $kode): string
{
    return match ($kode) {
        'RT' => 'Rumah Tangga',
        'ID' => 'Industri',
        'IP' => 'Instansi Pemerintah',
        default => $kode,
    };
}

function biaya_adm(string $kategori): int
{
    return match ($kategori) {
        'RT' => 10000,
        'ID' => 20000,
        'IP' => 15000,
        default => 0,
    };
}
