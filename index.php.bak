<?php
// データベース接続設定
$host = 'localhost';
$dbname = 'board';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("データベース接続失敗: " . $e->getMessage());
}

// 投稿データの取得
try {
    $sql = "SELECT posts.post_id, posts.title, posts.content, posts.created_at, 
                   users.username, 
                   images.image_path, images.thumbnail_path 
            FROM posts
            LEFT JOIN users ON posts.user_id = users.user_id
            LEFT JOIN images ON posts.post_id = images.post_id
            WHERE posts.is_archived = FALSE
            ORDER BY posts.created_at DESC";

    $stmt = $pdo->query($sql);
    $ps = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("投稿データの取得に失敗: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>簡易掲示板</title>
</head>

<body>
    <?php require 'menu.php'; ?>
    <main>
        <div class="post-create">
            <a href="create_post.php">新規投稿</a>
        </div>

        <div class="posts">

            <?php foreach ($ps as $p): ?>
            <div class="post">
                <div class="post-user">
                    投稿者：<?php echo htmlspecialchars($p['username'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <?php if ($p['title']): ?>
                <div class="post-title">
                    タイトル：<?php echo htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <?php endif; ?>
                <div class="post-content">
                    投稿：<?php echo htmlspecialchars($p['content'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <?php if ($p['image_path']): ?>
                <div class="post-image">
                    <img src="<?php echo htmlspecialchars($p['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="投稿画像">
                </div>
                <?php endif; ?>
                <div class="post-date">
                    <?php echo htmlspecialchars($p['created_at'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
                <div class="post-actions">
                    <!-- いいねボタン（いいねの状態によって表示を変える） -->
                    <button class="like-button" onclick="likePost(<?php echo $p['post_id']; ?>)">いいね</button>
                    <span class="likes-count" id="likes-count-<?php echo $p['post_id']; ?>">いいねの数:
                        <?php // いいねの数を表示 ?></span>

                    <!-- JavaScript: いいねの非同期処理 -->
                    <script>
                    function likePost(postId) {
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "like.php", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhr.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                // いいねの数を更新
                                document.getElementById('likes-count-' + postId).textContent = 'いいねの数: ' + this
                                    .responseText;
                            }
                        };
                        xhr.send("post_id=" + postId);
                    }
                    </script>

                    <!-- コメント数の表示 -->
                    <span class="comments-count">コメント数: <?php // コメント数を表示 ?></span>
                </div>

                <!-- コメントエリア（コメントを表示） -->
                <div class="comments">
                    <?php // コメントの表示処理 ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>