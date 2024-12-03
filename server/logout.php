<?php 
session_start();
include 'log_functions.php'; // Подключаем файл логирования

// Логируем выход пользователя
write_logs("Logged out");

// Уничтожаем сессию
session_unset();
session_destroy();

// Перенаправляем пользователя на страницу входа
header("Location: ../pages/login.html");
exit();
?>
