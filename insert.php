<?php
session_start();
require_once('../lib/util.php');
$gobackURL ='add_db.php';
?>

<!DOCTYPE html>
<?php require_once("head.php")?>
<title>貸し借り</title>
</head>
<body>
<audio id="audio"></audio>
  <?php
  // 簡単なエラー処理
  $errors = [];
  $money=$_POST["money"];
  if (!isset($_POST["money"])||(!ctype_digit($_POST["money"]))) {
    $money=100;
  }
  if($money<100||10000000<=$money){
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
  require_once "db_connect.php";
  $kind_id=$_POST["kind"];
  try{
    
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
		<?php require_once("header.php");?>


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
    <div>
    <?php
    $id=$_SESSION["id"];
    date_default_timezone_set('Asia/Tokyo');
    $created_at=date("Y/m/d H:i:s");
    if($_POST["item"]!=""){
      $item=$_POST["item"];
    }else{
      $lines=file("named1.txt",FILE_IGNORE_NEW_LINES);
      $lines2=file("named2.txt",FILE_IGNORE_NEW_LINES);
      $item="{$lines[rand(0,7)]}{$lines2[rand(0,6)]}";
    }
    $comment=$_POST["comment"];
    $upfile = $_FILES["image"]["tmp_name"];
    $imgdat = file_get_contents($upfile);

        try{
            
            
            $sql="INSERT INTO list (created_at,user_id,item,comment,money,kind,image) VALUES(:created_at,:id,:item,:comment,:money,:kind,:imgdat)";
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
            $sql = 'SELECT * FROM list WHERE created_at = :created_at';
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':created_at',$created_at,PDO::PARAM_STR);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
              $list_id=$row["id"];
            }
            if(isset($_FILES["image2"])&&($_FILES["image2"]["tmp_name"]!='')){
              $upfile = $_FILES["image2"]["tmp_name"];
              $imgdat = file_get_contents($upfile);
              $sql="INSERT INTO image_list (list_id,image,number) VALUES(:list_id,:imgdat,:number)";
              $stm=$pdo->prepare($sql);
              $stm->bindValue(':list_id',$list_id,PDO::PARAM_STR);
              $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
              $stm->bindValue(':number',1,PDO::PARAM_STR);
              $stm->execute();
            }
            if(isset($_FILES["image3"])&&($_FILES["image3"]["tmp_name"]!='')){
              $upfile = $_FILES["image3"]["tmp_name"];
              $imgdat = file_get_contents($upfile);
              $sql="INSERT INTO image_list (list_id,image,number) VALUES(:list_id,:imgdat,:number)";
              $stm=$pdo->prepare($sql);
              $stm->bindValue(':list_id',$list_id,PDO::PARAM_STR);
              $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
              $stm->bindValue(':number',2,PDO::PARAM_STR);
              $stm->execute();
            }
            if(isset($_FILES["image4"])&&($_FILES["image4"]["tmp_name"]!='')){
              $upfile = $_FILES["image4"]["tmp_name"];
              $imgdat = file_get_contents($upfile);
              $sql="INSERT INTO image_list (list_id,image,number) VALUES(:list_id,:imgdat,:number)";
              $stm=$pdo->prepare($sql);
              $stm->bindValue(':list_id',$list_id,PDO::PARAM_STR);
              $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
              $stm->bindValue(':number',3,PDO::PARAM_STR);
              $stm->execute();
            }
            if(isset($_FILES["image5"])&&($_FILES["image5"]["tmp_name"]!='')){
              $upfile = $_FILES["image5"]["tmp_name"];
              $imgdat = file_get_contents($upfile);
              $sql="INSERT INTO image_list (list_id,image,number) VALUES(:list_id,:imgdat,:number)";
              $stm=$pdo->prepare($sql);
              $stm->bindValue(':list_id',$list_id,PDO::PARAM_STR);
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