<?php
session_start();
require_once('../lib/util.php');
// $gobackURL ="blocklist.php?id={$_SESSION["my_id"]}&user_id={$_SESSION["user_id"]}";
//$gobackURL = 'blocklist.php';
require_once "db_connect.php";
$my_id = $_SESSION["id"];
$user_id = $_GET["id"];
$follow_count = 0;
try {

  $sql = "SELECT * FROM followlist WHERE user_id =:user_id and my_id=:my_id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stm->bindValue(':my_id', $_SESSION["id"], PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $follow_count += 1;
  }
} catch (Exception $e) {
  echo 'エラーがありました。';
  echo $e->getMessage();
  exit();
}
if ($follow_count == 0) {
  date_default_timezone_set('Asia/Tokyo');
  $created_at = date("Y/m/d H:i:s");
  $sql = "INSERT INTO followlist (my_id,user_id,created_at) VALUES(:my_id,:user_id,:created_at)";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':my_id', $my_id, PDO::PARAM_STR);
  $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
  $stm->bindValue(':created_at', $created_at, PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
} else {

  $sql = "DELETE FROM followlist WHERE my_id=$my_id and user_id=$user_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
}
header('Location:profile.php?id=' . $user_id);
?>