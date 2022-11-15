<?php
session_start();
require_once('../lib/util.php');
<<<<<<< HEAD
$gobackURL = 'mypage.php';
require_once "db_connect.php";
$id = $_SESSION["id"];
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
=======
$gobackURL ='mypage.php';
require_once "db_connect.php";
$id=$_SESSION["id"];
try{

  $sql = "DELETE FROM list WHERE user_id = :id";
  $stm=$pdo->prepare($sql);
  $stm->bindValue(':id',$id,PDO::PARAM_STR);
  if($stm->execute()){
  // $stm = $pdo->prepare($sql);
  // $stm->execute();
  $result=$stm->fetchAll(PDO::FETCH_ASSOC);
}else{
  echo "ツイカエラーガアリマシタ。";
}
}catch(Exception $e){
>>>>>>> root/master
  echo 'エラーがありました。2';
  echo $e->getMessage();
  exit();
}
<<<<<<< HEAD
try {
=======
try{
>>>>>>> root/master

  $sql = "DELETE FROM users WHERE id = $id";
  $stm = $pdo->prepare($sql);
  if ($stm->execute()) {
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    header("location: logout.php");
    exit;
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
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<?php require_once("head.php")?>
>>>>>>> root/master
<title>貸し借り|一覧</title>
</head>

<body>
<<<<<<< HEAD
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <div>
            <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
          </div>
        </section>
      </div>
      <!--/メイン-->
=======
<div id="fb-root"></div>

  
  <!--ヘッダー-->
		<?php require_once("header.php");?>
>>>>>>> root/master

      <!--サイド-->

      <?php
      require_once('side.php');
      ?>


      <!--/サイド-->
    </div>
    <!--/wrapper-->

<<<<<<< HEAD
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
=======
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
        <li><a href="register.php">アカウント登録</a></li><li><a href="login.php">ログイン</a></li>
      </ul>
    </div>
    <small>&copy; 2015 Bloom.</small>
  </footer>
  <!--/フッター-->
>>>>>>> root/master

</body>

</html>