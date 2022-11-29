<?php
session_start();
require_once('../lib/util.php');
$myURL='search_kind.php';
$gobackURL = "search_sp.php";
require_once "db_connect.php";
define('MAX', '5');
// 文字エンコードの検証
if (!cken($_POST)) {
  header("Location:{$gobackURL}");
  exit();
}

// nameが未設定、空のときはエラー
if (isset($_GET["kind_name"])) {
  $kind_name = $_GET["kind_name"];
} else if (empty($_POST)) {
  header("Location:{$gobackURL}");
  exit();
} else if (!isset($_POST["kind_name"]) || ($_POST["kind_name"] === "")) {
  header("Location:{$gobackURL}");
  exit();
}
if (!isset($_GET["kind_name"])) {
  $kind_id = $_POST["kind_name"];
  try {

    $sql = "SELECT * FROM kind WHERE id=$kind_id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $kind = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($kind as $row) {
      $kind_name = $row["name"];
    }
  } catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }
}
$myURL = 'search_kind.php';
$option = "&kind_name=$kind_name";
?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|検索</title>
</head>

<body>
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
          <h2>ジャンル検索</h2>
          <form method="POST" action="search_kind.php">
            <ul>
              <li>
                <label>ジャンルで検索します：<br>
                  <select name="kind_name">
                    <?php
                    try {

                      $sql = "SELECT * FROM kind";
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $kind = $stm->fetchAll(PDO::FETCH_ASSOC);
                    } catch (Exception $e) {
                      echo 'エラーがありました。';
                      echo $e->getMessage();
                      exit();
                    }
                    foreach ($kind as $row) {
                      echo '<option value="', $row["id"], '">', $row["name"], "</option>";
                    }
                    ?>
                  </select>
                </label>
              </li>
              <li><input type="submit" value="検索する"></li>
            </ul>
          </form>
        </section>
        <section id="point">
          <h2>出品物一覧</h2>
          <div>
            <?php
            try {
              if (isset($_SESSION["loggedin"])) {
                $block = 0;
                require_once('block_check.php');
                if ($block_count != 0) {
                  $block_list = implode(",", $block_list);
                  $sql = "SELECT * FROM list WHERE kind LIKE(:item) and loan=0 and user_id not in ($block_list)";
                } else {
                  $sql = "SELECT * FROM list WHERE kind LIKE(:item) and loan=0";
                }
              }else{
                $sql = "SELECT * FROM list WHERE kind LIKE(:item) and loan=0";
              }
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':item', $kind_name, PDO::PARAM_STR);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              require_once("paging.php");
              if (count($disp_data) > 0) {
                echo "ジャンル:{$kind_name}";
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
                echo "名前に「{$kind_name}」は見つかりませんでした。<br>";
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