<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: ../pages/login.html");
    exit();
}

// Создаем искусственную ошибку
trigger_error("Тестовая ошибка для проверки логирования.");

include('../database/conn.php');
include '../server/log_functions.php'; // Подключаем файл логирования
write_logs("View page: books.php");

// Получение списка категорий для отображения в форме добавления книги
$stmt = $conn->prepare("SELECT * FROM category");
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Получение выбранной категории
$selectedCategory = isset($_GET['category']) ? intval($_GET['category']) : 0;

// Получение списка книг
if ($selectedCategory > 0) {
    $stmt = $conn->prepare("SELECT * FROM book WHERE category = :category");
    $stmt->bindParam(':category', $selectedCategory);
} else {
    $stmt = $conn->prepare("SELECT * FROM book");
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    
    <script src="../scripts/books.js"></script>
    <script>
        function logCategoryView(categoryId, categoryName) {
            $.post('../server/log_view.php', { action: 'View category', category_id: categoryId, category_name: categoryName });
        }
    </script>

    <style>
        .card-content {
            width: 90%;
            height: 100%;
            background-color: #f2f2f2;
        }
        
        .main-panel {
            margin: auto;
            width: 90%;
        }
        .card-list {
            margin: 15px;
        }
        .btn-sm {
            float: middle !important;
            color: blue;
            background-color: #fff;
        }
        .card-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
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
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="">Book Management System</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="books.php">Books <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <ul class="navbar-nav mt-2 mt-lg-0">
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<li class="nav-item"><a class="nav-link" href="">Welcome ' . $_SESSION['username'] . '</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="../pages/login.html">Sign In</a></li>';
                }
                ?>
            </ul>
        </div>
    </nav>

    <div class="main-panel">
        <div class="container-fluid">
            <div class="row">
                <div class="side-bar ml-5 mt-5 col-md-3">
                    <h3>Book Categories</h3><hr>
                    <div class="card border-0">
                        <button onclick="logCategoryView(0, 'All')" class="btn btn-outline-secondary category-filter-link active" autofocus="autofocus" data-category="All" id="categoryAll">All Books</button>
                        <?php foreach ($categories as $category): ?>
                            <button onclick="logCategoryView(<?php echo $category['id']; ?>, '<?php echo htmlspecialchars($category['name']); ?>')" class="btn mt-1 btn-outline-secondary category-filter-link" data-category="<?php echo htmlspecialchars($category['name']); ?>" id="category<?php echo $category['id']; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="main-content ml-5 mt-5 col-md-8">
                    <div class="card card-content">
                        <div class="d-flex justify-content-between mt-3">
                            
                            <!-- Add Book Modal -->
                            <button type="button" class="btn btn-secondary ml-3" data-toggle="modal" data-target="#addBookModal">&#10010; Add Book </button>
                            
                            <!-- Modal Form for Adding Book -->
                            <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBook" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addBook">Add Book Form</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="../server/add_book.php" method="POST" class="add-form" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label for="bookImage">Book Image</label>
                                                    <input type="file" class="form-control-file" id="bookImage" name="book_image" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bookTitle">Book Title</label>
                                                    <input type="text" class="form-control" id="bookTitle" name="book_title" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bookCategory">Category</label>
                                                    <select class="form-control" name="book_category" id="bookCategory" required>
                                                        <option value="">- select -</option>
                                                        <?php foreach ($categories as $category): ?>
                                                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bookAuthor">Book Author(s)</label>
                                                    <input type="text" class="form-control" id="bookAuthor" name="book_author" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-dark">Add Book</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- View and Update Modals (if needed) can be included here -->
                            
                            <form class="form-inline justify-content-end mr-3">
                                <input class="form-control mr-sm-2" id="searchInput" type="search" placeholder="Search" aria-label="Search">
                            </form>
                        </div>
                        <div class="row book-list">
                            <!-- Books will be loaded here using AJAX -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
