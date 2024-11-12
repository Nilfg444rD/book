<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'менеджер') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель менеджера</title>
</head>
<body>
    <h1>Добро пожаловать в панель менеджера</h1>
    <p>Здесь доступен функционал для менеджеров.</p>
    <a href="logout.php">Выйти</a>
</body>
</html>
