<?php
// Параметры подключения к MySQL в Docker
$servername = 'db';  // Имя сервиса из docker-compose.yml
$username = 'root';
$password = 'newpassword';  // Пароль из docker-compose.yml
$dbname = 'form_back';      // База данных из docker-compose.yml

// Подключение
$connect = mysqli_connect($servername, $username, $password, $dbname);

if (!$connect) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Проверка таблицы (создаём, если её нет)
$check_table = "CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!mysqli_query($connect, $check_table)) {
    die("Ошибка при создании таблицы: " . mysqli_error($connect));
}
?>