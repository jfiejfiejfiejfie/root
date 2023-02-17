<?php
if (isset($_GET["reservation"])) {
  $id = $_GET["id"];
  $sql = "SELECT list.item as list_name,list.id as id,users.id as user_id,users.email as email  FROM list,users WHERE list.id=$id && list.user_id=users.id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $list_name = $row["list_name"];
    $user_id = $row["user_id"];
    $email = $row["email"];
  }
  $my_id = $_SESSION["id"];
  $sql = "SELECT *FROM users WHERE id=$my_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $user_name = $row["name"];
  }
  $count = 0;
  $memo = "予約";
  $myURL = "detail.php?id=" . $id;
  $errors = [];
  require_once('error.php');
  try {
    $sql = "SELECT * FROM reservation_list WHERE user_id=$my_id and list_id=$id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $count += 1;
    }
  } catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }
  if ($count > 0) {
    $sql = "DELETE FROM reservation_list WHERE list_id=:list_id and user_id=:user_id";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':list_id', $id, PDO::PARAM_STR);
    $stm->bindValue(':user_id', $my_id, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  } else {
    date_default_timezone_set('Asia/Tokyo');
    $created_at = date("Y/m/d H:i:s");
    $sql = "INSERT INTO reservation_list (list_id,user_id,created_at) VALUES(:list_id,:user_id,:created_at)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':list_id', $id, PDO::PARAM_STR);
    $stm->bindValue(':user_id', $my_id, PDO::PARAM_STR);
    $stm->bindValue(':created_at', $created_at, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    mb_language("Japanese");
    mb_internal_encoding("UTF-8");
    $to = $email;
    $http_host = $_SERVER['HTTP_HOST'];
    // $to = "fki2166301@stu.o-hara.ac.jp"; // 送信先のアドレス
    $subject = "予約の件"; // 件名
    $message = $user_name . "さんが「" . $list_name . "」を予約しました。
		http://" . $http_host . "/root/reservation_auth?id=$id
		関係のない場合は削除してください。"; // 本文
    $additional_headers = ""; // ヘッダーオプション

    if (mb_send_mail($to, $subject, $message, $additional_headers)) {
      $text = "メールを送信しました。";
    } else {
      $text = "メール送信に失敗しました。";
    }
  }
  header('Location:detail?id=' . $id);
}