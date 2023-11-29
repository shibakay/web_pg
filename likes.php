<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=board;charset=utf8', 'root', '');

if (isset($_SESSION['users']) && is_array($_SESSION['users'])) {
    $user_id = $_SESSION['users']['user_id']; // ログインしているユーザーのID
} else {
    // `users` キーが存在しない、または配列ではない場合のエラーハンドリング
    exit;
}

$post_id = $_POST['post_id'];

// 重複いいねを防止するチェック
$sql = "SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id, 'post_id' => $post_id]);
if ($stmt->rowCount() == 0) {
    // いいねを挿入
    $sql = "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id, 'post_id' => $post_id]);
}

// いいねの数をカウント
$sql = "SELECT COUNT(*) FROM likes WHERE post_id = :post_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['post_id' => $post_id]);
$likes_count = $stmt->fetchColumn();

echo $likes_count;
