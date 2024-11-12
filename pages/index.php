<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: login.html'); // Перенаправление на страницу входа, если пользователь не вошел в систему
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

include('../database/conn.php');

// Запрос на получение всех книг
$stmt = $conn->prepare("SELECT title, author FROM book");
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Book Catalog</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/registration.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../scripts/books.js"></script>

    <style>
        .main-content {
            margin: 48px auto;
            width: 80%;
            padding: 20px;
            background-color: rgb(216, 215, 231);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-5" href="index.php">Book Management System</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="../server/books.php">All Books <span class="sr-only">(current)</span></a>
                </li>
                <?php if ($role === 'менеджер'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../server/manage_categories.php">Редактировать категории</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../server/manager_panel.php">Панель менеджера</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav mt-2 mt-lg-0">
                <li class="nav-item">
                    <span class="navbar-text text-white mr-3"><?php echo htmlspecialchars($username); ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../server/logout.php">Выйти</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main-content">
        <h1>Welcome to Book Management System</h1>

        <!-- Список книг -->
        <h2>Available Books</h2>
        <?php if (count($books) > 0): ?>
            <ul>
                <?php foreach ($books as $book): ?>
                    <li><?php echo htmlspecialchars($book['title']) . ' by ' . htmlspecialchars($book['author']); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No books available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
