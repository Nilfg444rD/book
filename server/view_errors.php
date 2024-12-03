<?php
session_start();

// Проверяем, что пользователь аутентифицирован и имеет роль администратора
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'администратор') {
    die("Доступ запрещен. Только администраторы могут просматривать ошибки.");
}

$errorFile = "../logs/error.log"; // Путь к файлу ошибок

if (file_exists($errorFile)) {
    $errors = file_get_contents($errorFile); // Читаем содержимое файла
} else {
    $errors = "Файл ошибок отсутствует.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр ошибок</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Журнал ошибок</h1>
        <pre class="border p-3 bg-light"><?php echo htmlspecialchars($errors); ?></pre>
        <a href="admin.php" class="btn btn-primary mt-3">Назад</a>
    </div>
</body>
</html>
