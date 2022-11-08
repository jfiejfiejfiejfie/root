<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="ja" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.faceboook.com/2008/fbml">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="UTF-8">
<meta property="og:title" content="フラワーアレンジメント教室　Bloom【ブルーム】">
<meta property="og:description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】">
<meta property="og:url" content="http://bloom.ne.jp">
<meta property="og:image" content="images/main_visual.jpg">
<title>貸し借り|HOME</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="東京都千代田区にあるフラワーアレンジメント教室Bloom【ブルーム】。一人ひとりに向き合った、その人らしいアレンジメントを考えながら楽しく学べます。初心者の方も安心してご参加ください。">
<link rel="stylesheet" href="css/styled.css">
<link rel="stylesheet" href="css/original.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="favicon.ico">
<link rel="apple-touch-icon" href="webclip152.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="css/common.css">
<link rel="stylesheet" href="css/l.css">
<link rel="stylesheet" href="css/m.css">
<link rel="stylesheet" href="css/s.css">
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
				<div><a href="all.php"><img src="images/home.png"  style="width:70px" /><span>HOME　　　</span></a></div>
				<div><a href="add_db.php"><img src="images/register.png"  style="width:70px" /><span>商品登録　　</span></span></a></div>
				<div><a href="search_sp.php"><img src="images/search.png"  style="width:70px" /><span>検索　　　　</span></span></a></div>
				<div><a href="list.php"><img src="https://cdn08.net/dqwalk/data/img0/img2_5.png?6e1"  style="width:70px" /><span>一覧　　　　</span></a></div>
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
    <ul class="article-list">
          <li class="article-list-item  article-promoted">
              <span data-title="ピックアップ記事" class="icon-star"></span>
            <a href="/hc/ja/articles/360006902153-%E4%BA%BA%E6%B0%97%E3%81%AE%E3%81%82%E3%82%8B%E5%95%86%E5%93%81" class="article-list-link">人気のある商品</a>
          </li>
          <li class="article-list-item  article-promoted">
              <span data-title="ピックアップ記事" class="icon-star"></span>
            <a href="/hc/ja/articles/360000784034-%E5%AE%89%E5%85%A8%E3%81%B8%E3%81%AE%E5%8F%96%E3%82%8A%E7%B5%84%E3%81%BF" class="article-list-link">安全への取り組み</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/900004386506-%E6%89%8B%E6%B8%A1%E3%81%97%E5%A0%B4%E6%89%80%E3%82%92%E6%B6%88%E5%8E%BB%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95" class="article-list-link">手渡し場所を消去する方法</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/900002061083-%E3%82%AF%E3%83%AC%E3%82%B8%E3%83%83%E3%83%88%E3%82%AB%E3%83%BC%E3%83%89%E3%81%AE%E5%A4%89%E6%9B%B4" class="article-list-link">クレジットカードの変更</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/900001969263-%E9%A0%98%E5%8F%8E%E6%9B%B8%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6" class="article-list-link">領収書について</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/900001465406-%E3%83%97%E3%83%AC%E3%83%9F%E3%82%A2%E3%83%A0%E5%95%86%E5%93%81%E3%81%AE%E8%A3%9C%E5%84%9F%E9%87%91" class="article-list-link">プレミアム商品の補償金</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/900001446786-%E3%82%AF%E3%82%AA%E3%83%83%E3%82%BFandroid%E7%89%88" class="article-list-link">クオッタandroid版</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/900000940863-%E5%95%86%E5%93%81%E3%81%AE%E7%A0%B4%E6%90%8D%E3%81%A8%E7%B4%9B%E5%A4%B1%E3%81%AE%E3%83%88%E3%83%A9%E3%83%96%E3%83%AB" class="article-list-link">商品の破損と紛失のトラブル</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/900000402506-%E8%B2%B7%E3%81%84%E5%8F%96%E3%82%8A%E3%81%AE%E5%A0%B4%E5%90%88" class="article-list-link">買い取りの場合</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/900000327586-%E5%A3%B2%E4%B8%8A%E3%81%AE%E5%8F%8D%E6%98%A0%E3%81%AE%E3%82%BF%E3%82%A4%E3%83%9F%E3%83%B3%E3%82%B0" class="article-list-link">売上の反映のタイミング</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/900000026603-%E3%83%87%E3%83%9D%E3%82%B8%E3%83%83%E3%83%88-%E4%BF%9D%E8%A8%BC%E9%87%91-" class="article-list-link">デポジット（保証金）</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360000289881-%E9%80%9A%E7%9F%A5%E8%A8%AD%E5%AE%9A" class="article-list-link">通知設定</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360000276341-%E6%89%8B%E6%B8%A1%E3%81%97%E3%81%A7%E3%81%AE%E3%81%8A%E5%8F%96%E5%BC%95" class="article-list-link">手渡しでのお取引</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360000233042-%E8%BF%BD%E5%8A%A0%E8%AB%8B%E6%B1%82" class="article-list-link">追加請求</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360020108514-%E9%80%81%E6%96%99%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6" class="article-list-link">送料について</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360015345914-%E5%86%8D%E5%87%BA%E5%93%81%E3%81%AE%E6%96%B9%E6%B3%95" class="article-list-link">再出品の方法</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360013576794-%E6%94%AF%E6%89%95%E3%81%84-%E6%B1%BA%E6%B8%88%E6%96%B9%E6%B3%95%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6" class="article-list-link">支払い・決済方法について</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360012466593-%E5%BB%B6%E9%95%B7%E6%96%99%E9%87%91%E3%81%AE%E8%AB%8B%E6%B1%82%E6%96%B9%E6%B3%95" class="article-list-link">延長料金の請求方法</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360011191214-%E6%89%8B%E6%95%B0%E6%96%99%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6" class="article-list-link">手数料について</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360009818034-%E3%82%A2%E3%83%97%E3%83%AA%E3%81%AE%E4%B8%8D%E5%85%B7%E5%90%88-%E3%83%90%E3%82%B0-%E3%82%A8%E3%83%A9%E3%83%BC" class="article-list-link">アプリの不具合・バグ・エラー</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360009927033-%E3%83%88%E3%83%A9%E3%83%96%E3%83%AB%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6" class="article-list-link">トラブルについて</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360009347914-%E5%8F%96%E5%BC%95%E3%81%AE%E6%B5%81%E3%82%8C" class="article-list-link">取引の流れ</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360006377754-%E9%80%80%E4%BC%9A%E6%96%B9%E6%B3%95" class="article-list-link">退会方法</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360006200914-%E5%88%A9%E7%94%A8%E8%A6%8F%E7%B4%84-%E3%83%97%E3%83%A9%E3%82%A4%E3%83%90%E3%82%B7%E3%83%BC%E3%83%9D%E3%83%AA%E3%82%B7%E3%83%BC" class="article-list-link">利用規約・プライバシーポリシー</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360005920914-%E5%87%BA%E5%93%81%E3%82%92%E7%A6%81%E6%AD%A2%E3%81%97%E3%81%A6%E3%81%84%E3%82%8B%E5%95%86%E5%93%81" class="article-list-link">出品を禁止している商品</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360004527393-%E8%B2%B8%E5%87%BA%E6%9C%9F%E9%96%93" class="article-list-link">貸出期間</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360003410453-%E5%A3%B2%E4%B8%8A%E9%87%91%E3%81%AF%E3%81%84%E3%81%A4%E6%8C%AF%E3%82%8A%E8%BE%BC%E3%81%BE%E3%82%8C%E3%81%BE%E3%81%99%E3%81%8B-" class="article-list-link">売上金はいつ振り込まれますか？</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360002356834-%E5%A3%B2%E4%B8%8A-%E6%8C%AF%E8%BE%BC%E7%94%B3%E8%AB%8B" class="article-list-link">売上・振込申請</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360001506034-ID%E8%AA%8D%E8%A8%BC%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6" class="article-list-link">ID認証について</a>
          </li>
          <li class="article-list-item ">
            <a href="/hc/ja/articles/360001168034-%E5%8F%96%E5%BC%95%E3%81%AE%E3%82%AD%E3%83%A3%E3%83%B3%E3%82%BB%E3%83%AB" class="article-list-link">取引のキャンセル</a>
          </li>
      </ul>
    </div>
    <!--/メイン-->

    <!--サイド-->
    <aside id="sidebar">
      <section id="side_banner">
        <h2>関連リンク</h2>
        <ul>
        <li><a href="notice.php"><img src="images/kanban.gif"></a></li>
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
  <!-- <footer>
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
  </footer> -->
  <!--/フッター-->

</body>
</html>