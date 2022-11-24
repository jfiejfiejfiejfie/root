<?php
session_start(); 
require_once('../lib/util.php');
$gobackURL = "keijiban.php";
require_once "db_connect.php";
define('MAX','5');
// 文字エンコードの検証
if (!cken($_POST)){
  header("Location:{$gobackURL}");
  exit();
}

// nameが未設定、空のときはエラー
if (empty($_POST)){
    header("Location:searchform.html");
    exit();
  } else if(!isset($_POST["message"])||($_POST["message"]==="")){
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
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5&appId=643231655816289";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  
  <!--ヘッダー-->
		<?php require_once("header.php");?>

<div>
  <!-- 入力フォームを作る -->
  <div id="wrapper">
    <!--メイン-->
    <div id="main">
<section id="point">
        <div>
        <?php
        $message = $_POST["message"];
        try{
            $sql = "SELECT * FROM message WHERE message LIKE(:message)";
    // プリペアドステートメントを作る
    $stm=$pdo->prepare($sql);
    // プレースホルダに値をバインドする
    $stm->bindValue(':message',"%{$message}%",PDO::PARAM_STR);
    // SQL文を実行する
    $stm->execute();
    // 結果の取得（連想配列で受け取る）
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(count($result)>0){
      // echo "<script> final(); </script>";
      echo "コメントに「{$message}」が含まれているレコード";
      // テーブルのタイトル行
    //   echo '<table class="table table-striped">';
    //   echo '<thead><tr>';
    //   echo '<th>','ユーザ','</th>';
    //   echo '<th>','コメント','</th>';
    //   echo '</tr></thead>';
    //   echo '<tbody>';
      foreach($result as $row){
        echo '<table class="table table-striped">';
        echo '<thead><tr>';
        echo '<th>No',$row["id"],' ',$row["view_name"],':';
        echo $row["post_date"],'</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>',$row["message"],'</td>';
        echo '</tr>';
        echo '</thead>';
        echo '</table>';
        }
    } else {
      echo "名前に「{$message}」は見つかりませんでした。";
      // echo "<script> suteki(); </script>";
    }
  } catch (Exception $e) {
    echo '<span class="error">エラーがありました。</span><br>';
    echo $e->getMessage();
  }
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
        <li><a href="register.php">アカウント登録</a></li><li><a href="login.php">ログイン</a></li>
      </ul>
    </div>
    <small>&copy; 2015 Bloom.</small>
  </footer>
  <!--/フッター-->

</body>
</html>