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
</head>
<body>
    <h1>Добро пожаловать в панель администратора</h1>
    <p>Здесь доступен функционал для администраторов.</p>
    <a href="logout.php">Выйти</a>
</body>
</html>
