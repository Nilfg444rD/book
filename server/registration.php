<?php
session_start();
include('../database/conn.php');
extract($_POST);

// Проверка, есть ли пользователь с таким email
$stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$result = $stmt->fetchAll();

if ($result) {
    echo "<script>
    alert('A user with this email has already signed up!'); 
    window.location.href = 'http://localhost/book/pages/registration.html';
    </script>";
} else {
    // Сохраняем данные в сессии
    $_SESSION["username"] = $username;

    // Хешируем пароль
    $hashedPassword = hash("sha256", $pass);

    // Подготовка запроса для добавления нового пользователя с ролью "пользователь" по умолчанию
    $stmt = $conn->prepare("
        INSERT INTO user (id, username, email, password, role)
        VALUES (NULL, :username, :email, :hashedPassword, :role)
    ");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':hashedPassword', $hashedPassword);

    // Устанавливаем роль "пользователь" по умолчанию
    $role = 'пользователь';
    $stmt->bindParam(':role', $role);

    $stmt->execute();

    // Устанавливаем переменные сессии после регистрации
    $_SESSION['user_id'] = $conn->lastInsertId();
    $_SESSION['role'] = $role;

    echo "<script>
    alert('Sign up Success!'); 
    window.location.href = 'http://localhost/book/server/books.php';
    </script>";
}
?>
