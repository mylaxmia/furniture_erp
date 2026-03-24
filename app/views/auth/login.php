<?php
// Load language system for login page
session_start();
$lang = [];
$current_lang = $_SESSION['lang'] ?? 'en';
$lang_file = __DIR__ . '/../../../lang/' . $current_lang . '.php';
if (file_exists($lang_file)) {
    require_once $lang_file;
}

function t($key, $default = '') {
    global $lang;
    return $lang[$key] ?? ($default ?: $key);
}
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo t('login', 'Login'); ?> - Universal Team</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }
        .login-container .subtitle {
            text-align: center;
            color: #999;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .btn-login {
            width: 100%;
            padding: 10px;
            font-weight: bold;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
        .register-link a {
            color: #667eea;
            text-decoration: none;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo h1 {
            color: #667eea;
            font-size: 28px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1><i class="fas fa-cubes"></i> Universal Team</h1>
        </div>

        <h2><?php echo t('login', 'Login'); ?></h2>
        <p class="subtitle"><?php echo t('welcome', 'Access your inventory management system'); ?></p>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label"><?php echo t('username', 'Username'); ?></label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label"><?php echo t('password', 'Password'); ?></label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-login"><?php echo t('login', 'Login'); ?></button>
        </form>

        <div class="forgot-link">
            <a href="/furniture_erp/?route=forgot-password"><?php echo t('forgot_password', 'Forgot Password?'); ?></a>
        </div>

        <!-- Demo credentials -->
        <div class="alert alert-info alert-sm mt-3" role="alert" style="font-size: 12px;">
            <strong><?php echo t('demo', 'Demo'); ?>:</strong> master / [secure password]
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
