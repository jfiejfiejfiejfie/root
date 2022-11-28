<?php
session_start();
require_once('../lib/util.php');
$myURL = 'user_chat_list.php';
$option = '';
$gobackURL = 'index.php';
require_once "db_connect.php";
$block_count = 0;
$block = 0;
define('MAX', '12');
// require_once("block_check.php");
if (!isset($_SESSION["check"])) {
  $check = 0;
} else {
  $check = $_SESSION["check"];
}
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|一覧</title>
</head>

<body>
  <script src="js/original.js"></script>
  <div id="cursor"></div>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <!-- 入力フォームを作る -->

    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">

          <div>
            <?php
              if (isset($_SESSION["loggedin"])) {

                echo '<br><h2>チャット一覧</h2>';
                $user_id_list = [];
                $id = $_SESSION["id"];
                $sql = "SELECT * FROM user_chat WHERE others_id=$id or user_id=$id ORDER BY created_at DESC";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                  if ($row["others_id"] == $id) {
                    if (!in_array($row["user_id"], $user_id_list)) {
                      echo '<table id="user_chat">';
                      echo '<thead><tr>';
                      echo '<th><a href="profile.php?id=', $row["user_id"], '">', '<img id="image" height="100" width="100" src="my_image.php?id=', $row["user_id"], '"></a>';
                      $user_id = $row["user_id"];
                      $sql = "SELECT * FROM users WHERE id=$user_id";
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                        $block_list=[];
                        $sql = "SELECT * FROM blocklist WHERE my_id =:id";
                        $stm = $pdo->prepare($sql);
                        $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
                        $stm->execute();
                        $block_result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($block_result as $block_row) {
                          $block_list[] = $block_row["user_id"];
                        }
                        if (in_array($user_id, $block_list)) {
                          echo $row2["name"], "<c style='color:red;'>※ブロック中!</c></th>";
                        }else{
                          echo $row2["name"], "</th>";
                        }
                      }
                      $user_id_list[] = $row["user_id"];
                      $user_id = $row["user_id"];
                      $sql = "SELECT * FROM users WHERE id=$user_id";
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                        echo "<td>" . $row2["name"] . ':' . $row["text"];
                        if ($row["image"] != "") {
                          echo '<br>画像が添付されています。';
                        }
                        echo '<br>', $row["created_at"];
                        echo "<br><a class='btn btn-primary' href='user_chat.php?id=$user_id'>チャットに行く</a>";
                        echo '</td>';
                      }
                      echo '</tr>';
                      echo '</thead>';
                      echo '</table>';
                    }
                  } else {
                    if (!in_array($row["others_id"], $user_id_list)) {
                      echo '<table id="user_chat">';
                      echo '<thead><tr>';
                      echo '<th><a href="profile.php?id=', $row["others_id"], '">', '<img id="image" height="100" width="100" src="my_image.php?id=', $row["others_id"], '"></a>';
                      $user_id = $row["others_id"];
                      $sql = "SELECT * FROM users WHERE id=$user_id";
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                        $block_list=[];
                        $sql = "SELECT * FROM blocklist WHERE my_id =:id";
                        $stm = $pdo->prepare($sql);
                        $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
                        $stm->execute();
                        $block_result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($block_result as $block_row) {
                          $block_list[] = $block_row["user_id"];
                        }
                        if (in_array($user_id, $block_list)) {
                          echo $row2["name"], "<c style='color:red;'>※ブロック中!</c></th>";
                        }else{
                          echo $row2["name"], "</th>";
                        }
                      }
                      $user_id_list[] = $row["others_id"];
                      echo '<td>あなた:', $row["text"];
                      if ($row["image"] != "") {
                        echo '<br>画像が添付されています。';
                      }
                      echo '<br>', $row["created_at"];
                      echo "<br><a class='btn btn-primary' href='user_chat.php?id=$user_id'>チャットに行く</a>";
                      echo '</td>';
                      echo '</tr>';
                      echo '</thead>';
                      echo '</table>';
                    }
                  }
                }
              } else {
                echo "<br><h2>この機能を利用するにはログインしてください。</h2>";
                echo "<a href='login.php' class='btn btn-danger'>ログイン</a>";
              }
              ?>
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