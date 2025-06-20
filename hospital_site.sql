-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Час створення: Чрв 19 2025 р., 22:13
-- Версія сервера: 5.7.24
-- Версія PHP: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `hospital_site`
--

-- --------------------------------------------------------

--
-- Структура таблиці `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `symptoms` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп даних таблиці `appointments`
--

INSERT INTO `appointments` (`id`, `first_name`, `last_name`, `phone`, `email`, `birth_date`, `doctor_id`, `appointment_date`, `appointment_time`, `symptoms`, `created_at`) VALUES
(4, 'Ivan', 'Forkaliuk', '+380689417318', 'diorg99@gmail.com', '2025-06-19', 9, '2025-06-21', '09:00:00', '', '2025-06-19 22:08:41'),
(5, 'Ivan', 'Forkaliuk', '+380689417318', 'diorg99@gmail.com', '2025-06-19', 7, '2025-05-31', '09:00:00', '', '2025-06-19 22:10:07');

-- --------------------------------------------------------

--
-- Структура таблиці `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `description` text,
  `image_filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп даних таблиці `doctors`
--

INSERT INTO `doctors` (`id`, `full_name`, `specialty`, `description`, `image_filename`) VALUES
(6, 'Др. Олена Іваненко', 'Кардіолог', '15 років досвіду. Спеціалізується на діагностиці та лікуванні серцево-судинних захворювань. Проводить сучасні методи діагностики, включно з УЗД серця та стрес-тестами. Активно бере участь у наукових конференціях.', 'doctor11.jpg'),
(7, 'Др. Андрій Петренко', 'Хірург', '20 років досвіду в загальній та пластичній хірургії. Виконує складні операції з мінімальним втручанням, швидке відновлення пацієнтів. Відзначений нагородами за професіоналізм.', 'doctor22.jpg'),
(8, 'Др. Наталія Коваль', 'Педіатр', '12 років досвіду. Любить дітей і має індивідуальний підхід до кожної дитини. Спеціалізується на вакцинації та лікуванні інфекційних захворювань. Проводить консультації для батьків.', 'doctor33.jpg'),
(9, 'Др. Сергій Бондар', 'Терапевт', '10 років досвіду у профілактиці та лікуванні захворювань внутрішніх органів. Надає комплексний підхід та розробляє індивідуальні плани лікування.', 'doctor44.jpg'),
(10, 'Др. Ірина Мельник', 'Дерматолог', '13 років досвіду у лікуванні шкірних захворювань, алергій та косметології. Використовує сучасні методи лікування та омолодження шкіри.', 'doctor55.jpg'),
(11, 'Др. Віктор Кравчук', 'Невролог', '17 років досвіду. Лікує захворювання центральної та периферичної нервової системи. Застосовує сучасні методи діагностики, реабілітації після інсультів.', 'doctor66.jpg'),
(12, 'Др. Катерина Савченко', 'Гінеколог', '14 років досвіду. Спеціаліст із ведення вагітності, лікування жіночих захворювань. Проводить ультразвукові обстеження та планування сім’ї.', 'doctor77.jpg'),
(13, 'Др. Максим Федоренко', 'Офтальмолог', '11 років досвіду. Проводить діагностику і лікування очних захворювань, корекцію зору. Застосовує лазерні технології в офтальмології.', 'doctor88.jpg'),
(14, 'Др. Людмила Гончар', 'Ендокринолог', '16 років досвіду у діагностиці та лікуванні гормональних розладів, цукрового діабету. Застосовує сучасні методи лікування та контролю стану пацієнтів.', 'doctor99.jpg');

-- --------------------------------------------------------

--
-- Структура таблиці `doctor_users`
--

CREATE TABLE `doctor_users` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп даних таблиці `doctor_users`
--

INSERT INTO `doctor_users` (`id`, `doctor_id`, `email`, `password_hash`, `created_at`) VALUES
(1, 6, 'ivanenko@clinic.ua', '$2y$10$hOvamCgiYFAGxwfqUsiDju.QMgKkmJP09D79msKJA49dwjJOXpmuu', '2025-06-19 21:38:28'),
(2, 7, 'petrenko@clinic.ua', '$2y$10$hOvamCgiYFAGxwfqUsiDju.QMgKkmJP09D79msKJA49dwjJOXpmuu', '2025-06-19 21:38:28'),
(3, 8, 'koval@clinic.ua', '$2y$10$hOvamCgiYFAGxwfqUsiDju.QMgKkmJP09D79msKJA49dwjJOXpmuu', '2025-06-19 21:38:28'),
(4, 9, 'bondar@clinic.ua', '$2y$10$hOvamCgiYFAGxwfqUsiDju.QMgKkmJP09D79msKJA49dwjJOXpmuu', '2025-06-19 21:38:28'),
(5, 10, 'melnyk@clinic.ua', '$2y$10$hOvamCgiYFAGxwfqUsiDju.QMgKkmJP09D79msKJA49dwjJOXpmuu', '2025-06-19 21:38:28'),
(6, 11, 'kravchuk@clinic.ua', '$2y$10$hOvamCgiYFAGxwfqUsiDju.QMgKkmJP09D79msKJA49dwjJOXpmuu', '2025-06-19 21:38:28'),
(7, 12, 'savchenko@clinic.ua', '$2y$10$hOvamCgiYFAGxwfqUsiDju.QMgKkmJP09D79msKJA49dwjJOXpmuu', '2025-06-19 21:38:28'),
(8, 13, 'fedorenko@clinic.ua', '$2y$10$hOvamCgiYFAGxwfqUsiDju.QMgKkmJP09D79msKJA49dwjJOXpmuu', '2025-06-19 21:38:28'),
(9, 14, 'honchar@clinic.ua', '$2y$10$hOvamCgiYFAGxwfqUsiDju.QMgKkmJP09D79msKJA49dwjJOXpmuu', '2025-06-19 21:38:28');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `birth_date`, `gender`, `password_hash`, `created_at`) VALUES
(4, 'Марія', 'Коваленко', 'maria@example.com', '+380507654321', '2025-06-04', 'female', '1234', '2025-06-15 17:32:00'),
(5, 'Дмитро', 'Лайтер', 'dimalayter756@gmail.com', '+380932860342', '2027-06-04', 'male', '$2y$10$PvlT5BlrojVJQAnckXcZ/OwNH1zb2gmWgWBGjzrLXUyR7HvWvCBhi', '2025-06-16 17:26:50'),
(8, 'Андрій', 'Гонга', 'gonga756@gmail.com', '+380123456789', '2025-06-06', 'male', '$2y$10$gGMZ0qS2oDIJLgcgan93TeMkReJhldbj0UPtJ473gzmYM/1HVKGsq', '2025-06-16 17:38:06'),
(9, 'Денис', 'Шелепало', 'artemslapak340@gmail.com', '+380962174851', '2025-06-20', 'male', '$2y$10$qWWnGdZFoHahx9WZ6knOaO/1QKwHI5KN878BJSYeuNu/JmCDWNM9q', '2025-06-16 17:42:12'),
(10, 'Темур', 'Тихівський', '01-24-039.stud@vntu.vn.ua', '+380932176798', '2025-06-06', 'male', '$2y$10$jn77Cf9zUfor4A7Q0XQB6ur9b..J40NciK3p2vsX9Y4p.e8OXDbJ.', '2025-06-16 17:43:25'),
(12, 'Ivan', 'Forkaliuk', 'diorg99@gmail.com', '+380689417318', '2025-06-19', 'male', '$2y$10$MtyQtMvZD986WEyyK5sO8uZUp.NqcFZy5XbQtVWDN.DN3xJ2NlWXy', '2025-06-19 20:03:37');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Індекси таблиці `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `doctor_users`
--
ALTER TABLE `doctor_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_doctor_email` (`email`),
  ADD KEY `fk_doctor` (`doctor_id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблиці `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблиці `doctor_users`
--
ALTER TABLE `doctor_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `doctor_users`
--
ALTER TABLE `doctor_users`
  ADD CONSTRAINT `fk_doctor_users_doctors` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
