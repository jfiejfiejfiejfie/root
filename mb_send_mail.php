<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");

$to = "fki2166220@stu.o-hara.ac.jp"; // 送信先のアドレス
$subject = "テスト送信"; // 件名
$message = "ただいまメールのテスト中です。"; // 本文
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
>>>>>>> root/master
