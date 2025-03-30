<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('config.php');

// Старт сессии ТОЛЬКО если она не начата
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $errors = [];

    // Валидация
    if (empty($name)) $errors[] = 'Укажите имя';
    if (empty($email)) $errors[] = 'Укажите email';
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Некорректный email';
    if (empty($message)) $errors[] = 'Напишите сообщение';

    if (empty($errors)) {
        $sql = "INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connect, $sql);
        
        if (!$stmt) {
            $_SESSION['errors'] = ['Ошибка БД: ' . mysqli_error($connect)];
            header('Location: index.php');
            exit;
        }

        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $message);
        
        if (mysqli_stmt_execute($stmt)) {
            // Передаем данные в bot.php через переменные
            $telegram_data = [
                'name' => $name,
                'email' => $email,
                'message' => $message
            ];
            require_once('bot.php');
            $_SESSION['success'] = 'Сообщение отправлено!';
        } else {
            $_SESSION['errors'] = ['Ошибка БД: ' . mysqli_error($connect)];
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['errors'] = $errors;
    }

    $_SESSION['form_data'] = compact('name', 'email', 'message');
    header('Location: index.php');
    exit;
}

mysqli_close($connect);
?>