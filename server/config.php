<?php
// Отображение ошибок для разработчиков (временно)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Обработчик ошибок
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $errorLog = "../logs/error.log"; // Файл для записи ошибок
    $date = date("Y-m-d H:i:s");
    $errorMessage = "$date | Ошибка уровня [$errno]: $errstr в файле $errfile на строке $errline\n";

    // Запись в лог
    file_put_contents($errorLog, $errorMessage, FILE_APPEND);

    // Сообщение пользователю (на продакшене можно сделать более общее)
    echo "<h1>Что-то пошло не так!</h1>";
    echo "<p>Пожалуйста, обратитесь к администратору или попробуйте позже.</p>";
    exit();
}

// Устанавливаем пользовательский обработчик ошибок
set_error_handler("customErrorHandler");
?>
