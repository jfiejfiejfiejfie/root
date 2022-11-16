<?php
session_start();
require_once('../lib/util.php');
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
$id = $_GET["id"];
$gobackURL = "detail.php?id={$id}";
require_once "db_connect.php";
  try {
    $data = $_SESSION["id"];
<<<<<<< HEAD

=======

=======
$id=$_GET["id"];
$gobackURL="detail.php?id={$id}";
require_once "db_connect.php";
?>

<!DOCTYPE html>
<?php require_once("head.php")?>
<title>貸し借り</title>
</head>
<body>
<audio id="audio"></audio>
  <?php
  try{
    $data=$_SESSION["id"];
    
>>>>>>> root/master
>>>>>>> root/master
    $sql = "SELECT * FROM users WHERE id=$data";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $money = $row["money"];
      $name = $row["name"];
    }
  } catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }
  try {
    $sql = "SELECT * FROM list WHERE id=$id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $user_id = $row["user_id"];
    }
  } catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }

  // 簡単なエラー処理
  $errors = [];
  if ($money < $_GET["money"]) {
    $errors[] = "お金が足りません";
  }
  $memo = "購入";
  require_once('error.php');
  //エラーがあったとき
  if (count($errors) > 0) {
    echo "<script> rikki(); </script>";
    echo "<img src='images/main_visual.jpg'>";
    echo "<h1>Error!!!</h1>";
    echo '<ol class="error">';
    foreach ($errors as $value) {
      echo "<li>", $value, "</li>";
    }
    echo "</ol>";
    echo "<hr>";
    echo "<a href=", $gobackURL, ">戻る</a><br>";
    exit();
  }
  ?>
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り</title>
</head>

<body>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
<<<<<<< HEAD
=======
=======
<div id="fb-root"></div>

  
  <!--ヘッダー-->
  <?php require_once("header.php");?>
>>>>>>> root/master
>>>>>>> root/master


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
      <div>
        <?php
    try {
      $loan = 1;

      $sql = "UPDATE list SET loan=$loan,buy_user_id=$data WHERE id=$id";
      $stm = $pdo->prepare($sql);
      if ($stm->execute()) {
        $sql = 'SELECT * FROM list';
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo "<h1>購入しました。</h1>";
      } else {
        echo "ツイカエラーガアリマシタ。";
      }
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
    }
    try {
      $money = $money - $_GET["money"];

      $sql = "UPDATE users SET money=$money WHERE id=$data";
      $stm = $pdo->prepare($sql);
      $stm->execute();
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
    }
    try {
      $user_id = $_GET["user_id"];
      $money = $_GET["money"];

      $sql = "UPDATE users SET money=money+$money WHERE id=$user_id";
      $stm = $pdo->prepare($sql);
      $stm->execute();
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
    }
<<<<<<< HEAD
=======
=======
    <div>
    <?php
        try{
            $loan=1;
            
            $sql="UPDATE list SET loan=$loan,buy_user_id=$data WHERE id=$id";
            $stm=$pdo->prepare($sql);
            if($stm->execute()){
            $sql = 'SELECT * FROM list';
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            echo "<h1>購入しました。</h1>";
            }else{
              echo "ツイカエラーガアリマシタ。";
            }
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
        }
        try{
          $money=$money-$_GET["money"];
          
          $sql="UPDATE users SET money=$money WHERE id=$data";
          $stm=$pdo->prepare($sql);
          $stm->execute();
          $result=$stm->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
        echo 'エラーがありました。';
        echo $e->getMessage();
        exit();
        }
        try{
          $user_id=$_GET["user_id"];
          $money=$_GET["money"];
          
          $sql="UPDATE users SET money=money+$money WHERE id=$user_id";
          $stm=$pdo->prepare($sql);
          $stm->execute();
          $result=$stm->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
        echo 'エラーがありました。';
        echo $e->getMessage();
        exit();
        }
>>>>>>> root/master
>>>>>>> root/master
    ?>
        <hr>
        <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
      </div>
    </div>
    <!--/メイン-->

    <!--サイド-->
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master

    <?php
      require_once('side.php');
      ?>


<<<<<<< HEAD
=======
=======
    
      <?php
    require_once('side.php');
    ?>

    
>>>>>>> root/master
>>>>>>> root/master
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