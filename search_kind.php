<?php
session_start(); 
require_once('../lib/util.php');
$gobackURL = "search_sp.php";

// 文字エンコードの検証
if (!cken($_POST)){
  header("Location:{$gobackURL}");
  exit();
}

// nameが未設定、空のときはエラー
if(isset($_GET["kind_name"])){
  $kind_name=$_GET["kind_name"];
}
else if (empty($_POST)){
  header("Location:{$gobackURL}");
  exit();
} else if(!isset($_POST["kind_name"])||($_POST["kind_name"]==="")){
  header("Location:{$gobackURL}");
  exit();
}

// データベースユーザ
$user = 'root';
$password = '';
// 利用するデータベース
$dbName = 'wakka1';
// MySQLサーバ
$host = 'localhost:3306';
// MySQLのDSN文字列
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
if(!isset($_GET["kind_name"])){
$kind_id=$_POST["kind_name"];
try{
  $pdo=new PDO($dsn,$user,$password);
  $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM kind WHERE id=$kind_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $kind=$stm->fetchAll(PDO::FETCH_ASSOC);
  foreach($kind as $row){
    $kind_name=$row["name"];
  }
}catch(Exception $e){
  echo 'エラーがありました。';
  echo $e->getMessage();
  exit();
}
}
?>
<!DOCTYPE html>
<html lang="ja" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.faceboook.com/2008/fbml">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="UTF-8">
<meta property="og:title" content="フラワーアレンジメント教室　Bloom【ブルーム】">
<meta property="og:description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】">
<meta property="og:url" content="http://bloom.ne.jp">
<meta property="og:image" content="">
<title>貸し借り|検索</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】。一人ひとりに向き合った、その人らしいアレンジメントを考えながら楽しく学べます。初心者の方も安心してご参加ください。">
<link rel="stylesheet" href="css/styled.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="css/common.css">
<link rel="stylesheet" href="css/l.css">
<link rel="stylesheet" href="css/m.css">
<link rel="stylesheet" href="css/s.css">
<link rel="favicon.ico">
<link rel="apple-touch-icon" href="webclip152.png">
<script src="js/original.js">
</script>
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
		<div id="header">
<div class="game_bar" style="background-image: url();">
		<div class="game_title">
				<a href="all.php"><img src=""class="mr5" /></a>
				<a  href="all.php">貸し借りサイト</a>
			<div id="menu_s">
				<div>
				<div><a href="all.php"><img src="images/home.png"  style="width:70px" /><span>HOME</span></a></div>
				<div><a href="add_db.php"><img src="images/register.png"  style="width:70px" /><span>商品登録</span></span></a></div>
				<div><a href="search_sp.php"><img src="images/search.png"  style="width:70px" /><span>検索</span></span></a></div>
				<div><a href="list.php"><img src="https://cdn08.net/dqwalk/data/img0/img2_5.png?6e1"  style="width:70px" /><span>一覧</span></a></div>
				<div><a href="mypage.php"><img src="https://cdn08.net/dqwalk/data/img0/img93_5.png?87b"  style="width:70px" /><span>マイページ</span></span></a></div>
				<div><a href="contact.php"><img src="images/contact.png"  style="width:70px" /><span>お問い合わせ</span></a></div>
			</div>
			</div>
			<?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true){
          ?>
          <a href="javascript:if(confirm('ログアウトしますか？')) location.href='logout.php';"  style="width:30px;"><img height="30" width="30" src="my_image.php?id=<?php echo $_SESSION["id"];?>" style="border-radius: 50%"/></a>

        <?php }else{?>
          <a href="javascript:location.href='login.php';" style="width:30px;" class="open_login_menu pl5 pr5"><img src="https://cdn08.net/pokemongo/wiki/login.png" alt="ログイン"></a>		
                            <?php }?>
		</div>
		</div>

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
                                  try{
                                    $pdo=new PDO($dsn,$user,$password);
                                    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                                    $sql = "SELECT * FROM kind";
                                    $stm = $pdo->prepare($sql);
                                    $stm->execute();
                                    $kind=$stm->fetchAll(PDO::FETCH_ASSOC);
                                }catch(Exception $e){
                                    echo 'エラーがありました。';
                                    echo $e->getMessage();
                                    exit();
                                }
                            foreach($kind as $row){
                              echo '<option value="',$row["id"],'">',$row["name"],"</option>";
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
  //MySQLデータベースに接続する
  try {
    $pdo = new PDO($dsn, $user, $password);
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // SQL文を作る
    $sql = "SELECT * FROM main WHERE kind LIKE(:item) and loan=0";
    //$sql = "SELECT * FROM main where item='$item'";
    // プリペアドステートメントを作る
    $stm=$pdo->prepare($sql);
    // プレースホルダに値をバインドする
    $stm->bindValue(':item',$kind_name,PDO::PARAM_STR);
    // SQL文を実行する
    $stm->execute();
    // 結果の取得（連想配列で受け取る）
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(count($result)>0){
      echo "ジャンル:{$kind_name}";
      // テーブルのタイトル行
      echo '<table class="table table-striped">';
            echo '<thead><tr>';
            echo '<th>','貸出者','</th>';
            echo '<th>','貸出物','</th>';
            echo '<th>','ジャンル','</th>';
            echo '<th>','金額','</th>';
            echo '<th>','画像','</th>';
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
              if($_SESSION["admin"]==1){
              echo '<th>','削除','</th>';
              }
            }
            echo '</tr></thead>';
            echo '<tbody>';
            foreach($result as $row){
                echo '<tr>';
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                  if($row['member']===$_SESSION['name']){
                    echo '<td id="color">',es($row['member']);
                  }else{
                    echo '<td>',es($row['member']);
                  }
                }else{
                  echo '<td>',es($row['member']);
                }
                echo "<br><a target='_blank' href='profile.php?id={$row['member_id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row['member_id']}'></a></td>";
                echo '<td>',es($row['item']),'</td>';
                echo '<td>',$row['kind'],'</td>';
                echo '<td>￥',number_format($row['money']),'</td>';
                echo "<td><a target='_blank' href=detail.php?id={$row["id"]}>",'<img height="100" width="100" src="image.php?id=',$row['id'],'"></a></td>';
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                  if($_SESSION["admin"]==1){
                    $row['id']=rawurlencode($row['id']);
                    echo "<td><a class = 'btn btn-primary' href=delete.php?id={$row["id"]}>","消す",'</a></td>';
                    }
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
    } else {
      echo "名前に「{$kind_name}」は見つかりませんでした。";
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
      
    </aside>
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