<?php
  session_start();
  require_once "db_connect.php";
?>
<!DOCTYPE html>
<?php require_once("head.php")?>
<title>貸し借り|HOME</title>
<link rel="stylesheet" href="css/top.css">
</head>
<body>
<audio id="audio"></audio>
<div id="fb-root"></div>

  
  <!--ヘッダー-->
  <?php require_once("header.php");?>

  <div id="wrapper">
    <!--メイン-->
    <div id="main">
		<h1>最近投稿されたもの</h1>
		<table>
			<?php
				echo '<tr>';
				$count=0;
				$sql = "SELECT * FROM list ORDER BY created_at DESC LIMIT 4";
				$stm = $pdo->prepare($sql);
				$stm->execute();
				$result=$stm->fetchAll(PDO::FETCH_ASSOC);
				foreach($result as $row){
					echo '<div class="container mt-3">';
					echo '<td class="border border-dark">';
					echo'<div class="sample5"><a href=detail.php?',"id={$row["id"]}>";
					echo '<img id="parent" src="image.php?id=',$row["id"],' alt="" height="232" width="232"/>';
					if($row["loan"]==1){
					echo '<img id="child" src="images/sold.png" height="232" width="232"/>';
					}
					echo '<div class="mask">';
					echo '<div class="caption">',$row["item"],'</div>';
					echo '<div class="price"><p class="rainbow">￥',number_format($row["money"]),'</p></div>';
					echo '</div></div></a></td></div>';
				}
				echo "</tr>";
			?>
		</table>
      <section id="sec-feature">
					<div class="feature-01">
						<div class="sec_inner">
							<div class="feature_cont">
								<div class="feature_cont_img">
									<div class="num"><span class="en">53</span></div>
									<img src="images/gomi.png" class="illust-01" loading="lazy">
									<img src="images/image1.png" alt="使いたいモノをレンタルしよう♪" class="img-screen" loading="lazy">
								</div>
								<!-- /feature_cont_img -->
								<div class="feature_cont_txt">
									<h3>使いたい物を<br>レンタルしよう♪</h3>
									<p>カメラ、ドレス、腕時計、家電など様々な商品を、<br class="spNone">個人間なので<span class="is-bold">安い価格でレンタル</span>出来ます。<br class="spNone"><span class="is-bold">お支払いはクレジット決済</span>でらくらく。<br class="spNone">個人間での取引のため消費税もかかりません。</p>
								</div>
								<!-- /feature_cont_txt -->
							</div>
							<!-- /feature_cont -->
						</div>
						<!-- /sec_inner -->
					</div>
					<!-- /feature-01 -->
					<div class="feature-02">
						<div class="sec_inner">
							<div class="feature_cont">
								<div class="feature_cont_img">
									<div class="num"><span class="en">53</span></div>
									<img src="images/kuso.png"  class="illust-02" loading="lazy">
									<img src="images/image2.png" width="290" height="390" alt="使いたいモノをレンタルしよう♪" class="img-screen" loading="lazy">
								</div>
								<!-- /feature_cont_img -->
								<div class="feature_cont_txt">
									<h3>使っていない物を<br>貸してみよう!</h3>
									<p>まるでメルカリの様に<span class="is-bold">3分でかんたん出品。</span><br class="spNone">副業にもおススメ。<br class="spNone">個人間レンタルで<br class="spNone">お金を稼ごう♪</p>
								</div>
								<!-- /feature_cont_txt -->
							</div>
							<!-- /feature_cont -->
						</div>
						<!-- /sec_inner -->
					</div>
					
					<!-- /feature-02 -->
					<div class="feature-03">
						<div class="sec_inner">
							<div class="feature_cont">
								<div class="feature_cont_img">
									<div class="num"><span class="en">53</span></div>
									<img src="images/gomi.png"  class="illust-03" loading="lazy">
									<img src="images/ketuana.png" width="265" height="400" alt="安心への取り組みも充実" class="img-screen" loading="lazy">
								</div>
								<!-- /feature_cont_img -->
								<div class="feature_cont_txt">
									<h3>安心への取り組みも<br>充実</h3>
									<p>電話番号と身分証で本人確認があり、<br class="spNone">レンタルにはWAKKA独自の審査を設けています。<br class="spNone">貸し出す商品代を確保する<br class="spNone">デポジット機能があります。</p>
								</div>
								<!-- /feature_cont_txt -->
							</div>
							<!-- /feature_cont -->
						</div>
						<!-- /sec_inner -->
					</div>
					<!-- /feature-03 -->
				</section>
				<!-- /sec-feature -->
        </div>
				<!-- /sec-faq -->
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