<?php
session_start();
require_once('../lib/util.php');
// $gobackURL ="blocklist.php?id={$_SESSION["my_id"]}&user_id={$_SESSION["user_id"]}";
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
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
<<<<<<< HEAD

  $sql = "DELETE FROM followlist WHERE my_id=$my_id and user_id=$user_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();

  $sql = "DELETE FROM followlist WHERE my_id=$user_id and user_id=$my_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
=======
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
>>>>>>> root/master
} else {

  $sql = "DELETE FROM blocklist WHERE my_id=$my_id and user_id=$user_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
<<<<<<< HEAD
}
header('Location:profile.php?id=' . $user_id);
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
=======
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
}
header('Location:profile.php?id=' . $user_id);
<<<<<<< HEAD
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
=======
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
=======
$gobackURL ='blocklist.php';
require_once "db_connect.php";
$my_id=$_SESSION["id"];
$user_id=$_GET["id"];
$block_count=0;
  try{
    
    $sql = "SELECT * FROM blocklist WHERE user_id =:user_id and my_id=:my_id";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id',$user_id,PDO::PARAM_STR);
    $stm->bindValue(':my_id',$_SESSION["id"],PDO::PARAM_STR);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
      $block_count+=1;
    }
}catch(Exception $e){
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
}
if($block_count==0){
    
    $sql = "INSERT INTO blocklist (my_id,user_id) VALUES(:my_id,:user_id)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':my_id',$my_id,PDO::PARAM_STR);
    $stm->bindValue(':user_id',$user_id,PDO::PARAM_STR);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
}else{
    
    $sql = "DELETE FROM blocklist WHERE my_id=$my_id and user_id=$user_id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
}
header('Location:profile.php?id='.$user_id);
?>

<!DOCTYPE html>
<?php require_once("head.php")?>
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
<title>貸し借り|詳細</title>
</head>

<body>
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
  <audio id="audio"></audio>
  <div id="fb-root"></div>


<<<<<<< HEAD
  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <?php if ($block_count == 0) { ?>
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
=======
<<<<<<< HEAD
  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <?php if ($block_count == 0) { ?>
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
=======
  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <?php if ($block_count == 0) { ?>
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
=======
<audio id="audio"></audio>
<div id="fb-root"></div>

  
  <!--ヘッダー-->
  	<?php require_once("header.php");?>
  <div>
  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <section id="point">
        <?php if($block_count==0){?>
        <h2>ブロック完了</h2>
        <p><a href="<?php echo $gobackURL ?>">ブロックリスト</a></p>
        <?php }else{?>
          <h2>ブロック解除完了</h2>
        <p><a href="<?php echo $gobackURL ?>">ブロックリスト</a></p>
        <?php }?>
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