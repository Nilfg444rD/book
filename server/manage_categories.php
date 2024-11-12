<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== 'менеджер') {
    header("Location: ../pages/login.html");
    exit();
}

include('../database/conn.php');

// Обработка добавления категории
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        $stmt = $conn->prepare("INSERT INTO category (name) VALUES (:name)");
        $stmt->bindParam(':name', $category_name);
        $stmt->execute();
        header("Location: manage_categories.php"); // Перезагрузка страницы
        exit();
    }
}

// Обработка удаления категории
if (isset($_GET['delete_category_id'])) {
    $category_id = $_GET['delete_category_id'];
    $stmt = $conn->prepare("DELETE FROM category WHERE id = :id");
    $stmt->bindParam(':id', $category_id);
    $stmt->execute();
    header("Location: manage_categories.php"); // Перезагрузка страницы
    exit();
}

// Получение списка категорий
$stmt = $conn->query("SELECT * FROM category");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand ml-5" href="../pages/index.php">Book Management System</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="manager_books.php">Books</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_categories.php">Manage Categories</a>
                </li>
            </ul>
            <ul class="navbar-nav mt-2 mt-lg-0">
                <li class="nav-item">
                    <span class="navbar-text text-white mr-3">Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Manage Categories</h2>
        
        <!-- Форма для добавления новой категории -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="category_name">New Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_category">Add Category</button>
        </form>
        
        <hr>

        <!-- Список существующих категорий с возможностью удаления -->
        <h3>Existing Categories</h3>
        <ul class="list-group">
            <?php foreach ($categories as $category): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($category['name']); ?>
                    <a href="?delete_category_id=<?php echo $category['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
