<?php
function write_logs($action) {
    $fileName = "../logs/actions.log"; // Файл для логов
    $fieldsSeparator = "\t";

    // Определяем данные для записи в лог
    $date = date("d/m/y H:i:s");
    $fileAccessed = $_SERVER['PHP_SELF'];
    $sessionId = session_id();
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "[-]";
    $userRole = isset($_SESSION['role']) ? $_SESSION['role'] : "[-]";
    $logLine = "$date$fieldsSeparator$fileAccessed$fieldsSeparator$sessionId$fieldsSeparator$userId$fieldsSeparator$userRole$fieldsSeparator$action\n";

    // Если файл не существует, создаем его и записываем заголовок
    if (!file_exists($fileName)) {
        file_put_contents($fileName, "Date\tFile\tSession ID\tUser ID\tRole\tAction\n", FILE_APPEND);
    }

    // Записываем данные в файл
    file_put_contents($fileName, $logLine, FILE_APPEND);
}
?>
