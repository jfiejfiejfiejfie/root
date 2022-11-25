<?php
if (isset($_GET["reservation"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM list WHERE id=$id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $user_id = $row["user_id"];
    }
    $my_id = $_SESSION["id"];
    $count = 0;
    $memo="予約";
    $myURL="detail.php?id=".$id;
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
      $sql = "INSERT INTO reservation_list (list_id,user_id) VALUES(:list_id,:user_id)";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':list_id', $id, PDO::PARAM_STR);
      $stm->bindValue(':user_id', $my_id, PDO::PARAM_STR);
      $stm->execute();
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    header('Location:detail.php?id=' . $id);
  }