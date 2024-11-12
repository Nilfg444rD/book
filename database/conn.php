<?php 

$servername = "localhost";
$username = "root";
$password = "123";
$db = "book_db";

try {

    $conn = new PDO("mysql:host=$servername;port=3306;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo ""; 
} catch (PDOException $e) {
    echo "Failed" . $e->getMessage();
}

?>