<?php
// /pages/produk.php

$page_title = "Manajemen Produk";
require_once '../includes/header.php'; // Header akan menjalankan require_login() dan auth.php

// Koneksi sudah di-include dari header.php -> auth.php -> db.php
// $koneksi sudah tersedia

// Ambil semua produk beserta nama kategorinya
$sql = "SELECT p.id_produk, p.kode_produk, p.nama_produk, k.nama_kategori, p.harga_jual, p.stok, p.satuan
        FROM produk p
        JOIN kategori k ON p.id_kategori = k.id_kategori
        ORDER BY p.nama_produk ASC";
$query = mysqli_query($koneksi, $sql);

// Periksa apakah query berhasil
if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi)); // Tampilkan error jika query gagal
}

?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $page_title; ?></h1>
        <a href="produk_form.php" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                </svg>
            </span>
            <span class="text">Tambah Produk Baru</span>
        </a>
    </div>

    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash_message_type']; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['flash_message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash_message']); unset($_SESSION['flash_message_type']); ?>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTableProduk" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($query) > 0): ?>
                            <?php $nomor = 1; ?>
                            <?php while($produk = mysqli_fetch_assoc($query)): ?>
                            <tr>
                                <td><?php echo $nomor++; ?></td>
                                <td><?php echo htmlspecialchars($produk['kode_produk'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($produk['nama_produk']); ?></td>
                                <td><?php echo htmlspecialchars($produk['nama_kategori']); ?></td>
                                <td class="text-end"><?php echo "Rp " . number_format($produk['harga_jual'], 0, ',', '.'); ?></td>
                                <td class="text-center"><?php echo htmlspecialchars($produk['stok']); ?></td>
                                <td><?php echo htmlspecialchars($produk['satuan']); ?></td>
                                <td>
                                    <a href="produk_form.php?id=<?php echo $produk['id_produk']; ?>" class="btn btn-sm btn-warning mb-1" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                          <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                          <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg> Edit
                                    </a>
                                   
                                    <a href="#" onclick="konfirmasiHapusProduk(<?php echo $produk['id_produk']; ?>, '<?php echo htmlspecialchars(addslashes($produk['nama_produk'])); ?>')" class="btn btn-sm btn-danger mb-1" title="Hapus">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                          <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg> Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data produk.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Fungsi konfirmasi hapus yang dimodifikasi untuk menggunakan POST
function konfirmasiHapusProduk(idProduk, namaProduk) {
    if (confirm(`Apakah Anda yakin ingin menghapus produk "${namaProduk}"? Tindakan ini tidak dapat dibatalkan.`)) {
        // Buat form dinamis untuk mengirim data via POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../modules/produk/proses_produk.php'; // Arahkan ke skrip proses

        // Input untuk aksi
        const inputAksi = document.createElement('input');
        inputAksi.type = 'hidden';
        inputAksi.name = 'aksi';
        inputAksi.value = 'hapus';
        form.appendChild(inputAksi);

        // Input untuk ID produk
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'id_produk';
        inputId.value = idProduk;
        form.appendChild(inputId);

        // Input untuk CSRF token
        const inputCsrf = document.createElement('input');
        inputCsrf.type = 'hidden';
        inputCsrf.name = 'csrf_token';
        // Pastikan fungsi generate_csrf_token() tersedia dan tokennya valid saat halaman ini dimuat
        // Fungsi ini berasal dari auth.php yang di-include oleh header.php
        inputCsrf.value = '<?php echo htmlspecialchars(function_exists("generate_csrf_token") ? generate_csrf_token() : ""); ?>'; 
        form.appendChild(inputCsrf);

        // Tambahkan form ke body dan submit, lalu hapus form
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
}
</script>

<?php
require_once '../includes/footer.php';
?>