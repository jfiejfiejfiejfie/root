<?php
session_start();
require_once('../lib/util.php');
<<<<<<< HEAD
$gobackURL = 'admin.php';
require_once "db_connect.php";
if(isset($_POST["id"])){
  $id=$_POST["id"];
}else{
  $id = $_SESSION["id"];
}
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
$gobackURL = 'mypage.php';
require_once "db_connect.php";
$id = $_SESSION["id"];
>>>>>>> root/master
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
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
>>>>>>> root/master
>>>>>>> root/master
  echo 'エラーがありました。2';
  echo $e->getMessage();
  exit();
}
<<<<<<< HEAD
try {
=======
<<<<<<< HEAD
try {
=======
<<<<<<< HEAD
try {
=======
try{
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master

  $sql = "DELETE FROM users WHERE id = $id";
  $stm = $pdo->prepare($sql);
  if ($stm->execute()) {
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
<<<<<<< HEAD
    if(!isset($_POST["id"])){
    header("location: logout.php");
    exit;
    }
=======
    header("location: logout.php");
    exit;
>>>>>>> root/master
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
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<?php require_once("head.php")?>
>>>>>>> root/master
>>>>>>> root/master
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
            <h1>垢BAN完了♪</h1>
            <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
          </div>
        </section>
      </div>
      <!--/メイン-->

      <!--サイド-->

=======
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

      <!--サイド-->

=======
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

>>>>>>> root/master
>>>>>>> root/master
      <?php
      require_once('side.php');
      ?>


      <!--/サイド-->
    </div>
    <!--/wrapper-->

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
    <!--フッター-->
    <footer>
      <div id="footer_nav">
        <ul>
<<<<<<< HEAD
          <li class="current"><a href="index.php">HOME</a></li>
          <li><a href="add_db.php">商品登録</a></li>
          <li><a href="user_chat_list.php">一覧</a></li>
=======
          <li class="current"><a href="all.php">HOME</a></li>
          <li><a href="add_db.php">商品登録</a></li>
          <li><a href="list.php">一覧</a></li>
>>>>>>> root/master
          <li><a href="mypage.php">マイページ</a></li>
          <li><a href="register.php">アカウント登録</a></li>
          <li><a href="login.php">ログイン</a></li>
        </ul>
      </div>
      <small>&copy; 2015 Bloom.</small>
    </footer>
    <!--/フッター-->
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
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
>>>>>>> root/master
>>>>>>> root/master

</body>

</html>