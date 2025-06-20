<?php
require_once 'db.php';
session_start();

$result = $conn->query("
  SELECT full_name, specialty, description, image_filename 
  FROM doctors
");
$doctors = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Наші лікарі - Клініка</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <script src="main.js" defer></script>
</head>
<body>
  <header class="header">
    <div class="container header-content">
      <div class="logo">
        <img src="images/logo.png" alt="Логотип клініки" />
        <h1>Клініка Здоров'я</h1>
      </div>
      <nav class="nav">
        <ul>
          <li><a href="index.php">Головна</a></li>
          <li><a href="services.php">Послуги</a></li>
          <li><a href="doctors.php" class="active profile-btn">Лікарі</a></li>
          <li><a href="about.php">Про нас</a></li>
          <li><a href="contact.php">Контакти</a></li>
          <li><a href="profile.php">Кабінет</a></li>
        </ul>
        <div class="burger" onclick="toggleMenu()">
          <span></span><span></span><span></span>
        </div>
      </nav>
    </div>
  </header>

 <main class="container" style="margin-top:100px">
  <h2 class="section-title">Наші лікарі</h2>
  <div class="doctors-slider">
    <?php if (!empty($doctors)): ?>
      <?php foreach ($doctors as $doc): ?>
        <div class="doctor-card">
          <img src="images/<?= htmlspecialchars($doc['image_filename']) ?>"
               alt="<?= htmlspecialchars($doc['full_name']) ?>" />
          <h3><?= htmlspecialchars($doc['full_name']) ?></h3>
          <p class="specialty"><?= htmlspecialchars($doc['specialty']) ?></p>
          <p class="experience"><?= nl2br(htmlspecialchars($doc['description'])) ?></p>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>На жаль, наразі інформація про лікарів недоступна.</p>
    <?php endif; ?>
  </div>
</main>


  <footer class="footer">
    <div class="container footer-content">
      <div class="footer-section">
        <h3>Про нас</h3>
        <p>Сучасна клініка з турботою про кожного.</p>
      </div>
      <div class="footer-section">
        <h3>Контакти</h3>
        <ul>
          <li>+38 (050) 123 45 67</li>
          <li>вул. Здоров’я, 1</li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Соцмережі</h3>
        <div class="social-links">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2025 Клініка+. Усі права захищено.
    </div>
  </footer>
  <button class="scroll-top" onclick="scrollToTop()">↑</button>
</body>
</html>
