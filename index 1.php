<?php require 'menu.php'; ?>

<?php
session_start();

// データベース接続の詳細
$host = 'localhost';
$dbname = 'board';
$username = 'root';
$password = '';

// PDOを使用してデータベースに接続
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベースの接続に失敗しました：" . $e->getMessage());
}

// 投稿データを取得
try {
    $stmt = $pdo->query("SELECT posts.*, users.username FROM posts 
                        JOIN users ON posts.user_id = users.user_id 
                        WHERE posts.is_archived = false 
                        ORDER BY posts.created_at DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("データベースエラー：" . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿一覧</title>
    <style>
        /* 任意のスタイリングを追加 */
        .post {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        .post-image img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<h1>投稿一覧</h1>

<?php foreach ($posts as $post): ?>
    <div class="post">
        <p>投稿者: <?php echo htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p>タイトル: <?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></p>
        <p>投稿内容: <?php echo htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8'); ?></p>

        <?php echo $post['image_path'] ?>
        <?php if (!empty($post['image_path'])): ?>
            <div class="post-image">
                <img src="<?php echo htmlspecialchars($post['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="投稿画像">
            </div>
        <?php endif; ?>

        <p>投稿日付: <?php echo htmlspecialchars($post['created_at'], ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
<?php endforeach; ?>

</body>
</html>
