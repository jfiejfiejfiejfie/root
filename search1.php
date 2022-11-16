<?php
session_start();
require_once('../lib/util.php');
$gobackURL = "list.php";
require_once "db_connect.php";
<<<<<<< HEAD
define('MAX', '5');
=======
<<<<<<< HEAD
define('MAX', '5');
=======
define('MAX','5');
>>>>>>> root/master
>>>>>>> root/master
// 文字エンコードの検証
if (!cken($_POST)) {
  header("Location:{$gobackURL}");
  exit();
}

// nameが未設定、空のときはエラー
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
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
<<<<<<< HEAD
=======
=======
if(!isset($_GET["item"])){
  if (empty($_POST)){
    header("Location:{$gobackURL}");
    exit();
  } else if(!isset($_POST["item"])||($_POST["item"]==="")){
    header("Location:{$gobackURL}");
    exit();
  }
}
if(isset($_GET["item"])){
  $item=$_GET["item"];
}else{
  $item = $_POST["item"];
}

?>
<!DOCTYPE html>
<?php require_once("head.php")?>
>>>>>>> root/master
>>>>>>> root/master
<title>貸し借り|検索</title>
</head>

<body>
<<<<<<< HEAD
=======
<<<<<<< HEAD
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
=======
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
  <form method="POST" action="search1.php">
    <ul>
      <li>
      <h2>検索</h2>
        <label>名前を検索します（部分一致）：<br>
        <input type="text" name="item" placeholder="名前を入れてください。" value="<?php echo htmlspecialchars($item);?>">
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

    // SQL文を作る
    $sql = "SELECT * FROM list WHERE item LIKE(:item)";
    //$sql = "SELECT * FROM list where item='$item'";
    // プリペアドステートメントを作る
    $stm=$pdo->prepare($sql);
    // プレースホルダに値をバインドする
    $stm->bindValue(':item',"%{$item}%",PDO::PARAM_STR);
    // SQL文を実行する
>>>>>>> root/master
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
<<<<<<< HEAD
    require_once('paging.php');
    if (count($disp_data) > 0) {
=======
    $books_num = count($result);
    $max_page = ceil($books_num / MAX);
    if(!isset($_GET['page_id'])){
        $now = 1;
    }else{
        $now = $_GET['page_id'];
    }
    $start_no = ($now - 1) * MAX;
    $disp_data = array_slice($result, $start_no, MAX, true);
    if(count($disp_data)>0){
>>>>>>> root/master
>>>>>>> root/master
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
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
        echo '<td>', es($row['item']), '</td>';
        echo '<td>￥', number_format($row['money']), '</td>';
        echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
          if ($_SESSION["admin"] == 1) {
            $row['id'] = rawurlencode($row['id']);
            echo "<td><a class = 'btn btn-primary' href=delete.php?id={$row["id"]}>", "消す", '</a></td>';
          }
        }
        echo '</tr>';
<<<<<<< HEAD
=======
=======
      foreach($disp_data as $row){
          echo '<tr>';
          $user_id=$row["user_id"];
          $sql = "SELECT * FROM users WHERE id=$user_id";
          $stm = $pdo->prepare($sql);
          $stm->execute();
          $result2=$stm->fetchAll(PDO::FETCH_ASSOC);
          foreach($result2 as $row2){
            echo '<td>',$row2["name"];
          }
          echo "<br><a href='profile.php?id={$row['user_id']}'><img height='100' width='100'src='my_image.php?id={$row['user_id']}'></a></td>";
          echo '<td>',es($row['item']),'</td>';
          echo '<td>￥',number_format($row['money']),'</td>';
          echo "<td><a href=detail.php?id={$row["id"]}>",'<img height="100" width="100" src="image.php?id=',$row['id'],'"></a></td>';
          if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            if($_SESSION["admin"]==1){
              $row['id']=rawurlencode($row['id']);
              echo "<td><a class = 'btn btn-primary' href=delete.php?id={$row["id"]}>","消す",'</a></td>';
              }
          }
          echo '</tr>';
>>>>>>> root/master
>>>>>>> root/master
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
<<<<<<< HEAD
  require_once('paging2.php');
=======
<<<<<<< HEAD
  require_once('paging2.php');
=======
  echo '全件数'. $books_num. '件'. '　';
  if($now > 1){ // リンクをつけるかの判定
      echo '<a href=search1.php?page_id='.($now - 1).'&item=',$item,'>前へ</a>'. '　';
  } else {
      echo '前へ'. '　';
  }
  for($i = 1; $i <= $max_page; $i++){
      if ($i == $now) {
          echo $now. '　'; 
      } else {
          echo '<a href=search1.php?page_id='.$i.'&item=',$item,'>'.$i.'</a>'. '　';
      }
  }
  if($now < $max_page){ // リンクをつけるかの判定
      echo '<a href=search1.php?page_id='.($now + 1).'&item=',$item,'>次へ</a>'. '　';
  } else {
      echo '次へ';
  }
>>>>>>> root/master
>>>>>>> root/master
  ?>
            <hr>
            <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
          </div>
        </section>
      </div>
      <!--/メイン-->
<<<<<<< HEAD

      <!--サイド-->

      <?php
      require_once('side.php');
      ?>


      <!--/サイド-->
    </div>
    <!--/wrapper-->

=======

<<<<<<< HEAD
      <!--サイド-->

      <?php
      require_once('side.php');
      ?>


      <!--/サイド-->
    </div>
    <!--/wrapper-->

>>>>>>> root/master
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
<<<<<<< HEAD
=======
=======
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
        <li><a href="register.php">アカウント登録</a></li><li><a href="login.php">ログイン</a></li>
      </ul>
    </div>
    <small>&copy; 2015 Bloom.</small>
  </footer>
  <!--/フッター-->
>>>>>>> root/master
>>>>>>> root/master

</body>

</html>