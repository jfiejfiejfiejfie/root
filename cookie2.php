<?php
header("Content-type: text/html; charset=utf-8");
 
if(isset($_COOKIE["name"])){
	echo "<p>".$_COOKIE["name"]."さんのページです</p>" ;
	
	echo "<p>10秒後にクッキーは削除されます。10秒後に画面をリロードしてみて下さい。</p>";
	echo "<p><a href='cookie3.php'>クッキー削除画面へ</a></p>";
}else{
	echo "<p>クッキーは削除されています。</p>";
	echo "<p><a href='cookie1.php'>はじめの画面へ</a></p>";
}
 
?>