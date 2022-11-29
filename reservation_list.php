<?php
session_start();
$myURL='reservation_list.php';
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

            <h2>予約された商品</h2>
            <?php
          $id = $_SESSION["id"];
          $list_list = [];
          $list_count = 0;
          $sql = "SELECT * FROM list WHERE  user_id=:id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id', $id, PDO::PARAM_STR);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result as $row) {
              $list_count += 1;
              $list_list[] = $row["id"];
          }
          try {
              if ($list_count > 0) {
                  $reservation_list = [];
                  $list_list = implode(",", $list_list);
                  $sql = "SELECT * FROM reservation_list WHERE  list_id IN ($list_list) and checked=0";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result as $row) {
                      if (!in_array($row["list_id"], $reservation_list)) {
                          $reservation_list[] = $row["list_id"];
                          echo '<table class="table table-striped">';
                          echo "<a href='reservation_auth.php?id={$row['list_id']}'><img id='image' height='100' width='100'src='image.php?id={$row['list_id']}'></a><br>";
                          $list_id = $row["list_id"];
                          $sql = "SELECT * FROM list WHERE id=$list_id";
                          $stm = $pdo->prepare($sql);
                          $stm->execute();
                          $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result2 as $row2) {
                              echo $row2["item"], "</td>";
                          }
                          echo "<hr>";
                          echo '</tr>';
                      }
                  }
                  echo '</tbody>';
                  echo '</table>';
              } else {
                  echo "<h1>現在予約はありません。</h1>";
              }
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