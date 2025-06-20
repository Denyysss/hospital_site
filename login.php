<?php
session_start();
if (isset($_SESSION['user_id']) || isset($_SESSION['doctor_id'])) {
    header('Location: profile.php');
    exit();
}
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email && $password) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            header("Location: profile.php");
            exit();
        } else {
            $error = 'Невірний email або пароль.';
        }
    } else {
        $error = 'Будь ласка, заповніть всі поля.';
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Вхід - Медичний центр "Здоров'я+"</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="login.css" />
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-logo">
            <i class="fas fa-user-md"></i>
            <h1>Здоров'я+</h1>
        </div>

        <h2 class="auth-title">Вхід до системи</h2>
        <p class="auth-subtitle">Увійдіть до свого особистого кабінету</p>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required />
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" id="remember" name="remember" />
                    Запам'ятати мене
                </label>
            </div>

            <button type="submit" class="btn-auth">
                <i class="fas fa-sign-in-alt"></i> Увійти
            </button>
        </form>

        <div class="auth-links">
            <p>Немає акаунту? <a href="register.php">Зареєструватися</a></p>
            <p><a href="#">Забули пароль?</a></p>
        </div>

        <div class="divider">
            <span>або</span>
        </div>
        
        <a href="index.php" class="btn-secondary" style="margin-bottom: 10px;">
            <i class="fas fa-home"></i> Повернутися на головну
        </a>

        <a href="doctor_login.php" class="btn-secondary">
            <i class="fas fa-home"></i> Я доктор
        </a>
    </div>
</div>
</body>
</html>
