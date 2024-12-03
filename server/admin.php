<?php
session_start(); // Инициализация сессии для отслеживания пользователя

// Проверка, что пользователь аутентифицирован и имеет роль администратора
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'администратор') {
    // Если проверка не пройдена, перенаправляем на страницу входа
    header('Location: ../pages/login.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px; /* Расстояние между кнопками */
        }
        .btn-logout {
            margin-top: 20px; /* Отступ сверху для кнопки "Выйти" */
        }
    </style>
</head>
<body>
    <div class="container mt-5 text-center">
        <h1>Добро пожаловать в панель администратора</h1>
        <p>Здесь доступен функционал для администраторов.</p>
        
        <!-- Группа кнопок для "Просмотр логов" и "Просмотр ошибок" -->
        <div class="btn-group">
            <a href="view_logs.php" class="btn btn-dark">Просмотр логов</a>
            <a href="view_errors.php" class="btn btn-danger">Просмотр ошибок</a>
        </div>

        <!-- Кнопка "Выйти" -->
        <a href="logout.php" class="btn btn-secondary btn-logout">Выйти</a>
    </div>
</body>
</html>
