<?php
if (isset($_GET["chat"])) {
  $memo = "チャット";
  $sql = "SELECT * FROM list WHERE id=$id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $user_id = $row["user_id"];
  }
  $errors = [];
  require_once('error.php');
  $text = $_POST["text"];
  $user_id = $_SESSION["id"];
  if ($_FILES["image"]["tmp_name"] == "") {
    $imgdat = "";
  } else {
    $upfile = $_FILES["image"]["tmp_name"];
    $imgdat = file_get_contents($upfile);
  }
  $name = $_SESSION["name"];
  date_default_timezone_set('Asia/Tokyo');
  $date = date('Y-m-d H:i:s');
  try {
    $sql = "INSERT INTO chat (user_id,created_at,text,list_id,image) VALUES(:user_id,:date,:text,:list_id,:imgdat)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stm->bindValue(':date', $date, PDO::PARAM_STR);
    $stm->bindValue(':text', $text, PDO::PARAM_STR);
    $stm->bindValue(':list_id', $id, PDO::PARAM_STR);
    $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }
  if (isset($_GET['page_id'])) {
    header('Location:detail.php?id=' . $id . '&page_id=' . $now);
  } else {
    header('Location:detail.php?id=' . $id);
  }
}
?>