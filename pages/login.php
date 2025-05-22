<?php
// /pages/login.php

// Pastikan session dimulai di awal, sebelum output apapun
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Sertakan file koneksi database (dibutuhkan untuk proses login nanti)
// dan auth untuk fungsi CSRF
require_once '../includes/db.php'; // Path relatif dari /pages/ ke /includes/
require_once '../includes/auth.php'; // Path relatif dari /pages/ ke /includes/


// Jika pengguna sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php"); // dashboard.php ada di folder yang sama (/pages/)
    exit;
}

$error_message = ''; // Variabel untuk menyimpan pesan error

// Logika proses login akan ditambahkan di Langkah 3
// Untuk sekarang, kita hanya menampilkan form

// Generate CSRF token untuk form login
$csrf_token = generate_csrf_token();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem POS</title>
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 25px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="card login-card shadow-sm">
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Login Sistem POS</h3>
            
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>

            <form action="login_process.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
            </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>