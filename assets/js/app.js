const rupiah = (value) => new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    maximumFractionDigits: 0,
}).format(Number(value || 0));

const qs = (selector) => document.querySelector(selector);
const qsa = (selector) => [...document.querySelectorAll(selector)];

function formToObject(form) {
    return Object.fromEntries(new FormData(form).entries());
}

async function api(url, options = {}) {
    const response = await fetch(url, {
        headers: {'Content-Type': 'application/json'},
        ...options,
    });
    return response.json();
}

function renderPager(container, page, pages, onClick) {
    container.innerHTML = '';
    for (let i = 1; i <= pages; i++) {
        const button = document.createElement('button');
        button.textContent = i;
        button.className = i === page ? 'active' : '';
        button.addEventListener('click', () => onClick(i));
        container.appendChild(button);
    }
}

function initPelanggan() {
    const form = qs('#pelangganForm');
    const rows = qs('#pelangganRows');
    const pager = qs('#pelangganPager');
    const search = qs('#searchPelanggan');
    let page = 1;

    async function load() {
        const result = await api(`api/pelanggan.php?page=${page}&search=${encodeURIComponent(search.value)}`);
        rows.innerHTML = result.data.map(row => `
            <tr>
                <td>${row.no_rek}</td>
                <td>${row.nama}</td>
                <td>${row.kategori}</td>
                <td>${row.no_hp || '-'}</td>
                <td class="table-actions">
                    <button type="button" data-edit='${JSON.stringify(row)}'>Edit</button>
                    <button type="button" class="danger" data-delete="${row.id_pelanggan}">Hapus</button>
                </td>
            </tr>
        `).join('');
        renderPager(pager, result.page, result.pages, next => {
            page = next;
            load();
        });
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const result = await api('api/pelanggan.php', {method: 'POST', body: JSON.stringify(formToObject(form))});
        alert(result.message);
        form.reset();
        qs('#id_pelanggan').value = '';
        load();
    });

    rows.addEventListener('click', async (event) => {
        const edit = event.target.dataset.edit;
        const del = event.target.dataset.delete;
        if (edit) {
            const row = JSON.parse(edit);
            Object.keys(row).forEach(key => {
                const input = qs(`#${key}`);
                if (input) input.value = row[key] ?? '';
            });
        }
        if (del && confirm('Hapus pelanggan ini?')) {
            const result = await api('api/pelanggan.php', {method: 'POST', body: JSON.stringify({action: 'delete', id_pelanggan: del})});
            alert(result.message);
            load();
        }
    });

    qs('#resetPelanggan').addEventListener('click', () => {
        form.reset();
        qs('#id_pelanggan').value = '';
    });
    search.addEventListener('input', () => {
        page = 1;
        load();
    });
    load();
}

function initTagihan() {
    const form = qs('#tagihanForm');
    const rows = qs('#tagihanRows');
    const pager = qs('#tagihanPager');
    const search = qs('#searchTagihan');
    let page = 1;

    function setAdm() {
        const selected = qs('#id_pelanggan_select').selectedOptions[0];
        const kategori = selected?.dataset.kategori || 'RT';
        qs('#adm').value = kategori === 'ID' ? 20000 : kategori === 'IP' ? 15000 : 10000;
        calculate();
    }

    function calculate() {
        const pemakaian = Math.max(0, Number(qs('#mbi').value || 0) - Number(qs('#mbl').value || 0));
        const tagihan = (pemakaian * Number(qs('#hpka').value || 0)) + Number(qs('#adm').value || 0);
        qs('#pemakaian').value = pemakaian;
        qs('#tagihan').value = tagihan;
    }

    async function load() {
        const result = await api(`api/tagihan.php?page=${page}&search=${encodeURIComponent(search.value)}`);
        rows.innerHTML = result.data.map(row => `
            <tr>
                <td>${row.periode.substring(0, 7)}</td>
                <td>${row.no_rek}</td>
                <td>${row.nama}</td>
                <td>${row.pemakaian} m3</td>
                <td>${rupiah(row.tagihan)}</td>
                <td class="table-actions">
                    <a class="mini-link" target="_blank" href="print/rekening.php?id=${row.id_tagihan}">Cetak</a>
                    <button type="button" data-edit='${JSON.stringify(row)}'>Edit</button>
                    <button type="button" class="danger" data-delete="${row.id_tagihan}">Hapus</button>
                </td>
            </tr>
        `).join('');
        renderPager(pager, result.page, result.pages, next => {
            page = next;
            load();
        });
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        calculate();
        const result = await api('api/tagihan.php', {method: 'POST', body: JSON.stringify(formToObject(form))});
        alert(result.message);
        form.reset();
        qs('#id_tagihan').value = '';
        qs('#periode').value = '2025-05';
        load();
    });

    rows.addEventListener('click', async (event) => {
        const edit = event.target.dataset.edit;
        const del = event.target.dataset.delete;
        if (edit) {
            const row = JSON.parse(edit);
            qs('#id_tagihan').value = row.id_tagihan;
            qs('#id_pelanggan_select').value = row.id_pelanggan;
            qs('#periode').value = row.periode.substring(0, 7);
            ['tgl_tagih', 'hpka', 'adm', 'mbl', 'mbi', 'pemakaian', 'tagihan'].forEach(key => qs(`#${key}`).value = row[key]);
        }
        if (del && confirm('Hapus tagihan ini?')) {
            const result = await api('api/tagihan.php', {method: 'POST', body: JSON.stringify({action: 'delete', id_tagihan: del})});
            alert(result.message);
            load();
        }
    });

    ['id_pelanggan_select', 'hpka', 'mbl', 'mbi'].forEach(id => qs(`#${id}`).addEventListener('input', setAdm));
    qs('#resetTagihan').addEventListener('click', () => {
        form.reset();
        qs('#id_tagihan').value = '';
        qs('#periode').value = '2025-05';
    });
    search.addEventListener('input', () => {
        page = 1;
        load();
    });
    setAdm();
    load();
}

function initChart() {
    const chart = qs('#incomeChart');
    if (!chart) return;
    const data = JSON.parse(chart.dataset.chart || '[]');
    const max = Math.max(...data.map(item => Number(item.total)), 1);
    chart.innerHTML = data.map(item => `
        <div class="bar" style="height:${Math.max(10, Number(item.total) / max * 220)}px">
            <span>${rupiah(item.total)}</span>
            <small>${item.bulan}</small>
        </div>
    `).join('');
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.pageModule === 'pelanggan') initPelanggan();
    if (window.pageModule === 'tagihan') initTagihan();
    initChart();
});
