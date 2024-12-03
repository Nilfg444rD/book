<?php
session_start();
include('../database/conn.php');
include 'log_functions.php'; // Подключаем файл с функцией логирования

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['pass']); // Используем md5 для хэширования

    // Выполняем запрос для проверки пользователя и его роли
    $sql = "SELECT id, role, username FROM user WHERE email = :email AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        // Логируем успешный вход
        write_logs("Logged in");

        // Перенаправляем пользователя в зависимости от его роли
        if ($user['role'] === 'администратор') {
            header("Location: ../server/admin.php");
        } elseif ($user['role'] === 'менеджер') {
            header("Location: ../server/manager_books.php");
        } else {
            header("Location: ../server/books.php");
        }
        exit();
    } else {
        // Логируем неудачную попытку входа
        write_logs("Log fault");
        echo "Неверные учетные данные!";
    }
}
?>
