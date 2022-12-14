<?php
  session_start();
  require_once "db_connect.php";
?>
<!DOCTYPE html>
<html lang="ja" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.faceboook.com/2008/fbml">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="UTF-8">
<meta property="og:title" content="フラワーアレンジメント教室　Bloom【ブルーム】">
<meta property="og:description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】">
<meta property="og:url" content="http://bloom.ne.jp">
<meta property="og:image" content="images/main_visual.jpg">
<title>貸し借り|マイページ</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】。一人ひとりに向き合った、その人らしいアレンジメントを考えながら楽しく学べます。初心者の方も安心してご参加ください。">
<link rel="stylesheet" href="css/original.css">
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
<div class="game_bar" style="background-image: url(images/main_visual.jpg);">
		<div class="game_title">
				<a href="index.php"><img src=""class="mr5" /></a>
				<a  href="index.php">貸し借りサイト</a>
			<div id="menu_s">
				<div>
				<div><a href="index.php"><img src="images/home.png"  style="width:70px" /><span>HOME　　　</span></a></div>
				<div><a href="add_db.php"><img src="images/register.png"  style="width:70px" /><span>商品登録　　</span></span></a></div>
				<div><a href="search_sp.php"><img src="images/search.png"  style="width:70px" /><span>検索　　　　</span></span></a></div>
				<div><a href="user_chat_list.php"><img src="https://cdn08.net/dqwalk/data/img0/img2_5.png?6e1"  style="width:70px" /><span>一覧　　　　</span></a></div>
				<div><a href="mypage.php"><img src="https://cdn08.net/dqwalk/data/img0/img93_5.png?87b"  style="width:70px" /><span>マイページ　</span></span></a></div>
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
    <h2>プロフィール</h2>
    <?php
    if(isset($_SESSION["id"])){
    $id=$_SESSION["id"];
    }else{
      $id=0;
    }
    try{
      
      $sql = "SELECT * FROM users WHERE id =:id";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':id',$id,PDO::PARAM_STR);
      $stm->execute();
      $result=$stm->fetchAll(PDO::FETCH_ASSOC);
      foreach($result as $row){
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true){
            echo '<img id="image" height="150" width="150" src="my_image.php?id=',$row["id"],'"><br>';
            echo '<font size="10">',$row["name"],'</font><hr>';
            echo '<font size="5">',$row["age"],'歳</font><br>';
            echo '<font size="5">',$row["sex"],'</font><br>';
            echo '<font size="3">',$row["email"],'</font><br>';
            echo '<hr>コメント<br><font size="10">',$row["comment"],'</font><br>';
            echo '<hr>残金<br><font size="10">￥',number_format($row['money']),'</font><hr>';
            echo '<a href="blocklist.php" class="btn btn-primary">ブロックリスト</a><hr>';
            echo '<a href="edit.php" class="btn btn-primary">編集する</a>';
        }
      }
      if(!isset($_SESSION["loggedin"])){
        echo "ログインをしてください。";
        echo "<a href='login.php' class='btn btn-danger'>ログイン</a>";
      }
    }catch(Exception $e){
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
  }
    ?>
      <?php  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true){ ?>
      <h2>出品中</h2>
      <?php
        try{
            
            $sql = "SELECT * FROM list WHERE user_id=$id and loan=0";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            echo '<table class="table table-striped">';
            echo '<thead><tr>';
            echo '<th>','掲載日','</th>';
            echo '<th>','貸出物','</th>';
            echo '<th>','ジャンル','</th>';
            echo '<th>','金額','</th>';
            echo '<th>','画像','</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            foreach($result as $row){
                echo '<tr>';
                echo '<td>',$row['created_at'],'</td>';
                echo '<td>',$row['item'],'</td>';
                echo '<td>',$row['kind'],'</td>';
                echo '<td>￥',number_format($row['money']),'</td>';
                echo "<td><a href=detail.php?id={$row["id"]}>",'<img height="100" width="100" src="image.php?id=',$row['id'],'"></a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
        }
      ?>
      <?php
      try{
        $count=0;
        
        $sql = "SELECT * FROM likes WHERE my_id=$id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result=$stm->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
          $count+=1;
          $main_list[]=$row["list_id"];
        }
      }catch(Exception $e){
          echo 'エラーがありました。';
          echo $e->getMessage();
          exit();
      }
      ?>
      <?php
        if($count!=0){
          $main_list=implode(",",$main_list);
          
          $sql = "SELECT * FROM list WHERE id IN ($main_list)";
          $stm = $pdo->prepare($sql);
          $stm->execute();
          $result=$stm->fetchAll(PDO::FETCH_ASSOC);
          echo "<h2>「いいね」した商品</h2>";
          echo '<table class="table table-striped">';
          echo '<thead><tr>';
          echo '<th>','掲載日','</th>';
          echo '<th>','貸出物','</th>';
          echo '<th>','ジャンル','</th>';
          echo '<th>','金額','</th>';
          echo '<th>','画像','</th>';
          echo '</tr></thead>';
          echo '<tbody>';
          foreach($result as $row){
              echo '<tr>';
              echo '<td>',$row['created_at'],'</td>';
              echo '<td>',$row['item'],'</td>';
              echo '<td>',$row['kind'],'</td>';
              echo '<td>￥',number_format($row['money']),'</td>';
              echo "<td><a href=detail.php?id={$row["id"]}>",'<img height="100" width="100" src="image.php?id=',$row['id'],'"></a></td>';
              echo '</tr>';
          }
          echo '</tbody>';
          echo '</table>';
        }
      }
      ?>
    </div>
    <!--/メイン-->

    <!--サイド-->
    <aside id="sidebar">
      <section id="side_banner">
        <h2>関連リンク</h2>
        <ul>
        <li><a href="notice.php"><img src="images/kanban.gif"></a></li>
        <li><a href="keijiban.php"><img src="images/keijiban.png" style="width:90%;"></a></li>
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