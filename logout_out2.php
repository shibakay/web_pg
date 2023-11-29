<?php
// セッション開始
session_start();

// セッション変数を全て解除
$_SESSION = array();

// セッションを破棄
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// index.phpにリダイレクト
header('Location: index.php');
exit();
?>
