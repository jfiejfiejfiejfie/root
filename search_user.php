<?php
session_start();
require_once('../lib/util.php');
require_once "db_connect.php";
<<<<<<< HEAD
$gobackURL = "user_chat_list.php";
=======
$gobackURL = "list.php";
>>>>>>> root/master

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
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<?php require_once("head.php")?>
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
<title>貸し借り|検索</title>
</head>

<body>
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
  <audio id="audio"></audio>
  <div id="fb-root"></div>


<<<<<<< HEAD
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
    if(isset($_SESSION["loggedin"])){
      $block = 0;
      require_once('block_check.php');
      if ($block_count != 0) {
        $block_list = implode(",", $block_list);
        $sql = "SELECT * FROM users WHERE name LIKE(:name) and id not in ($block_list)";
      } else {
        $sql = "SELECT * FROM users WHERE name LIKE(:name)";
      }
    }else{
      $sql = "SELECT * FROM users WHERE name LIKE(:name)";
    }
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':name', "%{$user_name}%", PDO::PARAM_STR);
=======
<<<<<<< HEAD
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
    if(isset($_SESSION["loggedin"])){
      $block = 0;
      require_once('block_check.php');
      if ($block_count != 0) {
        $block_list = implode(",", $block_list);
        $sql = "SELECT * FROM users WHERE name LIKE(:name) and id not in ($block_list)";
      } else {
        $sql = "SELECT * FROM users WHERE name LIKE(:name)";
      }
    }else{
      $sql = "SELECT * FROM users WHERE name LIKE(:name)";
    }
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':name', "%{$user_name}%", PDO::PARAM_STR);
=======
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
=======
<audio id="audio"></audio>
<div id="fb-root"></div>

  
  <!--ヘッダー-->
		<?php require_once("header.php");?>

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
        <input type="text" name="user_name" placeholder="名前を入れてください。" value="<?php echo htmlspecialchars($_POST["user_name"]);?>">
        </label>
      </li>
      <li><input type="submit" value="検索する"></li>
    </ul>
  </form>
</div>
  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <section id="point">
        <h2>検索結果</h2>
        <div>
  <?php
  $user_name = $_POST["user_name"];
  //MySQLデータベースに接続する
  try {

    // SQL文を作る
    $sql = "SELECT * FROM users WHERE name LIKE(:name)";
    //$sql = "SELECT * FROM list where item='$item'";
    // プリペアドステートメントを作る
    $stm=$pdo->prepare($sql);
    // プレースホルダに値をバインドする
    $stm->bindValue(':name',"%{$user_name}%",PDO::PARAM_STR);
    // SQL文を実行する
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
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
<<<<<<< HEAD
        echo '<td>',$row['name'];
        echo "<br><a target='_blank' href='profile.php?id={$row['id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row['id']}'></a></td>";
        echo '<td>',$row['comment'];
=======
        echo '<td>', es($row['name']);
        echo "<br><a target='_blank' href='profile.php?id={$row['id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row['id']}'></a></td>";
        echo '<td>', es($row['comment']);
>>>>>>> root/master
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
<<<<<<< HEAD

      <!--サイド-->
      <?php require_once("side.php"); ?>
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
=======
<<<<<<< HEAD

      <!--サイド-->
      <?php require_once("side.php"); ?>
      <!--/サイド-->
    </div>
    <!--/wrapper-->

    <!--フッター-->
    <footer>
      <div id="footer_nav">
=======

      <!--サイド-->
      <?php require_once("side.php"); ?>
      <!--/サイド-->
    </div>
    <!--/wrapper-->

<<<<<<< HEAD
    <!--フッター-->
    <footer>
      <div id="footer_nav">
=======
    <!--サイド-->
    
      <section id="side_banner">
        <h2>関連リンク</h2>
>>>>>>> root/master
>>>>>>> root/master
        <ul>
          <li class="current"><a href="all.php">HOME</a></li>
          <li><a href="add_db.php">商品登録</a></li>
          <li><a href="list.php">一覧</a></li>
>>>>>>> root/master
          <li><a href="mypage.php">マイページ</a></li>
          <li><a href="register.php">アカウント登録</a></li>
          <li><a href="login.php">ログイン</a></li>
        </ul>
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
      </div>
      <small>&copy; 2015 Bloom.</small>
    </footer>
    <!--/フッター-->
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
      </section>
      <!-- <section id="side_banner">
      <form method="POST" action="search_user.php">
        <ul>
                <h2>ユーザ検索</h2><br>
                <input type="text" name="user_name" placeholder="名前を入れてください。" value="<?php echo htmlspecialchars($_POST["user_name"]);?>">
                <input type="submit" value="検索する">
        </ul>
       </form>
      </section> -->
      
    
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
        <li><a href="register.php">アカウント登録</a></li><li><a href="login.php">ログイン</a></li>
      </ul>
    </div>
    <small>&copy; 2015 Bloom.</small>
  </footer>
  <!--/フッター-->
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master

</body>

</html>