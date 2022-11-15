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
      <h2>閲覧履歴</h2>
      <?php
if (isset($_COOKIE['history_url'])) {
  $history_url = unserialize($_COOKIE['history_url']); //クッキーに保存されたURLを配列にする
}
if (isset($_COOKIE['history_item'])) {
  $history_item = unserialize($_COOKIE['history_item']); //クッキーに保存されたテキストを配列にする
  $i = 0;
  echo "<table><tr>";
  foreach ($history_item as $key => $val) {
    $sql = "SELECT * FROM list WHERE id=$val";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
    }
    echo '<td>';
    echo '<div class="sample5"><a href="' . $history_url[$i] . '"><img src="image.php?id=' . $val . '" id="parent" height="240" width="240"></img>'; //テキストを表示および同じ順番に保存されているURLを表示
    if ($row["loan"] == 1) {
      echo '<img id="child" src="images/sold.png" height="240" width="240"/>';
    }
    echo '<div class="mask">';
    echo '<div class="caption">', $row["item"], '</div></div></a></div></td>';
    // echo '<li><a href="'.$history_url[$i].'">'.$val.'</a></li>'."\n"; //テキストを表示および同じ順番に保存されているURLを表示
    $i++;
    if ($i % 4 == 0) {
      echo "</tr>";
      echo "<tr>";
    }
  }
  echo '</tr></table>';
} else {
  echo '<p>過去に見たページはありません。</p>';
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