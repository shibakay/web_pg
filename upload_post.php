<?php
session_start();
if (empty($_SESSION['users'])) {
    header('Location: login-input.php');
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
$userId = $_SESSION['users']['user_id'];

$sql = 'INSERT INTO posts (user_id, title, content) VALUES (:user_id, :title, :content)';
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $userId, ':title' => $title, ':content' => $content]);

// 最新の投稿IDを取得
$postId = $pdo->lastInsertId();

// ファイルアップロード処理
var_dump($_FILES);
if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $tmp_name = $_FILES['image']['tmp_name'];
    $name = basename($_FILES['image']['name']);
    $uploadPath = "upimages/" . $name;
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