<?php
session_start();
require_once('../lib/util.php');
$gobackURL ='add_db.php';
?>

<!DOCTYPE html>
<html lang="ja" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.faceboook.com/2008/fbml">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="UTF-8">
<meta property="og:title" content="フラワーアレンジメント教室　Bloom【ブルーム】">
<meta property="og:description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】">
<meta property="og:url" content="http://bloom.ne.jp">
<meta property="og:image" content="images/main_visual.jpg">
<title>貸し借り</title>
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
  <?php
  // 簡単なエラー処理
  $errors = [];
  if (!isset($_POST["money"])||(!ctype_digit($_POST["money"]))) {
    $errors[] = "金額が整数値ではありません。";
  }
  if($_POST["money"]<100||10000000<=$_POST["money"]){
    $errors[]="金額を100円以上10,000,000未満にしてください。";
  }
  //エラーがあったとき
  if (count($errors)>0){
    echo "<script> rikki(); </script>";
    echo "<img src='images/main_visual.jpg'>";
    echo '<ol class="error">';
    foreach ($errors as $value) {
      echo "<li>", $value , "</li>";
    }
    echo "</ol>";
    echo "<hr>";
    echo "<a href=", $gobackURL, ">戻る</a><br>";
    exit();
  }
  $user='root';
  $password='';
  $dbName = 'wakka1';
  $host = 'localhost:3306';
  $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
  $kind_id=$_POST["kind"];
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
  ?>
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
<div class="game_bar" style="background-image: url(images/main_visual.jpg);">
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


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
    <div>
    <?php
    $id=$_SESSION["id"];
    date_default_timezone_set('Asia/Tokyo');
    $created_at=date("Y/m/d H:i:s");
    $item=$_POST["item"];
    $comment=$_POST["comment"];
    $money=$_POST["money"];
    $upfile = $_FILES["image"]["tmp_name"];
    $imgdat = file_get_contents($upfile);

        try{
            $pdo=new PDO($dsn,$user,$password);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $sql="INSERT INTO main (created_at,user_id,item,comment,money,kind,image) VALUES(:created_at,:id,:item,:comment,:money,:kind,:imgdat)";
            $stm=$pdo->prepare($sql);
            $stm->bindValue(':created_at',$created_at,PDO::PARAM_STR);
            $stm->bindValue(':id',$id,PDO::PARAM_STR);
            $stm->bindValue(':item',$item,PDO::PARAM_STR);
            $stm->bindValue(':comment',$comment,PDO::PARAM_STR);
            $stm->bindValue(':money',$money,PDO::PARAM_STR);
            $stm->bindValue(':kind',$kind_name,PDO::PARAM_STR);
            $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
            if($stm->execute()){
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
<<<<<<< HEAD
            $sql = 'SELECT * FROM main WHERE created_at = :created_at';
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':created_at',$created_at,PDO::PARAM_STR);
=======
            $sql = 'SELECT * FROM main WHERE today = :today';
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':today',$today,PDO::PARAM_STR);
>>>>>>> root/master
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
              $image_id=$row["id"];
            }
            if(isset($_FILES["image2"])&&($_FILES["image2"]["tmp_name"]!='')){
              $upfile = $_FILES["image2"]["tmp_name"];
              $imgdat = file_get_contents($upfile);
              $sql="INSERT INTO image_list (image_id,image,number) VALUES(:image_id,:imgdat,:number)";
              $stm=$pdo->prepare($sql);
              $stm->bindValue(':image_id',$image_id,PDO::PARAM_STR);
              $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
              $stm->bindValue(':number',1,PDO::PARAM_STR);
              $stm->execute();
            }
            if(isset($_FILES["image3"])&&($_FILES["image3"]["tmp_name"]!='')){
              $upfile = $_FILES["image3"]["tmp_name"];
              $imgdat = file_get_contents($upfile);
              $sql="INSERT INTO image_list (image_id,image,number) VALUES(:image_id,:imgdat,:number)";
              $stm=$pdo->prepare($sql);
              $stm->bindValue(':image_id',$image_id,PDO::PARAM_STR);
              $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
              $stm->bindValue(':number',2,PDO::PARAM_STR);
              $stm->execute();
            }
            if(isset($_FILES["image4"])&&($_FILES["image4"]["tmp_name"]!='')){
              $upfile = $_FILES["image4"]["tmp_name"];
              $imgdat = file_get_contents($upfile);
              $sql="INSERT INTO image_list (image_id,image,number) VALUES(:image_id,:imgdat,:number)";
              $stm=$pdo->prepare($sql);
              $stm->bindValue(':image_id',$image_id,PDO::PARAM_STR);
              $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
              $stm->bindValue(':number',3,PDO::PARAM_STR);
              $stm->execute();
            }
            if(isset($_FILES["image5"])&&($_FILES["image5"]["tmp_name"]!='')){
              $upfile = $_FILES["image5"]["tmp_name"];
              $imgdat = file_get_contents($upfile);
              $sql="INSERT INTO image_list (image_id,image,number) VALUES(:image_id,:imgdat,:number)";
              $stm=$pdo->prepare($sql);
              $stm->bindValue(':image_id',$image_id,PDO::PARAM_STR);
              $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
              $stm->bindValue(':number',4,PDO::PARAM_STR);
              $stm->execute();
            }
            echo "<h1>登録しました。</h1>";
        }else{
            echo "ツイカエラーガアリマシタ。";
        }
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
        }
    ?>
    <hr>
    <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
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