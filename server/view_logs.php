<?php
session_start();

// Проверяем, авторизован ли пользователь и является ли он администратором
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'администратор') {
    die("Доступ запрещен. Только администраторы могут просматривать логи.");
}

$fileName = "../logs/actions.log"; // Путь к лог-файлу

// Проверяем существование файла логов
if (file_exists($fileName)) {
    $logs = file_get_contents($fileName); // Читаем содержимое лог-файла
} else {
    $logs = "Файл логов отсутствует.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр логов</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Логи действий пользователей</h1>
        <pre class="border p-3 bg-light"><?php echo htmlspecialchars($logs); ?></pre> <!-- Отображаем логи -->
        <a href="admin.php" class="btn btn-primary mt-3">Назад</a>
    </div>
</body>
</html>
