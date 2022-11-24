<?php
session_start();
require_once('../lib/util.php');
$gobackURL = 'mypage.php';
require_once "db_connect.php";
require_once('user_check.php');
if($row["admin"]==0){
    header('Location:index.php');
}
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <div>
        <?php
    $id = $_POST["id"];
    $user_id = $_POST["user_id"];
    $name = $_POST["name"];
    $age = $_POST["age"];
    $sex = $_POST["sex"];
    $comment = $_POST["comment"];
    $money = $_POST["money"];
    try {

      $sql = "UPDATE users SET user_id=:user_id,name=:name ,age = :age,sex = :sex,comment = :comment,money=:money where id = $id";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
      $stm->bindValue(':name', $name, PDO::PARAM_STR);
      $stm->bindValue(':age', $age, PDO::PARAM_STR);
      $stm->bindValue(':sex', $sex, PDO::PARAM_STR);
      $stm->bindValue(':comment', $comment, PDO::PARAM_STR);
      $stm->bindValue(':money', $money, PDO::PARAM_STR);
      if ($stm->execute()) {
        if (isset($_FILES["image"]) && $_FILES["image"]["tmp_name"] != "") {
          $upfile = $_FILES["image"]["tmp_name"];
          $imgdat = file_get_contents($upfile);
          $sql = "UPDATE users SET image=:imgdat where id = $id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
          $stm->execute();
        }
        if (isset($_POST["email"]) && $_POST["email"] != "") {
          $email = $_POST["email"];
          $sql = "UPDATE users SET email=:email where id = $id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':email', $email, PDO::PARAM_STR);
          $stm->execute();
        }
        $sql = "SELECT * FROM users WHERE id = $id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo '<table>';
        echo '<thead><tr>';
        echo '<th>', '年齢', '</th>';
        echo '<th>', '性別', '</th>';
        echo '<th>', 'E-mail', '</th>';
        echo '<th>', 'コメント', '</th>';
        echo '<th>', 'プロフィール画像', '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($result as $row) {
          echo '<tr>';
          echo '<td>',$row['age'], '</td>';
          echo '<td>',$row['sex'], '</td>';
          echo '<td>',$row['email'], '</td>';
          echo '<td>',$row['comment'], '</td>';
          echo '<td><img height="150" width="150" src="my_image.php?id=', $row['id'], '"></td>';
          echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
      } else {
        echo "ツイカエラーガアリマシタ。";
      }
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
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