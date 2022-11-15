<?php
session_start();
require_once "db_connect.php";
?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|マイページ</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>

  <!--ヘッダー-->
  <?php require_once("header.php"); ?>


  <div id="wrapper">
    <!--メイン-->
    <div id="main">

      <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>

      <h2>ブロックリスト</h2>
      <?php
        $id = $_SESSION["id"];
        try {

          $sql = "SELECT * FROM blocklist WHERE  my_id=:id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id', $id, PDO::PARAM_STR);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            echo '<table class="table table-striped">';
            echo "<a href='profile.php?id={$row['user_id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row['user_id']}'></a><br>";
            $user_id = $row["user_id"];
            $sql = "SELECT * FROM users WHERE id=$user_id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result2 as $row2) {
              echo $row2["name"], "</td>";
            }
            echo "<hr>";
            echo '</tr>';
          }
          echo '</tbody>';
          echo '</table>';
        } catch (Exception $e) {
          echo 'エラーがありました。';
          echo $e->getMessage();
          exit();
        }
      }
      ?>
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