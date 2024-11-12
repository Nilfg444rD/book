<?php
session_start();
include('../database/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = hash("sha256", $_POST['pass']);

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

        // Проверяем роль пользователя и перенаправляем в зависимости от неё
        if ($user['role'] === 'администратор') {
            header("Location: ../server/admin.php"); // Перенаправляем на admin.php для администраторов
        } elseif ($user['role'] === 'менеджер') {
            header("Location: ../server/manager_books.php"); // Перенаправляем на manager_books.php для менеджеров
        } else {
            header("Location: ../server/books.php"); // Перенаправляем на books.php для обычных пользователей
        }
        exit();
    } else {
        echo "Неверные учетные данные!";
    }
}
