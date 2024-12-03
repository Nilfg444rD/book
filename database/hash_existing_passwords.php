<?php
include('../database/conn.php');

try {
    // Выбираем все записи из таблицы user
    $sql = "SELECT id, password FROM user";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        $id = $user['id'];
        $plainPassword = $user['password'];

        // Хэшируем пароль (например, md5)
        $hashedPassword = md5($plainPassword);

        // Обновляем хэшированный пароль в базе данных
        $updateSql = "UPDATE user SET password = :hashedPassword WHERE id = :id";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':hashedPassword', $hashedPassword);
        $updateStmt->bindParam(':id', $id);
        $updateStmt->execute();
    }
    echo "Пароли успешно хэшированы.";
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>
