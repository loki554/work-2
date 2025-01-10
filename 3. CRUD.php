<?php
// подключение к БД
$dsn = 'mysql:host=localhost;dbname=work_comments;charset=utf8';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Ошибка подключения: ' . $e->getMessage());
}

// если форма была отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = trim($_POST['content'] ?? '');
    if (!empty($content)) {
        // защита от инъекций
        $stmt = $pdo->prepare('INSERT INTO comments (content) VALUES (:content)');
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->execute();
    }
}

// получение списка комментариев
$comments = $pdo->query('SELECT content, created_at FROM comments ORDER BY created_at ASC')->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Комментарии</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .comment { margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .timestamp { font-size: 0.8em; color: #666; }
    </style>
</head>
<body>
    <h1>Комментарии</h1>

    <!-- форма для добавления нового комментария -->
    <form action="" method="post">
        <textarea name="content" rows="4" cols="50" placeholder="Введите ваш комментарий..." required></textarea><br>
        <button type="submit">Добавить комментарий</button>
    </form>
    <h2>Список комментариев</h2>

    <!-- вывод всех комментариев -->
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p><?= htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8') ?></p>
                <div class="timestamp"><?= htmlspecialchars($comment['created_at'], ENT_QUOTES, 'UTF-8') ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Комментарии отсутствуют.</p>
    <?php endif; ?>
</body>
</html>