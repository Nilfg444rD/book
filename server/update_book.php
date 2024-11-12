<?php
error_reporting(E_ALL ^ E_NOTICE); //specify All errors and warnings are displayed

// connect to MySQL DB
require_once __DIR__ . '/../database/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $bookID = $_POST['tbl_book_id'];
    $bookTitle = $_POST['book_title'];
    $bookCategory = $_POST['book_category'];
    $bookAuthor = $_POST['book_author'];

    // Update the book information in the database
    $stmt = $conn->prepare("
        UPDATE book 
        SET title = ?, category = ?, author = ? 
        WHERE id = ?");
    $stmt->execute([$bookTitle, $bookCategory, $bookAuthor, $bookID]);

    // Handle image upload if a new image is provided
    if (!empty($_FILES['book_image']['name'])) {
        $targetDir = "../image/";
        $targetFile = $targetDir . basename($_FILES["book_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["book_image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["book_image"]["size"] > 500000) {
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            move_uploaded_file($_FILES["book_image"]["tmp_name"], $targetFile);
            // Update the book image filename in the database
            $stmt = $conn->prepare("UPDATE `tbl_book` SET `book_image` = ? WHERE `tbl_book_id` = ?");
            $stmt->execute([basename($_FILES["book_image"]["name"]), $bookID]);
        }
    }

    // Redirect to the page where you want to display the updated book details
    echo "<script>
        alert('Update Success!'); 
        window.location.href = 'books.php';
        </script>";
    exit();
}
?>
