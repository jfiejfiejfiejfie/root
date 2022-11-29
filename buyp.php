<?php
session_start();
require_once('../lib/util.php');
require_once "db_connect.php";
require_once('user_check.php');
$myURL='buyp.php';
$point = $row["point"];
$money = $row["money"];
$name = $row["name"];
$checked=$row["checked"]; 
if(isset($_GET["id"])){
  $id = $_GET["id"];
  $data = $_SESSION["id"];
  $gobackURL = "detail.php?id={$id}";
  try {
    $sql = "SELECT * FROM list WHERE id=$id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $user_id = $row["user_id"];
      $item=$row["item"];
    }
  } catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }
  // 簡単なエラー処理
  $errors = [];
  $memo = "購入"; 
  if ($point < $_GET["money"]) {
    $errors[] = "ポイントが足りません";
  }
  if($checked==0){
    $errors[] = 'メール認証が完了していないため購入できません';
  }
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
}
?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り</title>
</head>

<body>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <div>
        <?php
        if(isset($_GET["id"])){
          try {
            $loan = 1;
            $sql = "UPDATE list SET loan=$loan,buy_user_id=$data WHERE id=$id";
            $stm = $pdo->prepare($sql);
            if ($stm->execute()) {
              $sql = 'SELECT * FROM list';
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
              echo "ツイカエラーガアリマシタ。";
            }
          } catch (Exception $e) {
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
          }
          try {
            $point = $point - $_GET["money"];

            $sql = "UPDATE users SET point=$point WHERE id=$data";
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

            $sql = "UPDATE users SET point=point+$money WHERE id=$user_id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          } catch (Exception $e) {
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
          }
          try {
            $text="<a href='detail.php?id=".$id."'>".$item."</a>を購入しました。
            ※これは自動送信です。";
            date_default_timezone_set('Asia/Tokyo');
            $date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO user_chat (user_id,created_at,text,others_id) VALUES(:user_id,:date,:text,:others_id)";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':user_id', $data, PDO::PARAM_STR);
            $stm->bindValue(':date', $date, PDO::PARAM_STR);
            $stm->bindValue(':text', $text, PDO::PARAM_STR);
            $stm->bindValue(':others_id', $user_id, PDO::PARAM_STR);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          } catch (Exception $e) {
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
          }
          header('Location:buyp.php');
        }else{
          echo "<h1>購入しました。</h1>";
          $gobackURL="list.php";
        }
        ?>
        <hr>
        <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
      </div>
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