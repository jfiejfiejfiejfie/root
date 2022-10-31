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
  <header>
    <h1><a href="all.php"><img src="images/logo.png" alt="フラワーアレンジメント教室ブルーム" ></a></h1>
    <div id="header_contact"><a href="login.php"><?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){?><img src="images/logout.png"<?php }else{?><img src="images/btn_contact.jpg"<?php }?> alt="お問い合わせ"></a></div>
    <nav id="global_navi">
      <ul>
        <li class="current"><a href="all.php">HOME</a></li>
        <li><a href="add_db.php">商品登録</a></li>
        <li><a href="list.php">一覧</a>
        <ul>
          <li><a href="search_sp.php">商品検索</a></li>
        </ul>
        </li>
        <li><a href="mypage.php">マイページ</a>
        <ul>
          <li><a href="user_search.php">ユーザ検索</a></li>
      </li>
        </ul>
      </li>
        <li><?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){?><a href="contact.php">お問い合わせ💛</a>
        <?php }else{?><a href="register.php">アカウント登録</a><?php }?></li>
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
        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){echo "<h2>Hello,", htmlspecialchars($_SESSION["name"]),"</h2>"; }?>
        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ ?>
        <section>
          <h3>我が組員<?php echo htmlspecialchars($_SESSION["name"]);?>ごきげんよう。</h3>
          <p>この度はサイトに来てくれてありがとう。<br>
            人は生きながら自由であり、その自由を奪う理由などない。<br>
            己を信じ、己の道を進んでくれ。</p>
        </section>
        <?php }else{ ?>
          <h2>このサイトの使い方</h2>
        <section>
          <h3>ものを貸し借りするよ。皆さんで共有しましょう。</h3>
          <figure>
            <video src="images/hiroyuki.mp4" width="240" height="160" controls><a></a></video>
            <figcaption>実際に使用した人の声:Hさん</figcaption>
          </figure>
          <p>人類の数だけ、感動があります。<br>
            一人ひとりにあった、その人らしいもの。自分にないものを。<br>
            初心者の方も安心してご参加ください。</p>
        </section>
          <section>
          <h3>困ったらまずはアカウントを登録だ!</h3>
          <figure>
            <a href="register.php" class="btn btn-primary btn-lg"><btn class="rainbow">登録</btn></a>
            <figcaption class="rainbow" style="color: #ff5353;">↑をクリック!!</figcaption>
          </figure>
          <p>我々の組に入り、気持ちを共有しましょう。<br>
            また、人は生きながら自由であり、その自由を奪う理由などない。<br>
            ここに登録して組員になり自由を手に入れよう </p>
        </section>
        <?php }?>
      </section>
      <section id="news">
        <h2>お知らせ</h2>
        <dl>
        <dt>2022/09/10</dt>
          <dd><a href="#">某選手けつなあな<rai class="rainbow">確定</rai>しました。</a></dd>
          <dt>2022/05/03</dt>
          <dd><a href="https://youtu.be/4gX2k6lT_L0" target="_blank">動画が投稿されました。</a></dd>
          <dt>2016/03/21</dt>
          <dd><a href="course.html">講座案内を更新しました</a></dd>
        </dl>
      </section>
      <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
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
      <section id="side_contact">
        <h2>ご予約・お問い合わせ</h2>
        <address><i class="fa fa-phone"></i>052-232-8229</address>
        <p>受付時間 9:00〜18:00</p>
        <p><a href="contact.php" class="contact_button">お問い合わせフォーム</a></p>
      </section>
      <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://bloom.ne.jp" data-text="美味しいヤミー❗️✨🤟😁👍感謝❗️🙌✨感謝❗️🙌✨またいっぱい食べたいな❗️🍖😋🍴✨デリシャッ‼️🙏✨ｼｬ‼️🙏✨ ｼｬ‼️🙏✨ ｼｬ‼️🙏✨ ｼｬ‼️🙏✨ ｼｬ‼️🙏✨ ｼｬｯｯ‼ハッピー🌟スマイル❗️👉😁👈">Tweet</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
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