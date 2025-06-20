<?php
session_start();
if (!isset($_SESSION['user_id']) && !isset($_SESSION['doctor_id'])) {
    header('Location: login.php');
    exit();
}
require_once 'db.php';

// Визначаємо, чи це лікар чи пацієнт
$isDoctor = isset($_SESSION['doctor_id']);
$isUser   = isset($_SESSION['user_id']);

if (!$isDoctor && !$isUser) {
    header("Location: index.php");
    exit();
}

// Якщо лікар, дістаємо його дані з БД (включно з фото)
if ($isDoctor) {
    $doctorId = $_SESSION['doctor_id'];
    $stmt = $conn->prepare("SELECT full_name, image_filename FROM doctors WHERE id = ?");
    $stmt->bind_param("i", $doctorId);
    $stmt->execute();
    $doctorData = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Особистий кабінет</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="profile.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="container header-content">
      <div class="logo">
        <img src="images/logo.png" alt="Логотип клініки">
        <h1>Здоров'я</h1>
      </div>
      <nav class="nav">
        <ul>
          <li><a href="index.php">Головна</a></li>
          <li><a href="index.php#services">Послуги</a></li>
          <li><a href="index.php#about">Про нас</a></li>
          <li><a href="index.php#contact">Контакти</a></li>
          <li><a href="#" class="active">Кабінет</a></li>
        </ul>
      </nav>
      <div class="burger" onclick="toggleMenu()">
        <span></span><span></span><span></span>
      </div>
    </div>
  </header>

  <!-- Profile Section -->
  <section class="profile-section">
    <div class="container profile-content">
      <h2>Особистий кабінет</h2>

      <div class="profile-box">

        <?php if ($isUser): ?>
          <?php
          // Профіль пацієнта
          $user_id = $_SESSION['user_id'];
          $stmt = $conn->prepare("SELECT first_name, last_name, email, phone FROM users WHERE id = ?");
          $stmt->bind_param("i", $user_id);
          $stmt->execute();
          $user = $stmt->get_result()->fetch_assoc();
          $stmt->close();

          // Записи пацієнта
          $q = $conn->prepare(
            "SELECT a.appointment_date, a.appointment_time, d.full_name AS doctor_name, d.specialty
             FROM appointments a
             JOIN doctors d ON a.doctor_id = d.id
             WHERE a.email = ?
             ORDER BY a.appointment_date DESC, a.appointment_time DESC"
          );
          $q->bind_param("s", $user['email']);
          $q->execute();
          $appointments = $q->get_result();
          $q->close();
          ?>
          <div class="profile-info">
            <img src="images/user-avatar.png" alt="Аватар" class="avatar">
            <h3>Пацієнт: <span><?= htmlspecialchars($user['first_name'].' '.$user['last_name']) ?></span></h3>
            <p>Email: <span><?= htmlspecialchars($user['email']) ?></span></p>
            <p>Телефон: <span><?= htmlspecialchars($user['phone']) ?></span></p>
            <a href="logout.php" class="btn btn-secondary">Вийти</a>
          </div>

          <div class="appointments">
            <h3>Мої записи до лікаря</h3>
            <?php if ($appointments->num_rows > 0): ?>
              <table class="appointment-table">
                <thead>
                  <tr>
                    <th>Дата</th>
                    <th>Час</th>
                    <th>Лікар</th>
                    <th>Спеціальність</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($r = $appointments->fetch_assoc()): ?>
                    <tr>
                      <td><?= htmlspecialchars($r['appointment_date']) ?></td>
                      <td><?= htmlspecialchars(substr($r['appointment_time'],0,5)) ?></td>
                      <td><?= htmlspecialchars($r['doctor_name']) ?></td>
                      <td><?= htmlspecialchars($r['specialty']) ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p>Записів не знайдено.</p>
            <?php endif; ?>
            <a href="appointment.php" class="btn btn-primary">Записатися</a>
          </div>

        <?php elseif ($isDoctor): ?>
          <?php
          // Дашборд лікаря
          $stmt = $conn->prepare(
            "SELECT a.first_name, a.last_name, a.phone, a.email AS patient_email,
                    a.appointment_date, a.appointment_time, a.symptoms
             FROM appointments a
             WHERE a.doctor_id = ?
             ORDER BY a.appointment_date DESC, a.appointment_time DESC"
          );
          $stmt->bind_param("i", $doctorId);
          $stmt->execute();
          $appointments = $stmt->get_result();
          $stmt->close();
          ?>
          <div class="profile-info">
            <img src="images/<?= htmlspecialchars($doctorData['image_filename']) ?>" alt="<?= htmlspecialchars($doctorData['full_name']) ?>" class="avatar doctor-avatar">
            <h3>Лікар: <span><?= htmlspecialchars($doctorData['full_name']) ?></span></h3>
            <a href="doctor_logout.php" class="btn btn-secondary">Вийти</a>
          </div>

          <div class="appointments">
            <h3>Ваші пацієнти</h3>
            <?php if ($appointments->num_rows > 0): ?>
              <table class="appointment-table">
                <thead>
                  <tr>
                    <th>Пацієнт</th>
                    <th>Контакти</th>
                    <th>Дата/Час</th>
                    <th>Симптоми</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($r = $appointments->fetch_assoc()): ?>
                    <tr>
                      <td><?= htmlspecialchars($r['first_name'].' '.$r['last_name']) ?></td>
                      <td><?= htmlspecialchars($r['phone'].' / '.$r['patient_email']) ?></td>
                      <td><?= htmlspecialchars($r['appointment_date'].' '.$r['appointment_time']) ?></td>
                      <td><?= nl2br(htmlspecialchars($r['symptoms'] ?: '-')) ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            <?php else: ?>
              <p>Записів пацієнтів не знайдено.</p>
            <?php endif; ?>
          </div>

        <?php endif; ?>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container footer-content">
      <div class="footer-section">
        <h3>Клініка \"Здоров'я\"</h3>
        <p>Якісна медична допомога для кожного.</p>
        <div class="social-links">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-telegram"></i></a>
        </div>
      </div>
      <div class="footer-section">
        <h3>Навігація</h3>
        <ul>
          <li><a href="index.php">Головна</a></li>
          <li><a href="index.php#services">Послуги</a></li>
          <li><a href="index.php#about">Про нас</a></li>
          <li><a href="index.php#contact">Контакти</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2025 Клініка "Здоров'я". Всі права захищені.
    </div>
  </footer>

  <script>
    function toggleMenu() {
      document.querySelector('.nav ul').classList.toggle('active');
    }
  </script>

</body>
</html>