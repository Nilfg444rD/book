<?php
// Подключение к базе данных через conn.php
include 'conn.php';

try {
    // Правильное имя таблицы - user
    $sql = "SELECT * FROM user";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Получение результатов и их отображение
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        // Вывод данных в HTML-таблицу
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Role</th>
                </tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['username']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['password']) . "</td>
                    <td>" . htmlspecialchars($row['role']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Таблица user пуста.";
    }
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>
