# Sistem POS (Point of Sale) Sederhana

Ini adalah aplikasi Point of Sale (POS) berbasis web yang dibangun secara native menggunakan PHP, JavaScript vanilla, Bootstrap 5, dan MySQL. Aplikasi ini dirancang untuk membantu dalam manajemen penjualan, produk, pengguna, dan laporan transaksi dasar.

## ✨ Kutipan

> *"Aku tidak berilmu; yang berilmu hanyalah DIA. Jika tampak ilmu dariku, itu hanyalah pantulan dari Cahaya-Nya."*

## 🎥 Demo

![Demo](./videoujicoba.gif)

## 🔐 Informasi Login

Berikut adalah akun default yang dapat digunakan untuk mencoba sistem:

**Admin Login**

* Username: `admin`
* Password: `admin123`

**Kasir Login**

* Username: `kasir`
* Password: `kasir123`

## 📌 Fitur Utama

* **Autentikasi Pengguna:** Sistem login dengan peran Admin dan Kasir.
* **Dashboard:** Halaman utama setelah login (tampilan dasar).
* **Manajemen Produk:**

  * CRUD (Create, Read, Update, Delete) untuk produk.
  * Pengelolaan kategori produk (saat ini data kategori diisi manual atau melalui database).
* **Manajemen Transaksi:**

  * Input penjualan dengan pemilihan produk.
  * Perhitungan total belanja dan kembalian secara dinamis.
  * Penyimpanan data transaksi (header dan detail).
  * Pengurangan stok produk otomatis setelah transaksi.
* **Cetak Struk:** Menampilkan struk transaksi dalam format sederhana yang bisa dicetak.
* **Laporan Transaksi:**

  * Menampilkan daftar transaksi.
  * Filter transaksi berdasarkan rentang tanggal.
  * Export data laporan ke format CSV.
* **Manajemen Pengguna (Khusus Admin):**

  * CRUD (Create, Read, Update, Delete) untuk akun pengguna (Admin/Kasir).
* **Pengaturan Toko (Khusus Admin):**

  * Mengubah informasi toko (nama, alamat, kontak, catatan struk).
  * Mengunggah dan menghapus logo toko.
* **Keamanan Dasar:**

  * Proteksi terhadap SQL Injection (menggunakan Prepared Statements).
  * Pencegahan XSS (menggunakan `htmlspecialchars()`).
  * CSRF token pada form-form penting.
  * Hashing password pengguna.
  * Pembatasan akses direktori dan file sensitif menggunakan `.htaccess`.

## ⚙️ Teknologi yang Digunakan

* **Backend:** PHP Native (tanpa framework)
* **Frontend:**

  * HTML5
  * CSS3 (Eksternal dan Bootstrap)
  * JavaScript (Vanilla JS, tanpa framework JS)
  * Bootstrap 5 (versi offline)
* **Database:** MySQL
* **Server Web (Lingkungan Pengembangan):** XAMPP / Laragon (atau sejenisnya yang mendukung Apache dan MySQL)

## 🧠 Credits

Dibuat oleh [@Alghifari888](https://github.com/Alghifari888) sebagai project belajar dan open-source.

---

**Selamat belajar dan semoga bermanfaat!**
✨ Kalau project ini membantu, boleh kasih ⭐ di GitHub ya!

## 📄 License (English)

This project is licensed under the MIT License.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.

---

## 📄 Lisensi (Indonesia)

Proyek ini dilisensikan di bawah Lisensi MIT.

Hak Cipta (c) 2025 Alghifari888

Proyek ini menggunakan Lisensi MIT, yang berarti Anda bebas menggunakan, menyalin, mengubah, dan mendistribusikan perangkat lunak ini, termasuk untuk keperluan komersial, selama menyertakan pemberitahuan hak cipta dan lisensi asli.

Perangkat lunak ini disediakan apa adanya tanpa jaminan apa pun. Pengembang tidak bertanggung jawab atas kerusakan atau masalah yang timbul dari penggunaan perangkat lunak ini.


