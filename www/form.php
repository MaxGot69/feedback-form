<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Подключение к базе данных
require_once('config.php');

$name = '';
$email = '';
$message = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Проверка на ошибки
    if (empty($name)) {
        $errors[] = 'Пожалуйста, укажите ваше имя';
    }
    if (empty($email)) {
        $errors[] = 'Пожалуйста, укажите вашу почту';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Почта указана некорректно';
    }
    if (empty($message)) {
        $errors[] = 'А где ваше сообщение? Пожалуйста, напишите ваше сообщение';
    }

    // Если нет ошибок, вставляем данные в базу
    if (empty($errors)) {
        $insert = "INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connect, $insert);

        if ($stmt === false) {
            die('Ошибка подготовки запроса: ' . mysqli_error($connect));
        }

        mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $message);

        if (mysqli_stmt_execute($stmt)) {
            echo 'Форма успешно отправлена!<br>';
        } else {
            echo 'Ошибка при отправке данных!<br>';
        }

        mysqli_stmt_close($stmt);

        // Отправка сообщения в Telegram
        $token = "YOUR_BOT_TOKEN";
        $chat_id = "YOUR_CHAT_ID";
        $txt = "Новое сообщение с сайта:\n";
        $txt .= "Имя: $name\n";
        $txt .= "Email: $email\n";
        $txt .= "Сообщение: $message";

        $url = "https://api.telegram.org/bot$token/sendMessage";
        $data = [
            'chat_id' => $chat_id,
            'text' => $txt
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            echo "Сообщение отправлено в Telegram.<br>";
        } else {
            echo "Ошибка при отправке сообщения в Telegram.<br>";
        }
    } else {
        // Отправка ошибок в форму
        session_start();
        $_SESSION['errors'] = $errors;
        $_SESSION['form_data'] = ['name' => $name, 'email' => $email, 'message' => $message];
        header('Location: index.php');
        exit();
    }
}

// Закрытие соединения с базой данных
mysqli_close($connect);
?>
