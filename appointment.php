<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Дані користувача
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone, birth_date FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Лікарі з бази
$doctors = $conn->query("SELECT id, full_name, specialty FROM doctors")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Онлайн запис до лікаря - Медична клініка</title>
    <link rel="stylesheet" href="appointment.css" />
</head>
<body>
    <div class="floating-elements">
        <div class="floating-circle" style="width: 80px; height: 80px; top: 10%; left: 10%; animation-delay: 0s;"></div>
        <div class="floating-circle" style="width: 120px; height: 120px; top: 20%; right: 10%; animation-delay: 2s;"></div>
        <div class="floating-circle" style="width: 60px; height: 60px; bottom: 20%; left: 20%; animation-delay: 4s;"></div>
        <div class="floating-circle" style="width: 100px; height: 100px; bottom: 10%; right: 20%; animation-delay: 1s;"></div>
    </div>

    <div class="container">
        <div class="header">
            <h1>Онлайн запис до лікаря</h1>
            <p>Оберіть зручний час для візиту в нашу клініку</p>
        </div>

        <div class="form-container">
            <form id="appointmentForm" method="POST" action="process_appointment.php">
                <div class="form-grid">

                    <div class="form-group">
                        <label for="firstName">Ім'я *</label>
                        <input type="text" id="firstName" name="firstName" value="<?= htmlspecialchars($user['first_name']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="lastName">Прізвище *</label>
                        <input type="text" id="lastName" name="lastName" value="<?= htmlspecialchars($user['last_name']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон *</label>
                        <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="birthDate">Дата народження *</label>
                        <input type="date" id="birthDate" name="birthDate" value="<?= htmlspecialchars($user['birth_date']) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="doctor">Лікар *</label>
                        <select id="doctor" name="doctor" required>
                            <option value="">Оберіть лікаря</option>
                            <?php foreach ($doctors as $doc): ?>
                                <option value="<?= $doc['id'] ?>">
                                    <?= htmlspecialchars($doc['full_name']) ?> - <?= htmlspecialchars($doc['specialty']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="appointmentDate">Дата прийому *</label>
                        <input type="date" id="appointmentDate" name="appointmentDate" required>
                    </div>

                    <div class="form-group">
                        <label>Час прийому *</label>
                        <div class="time-slots" id="timeSlots">
                            <?php
                            $times = ['09:00','09:30','10:00','10:30','11:00','11:30','14:00','14:30','15:00','15:30','16:00','16:30'];
                            foreach ($times as $time) {
                                echo "<div class='time-slot' data-time='$time'>$time</div>";
                            }
                            ?>
                        </div>
                        <input type="hidden" id="appointmentTime" name="appointmentTime" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="symptoms">Опис симптомів або причина візиту</label>
                        <textarea id="symptoms" name="symptoms" placeholder="Опишіть ваші симптоми або причину візиту до лікаря..."></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Записатися на прийом</button>
            </form>
        </div>
    </div>

    <script>
        const timeSlots = document.querySelectorAll('.time-slot');
        const timeInput = document.getElementById('appointmentTime');

        timeSlots.forEach(slot => {
            slot.addEventListener('click', () => {
                timeSlots.forEach(s => s.classList.remove('selected'));
                slot.classList.add('selected');
                timeInput.value = slot.dataset.time;
            });
        });
    </script>
</body>
</html>
