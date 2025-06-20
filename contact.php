<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Контакти - Клініка</title>
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
          <li><a href="services.php">Послуги</a></li>
          <li><a href="doctors.php">Лікарі</a></li>
          <li><a href="about.php">Про нас</a></li>
          <li><a href="contact.php" class="active">Контакти</a></li>
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
    <h2 class="section-title">Контакти</h2>
    <section class="contact">
      <form class="contact-form" action="#" method="POST">
        <label for="name">Ім'я</label>
        <input type="text" id="name" name="name" placeholder="Ваше ім'я" required />

        <label for="email">Електронна пошта</label>
        <input type="email" id="email" name="email" placeholder="example@email.com" required />

        <label for="phone">Телефон</label>
        <input type="tel" id="phone" name="phone" placeholder="+380 00 000 00 00" />

        <label for="message">Повідомлення</label>
        <textarea id="message" name="message" rows="5" placeholder="Ваше повідомлення..." required></textarea>

        <button type="submit" class="btn-submit">Надіслати</button>
      </form>

      <div class="contact-info">
        <h3>Наші контакти</h3>
        <p>Адреса: вул. Здоров'я, 10, Київ, Україна</p>
        <p>Телефон: +380 44 123 45 67</p>
        <p>Email: info@clinic.com.ua</p>
        <p>Графік роботи: Пн-Пт 9:00 - 18:00, Сб 10:00 - 14:00</p>
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