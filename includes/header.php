<?php
// /includes/header.php

// Sertakan auth.php untuk memulai sesi dan fungsi autentikasi
// auth.php akan mengurus session_start() dan include db.php
require_once 'auth.php'; // auth.php ada di folder yang sama (/includes/)

// Semua halaman yang menggunakan header ini diasumsikan memerlukan login
// Kita bisa membuat pengecualian jika ada halaman publik yang tetap pakai layout ini
require_login('../pages/login.php'); // Jika tidak login, redirect ke login.php

// Ambil nama_toko untuk judul atau keperluan lain
$nama_toko_default = 'Sistem POS';
$nama_toko = $nama_toko_default;
if (isset($koneksi)) { // $koneksi berasal dari db.php yang di-include oleh auth.php
    $query_pengaturan = mysqli_query($koneksi, "SELECT nama_toko FROM pengaturan_toko LIMIT 1");
    if ($row_pengaturan = mysqli_fetch_assoc($query_pengaturan)) {
        $nama_toko = htmlspecialchars($row_pengaturan['nama_toko']);
    }
}

// Judul halaman dinamis, bisa di-set di setiap file /pages/ sebelum include header.php
$page_title = isset($page_title) ? htmlspecialchars($page_title) . " - " . $nama_toko : $nama_toko;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    </head>
<body>

<div class="d-flex">
    <?php include_once 'sidebar.php'; // Memasukkan sidebar ?>
    
    <div id="content-wrapper" class="flex-grow-1 p-4 bg-light">
        <div class="container-fluid">