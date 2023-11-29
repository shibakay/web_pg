<?php
// セッション開始
session_start();

// データベース接続設定
$pdo = new PDO("mysql:host=localhost;dbname=board;charset=utf8", "root", "");

// ユーザー情報の取得
if (isset($_SESSION['users']) && isset($_SESSION['users']['user_id'])) {
    $userId = $_SESSION['users']['user_id']; // セッションからユーザーIDを取得

    // データベースからユーザー情報を取得
    $sql = "SELECT username, email FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ユーザーの投稿履歴の取得
    $sql = "SELECT post_id, title, content, created_at FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // セッションにユーザー情報がない場合の処理
    $user = null;
    $posts = [];
    // ログインページにリダイレクトする
    header('Location: login_input.php');
}

// 以下、HTML部分は変更なし
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php require 'menu.php'; ?>
    <main>
        <section class="profile">
            <h2>プロフィール情報</h2>
            <p>ユーザー名: <?php echo htmlspecialchars($user['username']); ?></p>
            <p>メールアドレス: <?php echo htmlspecialchars($user['email']); ?></p>
        </section>

        <section class="posts">
            <h2>投稿履歴</h2>
            <ul>
                <?php foreach ($posts as $post): ?>
                    <li>
                        <a href="post_detail.php?post_id=<?php echo $post['post_id']; ?>">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </a>
                        <span><?php echo $post['created_at']; ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <!-- いいねした投稿の一覧を表示 -->
        <section class="likes">
            <h2>いいねした投稿</h2>
            <ul>
                <li>
                    <a href="post_detail.php?post_id=1">投稿タイトル</a>
                    <span>2020-01-01 12:00:00</span>
                </li>
                <li>
                    <a href="post_detail.php?post_id=2">投稿タイトル</a>
                    <span>2020-01-01 12:00:00</span>
                </li>
            </ul>
        </section>
    </main>

    <!-- サイドメニューの追加 -->
    <aside class="sidebar">
        <ul class="menu">
            <li><a href="profile_edit.php">プロフィール変更</a></li>
            <li><a href="password_change.php">パスワード変更</a></li>
            <li><a href="logout.php">ログアウト</a></li>
        </ul>
    </aside>
</body>
</html>
