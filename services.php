<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Наші послуги - Клініка</title>
  <link rel="stylesheet" href="style.css" />
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
          <li><a href="services.php" class="active">Послуги</a></li>
          <li><a href="doctors.php">Лікарі</a></li>
          <li><a href="about.php">Про нас</a></li>
          <li><a href="contact.php">Контакти</a></li>
          <li><a href="profile.php">Кабінет</a></li>
        </ul>
      </nav>
      <div class="burger" aria-label="Відкрити меню" role="button" tabindex="0" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </header>

  <main class="container">
    <h2 class="section-title">Наші послуги</h2>
    <section class="services">
      <div class="services-grid">
        <div class="service-card">
          <img src="images/diagnostics.jpg" alt="Діагностика" />
          <h3>Діагностика</h3>
          <p>Сучасне обладнання для точного виявлення захворювань.</p>
        </div>
        <div class="service-card">
          <img src="images/therapy.jpg" alt="Терапія" />
          <h3>Терапевтичні послуги</h3>
          <p>Комплексне лікування внутрішніх органів і загальне оздоровлення.</p>
        </div>
        <div class="service-card">
          <img src="images/surgery.jpg" alt="Хірургія" />
          <h3>Хірургія</h3>
          <p>Планові та екстрені операції високої складності.</p>
        </div>
        <div class="service-card">
          <img src="images/pediatrics.jpg" alt="Педіатрія" />
          <h3>Педіатрія</h3>
          <p>Дбайливий підхід до здоров’я дітей будь-якого віку.</p>
        </div>
        <div class="service-card">
          <img src="images/laboratory.jpg" alt="Лабораторія" />
          <h3>Лабораторні дослідження</h3>
          <p>Швидкий аналіз крові, сечі, гормонів та інше.</p>
        </div>
        <div class="service-card">
          <img src="images/cardiology.jpg" alt="Кардіологія" />
          <h3>Кардіологія</h3>
          <p>Повне обстеження серцево-судинної системи.</p>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-content">
      <p>&copy; 2025 Клініка Здоров'я. Всі права захищено.</p>
    </div>
  </footer>

  <script>
    function toggleMenu() {
      document.querySelector('.nav ul').classList.toggle('active');
    }
  </script>
</body>
</html>