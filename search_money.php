<?php
session_start();
require_once('../lib/util.php');
require_once "db_connect.php";
$gobackURL = "search_sp.php";
define('MAX', '5');
// 文字エンコードの検証
if (!cken($_POST)) {
  header("Location:{$gobackURL}");
  exit();
}

?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|検索</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>

  <?php
  // 簡単なエラー処理
  $errors = [];
  if (isset($_GET["money1"])) {
    $money1 = $_GET["money1"];
    $money2 = $_GET["money2"];
  } else {
    $money1 = $_POST["money1"];
    $money2 = $_POST["money2"];
    if (!(is_numeric($_POST["money1"])) || ($_POST["money1"] < 0)) {
      $money1 = 100;
    }
    if (!(is_numeric($_POST["money2"])) || ($_POST["money2"] < 0)) {
      $money2 = 9999999;
    }
    if ($money1 > $money2) {
      $errors[] = "そんなもの存在しない。";
    }
  }
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
    echo "<h1>ヒント:</h1>";
    echo "<ol>";
    echo "<li>数字をちゃんと確認しよう!!!</li>";
    echo "</ol>";
    echo "<a href=", $gobackURL, ">戻る</a><br>";
    exit();
  }
  $myURL = 'search_money.php';
  $option = "&money1=$money1&money2=$money2";
  ?>
  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <!-- 入力フォームを作る -->
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <h2>金額検索</h2>
          <form method="POST" action="search_money.php">
            <ul>
              <li>
                <label>金額で検索します:<br>
                  <input type="number_format" name="money1">以上
                  <input type="number_format" name="money2">以下
              </li>
              <li><input type="submit" value="検索する"></li>
            </ul>
          </form>
        </section>
        <section id="point">
          <h2>出品物一覧</h2>
          <div>
            <?php
            //MySQLデータベースに接続する
            
            try {
              if (isset($_SESSION["loggedin"])) {
                $block = 0;
                require_once('block_check.php');
                if ($block_count != 0) {
                  $block_list = implode(",", $block_list);
                  $sql = "SELECT * FROM list WHERE money BETWEEN $money1 AND $money2  AND loan=0 and user_id not in ($block_list) ORDER BY money";
                } else {
                  $sql = "SELECT * FROM list WHERE money BETWEEN $money1 AND $money2  AND loan=0 ORDER BY money";
                }
              } else {
                $sql = "SELECT * FROM list WHERE money BETWEEN $money1 AND $money2  AND loan=0 ORDER BY money";
              }
              $stm = $pdo->prepare($sql);
              $stm->execute();
              // 結果の取得（連想配列で受け取る）
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              require_once('paging.php');
              if (count($disp_data) > 0) {
                echo "{$money1}以上{$money2}以下の商品";
                // テーブルのタイトル行
                echo '<table class="table table-striped">';
                echo '<thead><tr>';
                echo '<th>', '貸出者', '</th>';
                echo '<th>', '貸出物', '</th>';
                echo '<th>', 'ジャンル', '</th>';
                echo '<th>', '金額', '</th>';
                echo '<th>', '画像', '</th>';
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                  if ($_SESSION["admin"] == 1) {
                    echo '<th>', '削除', '</th>';
                  }
                }
                echo '</tr></thead>';
                echo '<tbody>';
                foreach ($disp_data as $row) {
                  echo '<tr>';
                  $user_id = $row["user_id"];
                  $sql = "SELECT * FROM users WHERE id=$user_id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result2 as $row2) {
                    echo '<td>', $row2["name"];
                  }
                  echo "<br><a target='_blank' href='profile.php?id={$row['user_id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row['user_id']}'></a></td>";
                  echo '<td>', $row['item'], '</td>';
                  echo '<td>', $row['kind'], '</td>';
                  echo '<td>￥', number_format($row['money']), '</td>';
                  echo "<td><a target='_blank' href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
                  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                    if ($_SESSION["admin"] == 1) {
                      $row['id'] = rawurlencode($row['id']);
                      echo "<td><a class = 'btn btn-primary' href=delete.php?id={$row["id"]}>", "消す", '</a></td>';
                    }
                  }
                  echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
              } else {
                echo "{$money1}以上{$money2}以下の商品は見つかりませんでした。";
              }
            } catch (Exception $e) {
              echo '<span class="error">エラーがありました。</span><br>';
              echo $e->getMessage();
            }
            require_once('paging2.php');
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