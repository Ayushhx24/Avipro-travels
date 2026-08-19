<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');     
define('DB_PASSWORD', 'adijsh@1521');      
define('DB_NAME', 'avipro_database');

try {
    $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
        PDO::ATTR_EMULATE_PREPARES   => false,                
    ];

    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
    
} catch (PDOException $e) {
    die("Database Connection ERROR: " . $e->getMessage());
}
?>