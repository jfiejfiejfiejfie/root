<?php
session_start();
require_once('../lib/util.php');
$gobackURL = "user_chat_list.php";
require_once "db_connect.php";
define('MAX', '5');
// 文字エンコードの検証
if (!cken($_POST)) {
  header("Location:{$gobackURL}");
  exit();
}

// nameが未設定、空のときはエラー
if (!isset($_GET["item"])) {
  if (empty($_POST)) {
    header("Location:{$gobackURL}");
    exit();
  } else if (!isset($_POST["item"]) || ($_POST["item"] === "")) {
    header("Location:{$gobackURL}");
    exit();
  }
}
if (isset($_GET["item"])) {
  $item = $_GET["item"];
} else {
  $item = $_POST["item"];
}
$myURL = 'search1.php';
$option = "&item=$item";
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
          <form method="POST" action="search1.php">
            <ul>
              <li>
                <h2>検索</h2>
                <label>名前を検索します（部分一致）：<br>
                  <input type="text" name="item" placeholder="名前を入れてください。"
                    value="<?php echo htmlspecialchars($item); ?>">
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

  //MySQLデータベースに接続する
  try {
    $block = 0;
    require_once('block_check.php');
    if ($block_count != 0) {
      $block_list = implode(",", $block_list);
      $sql = "SELECT * FROM list WHERE item LIKE(:item) and user_id not in ($block_list)";
    } else {
      $sql = "SELECT * FROM list WHERE item LIKE(:item)";
    }
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':item', "%{$item}%", PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    require_once('paging.php');
    if (count($disp_data) > 0) {
      echo "名前に「{$item}」が含まれているレコード";
      // テーブルのタイトル行
      echo '<table class="table table-striped">';
      echo '<thead><tr>';
      echo '<th>', '貸出者', '</th>';
      echo '<th>', '貸出物', '</th>';
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
        echo "<br><a href='profile.php?id={$row['user_id']}'><img height='100' width='100'src='my_image.php?id={$row['user_id']}'></a></td>";
        echo '<td>',$row['item'], '</td>';
        echo '<td>￥', number_format($row['money']), '</td>';
        echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
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
      echo "名前に「{$item}」は見つかりませんでした。";
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