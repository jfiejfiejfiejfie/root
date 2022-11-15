<?php
session_start();
require_once('../lib/util.php');
require_once "db_connect.php";
$gobackURL = "list.php";

// 文字エンコードの検証
if (!cken($_POST)) {
  header("Location:{$gobackURL}");
  exit();
}

// nameが未設定、空のときはエラー
if (empty($_POST)) {
  header("Location:searchform.html");
  exit();
} else if (!isset($_POST["user_name"]) || ($_POST["user_name"] === "")) {
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


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <!-- 入力フォームを作る -->
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <form method="POST" action="search_user.php">
            <ul>
              <li>
                <label>ユーザ名を検索します（部分一致）：<br>
                  <input type="text" name="user_name" placeholder="名前を入れてください。"
                    value="<?php echo htmlspecialchars($_POST["user_name"]); ?>">
                </label>
              </li>
              <li><input type="submit" value="検索する"></li>
            </ul>
          </form>
          <?php
  $user_name = $_POST["user_name"];
  //MySQLデータベースに接続する
  try {
    $block = 0;
    require_once('block_check.php');
    if ($block_count != 0) {
      $block_list = implode(",", $block_list);
      $sql = "SELECT * FROM users WHERE name LIKE(:name) and id not in ($block_list)";
    } else {
      $sql = "SELECT * FROM users WHERE name LIKE(:name)";
    }
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':name', "%{$user_name}%", PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if (count($result) > 0) {
      echo "<script> final(); </script>";
      echo "ユーザ名に「{$user_name}」が含まれているレコード";
      // テーブルのタイトル行
      echo '<table class="table table-striped">';
      echo '<thead><tr>';
      echo '<th>', 'ユーザ', '</th>';
      echo '<th>', 'コメント', '</th>';
      echo '</tr></thead>';
      echo '<tbody>';
      foreach ($result as $row) {
        echo '<tr>';
        echo '<td>', es($row['name']);
        echo "<br><a target='_blank' href='profile.php?id={$row['id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row['id']}'></a></td>";
        echo '<td>', es($row['comment']);
        echo '</tr>';
      }
      echo '</tbody>';
      echo '</table>';
    } else {
      echo "名前に「{$user_name}」は見つかりませんでした。";
      echo "<script> suteki(); </script>";
    }
  } catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
  }
  ?>
      </div>
      </section>
      <!--/メイン-->

      <!--サイド-->
      <?php require_once("side.php"); ?>
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