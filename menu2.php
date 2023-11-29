<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    nav {
        background-color: #f2f2f2;
        /* 背景色 */
        padding: 10px 0;
        /* 上下のパディング */
        text-align: center;
        /* 中央揃え */
    }

    nav a {
        color: #333333;
        /* リンクの色 */
        text-decoration: none;
        /* 下線を消す */
        padding: 10px 15px;
        /* リンクのパディング */
        margin: 0 10px;
        /* リンク間の余白 */
        display: inline-block;
        /* インラインブロック表示 */
        border-radius: 5px;
        /* 角の丸み */
        transition: background-color 0.3s;
        /* 背景色のトランジション */
    }

    nav a:hover {
        background-color: #ddd;
        /* ホバー時の背景色 */
        color: #000;
        /* ホバー時のテキスト色 */
    }
</style>

</head>

<body>
<nav>
    <a href="index.php">ホーム</a></li>
    <a href="create_post.php">新規投稿</a></li>
    <a href="mypage.php">マイページ</a></li>
    <a href="login.php">ログイン</a></li>
    <a href="logout.php">ログアウト</a></li>
</nav>
</body>

</html>

