<?php require 'menu.php'; ?>
<?php 
session_start(); 
if (isset($_SESSION['customer'])) {
	// 配列の内容をクリアする関数unset
	unset($_SESSION['customer']);
	echo 'ログアウトしました。';
} else {
	echo 'すでにログアウトしています。';
}
var_dump($_SESSION);
?>

