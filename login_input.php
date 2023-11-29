<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <?php require 'menu.php'; ?>

    <!-- ユーザ名をクッキーから取得 -->
    <?php $username = isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>
    
    <!-- ログインフォームのラッパーを追加 -->
    
    <div class="login-form">
        <div class="form-container">
            <form action="login_pdo.php" method="post">
                <div class="form-group">
                    <label for="username">ログイン名</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" id="password">
                </div>
                <input type="submit" value="ログイン" class="btn">
            </form>
        </div>
    </div>
</body>
</html>

