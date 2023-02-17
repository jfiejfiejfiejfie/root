<?php
session_start();

// $gobackURL ="blocklist.php?id={$_SESSION["my_id"]}&user_id={$_SESSION["user_id"]}";
$gobackURL = 'blocklist.php';
require_once "db_connect.php";
$my_id = $_SESSION["id"];
$user_id = $_GET["id"];
$block_count = 0;
try {

  $sql = "SELECT * FROM blocklist WHERE user_id =:user_id and my_id=:my_id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stm->bindValue(':my_id', $_SESSION["id"], PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $block_count += 1;
  }
} catch (Exception $e) {
  echo 'エラーがありました。';
  echo $e->getMessage();
  exit();
}
if ($block_count == 0) {

  $sql = "INSERT INTO blocklist (my_id,user_id) VALUES(:my_id,:user_id)";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':my_id', $my_id, PDO::PARAM_STR);
  $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stm->execute();

  $sql = "DELETE FROM followlist WHERE my_id=$my_id and user_id=$user_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();

  $sql = "DELETE FROM followlist WHERE my_id=$user_id and user_id=$my_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
} else {

  $sql = "DELETE FROM blocklist WHERE my_id=$my_id and user_id=$user_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
}
header('Location:profile?id=' . $user_id);
?>
