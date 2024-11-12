<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

if(!isset($_SESSION["username"]) || $_SESSION["role"] !== 'менеджер'){
    header("Location: ../pages/login.html");
    exit();
}

include('../database/conn.php');

// Получение списка категорий из таблицы category
$stmt = $conn->prepare("SELECT * FROM category");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Book Catalog</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../scripts/books.js"></script>

    <style>
        .main-panel {
            margin: auto;
            width: 90%;
        }
        .navbar {
            display: flex;
            justify-content: center;
        }
        .navbar-brand {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="">Book Management System</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="manager_books.php">Books <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_categories.php">Панель менеджера</a>
                </li>
            </ul>
            <ul class="navbar-nav mt-2 mt-lg-0">
                <?php
                if(isset($_SESSION['username'])){
                    echo '<li class="nav-item"><a class="nav-link" href="">Welcome '.$_SESSION['username'].'</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>

    <div class="main-panel">
        <div class="container-fluid">
            <div class="row">
                <div class="side-bar col-md-3 mt-5">
                    <h3>Book Categories</h3>
                    <hr>
                    <div class="card border-0">
                        <button onclick="load_books(0)" class="btn btn-outline-secondary category-filter-link active" autofocus="autofocus" data-category="All" id="categoryAll">All Books</button>
                        <?php foreach ($categories as $category): ?>
                            <button onclick="load_books(<?php echo $category['id']; ?>)" class="btn mt-1 btn-outline-secondary category-filter-link" data-category="<?php echo htmlspecialchars($category['name']); ?>" id="category<?php echo $category['id']; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="main-content col-md-8 mt-5">
                    <div class="card card-content">
                        <!-- Здесь отобразятся книги, загруженные через AJAX -->
                        <div class="row book-list">
                            <!-- Load Books from AJAX call here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
