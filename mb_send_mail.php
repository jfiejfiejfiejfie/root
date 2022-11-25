<?php
<<<<<<< HEAD
session_start();
require_once("db_connect.php");
mb_language("Japanese");
mb_internal_encoding("UTF-8");
$id=$_SESSION["id"];
$sql = "SELECT * FROM users where id = $id";
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row){
	$name=$row["name"];
}
$to=$_GET["email"];
// $to = "fki2166301@stu.o-hara.ac.jp"; // 送信先のアドレス
$subject = "メール認証の件"; // 件名
$message = "$name さんのメール認証をするには以下のURLに接続してください。
		http://172.16.31.28/root/auth.php?id=$id
		もし関係ない場合はスルーしろks"; // 本文
=======
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to = "fki2166220@stu.o-hara.ac.jp"; // 送信先のアドレス
$subject = "テスト送信"; // 件名
$message = "ただいまメールのテスト中です。"; // 本文
>>>>>>> root/master
$additional_headers = ""; // ヘッダーオプション

if(mb_send_mail($to, $subject, $message, $additional_headers))
{
	print "メールを送信しました。";
}
else
{
	print "メール送信に失敗しました。";
}
<<<<<<< HEAD
?>
=======
<<<<<<< HEAD
?>
=======
>>>>>>> root/master
>>>>>>> root/master
