<?php
include 'log_functions.php';
session_start();
if (isset($_POST['action']) && isset($_POST['category_id'])) {
    $categoryId = $_POST['category_id'];
    write_logs("Viewed category ID: " . $categoryId);
}
?>
