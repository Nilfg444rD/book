<?php
error_reporting(E_ALL ^ E_NOTICE); //specify All errors and warnings are displayed

session_start();

//connect to MySQL DB
require_once __DIR__ . '/../database/conn.php';

if ($_GET['category_id'] == 0) {
    // get all books from DB
    $stmt = $conn->prepare("
        SELECT b.*, c.name as categoryname 
        FROM book b LEFT JOIN category c ON b.category = c.id 
    ");
} else {
    // get books by category
    $stmt = $conn->prepare("
        SELECT b.*, c.name as categoryname  
        FROM book b LEFT JOIN category c ON b.category = c.id 
        WHERE category = :category_id
    ");
    $stmt->bindParam(':category_id', $_GET['category_id']);
}

$stmt->execute();
$result = $stmt->fetchAll();

if (count($result) == 0) {
    echo '<h5 class="text-center mt-5">No books found.</h5>';
    return;
}

$html = '';

foreach($result as $row) {
    $bookID = $row['id'];
    $bookImage = $row['image'];
    $bookTitle = $row['title'];
    $bookCategoryID = $row['category'];
    $bookCategoryName = $row['categoryname'];
    $bookAuthor = $row['author'];

    $html .= '
    <div class="card card-list mb-2" style="width:15rem;height:23rem;" data-category="'.$bookCategoryID.'">
        <div class="btn-view">
            <button onclick="delete_book('.$bookID.')" type="button" class="btn btn-sm btn-light mr-2 mt-2" title="Delete"><i class="fa-solid fa-trash"></i></button>
            <button onclick="update_book('.$bookID.')" type="button" class="btn btn-sm btn-light mt-2" title="Update"><i class="fa-solid fa-pencil"></i></button>
            <button onclick="view_details('.$bookID.')" type="button" class="btn btn-sm btn-light mt-2" title="View"><i class="fa-solid fa-list"></i></button>
        </div>

        <h6 id="bookID-'.$bookID.'" hidden>'.$bookID.'</h6>
        <h6 id="bookAuthor-'.$bookID.'" hidden>'.$bookAuthor.'</h6>
        <div class="d-flex justify-content-center align-items-center" style="height: 280px;">
            <img id="bookImage-'.$bookID.'" src="../image/'.$bookImage.'" class="card-img-top mt-2" alt="book" style="max-width: 150px; max-height: 200px;">
        </div>
        <div class="card-body">
            <h6 id="bookTitle-'.$bookID.'" class="card-title">'.$bookTitle.'</h6>
            <i class="text-muted">Category: </i><i id="bookCategory-'.$bookID.'" class="card-subtitle text-muted" data-category="'.$bookCategoryID.'">'.$bookCategoryName.'</i><br>
            <i class="text-muted">Author: </i><i id="bookAuthor-'.$bookAuthor.'" class="card-subtitle text-muted">'.$bookAuthor.'</i><br>
        </div>
    </div>
';
}

echo $html;

?>
