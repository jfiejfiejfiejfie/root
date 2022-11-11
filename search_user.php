<?php
session_start(); 
require_once('../lib/util.php');
require_once "db_connect.php";
$gobackURL = "list.php";

// 文字エンコードの検証
if (!cken($_POST)){
  header("Location:{$gobackURL}");
  exit();
}

// nameが未設定、空のときはエラー
if (empty($_POST)){
  header("Location:searchform.html");
  exit();
} else if(!isset($_POST["user_name"])||($_POST["user_name"]==="")){
  header("Location:{$gobackURL}");
  exit();
}


?>
<!DOCTYPE html>
<?php require_once("head.php")?>
<title>貸し借り|検索</title>
</head>
<body>
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
    $stm->execute();
    // 結果の取得（連想配列で受け取る）
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(count($result)>0){
      echo "<script> final(); </script>";
      echo "ユーザ名に「{$user_name}」が含まれているレコード";
      // テーブルのタイトル行
      echo '<table class="table table-striped">';
      echo '<thead><tr>';
      echo '<th>','ユーザ','</th>';
      echo '<th>','コメント','</th>';
      echo '</tr></thead>';
      echo '<tbody>';
      foreach($result as $row){
          echo '<tr>';  
          echo '<td>',es($row['name']);
          echo "<br><a target='_blank' href='profile.php?id={$row['id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row['id']}'></a></td>";
          echo '<td>',es($row['comment']);
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
    </div>
    <!--/メイン-->

    <!--サイド-->
    
      <section id="side_banner">
        <h2>関連リンク</h2>
        <ul>
        <li><a href="notice.php"><img src="images/kanban.png"></a></li>
          <li><a href="../phpmyadmin" target="_blank"><img src="images/banner01.jpg" alt="ブルームブログ"></a></li>
          

          <div class="block-download">
					<p>アプリのダウンロードはコチラ！</p>
					<a href="https://apps.apple.com/jp/app/final-fantasy-x-x-2-hd%E3%83%AA%E3%83%9E%E3%82%B9%E3%82%BF%E3%83%BC/id1297115524" onclick="gtag('event','click', {'event_category': 'download','event_label': 'from-fv-to-appstore','value': '1'});gtag_report_conversion('https://itunes.apple.com/jp/app/%E3%83%95%E3%83%AA%E3%83%9E%E3%81%A7%E3%83%AC%E3%83%B3%E3%82%BF%E3%83%AB-%E3%82%AF%E3%82%AA%E3%83%83%E3%82%BF-%E8%B2%B8%E3%81%97%E5%80%9F%E3%82%8A%E3%81%AE%E3%83%95%E3%83%AA%E3%83%9E%E3%82%A2%E3%83%97%E3%83%AA/id1288431440?l=en&mt=8');" class="btn-download"target="_blank">
						<img src="https://quotta.net/wp-content/themes/quotta_2019/assets/img/common/btn_apple.png" alt="アップルストアでダウンロード" loading="lazy">
					</a>
				</div>
        </ul>
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

</body>
</html>