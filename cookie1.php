<?php
header("Content-type: text/html; charset=utf-8");
 
$yourname = "ウェブの葉";
setcookie("name", $yourname , time()+10);
 
echo "<p>". $yourname. "さんでクッキーを保存しました。<p>";
 
<<<<<<< HEAD
echo "<p><a href='cookie2.php'>確認画面へgsgsa</a></p>";
=======
echo "<p><a href='cookie2.php'>確認画面へ</a></p>";
>>>>>>> root/master
 
?>