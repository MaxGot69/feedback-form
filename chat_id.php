<?php
$url = "https://api.telegram.org/bot7944907885:AAEvKmFsB-axQr4W-yFd_VExTle6gh1t7Qw/getUpdates"; // Получаем обновления

$response = file_get_contents($url);
echo $response; // Выведет ответ, в котором будет chat_id