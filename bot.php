<?php
// НИКАКОГО session_start() здесь!
$token = "7944907885:AAEvKmFsB-axQr4W-yFd_VExTle6gh1t7Qw";
$chat_id = "-1002636663462";

// Данные получаем из массива $telegram_data, переданного из form.php
$name = $telegram_data['name'];
$email = $telegram_data['email'];
$message = $telegram_data['message'];

$txt = "Новое сообщение с сайта:\nИмя: $name\nEmail: $email\nСообщение: $message";

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
curl_exec($ch);
curl_close($ch);
?>