<?php
session_start(); 
require_once('../lib/util.php');
require_once "db_connect.php";
date_default_timezone_set('Asia/Tokyo');
$list_id=$_POST["list_id"];
$gobackURL ="loan.php?id={$list_id}";
$id=$_SESSION["id"];
$text=$_POST["text"];
if($_FILES["image"]["tmp_name"]==""){
$imgdat="";
}else{
  $upfile = $_FILES["image"]["tmp_name"];
  $imgdat = file_get_contents($upfile);
}
$name=$_SESSION["name"];
$date = date('Y-m-d H:i:s');
try{
    
    $sql = "INSERT INTO chat (user_id,created_at,text,list_id,image) VALUES(:user_id,:date,:text,:list_id,:imgdat)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id',$id,PDO::PARAM_STR);
    $stm->bindValue(':date',$date,PDO::PARAM_STR);
    $stm->bindValue(':text',$text,PDO::PARAM_STR);
    $stm->bindValue(':list_id',$list_id,PDO::PARAM_STR);
    $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
}catch(Exception $e){
    echo 'エラーがありました。';
    echo $e->getMessage();
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
<title>貸し借り|詳細</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】。一人ひとりに向き合った、その人らしいアレンジメントを考えながら楽しく学べます。初心者の方も安心してご参加ください。">
<link rel="stylesheet" href="css/styled.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/original.css">
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

  
  <!--ヘッダー-->
  	<div id="header">
<div class="game_bar" style="background-image: url(images/main_visual.jpg);">
		<div class="game_title">
				<a href="all.php"><img src=""class="mr5" /></a>
				<a  href="all.php">貸し借りサイト</a>
			<div id="menu_s">
				<div>
				<div><a href="all.php"><img src="images/home.png" alt="最新情報" style="width:70px" /><span>HOME</span></a></div>
				<div><a href="add_db.php"><img src="images/register.png" alt="ツール" style="width:70px" /><span>商品登録</span></span></a></div>
				<div><a href="search_sp.php"><img src="images/register.png" alt="ツール" style="width:70px" /><span>検索</span></span></a></div>
				<div><a href="list.php"><img src="https://cdn08.net/dqwalk/data/img0/img2_5.png?6e1" alt="掲示板" style="width:70px" /><span>一覧</span></a></div>
				<div><a href="mypage.php"><img src="https://cdn08.net/dqwalk/data/img0/img93_5.png?87b" alt="ﾗﾝｷﾝｸﾞ" style="width:70px" /><span>マイページ</span></span></a></div>
				<div><a href="contact.php"><img src="images/contact.png" alt="3周年" style="width:70px" /><span>お問い合わせ</span></a></div>
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
  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <section id="point">
        <h2>送信完了</h2>
        <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
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