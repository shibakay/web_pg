<?php

session_start();

if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
    // セッションをリセット
    unset($_SESSION['user']);
    
    // データベース接続
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

    try {       
        // プリペアドステートメントを使用してクエリ実行
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        
        $params = [
            ':username' => $username,
            ':password' => $password
        ];
        
        $sql = $pdo->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
        $sql->execute($params);
               
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            // 認証成功
            $_SESSION['users'] = [
              


                'user_id' => $row['user_id'],
                'username' => $row['username'],
                'password' => $row['password'],
                'email' => $row['email'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
                
            ];
            echo 'おかえりなさい、', $_SESSION['users']['username'], 'さん。';
        } else {
            // ログイン失敗
            echo 'ログイン名またはパスワードが違います。';
        }
    } catch (PDOException $e) {
        // エラーハンドリング
        echo 'データベースエラー: ' . $e->getMessage();
    }
} else {
    // ユーザーからのログイン情報が提供されなかった場合のエラーメッセージ
    echo 'ログイン名とパスワードを提供してください。';
}
// echo '<br>';
// foreach ($_SERVER as $key => $value) {
//     if (strpos($key, 'HTTP_') === 0) {
//         echo "$key: $value<br>";
//     }
// }

?>