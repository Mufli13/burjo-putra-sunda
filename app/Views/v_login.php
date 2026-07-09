<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Putra Sunda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --war-red: #ED1C24;
            --war-yellow: #FFD700;
            --war-green: #00A651;
        }

        body {
            background: linear-gradient(135deg, var(--war-red) 0%, #b31217 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            position: relative;
            overflow: hidden;
        }

        /* GELOMBANG */
        .bg-wave-yellow {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 260px;
            background: var(--war-yellow);
            clip-path: polygon(0% 50%, 25% 45%, 50% 55%, 75% 40%, 100% 55%, 100% 100%, 0% 100%);
            opacity: 0.8;
            z-index: -2;
        }

        .bg-wave-green {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 200px;
            background: var(--war-green);
            clip-path: polygon(0% 40%, 20% 38%, 45% 55%, 70% 60%, 85% 50%, 100% 45%, 100% 100%, 0% 100%);
            z-index: -1;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            border-top: 10px solid var(--war-yellow);
            position: relative;
            z-index: 10;
        }

        .login-header {
            padding: 30px 20px 10px;
            text-align: center;
        }

        .login-header h2 {
            color: var(--war-red);
            font-weight: 900;
            letter-spacing: 1px;
            margin: 0;
        }

        .login-header p {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .card-body {
            padding: 20px 30px 30px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #eee;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--war-green);
            box-shadow: none;
        }

        .btn-login {
            background: var(--war-green);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: bold;
            width: 100%;
            font-size: 1.1rem;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #008541;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,166,81,0.3);
            color: white;
        }

        .badge-warmindo {
            background: var(--war-yellow);
            color: var(--war-red);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
        }

        .forgot-link {
            text-align: right;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        .forgot-link a {
            color: #888;
            font-size: 0.8rem;
            text-decoration: none;
        }

        .forgot-link a:hover { color: var(--war-red); }

        .back-to-web {
            text-align: center;
            margin-top: 20px;
        }

        .back-to-web a {
            color: var(--war-red);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="bg-wave-yellow"></div>
    <div class="bg-wave-green"></div>

    <div class="login-card shadow">
        <div class="login-header">
            <div class="badge-warmindo text-uppercase">Management System</div>
            <h2>PUTRA SUNDA</h2>
            <p>Silakan masuk ke panel kasir</p>
        </div>

        <div class="card-body">
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success border-0 small py-2 mb-3">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger border-0 small py-2 mb-3">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/verify') ?>" method="post">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                
                <div class="forgot-link">
                    <a href="<?= base_url('auth/lupa-password') ?>">Lupa password?</a>
                </div>

                <button type="submit" class="btn btn-login shadow-sm">MASUK SEKARANG</button>
            </form>

            <div class="back-to-web">
                <a href="<?= base_url('/') ?>">← Kembali ke Halaman Menu</a>
            </div>
        </div>
    </div>

</body>
</html>