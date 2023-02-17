<?php
session_start();
require_once("db_connect.php");
mb_language("Japanese");
mb_internal_encoding("UTF-8");
// $id=$_SESSION["id"];
// $sql = "SELECT * FROM users where id = $id";
// $stm = $pdo->prepare($sql);
// $stm->execute();
// $result = $stm->fetchAll(PDO::FETCH_ASSOC);
// foreach($result as $row){
// 	$name=$row["name"];
// }
$to = $_POST["email"];
$http_host = $_SERVER['HTTP_HOST'];
// $to = "fki2166301@stu.o-hara.ac.jp"; // 送信先のアドレス
$subject = "メール認証の件"; // 件名
$message = "メール認証をするには以下のURLに接続してください。
		http://" . $http_host . "/root/auth?email=$to
		関係のない場合は削除してください。"; // 本文
$additional_headers = ""; // ヘッダーオプション

if (mb_send_mail($to, $subject, $message, $additional_headers)) {
	print "メールを送信しました。";
} else {
	print "メール送信に失敗しました。";
}
?>