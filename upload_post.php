<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// データベース接続情報
$host = 'localhost';
$dbname = 'board';
$username = 'root';
$password = '';

// データベース接続
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    echo "データベース接続失敗: " . $e->getMessage();
    exit;
}

// データベースへの投稿処理
$title = isset($_POST['title']) ? $_POST['title'] : null;
$content = isset($_POST['content']) ? $_POST['content'] : '';

if (empty($content)) {
    header('Location: create_post.php');
    exit;
}

$sql = 'INSERT INTO posts (title, content) VALUES (:title, :content)';
$stmt = $pdo->prepare($sql);
$stmt->execute([':title' => $title, ':content' => $content]);

// 最新の投稿IDを取得
$postId = $pdo->lastInsertId();

// ファイルアップロード処理
if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['image']['tmp_name'];
    $name = basename($_FILES['image']['name']);
    $uploadPath = "uploads/" . $name;
    move_uploaded_file($tmp_name, $uploadPath);

    // データベースへの画像投稿処理
    $sql = 'INSERT INTO images (post_id, image_path) VALUES (:post_id, :image_path)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':post_id' => $postId, ':image_path' => $uploadPath]);
}

// 投稿後のリダイレクト
header('Location: index.php');
exit;
?>
