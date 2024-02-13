<?php

// Достъп до базата данни за базата данни
$db_server = "localhost"; //още известно като host
$db_user = "root";
$db_password = "";
$db_name = "renault_website";


// PDO връзка
$dsn = "mysql:host=$db_server;dbname=$db_name;charset=utf8mb4";
// PDO опции
$db_options = [
    // PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    //създаваме връзката
    $pdo = new PDO($dsn, $db_user, $db_password, $db_options);
} catch (PDOException $e) {
    // проверяваме за грешки
    die("Error: " . $e->getMessage());
}

