<?php
session_start();
require_once('../lib/util.php');
// $gobackURL ="blocklist.php?id={$_SESSION["my_id"]}&room_id={$_SESSION["room_id"]}";
//$gobackURL = 'blocklist.php';
require_once "db_connect.php";
$my_id = $_SESSION["id"];
$room_id = $_GET["id"];
$attend_count = 0;
try {

  $sql = "SELECT * FROM roomlist WHERE room_id =:room_id and my_id=:my_id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':room_id', $room_id, PDO::PARAM_STR);
  $stm->bindValue(':my_id', $_SESSION["id"], PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $attend_count += 1;
  }
} catch (Exception $e) {
  echo 'エラーがありました。';
  echo $e->getMessage();
  exit();
}
if ($attend_count == 0) {
  date_default_timezone_set('Asia/Tokyo');
  $created_at = date("Y/m/d H:i:s");
  $sql = "INSERT INTO roomlist (my_id,room_id,created_at) VALUES(:my_id,:room_id,:created_at)";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':my_id', $my_id, PDO::PARAM_STR);
  $stm->bindValue(':room_id', $room_id, PDO::PARAM_STR);
  $stm->bindValue(':created_at', $created_at, PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
} else {

  $sql = "DELETE FROM roomlist WHERE my_id=$my_id and room_id=$room_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
}
header('Location:room.php?id=' . $room_id);
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|詳細</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <?php if ($attend_count == 0) { ?>
          <h2>ブロック完了</h2>
          <p><a href="<?php echo $gobackURL ?>">ブロックリスト</a></p>
          <?php } else { ?>
          <h2>ブロック解除完了</h2>
          <p><a href="<?php echo $gobackURL ?>">ブロックリスト</a></p>
          <?php } ?>
        </section>
      </div>
      <!--/メイン-->

      <!--サイド-->

      <?php
      require_once('side.php');
      ?>


      <!--/サイド-->
    </div>
    <!--/wrapper-->

    <!--フッター-->
    <footer>
      <div id="footer_nav">
        <ul>
          <li class="current"><a href="all.php">HOME</a></li>
          <li><a href="add_db.php">商品登録</a></li>
          <li><a href="list.php">一覧</a></li>
          <li><a href="mypage.php">マイページ</a></li>
          <li><a href="register.php">アカウント登録</a></li>
          <li><a href="login.php">ログイン</a></li>
        </ul>
      </div>
      <small>&copy; 2015 Bloom.</small>
    </footer>
    <!--/フッター-->

</body>

</html>