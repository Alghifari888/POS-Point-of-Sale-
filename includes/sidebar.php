<?php
// /includes/sidebar.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar border-end bg-dark" data-bs-theme="dark" style="width: 280px;"> <div class="p-3">
        <a href="dashboard.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4 fw-semibold">Sistem POS</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link <?php echo ($current_page == 'dashboard.php') ? 'active' : 'text-white'; ?>">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="produk.php" class="nav-link <?php echo ($current_page == 'produk.php') ? 'active' : 'text-white'; ?>">
                    Produk
                </a>
            </li>
            <li>
                <a href="transaksi.php" class="nav-link <?php echo ($current_page == 'transaksi.php') ? 'active' : 'text-white'; ?>">
                    Transaksi
                </a>
            </li>
            <li>
                <a href="laporan.php" class="nav-link <?php echo ($current_page == 'laporan.php') ? 'active' : 'text-white'; ?>">
                    Laporan
                </a>
            </li>
            
            <?php
            // Menu Khusus Admin (Akan diaktifkan setelah proses login berfungsi penuh)
            if (function_exists('get_current_user_role') && get_current_user_role() == 'Admin'):
            ?>
            <li class="nav-item mt-2 pt-2 border-top">
                <span class="nav-link disabled" style="color: #6c757d;"><small>ADMINISTRASI</small></span> </li>
            <li>
                <a href="pengguna.php" class="nav-link <?php echo ($current_page == 'pengguna.php') ? 'active' : 'text-white'; ?>">
                    Pengguna
                </a>
            </li>
            <li>
                <a href="pengaturan.php" class="nav-link <?php echo ($current_page == 'pengaturan.php') ? 'active' : 'text-white'; ?>">
                    Pengaturan Toko
                </a>
            </li>
            <?php endif; ?>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <strong><?php echo htmlspecialchars(function_exists('get_current_user_nama') ? (get_current_user_nama() ?? 'Pengguna') : 'Pengguna'); ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="../logout.php">Logout</a></li> </ul>
        </div>
    </div>
</div>