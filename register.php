<?php
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $birthDate = $_POST['birthDate'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $termsAccepted = isset($_POST['terms']);

    if (!$firstName || !$lastName || !$email || !$phone || !$birthDate || !$gender || !$password || !$confirmPassword) {
        $error = 'Будь ласка, заповніть усі поля.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Некоректний email.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Паролі не співпадають.';
    } elseif (!$termsAccepted) {
        $error = 'Ви повинні погодитися з умовами.';
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'Користувач з таким email вже існує.';
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, birth_date, gender, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert->bind_param("sssssss", $firstName, $lastName, $email, $phone, $birthDate, $gender, $passwordHash);

            if ($insert->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error = 'Помилка при збереженні. Спробуйте пізніше.';
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація - Медичний центр "Здоров'я+"</title>
    <link rel="stylesheet" href="register.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-logo">
            <i class="fas fa-user-plus"></i>
            <h1>Здоров'я+</h1>
        </div>

        <h2 class="auth-title">Реєстрація</h2>
        <p class="auth-subtitle">Створіть особистий кабінет для зручного запису</p>

        <div id="error-message" class="error-message">
            <?php if ($error): ?><?= htmlspecialchars($error) ?><?php endif; ?>
        </div>
        <div id="success-message" class="success-message">
            <?php if ($success): ?><?= htmlspecialchars($success) ?><?php endif; ?>
        </div>

        <form id="registerForm" method="POST" action="register.php">
            <div class="form-row">
                <div class="form-group">
                    <label for="firstName">Ім'я</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Прізвище</label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Телефон</label>
                <input type="tel" id="phone" name="phone" placeholder="+380123456789" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="birthDate">Дата народження</label>
                    <input type="date" id="birthDate" name="birthDate" required>
                </div>
                <div class="form-group">
                    <label for="gender">Стать</label>
                    <select id="gender" name="gender" required>
                        <option value="">Оберіть стать</option>
                        <option value="male">Чоловіча</option>
                        <option value="female">Жіноча</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
                <div id="passwordStrength" class="password-strength"></div>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Підтвердження пароля</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>

            <div class="terms-checkbox">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">
                    Я погоджуюся з <a href="#" target="_blank">умовами використання</a> 
                    та <a href="#" target="_blank">політикою конфіденційності</a>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-auth">
                <i class="fas fa-user-plus"></i> Зареєструватися
            </button>
        </form>

        <div class="auth-links">
            <p>Вже маєте акаунт? <a href="login.php">Увійти</a></p>
        </div>

        <div class="divider">
            <span>або</span>
        </div>

        <a href="index.php" class="btn btn-secondary btn-auth">
            <i class="fas fa-home"></i> Повернутися на головну
        </a>
    </div>
</div>

<script>
    document.getElementById('password').addEventListener('input', function () {
        const password = this.value;
        const strengthDiv = document.getElementById('passwordStrength');

        if (password.length < 6) {
            strengthDiv.textContent = 'Пароль занадто короткий';
            strengthDiv.className = 'password-strength strength-weak';
        } else if (password.length < 8) {
            strengthDiv.textContent = 'Слабкий пароль';
            strengthDiv.className = 'password-strength strength-weak';
        } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(password)) {
            strengthDiv.textContent = 'Середній пароль';
            strengthDiv.className = 'password-strength strength-medium';
        } else {
            strengthDiv.textContent = 'Сильний пароль';
            strengthDiv.className = 'password-strength strength-strong';
        }
    });
</script>
</body>
</html>
