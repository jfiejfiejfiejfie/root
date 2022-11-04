<?php
  session_start(); 
  require_once('../lib/util.php');
  $gobackURL ='list.php';
  $user='root';
  $password='';
  $dbName = 'wakka1';
  $host = 'localhost:3306';
  $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
  ?>
<!DOCTYPE html>
<html lang="ja" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.faceboook.com/2008/fbml">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="UTF-8">
<meta property="og:title" content="フラワーアレンジメント教室　Bloom【ブルーム】">
<meta property="og:description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】">
<meta property="og:url" content="http://bloom.ne.jp">
<meta property="og:image" content="images/main_visual.jpg">
<title>貸し借り|登録</title>
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
    <?php
    $data=$_GET["id"];
    $_SESSION["loan_id"]=$data;
    try{
      $pdo=new PDO($dsn,$user,$password);
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
      $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT * FROM image_list WHERE list_id=$data";
      $stm = $pdo->prepare($sql);
      $stm->execute();
      $result=$stm->fetchAll(PDO::FETCH_ASSOC);
      $image_count=0;
      foreach($result as $row){
        $image_count+=1;
      }
    }catch(Exception $e){
        echo 'エラーがありました。';
        echo $e->getMessage();
        exit();
    }
        try{
            $pdo=new PDO($dsn,$user,$password);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM list WHERE id=$data";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
            echo '<table class="table table-striped">';
            echo '<thead><tr>';
            echo '<td><img src="image.php?id=',$row['id'],'"style="max-width:200px;">';
            if($image_count>0){
              echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=',$row['id'],'&number=1">
                    <img src="image_next.php?id=',$row['id'],'&number=1"height="150" width="150"></a>';
              if($image_count>1){
                echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=',$row['id'],'&number=2">
                      <img src="image_next.php?id=',$row['id'],'&number=2"height="150" width="150"></a>';
                if($image_count>2){
                  echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=',$row['id'],'&number=3">
                        <img src="image_next.php?id=',$row['id'],'&number=3"height="150" width="150"></a>';
                  if($image_count>3){
                    echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=',$row['id'],'&number=4">
                          <img src="image_next.php?id=',$row['id'],'&number=4"height="150" width="150"></a></td>';
                  }
                }
              }
        }
            echo '</tr>';
            echo '<tr>';
            echo '</thead>';
            echo '</table>';
            //echo "<td><a href=detail.php?id={$row["id"]}>"
            $item=$row["item"];
            $money=$row["money"];
            }
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
        }
    ?><hr>
        <form method="POST" action="detail1.php" enctype="multipart/form-data">
            <ul>
                  <li>
                    <label>貸出物　:
                        <input type="text" name="item" value="<?php echo htmlspecialchars($item); ?>" placeholder="貸出物">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET["id"]);?>">
                    </label>
                  </li>
                  <li>
                    <label>ジャンル:
                        <select name="kind">
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
                              echo '<option value="',$row["name"],'">',$row["name"],"</option>";
                            }
                          ?>
                        </select>
                    </label>
                  </li>
                  <li>
                <label>金額　　:
                        <input type="number_format" name="money" value="<?php echo htmlspecialchars($money); ?>" placeholder="金額" required>
                    </label>
                </li>
                <li>
                  <label>画像選択:<br>
                <label><img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                        <input type="file" name="image"class="test" accept="image/*"  onchange="previewImage(this);">
                          </label>
                          <?php if($image_count>0){?>
                  <label><img src="images/imageplus.png" id="preview2" style="max-width:200px;"><br>
                        <input type="file" name="image2"class="test" accept="image/*"  onchange="previewImage2(this);">
                          </label>
                          <?php if($image_count>1){?>
                  <label><img src="images/imageplus.png" id="preview3" style="max-width:200px;"><br>
                        <input type="file" name="image3"class="test" accept="image/*"  onchange="previewImage3(this);">
                          </label>
                          <?php if($image_count>2){?>
                  <label><img src="images/imageplus.png" id="preview4" style="max-width:200px;"><br>
                        <input type="file" name="image4"class="test" accept="image/*"  onchange="previewImage4(this);">
                          </label>
                          <?php if($image_count>3){?>
                  <label><img src="images/imageplus.png" id="preview5" style="max-width:200px;"><br>
                        <input type="file" name="image5"class="test" accept="image/*"  onchange="previewImage5(this);">
                          </label>
                          <?php }}}}?>
                <li><input type="submit" value="編集する">
                </li>
            </ul>
        </form>
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
        <li><?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){?><a href="contact.php">お問い合わせ💛</a>
      <?php }else{?><a href="register.php">アカウント登録</a><?php }?></li><li><a href="login.php">ログイン</a></li>
      </ul>
    </div>
    <small>&copy; 2015 Bloom.</small>
  </footer>
  <!--/フッター-->

</body>
</html>