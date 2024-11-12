<?php
error_reporting(E_ALL ^ E_NOTICE); //specify All errors and warnings are displayed

//connect to MySQL DB
require_once __DIR__ . '/../database/conn.php';

if (isset($_GET['delete'])) {
    $bookID = $_GET['delete'];

    // Retrieve the book image filename
    $stmt = $conn->prepare("SELECT image FROM book WHERE id = ?");
    $stmt->execute([$bookID]);
    $row = $stmt->fetch();

    $bookImage = $row['image'];

    // Delete the book from the database
    $stmt = $conn->prepare("DELETE FROM book WHERE id = ?");
    $stmt->execute([$bookID]);

    // Delete the associated image file
    if (!empty($bookImage)) {
        $imagePath = "../image/" . $bookImage;

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Redirect to the page where you want to display the updated book list
    header("Location: books.php");
    exit();
}
?>
