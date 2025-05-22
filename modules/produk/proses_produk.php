<?php
// /modules/produk/proses_produk.php

// Pastikan sesi dimulai untuk menggunakan variabel session (untuk pesan flash, csrf)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Sertakan file koneksi database dan fungsi autentikasi
// Path relatif dari /modules/produk/ ke /includes/
require_once '../../includes/db.php'; 
require_once '../../includes/auth.php'; // Untuk fungsi CSRF dan require_login

// Hanya pengguna yang sudah login yang boleh mengakses proses ini
// Path redirect disesuaikan karena kita ada di dalam /modules/produk/
require_login('../../pages/login.php'); 


// --- Fungsi Bantuan untuk Redirect dengan Flash Message ---
function redirect_with_message($url, $message, $type = 'danger') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_message_type'] = $type;
    header("Location: " . $url);
    exit;
}

function redirect_form_with_error($url, $error_message) {
    $_SESSION['form_error_message'] = $error_message;
    header("Location: " . $url);
    exit;
}


// --- Logika Utama Berdasarkan Metode Request dan Aksi ---

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifikasi CSRF Token umum untuk semua aksi POST
    if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
        redirect_with_message('../../pages/produk.php', 'CSRF token tidak valid atau sesi telah berakhir. Silakan coba lagi.');
    }

    $aksi = $_POST['aksi'] ?? '';
    
    if ($aksi == 'tambah' || $aksi == 'edit') {
        // Proses untuk Tambah atau Edit Produk
        $id_produk = isset($_POST['id_produk']) ? (int)$_POST['id_produk'] : null;

        $kode_produk = trim($_POST['kode_produk'] ?? '');
        $nama_produk = trim($_POST['nama_produk'] ?? '');
        $id_kategori = (int)($_POST['id_kategori'] ?? 0);
        $harga_beli = !empty($_POST['harga_beli']) ? (float)$_POST['harga_beli'] : 0.00;
        $harga_jual = !empty($_POST['harga_jual']) ? (float)$_POST['harga_jual'] : 0.00;
        $stok = !empty($_POST['stok']) ? (int)$_POST['stok'] : 0;
        $satuan = trim($_POST['satuan'] ?? 'Pcs');
        $deskripsi_produk = trim($_POST['deskripsi_produk'] ?? '');

        // --- Validasi Server-Side ---
        $redirect_url_form = "../../pages/produk_form.php" . ($aksi == 'edit' && $id_produk ? "?id=$id_produk" : "");
        if (empty($nama_produk)) {
            redirect_form_with_error($redirect_url_form, "Nama produk tidak boleh kosong.");
        }
        if (empty($id_kategori) || $id_kategori <= 0) {
            redirect_form_with_error($redirect_url_form, "Kategori produk harus dipilih.");
        }
        if ($harga_jual <= 0) {
            redirect_form_with_error($redirect_url_form, "Harga jual harus lebih besar dari 0.");
        }
        if ($stok < 0) {
            redirect_form_with_error($redirect_url_form, "Stok tidak boleh negatif.");
        }
        if (empty($satuan)) {
            redirect_form_with_error($redirect_url_form, "Satuan produk tidak boleh kosong.");
        }

        if (!empty($kode_produk)) {
            $sql_cek_kode = "SELECT id_produk FROM produk WHERE kode_produk = ? AND id_produk != IFNULL(?, 0)";
            $stmt_cek_kode = mysqli_prepare($koneksi, $sql_cek_kode);
            // Untuk tambah, $id_produk adalah null. Untuk edit, $id_produk adalah ID produk yg diedit.
            $id_produk_untuk_cek = ($aksi == 'edit' && $id_produk) ? $id_produk : null;
            mysqli_stmt_bind_param($stmt_cek_kode, "si", $kode_produk, $id_produk_untuk_cek); 
            mysqli_stmt_execute($stmt_cek_kode);
            mysqli_stmt_store_result($stmt_cek_kode);
            if (mysqli_stmt_num_rows($stmt_cek_kode) > 0) {
                mysqli_stmt_close($stmt_cek_kode);
                redirect_form_with_error($redirect_url_form, "Kode produk '$kode_produk' sudah digunakan produk lain.");
            }
            mysqli_stmt_close($stmt_cek_kode);
        }

        if ($aksi == 'tambah') {
            $sql = "INSERT INTO produk (kode_produk, nama_produk, id_kategori, harga_beli, harga_jual, stok, satuan, deskripsi_produk) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, "ssiddiss", 
                $kode_produk, $nama_produk, $id_kategori, $harga_beli, $harga_jual, $stok, $satuan, $deskripsi_produk
            );
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                redirect_with_message('../../pages/produk.php', 'Produk baru berhasil ditambahkan!', 'success');
            } else {
                $error_db = mysqli_error($koneksi);
                mysqli_stmt_close($stmt);
                redirect_form_with_error($redirect_url_form, "Gagal menambahkan produk: " . $error_db);
            }
        } elseif ($aksi == 'edit' && $id_produk) {
            $sql = "UPDATE produk SET kode_produk = ?, nama_produk = ?, id_kategori = ?, harga_beli = ?, harga_jual = ?, 
                    stok = ?, satuan = ?, deskripsi_produk = ?, updated_at = NOW()
                    WHERE id_produk = ?";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, "ssiddissi",
                $kode_produk, $nama_produk, $id_kategori, $harga_beli, $harga_jual, $stok, $satuan, $deskripsi_produk, $id_produk
            );
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                redirect_with_message('../../pages/produk.php', 'Data produk berhasil diperbarui!', 'success');
            } else {
                $error_db = mysqli_error($koneksi);
                mysqli_stmt_close($stmt);
                redirect_form_with_error($redirect_url_form, "Gagal memperbarui produk: " . $error_db);
            }
        } else {
             redirect_with_message('../../pages/produk.php', 'Aksi tidak valid atau ID produk tidak ditemukan untuk diedit.');
        }

    } elseif ($aksi == 'hapus') {
        // --- Proses Hapus Produk (via POST) ---
        // CSRF sudah divalidasi di awal blok POST
        $id_produk_hapus = isset($_POST['id_produk']) ? (int)$_POST['id_produk'] : 0;

        if ($id_produk_hapus > 0) {
            $sql = "DELETE FROM produk WHERE id_produk = ?";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id_produk_hapus);

            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    mysqli_stmt_close($stmt);
                    redirect_with_message('../../pages/produk.php', 'Produk berhasil dihapus!', 'success');
                } else {
                    mysqli_stmt_close($stmt);
                    redirect_with_message('../../pages/produk.php', 'Produk tidak ditemukan atau sudah dihapus.');
                }
            } else {
                $error_db = mysqli_error($koneksi);
                mysqli_stmt_close($stmt);
                if (strpos($error_db, 'foreign key constraint fails') !== false) {
                     redirect_with_message('../../pages/produk.php', "Gagal menghapus produk. Produk ini mungkin sudah digunakan dalam transaksi atau data terkait lainnya.");
                } else {
                     redirect_with_message('../../pages/produk.php', "Gagal menghapus produk: " . $error_db);
                }
            }
        } else {
            redirect_with_message('../../pages/produk.php', 'ID produk tidak valid untuk dihapus.');
        }
    } else {
        redirect_with_message('../../pages/produk.php', 'Aksi POST tidak dikenal.');
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    // Menangani jika ada yang mencoba akses link hapus lama via GET
    redirect_with_message('../../pages/produk.php', 'Metode hapus produk telah diperbarui dan memerlukan POST. Silakan gunakan tombol yang tersedia.');
} else {
    // Metode request tidak didukung atau aksi tidak ada
    redirect_with_message('../../pages/produk.php', 'Permintaan tidak valid.');
}
?>