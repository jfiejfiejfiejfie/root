<?php
  session_start(); 
  require_once('../lib/util.php');
  $gobackURL ="my_edit.php?id={$_POST["id"]}";
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
  if($_POST["money"]<100){
    $errors[]="金額を100円以上にしてください。";
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
  require_once "db_connect.php";
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
		<?php require_once("header.php");?>

  <div id="wrapper">
    <!--メイン-->
    <div id="main">
    <h1>変更完了しますた。</h1>
  <?php
    date_default_timezone_set('Asia/Tokyo');
    $created_at=date("Y/m/d H:i:s");
    $id=$_SESSION["loan_id"];
    $item=$_POST["item"];
    $money=$_POST["money"];
    $kind=$_POST["kind"];
        try{
            
            $sql="UPDATE list SET item = :item, money = :money,created_at=:created_at,kind=:kind where id = $id";
            $stm=$pdo->prepare($sql);
            $stm->bindValue(':item',$item,PDO::PARAM_STR);
            // $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
            
            $stm->bindValue(':created_at',$created_at,PDO::PARAM_STR);
            $stm->bindValue(':money',$money,PDO::PARAM_STR);
            $stm->bindValue(':kind',$kind,PDO::PARAM_STR);
            if($stm->execute()){
              if(isset($_FILES["image"])&&($_FILES["image"]["tmp_name"]!='')){
                $upfile = $_FILES["image"]["tmp_name"];
                $imgdat = file_get_contents($upfile);
                $sql="UPDATE list SET image = :imgdat WHERE id=$id";
                $stm=$pdo->prepare($sql);
                $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
                $stm->execute();
              }
              if(isset($_FILES["image2"])&&($_FILES["image2"]["tmp_name"]!='')){
                $upfile = $_FILES["image2"]["tmp_name"];
                $imgdat = file_get_contents($upfile);
                $sql="UPDATE image_list SET image = :imgdat WHERE list_id=$id and number=:number";
                $stm=$pdo->prepare($sql);
                $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
                $stm->bindValue(':number',1,PDO::PARAM_STR);
                $stm->execute();
              }
              if(isset($_FILES["image3"])&&($_FILES["image3"]["tmp_name"]!='')){
                $upfile = $_FILES["image3"]["tmp_name"];
                $imgdat = file_get_contents($upfile);
                $sql="UPDATE image_list SET image = :imgdat WHERE list_id=$id and number=:number";
                $stm=$pdo->prepare($sql);
                $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
                $stm->bindValue(':number',2,PDO::PARAM_STR);
                $stm->execute();
              }
              if(isset($_FILES["image4"])&&($_FILES["image4"]["tmp_name"]!='')){
                $upfile = $_FILES["image4"]["tmp_name"];
                $imgdat = file_get_contents($upfile);
                $sql="UPDATE image_list SET image = :imgdat WHERE list_id=$id and number=:number";
                $stm=$pdo->prepare($sql);
                $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
                $stm->bindValue(':number',3,PDO::PARAM_STR);
                $stm->execute();
              }
              if(isset($_FILES["image5"])&&($_FILES["image5"]["tmp_name"]!='')){
                $upfile = $_FILES["image5"]["tmp_name"];
                $imgdat = file_get_contents($upfile);
                $sql="UPDATE image_list SET image = :imgdat WHERE list_id=$id and number=:number";
                $stm=$pdo->prepare($sql);
                $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
                $stm->bindValue(':number',4,PDO::PARAM_STR);
                $stm->execute();
              }
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
    <!--/メイン-->
    </div>
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
        <li><?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){?><a href="contact.php">お問い合わせ💛</a>
      <?php }else{?><a href="register.php">アカウント登録</a><?php }?></li><li><a href="login.php">ログイン</a></li>
      </ul>
    </div>
    <small>&copy; 2015 Bloom.</small>
  </footer>
  <!--/フッター-->

</body>
</html>