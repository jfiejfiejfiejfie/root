<?php
session_start();
require_once('../lib/util.php');
<<<<<<< HEAD
$gobackURL = 'list.php';
=======
$gobackURL ='list.php';
>>>>>>> root/master
require_once "db_connect.php";
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
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
<<<<<<< HEAD
  <?php require_once("header.php"); ?>

  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <h2>出品物一覧</h2>
          <div>
            <?php
            $data = $_GET["id"];
            try {
              echo $data, 'を';

              $sql = "DELETE FROM list WHERE id =$data";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $sql = "DELETE FROM chat WHERE list_id = $data";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $sql = "DELETE FROM image_list WHERE list_id = $data";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $sql = "DELETE FROM likes WHERE list_id = $data";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              echo "削除しました。";
            } catch (Exception $e) {
              echo 'エラーがありました。';
              echo $e->getMessage();
              exit();
            }
            ?>
            <hr>
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
=======
		<?php require_once("header.php");?>

<div>
  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <section id="point">
        <h2>出品物一覧</h2>
        <div>
    <?php
    $data=$_GET["id"];
        try{
            echo $data,'を';
            
            $sql = "DELETE FROM list WHERE id =$data";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $sql = "DELETE FROM chat WHERE list_id = $data";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $sql = "DELETE FROM image_list WHERE list_id = $data";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $sql = "DELETE FROM likes WHERE list_id = $data";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            echo "削除しました。";
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
        }
    ?>
    <hr>
    <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
      </section>
>>>>>>> root/master
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