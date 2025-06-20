<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: appointment.php");
    exit();
}

// Збираємо дані з форми
$firstName       = trim($_POST['firstName']       ?? '');
$lastName        = trim($_POST['lastName']        ?? '');
$phone           = trim($_POST['phone']           ?? '');
$email           = trim($_POST['email']           ?? '');
$birthDate       = trim($_POST['birthDate']       ?? '');
$doctorId        = (int) ($_POST['doctor']         ?? 0);
$appointmentDate = trim($_POST['appointmentDate'] ?? '');
$appointmentTime = trim($_POST['appointmentTime'] ?? '');
$symptoms        = trim($_POST['symptoms']        ?? '');

// DEBUG-логування (за бажанням)
// error_log("APPT DEBUG: firstName={$firstName}, lastName={$lastName}, phone={$phone}, email={$email}, birthDate={$birthDate}, doctorId={$doctorId}, appointmentDate={$appointmentDate}, appointmentTime={$appointmentTime}, symptoms={$symptoms}");

// Валідація формату дати прийому
$dateObj = DateTime::createFromFormat('Y-m-d', $appointmentDate);
if (!$dateObj || $dateObj->format('Y-m-d') !== $appointmentDate) {
    $_SESSION['appointment_message'] = "❌ Невірний формат дати прийому.";
    header("Location: appointment_success.php");
    exit();
}

// Підготовка запиту
$stmt = $conn->prepare("
    INSERT INTO appointments 
      (first_name, last_name, phone, email, birth_date, doctor_id, appointment_date, appointment_time, symptoms)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");

// Правильна маска типів: 5×s, 1×i, 3×s
$stmt->bind_param(
    "sssssisss",
    $firstName,       // s — first_name
    $lastName,        // s — last_name
    $phone,           // s — phone
    $email,           // s — email (може бути пустим рядком)
    $birthDate,       // s — birth_date
    $doctorId,        // i — doctor_id
    $appointmentDate, // s — appointment_date
    $appointmentTime, // s — appointment_time
    $symptoms         // s — symptoms (може бути пустим рядком)
);

// Виконання запиту
if ($stmt->execute()) {
    $_SESSION['appointment_message'] = "✅ Ваш запис успішно зареєстровано!";
} else {
    // Запис помилки в лог для відлагодження
    error_log("APPT ERROR: " . $stmt->error);
    $_SESSION['appointment_message'] = "❌ Помилка під час запису. Спробуйте пізніше.";
}

$stmt->close();

// Переадресація на сторінку успіху/невдачі
header("Location: appointment_success.php");
exit();
?>
