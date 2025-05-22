<?php
// /pages/dashboard.php

// Atur judul halaman
$page_title = "Dashboard";

// Sertakan header.php yang akan memeriksa login dan menampilkan layout
require_once '../includes/header.php'; // Path relatif dari /pages/ ke /includes/

// Jika kita sampai di sini, berarti pengguna sudah login.
// auth.php (via header.php) sudah memastikan ini.

// Ambil informasi pengguna dari session (fungsi dari auth.php)
$nama_pengguna = get_current_user_nama();
$peran_pengguna = get_current_user_role();

?>

<div class="row">
    <div class="col-12">
        <h1 class="mb-4">Selamat Datang di Dashboard!</h1>
        <p class="lead">Halo, <strong><?php echo htmlspecialchars($nama_pengguna ?? 'Pengguna'); ?></strong>!</p>
        <p>Peran Anda saat ini adalah: <strong><?php echo htmlspecialchars($peran_pengguna ?? 'Tidak diketahui'); ?></strong>.</p>
        <hr>
        <p>Ini adalah halaman ringkasan sistem Anda. Fitur lebih lanjut akan ditambahkan di sini.</p>
        <div class="row mt-4">
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Produk</h5>
                        <p class="card-text fs-3">150</p> <a href="produk.php" class="text-white stretched-link">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Penjualan Hari Ini</h5>
                        <p class="card-text fs-3">Rp 1.250.000</p> <a href="laporan.php" class="text-white stretched-link">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Transaksi</h5>
                        <p class="card-text fs-3">32</p> <a href="transaksi.php" class="text-white stretched-link">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Sertakan footer.php
require_once '../includes/footer.php';
?>