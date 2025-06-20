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
  <title>Клініка "Здоров'я"</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    .appointment-btn {
      background-color: #28a745;
      color: white;
      padding: 8px 14px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      display: inline-block;
      transition: background-color 0.3s;
    }
    .appointment-btn i {
      margin-right: 6px;
    }
    .appointment-btn:hover {
      background-color: #218838;
    }
    .scroll-top {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #007bff;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 50%;
      font-size: 20px;
      display: none;
      cursor: pointer;
      z-index: 999;
    }
    .scroll-top.visible {
      display: block;
    }
  </style>
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
          <li><a href="services.php">Послуги</a></li>
          <li><a href="doctors.php">Лікарі</a></li>
          <li><a href="about.php">Про нас</a></li>
          <li><a href="contact.php">Контакти</a></li>
          <li>
            <a href="appointment.php" class="appointment-btn">
              <i class="fas fa-calendar-check"></i> Записатися онлайн
            </a>
          </li>
          <li><a href="profile.php">Кабінет</a></li>
        </ul>
      </nav>
      <div class="burger" onclick="toggleMenu()">
        <span></span><span></span><span></span>
      </div>
    </div>
  </header>

  <!-- Hero -->
  <section class="hero">
    <div class="container">
      <div class="hero-content">
        <h2>Піклуємося про ваше здоров'я щодня</h2>
        <p>Клініка сучасної медицини з висококваліфікованими лікарями та комфортними умовами лікування.</p>
        <div class="hero-buttons">
          <a href="#contact" class="btn btn-primary">Записатися</a>
          <a href="#services" class="btn btn-secondary">Наші послуги</a>
        </div>
      </div>
      <div class="hero-image">
        <img src="images/hero.jpg" alt="Лікарі клініки">
      </div>
    </div>
  </section>

  <!-- Quick Info -->
  <section class="quick-info">
    <div class="container info-cards">
      <div class="info-card">
        <i class="fas fa-stethoscope"></i>
        <h3>Консультації</h3>
        <p>Професійна допомога та діагностика від досвідчених лікарів.</p>
      </div>
      <div class="info-card">
        <i class="fas fa-clock"></i>
        <h3>Графік</h3>
        <p>Ми працюємо щодня з 8:00 до 20:00 включно у вихідні.</p>
      </div>
      <div class="info-card">
        <i class="fas fa-user-md"></i>
        <h3>Кваліфіковані лікарі</h3>
        <p>У нашій команді тільки сертифіковані та досвідчені фахівці.</p>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section id="services" class="services">
    <div class="container">
      <h2 class="section-title">Наші Послуги</h2>
      <div class="services-grid">
        <div class="service-card">
          <img src="images/service1.jpg" alt="Послуга 1">
          <h3>Терапія</h3>
          <p>Комплексне обстеження та лікування внутрішніх хвороб.</p>
        </div>
        <div class="service-card">
          <img src="images/service2.jpg" alt="Послуга 2">
          <h3>Педіатрія</h3>
          <p>Дбайливий підхід до маленьких пацієнтів.</p>
        </div>
        <div class="service-card">
          <img src="images/service3.jpg" alt="Послуга 3">
          <h3>Лабораторія</h3>
          <p>Швидкі та точні аналізи без черг.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Doctors -->
  <section id="doctors" class="doctors">
    <div class="container">
      <h2 class="section-title">Наші Лікарі</h2>
      <div class="doctors-slider">
        <?php if (!empty($doctors)): ?>
          <?php foreach ($doctors as $doc): ?>
            <div class="doctor-card">
              <img src="images/<?= htmlspecialchars($doc['image_filename']) ?>"
                   alt="<?= htmlspecialchars($doc['full_name']) ?>" />
              <h3><?= htmlspecialchars($doc['full_name']) ?></h3>
              <p class="specialty"><?= htmlspecialchars($doc['specialty']) ?></p>
              <p class="experience">
                <?= nl2br(htmlspecialchars($doc['description'])) ?>
              </p>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>На жаль, наразі інформація про лікарів недоступна.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- About -->
  <section id="about" class="about">
    <div class="container about-content">
      <div class="about-image">
        <img src="images/about.jpg" alt="Про клініку">
      </div>
      <div class="about-text">
        <h2>Про нашу клініку</h2>
        <p>Ми дбаємо про здоров’я кожного пацієнта і надаємо сучасні медичні послуги на найвищому рівні.</p>
        <ul>
          <li>Сертифіковані лікарі</li>
          <li>Сучасне обладнання</li>
          <li>Комфортні умови</li>
          <li>Індивідуальний підхід</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Contact -->
  <section id="contact" class="contact">
    <div class="container contact-content">
      <div class="contact-info">
        <div class="contact-item">
          <i class="fas fa-map-marker-alt"></i>
          <div>
            <h3>Адреса</h3>
            <p>м. Київ, вул. Медицини, 12</p>
          </div>
        </div>
        <div class="contact-item">
          <i class="fas fa-phone"></i>
          <div>
            <h3>Телефон</h3>
            <p>+380 44 123 4567</p>
          </div>
        </div>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <div>
            <h3>Email</h3>
            <p>info@zdorovya.com</p>
          </div>
        </div>
      </div>
      <div class="contact-form">
        <h3>Зв'язатися з нами</h3>
        <form action="#" method="post">
          <input type="text" name="name" placeholder="Ваше ім'я" required>
          <input type="email" name="email" placeholder="Ваш Email" required>
          <textarea name="message" placeholder="Ваше повідомлення" required></textarea>
          <button type="submit" class="btn btn-primary">Надіслати</button>
        </form>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container footer-content">
      <div class="footer-section">
        <h3>Клініка "Здоров'я"</h3>
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
          <li><a href="#">Головна</a></li>
          <li><a href="#services">Послуги</a></li>
          <li><a href="#about">Про нас</a></li>
          <li><a href="#contact">Контакти</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; 2025 Клініка "Здоров'я". Всі права захищені.
    </div>
  </footer>

  <!-- Scroll Top -->
  <button class="scroll-top" onclick="scrollToTop()">↑</button>

  <script>
    function toggleMenu() {
      document.querySelector('.nav ul').classList.toggle('active');
    }

    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    window.addEventListener('scroll', () => {
      const scrollBtn = document.querySelector('.scroll-top');
      if (scrollBtn) {
        scrollBtn.classList.toggle('visible', window.scrollY > 300);
      }
    });
  </script>

</body>
</html>
