<?php
session_start();
require_once('../lib/util.php');
$gobackURL = "searchform.php";

// 文字エンコードの検証
if (!cken($_POST)){
  header("Location:{$gobackURL}");
  exit();
}

// nameが未設定、空のときはエラー
if (empty($_POST)){
  header("Location:searchform.html");
  exit();
} else if(!isset($_POST["item"])||($_POST["item"]==="")){
  header("Location:{$gobackURL}");
  exit();
}


?>

<!DOCTYPE html>
<html lang="ja" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.faceboook.com/2008/fbml">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="UTF-8">
<meta property="og:title" content="フラワーアレンジメント教室　Bloom【ブルーム】">
<meta property="og:description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】">
<meta property="og:url" content="http://bloom.ne.jp">
<meta property="og:image" content="images/main_visual.jpg">
<title>フラワーアレンジメント教室 Bloom</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】。一人ひとりに向き合った、その人らしいアレンジメントを考えながら楽しく学べます。初心者の方も安心してご参加ください。">
<link rel="stylesheet" href="css/styled.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="shortcut icon" href="favicon.ico">
<link rel="apple-touch-icon" href="webclip152.png">
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5&appId=643231655816289";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  
  <!--ヘッダー-->
  <header>
    <h1><a href="index.php"><img src="images/logo.png" alt="フラワーアレンジメント教室ブルーム" ></a></h1>
    <div id="header_contact"><a href="login.php"><?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){?><img src="images/logout.png"<?php }else{?><img src="images/btn_contact.jpg"<?php }?> alt="お問い合わせ"></a></div>
    <nav id="global_navi">
      <ul>
        <li><a href="index.php">HOME</a></li>
        <li><a href="add_db.php">登録</a></li>
        <li class="current"><a href="user_chat_list.php">一覧</a></li>
        <li><a href="mypage.php">マイページ</a></li>
        <li><a href="register.php">アカウント登録</a></li>
      </ul>
    </nav>
  </header>
  <!--/ヘッダー-->

  <!--メインビジュアル画像-->
  <div id="main_visual">
    <p><img src="images/main_visual.jpg" alt="あなただけのアレンジメントに出会えるフラワーアレンジメント教室"></p>
  </div>
  <!--/メインビジュアル画像-->

  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <section id="point">
      <div>
  <?php
  $item = $_POST["item"];
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
    $stm->execute();
    // 結果の取得（連想配列で受け取る）
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(count($result)>0){
      echo "名前に「{$item}」が含まれているレコード";
      // テーブルのタイトル行
            echo '<table>';
            echo '<thead><tr>';
            echo '<th>','ID','</th>';
            echo '<th>','掲載日','</th>';
            echo '<th>','貸出者','</th>';
            echo '<th>','貸出物','</th>';
            echo '<th>','コメント','</th>';
            echo '<th>','画像','</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            foreach($result as $row){
                echo '<tr>';
                echo '<td>',es($row['id']),'</td>';
                echo '<td>',es($row['created_at']),'</td>';
                $user_id=$row["user_id"];
                $sql = "SELECT * FROM users WHERE id=$user_id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result2=$stm->fetchAll(PDO::FETCH_ASSOC);
                foreach($result2 as $row2){
                  echo '<td>',$row2["name"];
                }
                echo '<td>',es($row['item']),'</td>';
                echo '<td>',es($row['comment']),'</td>';
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
  ?>
  <hr>
  <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
      </section>
    </div>
    <!--/メイン-->

    <!--サイド-->
    <aside id="sidebar">
      <section id="side_banner">
        <h2>関連リンク</h2>
        <ul>
          <li><a href="../phpmyadmin" target="_blank"><img src="images/banner01.jpg" alt="ブルームブログ"></a></li>
          <li><a href="../DQ5ierukana/dq5.html" target="_blank"><img src="images/banner02.jpg" alt="イイネ！押してね！facebookページ"></a></li>
        </ul>
      </section>
      <section id="side_contact">
        <h2>ご予約・お問い合わせ</h2>
        <address><i class="fa fa-phone"></i>052-232-8229</address>
        <p>受付時間 9:00〜18:00</p>
        <p><a href="akaunt.html" class="contact_button">お問い合わせフォーム</a></p>
      </section>
      <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://bloom.ne.jp" data-text="あなただけのフラワーアレンジメント教室Bloom">Tweet</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    </aside>
    <!--/サイド-->
  </div>
  <!--/wrapper-->

  <!--フッター-->
  <footer>
    <div id="footer_nav">
    <ul>
        <li class="current"><a href="index.php">HOME</a></li>
        <li><a href="add_db.php">登録</a></li>
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