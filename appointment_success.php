<?php
session_start();
$message = $_SESSION['appointment_message'] ?? 'Невідома помилка.';
unset($_SESSION['appointment_message']);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Результат запису</title>
    <link rel="stylesheet" href="appointment_success.css" />
</head>
<body>
    <div class="container" style="text-align: center; padding: 50px;">
        <h1><?= htmlspecialchars($message) ?></h1>
        <a href="index.php" class="btn btn-primary" style="margin-top: 20px;">Повернутися на головну</a>
    </div>
</body>
</html>
