<?php
header("Content-type: text/html; charset=utf-8");
 
setcookie('name', '', time() - 1800);
 
echo "<p>クッキーを削除しました。</p>";
 
echo "<p><a href='cookie2.php'>前の画面へ</a></p>";
echo "<p><a href='cookie1.php'>はじめの画面へa</a></p>";
 
?>