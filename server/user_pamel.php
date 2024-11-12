<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'пользователь') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель пользователя</title>
</head>
<body>
    <h1>Добро пожаловать в панель пользователя</h1>
    <p>Здесь доступен функционал для обычных пользователей.</p>
    <a href="logout.php">Выйти</a>
</body>
</html>
