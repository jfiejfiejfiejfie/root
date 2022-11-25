<?php
session_start();
require_once('../lib/util.php');
$gobackURL = 'admin.php';
require_once "db_connect.php";
if(isset($_POST["id"])){
  $id=$_POST["id"];
}else{
  $id = $_SESSION["id"];
}
try {

  $sql = "DELETE FROM list WHERE user_id = :id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':id', $id, PDO::PARAM_STR);
  if ($stm->execute()) {
    // $stm = $pdo->prepare($sql);
    // $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  } else {
    echo "ツイカエラーガアリマシタ。";
  }
} catch (Exception $e) {
  echo 'エラーがありました。2';
  echo $e->getMessage();
  exit();
}
try {

  $sql = "DELETE FROM users WHERE id = $id";
  $stm = $pdo->prepare($sql);
  if ($stm->execute()) {
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(!isset($_POST["id"])){
    header("location: logout.php");
    exit;
    }
  } else {
    echo "ツイカエラーガアリマシタ。";
  }
} catch (Exception $e) {
  echo 'エラーがありました。3';
  echo $e->getMessage();
  exit();
}
?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|一覧</title>
</head>

<body>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <div>
            <h1>垢BAN完了♪</h1>
            <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
          </div>
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
          <li class="current"><a href="index.php">HOME</a></li>
          <li><a href="add_db.php">商品登録</a></li>
          <li><a href="user_chat_list.php">一覧</a></li>
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