<?php

session_start();
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : ['name' => '', 'email' => '', 'message' => ''];

unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма обратной связи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #3b3d50 0%, #8a9ad7 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-container .form-label {
            font-weight: 600;
            color: #333;
        }
        .form-container .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 18px;
        }
        .form-container .btn {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            background-color: #667eea;
            border: none;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="form-container">
        <h2>Свяжитесь с нами</h2>

        <!-- Вывод ошибок -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="form.php">
            <div class="mb-4 position-relative">
                <label for="name" class="form-label">Ваше имя</label>
                <i class="fas fa-user input-icon"></i>
                <input type="text" class="form-control" id="name" name="name" placeholder="Введите ваше имя" value="<?= htmlspecialchars($form_data['name']) ?>" required>
            </div>
            <div class="mb-4 position-relative">
                <label for="email" class="form-label">Ваш email</label>
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" class="form-control" id="email" name="email" placeholder="Введите ваш email" value="<?= htmlspecialchars($form_data['email']) ?>" required>
            </div>
            <div class="mb-4 position-relative">
                <label for="message" class="form-label">Ваше сообщение</label>
                <i class="fas fa-comment input-icon"></i>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Введите ваше сообщение" required><?= htmlspecialchars($form_data['message']) ?></textarea>
            </div>
            <button type="submit" class="btn">Отправить сообщение</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
