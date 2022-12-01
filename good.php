<?php
if (isset($_GET["good"])) {
  $sql = "SELECT * FROM list WHERE id=$id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $user_id = $row["user_id"];
  }
  $my_id = $_SESSION["id"];
  $count = 0;
  $memo = "いいね";
  $myURL = "detail.php?id=" . $id;
  $errors = [];
  require_once('error.php');
  try {
    $sql = "SELECT * FROM likes WHERE my_id=$my_id and list_id=$list_id";
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
    $sql = "DELETE FROM likes WHERE list_id=:list_id and my_id=:my_id";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':list_id', $list_id, PDO::PARAM_STR);
    $stm->bindValue(':my_id', $my_id, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  } else {
    date_default_timezone_set('Asia/Tokyo');
    $created_at = date("Y/m/d H:i:s");
    $sql = "INSERT INTO likes (list_id,my_id,created_at) VALUES(:list_id,:my_id,:created_at)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':list_id', $list_id, PDO::PARAM_STR);
    $stm->bindValue(':my_id', $my_id, PDO::PARAM_STR);
    $stm->bindValue(':created_at', $created_at, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  }
  header('Location:detail.php?id=' . $id);
}