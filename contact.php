<<<<<<< HEAD
<?php
session_start();
require_once "db_connect.php";
?>
=======
<<<<<<< HEAD
>>>>>>> root/master
<?php 
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require 'functionZ.php';
 
//POSTされたデータを変数に格納（値の初期化とデータの整形：前後にあるホワイトスペースを削除）
$name = trim( filter_input(INPUT_POST, 'name') );
$email = trim( filter_input(INPUT_POST, 'email') );
$tel = trim( filter_input(INPUT_POST, 'tel') );
$subject = trim( filter_input(INPUT_POST, 'subject'));
$body = trim( filter_input(INPUT_POST, 'body') );
 
//送信ボタンが押された場合の処理
if (isset($_POST['submitted'])) {
 
  //POSTされたデータをチェック  
  $_POST = checkInput( $_POST ); 
 
  //エラーメッセージを保存する配列の初期化
  $error = array();
  
  //値の検証
  if ( $name == '' ) {
    $error['name'] = '*お名前は必須項目です。';
    //制御文字でないことと文字数をチェック
  } else if ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $name ) == 0 ) {
    $error['name'] = '*お名前は30文字以内でお願いします。';
  }
  if ( $email == '' ) {
    $error['email'] = '*メールアドレスは必須です。';
  } else { //メールアドレスを正規表現でチェック
    $pattern = '/\A([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}\z/uiD';
    if ( !preg_match( $pattern, $email ) ) {
      $error['email'] = '*メールアドレスの形式が正しくありません。';
    }
  }
  if ( $tel != '' && preg_match( '/\A\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}\z/u', $tel ) == 0 ) {
    $error['tel'] = '*電話番号の形式が正しくありません。';
  }
  if ( $subject == '' ) {
    $error['subject'] = '*件名は必須項目です。';
    //制御文字でないことと文字数をチェック
  } else if ( preg_match( '/\A[[:^cntrl:]]{1,50}\z/u', $subject ) == 0 ) {
    $error['subject'] = '*件名は50文字以内でお願いします。';
  }
  if ( $body == '' ) {
    $error['body'] = '*内容は必須項目です。';
    //制御文字（タブ、復帰、改行を除く）でないことと文字数をチェック
  } else if ( preg_match( '/\A[\r\n\t[:^cntrl:]]{1,300}\z/u', $body ) == 0 ) {
    $error['body'] = '*内容は300文字以内でお願いします。';
  }
  
  //エラーがなく且つ POST でのリクエストの場合
  if (empty($error) && $_SERVER['REQUEST_METHOD']==='POST') {
    //メールアドレス等を記述したファイルの読み込み
    require 'mailvars.php'; 
 
    //メール本文の組み立て
    $mail_body = 'コンタクトページからのお問い合わせ' . "\n\n";
    $mail_body .=  "お名前： " .h($name) . "\n";
    $mail_body .=  "Email： " . h($email) . "\n"  ;
    $mail_body .=  "お電話番号： " . h($tel) . "\n\n" ;
    $mail_body .=  "＜お問い合わせ内容＞" . "\n" . h($body);
 
    //--------sendmail------------
 
    //メールの宛先（名前<メールアドレス> の形式）。値は mailvars.php に記載
    $mailTo = mb_encode_mimeheader(MAIL_TO_NAME) ."<" . MAIL_TO. ">";
 
    //Return-Pathに指定するメールアドレス
    $returnMail = MAIL_RETURN_PATH; //
    //mbstringの日本語設定
    mb_language( 'ja' );
    mb_internal_encoding( 'UTF-8' );
 
    // 送信者情報（From ヘッダー）の設定
    $header = "From: " . mb_encode_mimeheader($name) ."<" . $email. ">\n";
    //$header .= "Cc: " . mb_encode_mimeheader(MAIL_CC_NAME) ."<" . MAIL_CC.">\n";
    //$header .= "Bcc: <" . MAIL_BCC.">";
 
    //メールの送信
    //メールの送信結果を変数に代入
    if ( ini_get( 'safe_mode' ) ) {
      //セーフモードがOnの場合は第5引数が使えない
      $result = mb_send_mail( $mailTo, $subject, $mail_body, $header );
    } else {
      $result = mb_send_mail( $mailTo, $subject, $mail_body, $header, '-f' . $returnMail );
    }
    
    //メール送信の結果判定
    if ( $result ) {
      $_POST = array(); //空の配列を代入し、すべてのPOST変数を消去
      //変数の値も初期化
      $name = '';
      $email = '';
      $tel = '';
      $subject = '';
      $body = '';
      
      //再読み込みによる二重送信の防止
      $params = '?result='. $result;
      //サーバー変数 $_SERVER['HTTPS'] が取得出来ない環境用
      if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] === "https") {
        $_SERVER['HTTPS'] = 'on';
      }
      $url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']; 
      header('Location:' . $url . $params);
      exit;
    } 
  }
}
?>
<!DOCTYPE html>
<<<<<<< HEAD
<?php require_once("head.php") ?>
<title>貸し借り|HOME</title>
<link rel="stylesheet" href="css/top.css">
=======
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>コンタクトフォーム</title>
<link href="../bootstrap4/css/bootstrap.min.css" rel="stylesheet">
<link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container">
  <h2 class="">お問い合わせフォーム</h2>
  <?php  if (filter_input(INPUT_GET, 'result') ) : // 送信が成功した場合?>
  <h4>送信完了!</h4>
  <p>送信完了いたしました。</p>
  <hr>
  <?php elseif (isset($result) && !$result ): // 送信が失敗した場合 ?>
  <h4>送信失敗</h4>
  <p>申し訳ございませんが、送信に失敗しました。</p>
  <p>しばらくしてもう一度お試しになるか、メールにてご連絡ください。</p>
  <p>メール：<a href="mailto:info@example.com">Contact</a></p>
  <hr>
  <?php endif; ?>
  <p>以下のフォームからお問い合わせください。</p>
  <form id="form" method="post">
    <div class="form-group">
      <label for="name">お名前（必須） 
        <span class="error-php"><?php if ( isset( $error['name'] ) ) echo h( $error['name'] ); ?></span>
      </label>
      <input type="text" class="form-control" id="name" name="name" placeholder="氏名" required value="<?php echo h($name); ?>">
    </div>
    <div class="form-group">
      <label for="email">Email（必須） 
        <span class="error-php"><?php if ( isset( $error['email'] ) ) echo h( $error['email'] ); ?></span>
      </label>
      <input type="email" class="form-control" id="email" name="email" pattern="([a-zA-Z0-9\+_\-]+)(\.[a-zA-Z0-9\+_\-]+)*@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}" placeholder="Email アドレス" required value="<?php echo h($email); ?>">
=======
<?php
session_start();
require_once "db_connect.php";
?>
<!DOCTYPE html>
<<<<<<< HEAD
<?php require_once("head.php") ?>
<title>貸し借り|HOME</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
=======
<?php require_once("head.php")?>
<title>貸し借り|HOME</title>
>>>>>>> root/master
</head>

<body>
<<<<<<< HEAD
	<audio id="audio"></audio>
	<div id="fb-root"></div>


	<!--ヘッダー-->
	<?php require_once("header.php"); ?>

	<div id="wrapper">
		<!--メイン-->
		<div id="main">

  <h2>お問い合わせフォーム</h2>
  <?php  if (filter_input(INPUT_GET, 'result') ) : // 送信が成功した場合?>
  <h4>送信完了!</h4>
  <p>送信完了いたしました。</p>
  <hr>
  <?php elseif (isset($result) && !$result ): // 送信が失敗した場合 ?>
  <h4>送信失敗</h4>
  <p>申し訳ございませんが、送信に失敗しました。</p>
  <p>しばらくしてもう一度お試しになるか、メールにてご連絡ください。</p>
  <p>メール：<a href="fki2166220@stu.o-hara.ac.jp">Contact</a></p>
  <hr>
  <?php endif; ?>
  <p>以下のフォームからお問い合わせください。</p>
  <form id="form" method="post">
    <div class="form-group">
      <label for="name">お名前（必須） 
        <span class="error-php"><?php if ( isset( $error['name'] ) ) echo h( $error['name'] ); ?></span>
      </label>
      <input type="text" class="form-control" id="name" name="name" placeholder="氏名" required value="<?php echo h($name); ?>">
    </div>
    <div class="form-group">
      <label for="email">Email（必須） 
        <span class="error-php"><?php if ( isset( $error['email'] ) ) echo h( $error['email'] ); ?></span>
      </label>
      <input type="email" class="form-control" id="email" name="email" pattern="([a-zA-Z0-9\+_\-]+)(\.[a-zA-Z0-9\+_\-]+)*@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}" placeholder="Email アドレス" required value="<?php echo h($email); ?>">
    </div>
    <div class="form-group">
      <label for="tel">お電話番号（半角英数字） 
        <span class="error-php"><?php if ( isset( $error['tel'] ) ) echo h( $error['tel'] ); ?></span>
      </label>
      <input type="tel" class="form-control" id="tel" name="tel" pattern="\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}" value="<?php echo h($tel); ?>" placeholder="電話番号">
    </div>
    <div class="form-group">
       <label for="subject">件名（必須） 
        <span class="error-php"><?php if ( isset( $error['subject'] ) ) echo h( $error['subject'] ); ?></span> 
      </label>
      <input type="text" class="form-control" id="subject" name="subject" placeholder="件名" required maxlength="50" value="<?php echo h($subject); ?>">
    </div>
    <div class="form-group">
       <label for="body">お問い合わせ内容（必須） 
        <span class="error-php"><?php if ( isset( $error['body'] ) ) echo h( $error['body'] ); ?></span>
      </label>
      <textarea class="form-control" id="body" name="body" placeholder="お問い合わせ内容" required  maxlength="300" rows="3"><?php echo h($body); ?></textarea>
    </div>
    <button name="submitted" type="submit" class="btn btn-primary">送信</button>
  </form>
=======
<audio id="audio"></audio>
<div id="fb-root"></div>

  
  <!--ヘッダー-->
		<?php require_once("header.php");?>
>>>>>>> root/master


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <ul class="article-list">
        <li class="article-list-item  article-promoted">
          <span data-title="ピックアップ記事" class="icon-star"></span>
          <a href="/hc/ja/articles/360006902153-%E4%BA%BA%E6%B0%97%E3%81%AE%E3%81%82%E3%82%8B%E5%95%86%E5%93%81"
            class="article-list-link">人気のある商品</a>
        </li>
        <li class="article-list-item  article-promoted">
          <span data-title="ピックアップ記事" class="icon-star"></span>
          <a href="/hc/ja/articles/360000784034-%E5%AE%89%E5%85%A8%E3%81%B8%E3%81%AE%E5%8F%96%E3%82%8A%E7%B5%84%E3%81%BF"
            class="article-list-link">安全への取り組み</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/900004386506-%E6%89%8B%E6%B8%A1%E3%81%97%E5%A0%B4%E6%89%80%E3%82%92%E6%B6%88%E5%8E%BB%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95"
            class="article-list-link">手渡し場所を消去する方法</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/900002061083-%E3%82%AF%E3%83%AC%E3%82%B8%E3%83%83%E3%83%88%E3%82%AB%E3%83%BC%E3%83%89%E3%81%AE%E5%A4%89%E6%9B%B4"
            class="article-list-link">クレジットカードの変更</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/900001969263-%E9%A0%98%E5%8F%8E%E6%9B%B8%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6"
            class="article-list-link">領収書について</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/900001465406-%E3%83%97%E3%83%AC%E3%83%9F%E3%82%A2%E3%83%A0%E5%95%86%E5%93%81%E3%81%AE%E8%A3%9C%E5%84%9F%E9%87%91"
            class="article-list-link">プレミアム商品の補償金</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/900001446786-%E3%82%AF%E3%82%AA%E3%83%83%E3%82%BFandroid%E7%89%88"
            class="article-list-link">クオッタandroid版</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/900000940863-%E5%95%86%E5%93%81%E3%81%AE%E7%A0%B4%E6%90%8D%E3%81%A8%E7%B4%9B%E5%A4%B1%E3%81%AE%E3%83%88%E3%83%A9%E3%83%96%E3%83%AB"
            class="article-list-link">商品の破損と紛失のトラブル</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/900000402506-%E8%B2%B7%E3%81%84%E5%8F%96%E3%82%8A%E3%81%AE%E5%A0%B4%E5%90%88"
            class="article-list-link">買い取りの場合</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/900000327586-%E5%A3%B2%E4%B8%8A%E3%81%AE%E5%8F%8D%E6%98%A0%E3%81%AE%E3%82%BF%E3%82%A4%E3%83%9F%E3%83%B3%E3%82%B0"
            class="article-list-link">売上の反映のタイミング</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/900000026603-%E3%83%87%E3%83%9D%E3%82%B8%E3%83%83%E3%83%88-%E4%BF%9D%E8%A8%BC%E9%87%91-"
            class="article-list-link">デポジット（保証金）</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360000289881-%E9%80%9A%E7%9F%A5%E8%A8%AD%E5%AE%9A" class="article-list-link">通知設定</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360000276341-%E6%89%8B%E6%B8%A1%E3%81%97%E3%81%A7%E3%81%AE%E3%81%8A%E5%8F%96%E5%BC%95"
            class="article-list-link">手渡しでのお取引</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360000233042-%E8%BF%BD%E5%8A%A0%E8%AB%8B%E6%B1%82" class="article-list-link">追加請求</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360020108514-%E9%80%81%E6%96%99%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6"
            class="article-list-link">送料について</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360015345914-%E5%86%8D%E5%87%BA%E5%93%81%E3%81%AE%E6%96%B9%E6%B3%95"
            class="article-list-link">再出品の方法</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360013576794-%E6%94%AF%E6%89%95%E3%81%84-%E6%B1%BA%E6%B8%88%E6%96%B9%E6%B3%95%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6"
            class="article-list-link">支払い・決済方法について</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360012466593-%E5%BB%B6%E9%95%B7%E6%96%99%E9%87%91%E3%81%AE%E8%AB%8B%E6%B1%82%E6%96%B9%E6%B3%95"
            class="article-list-link">延長料金の請求方法</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360011191214-%E6%89%8B%E6%95%B0%E6%96%99%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6"
            class="article-list-link">手数料について</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360009818034-%E3%82%A2%E3%83%97%E3%83%AA%E3%81%AE%E4%B8%8D%E5%85%B7%E5%90%88-%E3%83%90%E3%82%B0-%E3%82%A8%E3%83%A9%E3%83%BC"
            class="article-list-link">アプリの不具合・バグ・エラー</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360009927033-%E3%83%88%E3%83%A9%E3%83%96%E3%83%AB%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6"
            class="article-list-link">トラブルについて</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360009347914-%E5%8F%96%E5%BC%95%E3%81%AE%E6%B5%81%E3%82%8C"
            class="article-list-link">取引の流れ</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360006377754-%E9%80%80%E4%BC%9A%E6%96%B9%E6%B3%95" class="article-list-link">退会方法</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360006200914-%E5%88%A9%E7%94%A8%E8%A6%8F%E7%B4%84-%E3%83%97%E3%83%A9%E3%82%A4%E3%83%90%E3%82%B7%E3%83%BC%E3%83%9D%E3%83%AA%E3%82%B7%E3%83%BC"
            class="article-list-link">利用規約・プライバシーポリシー</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360005920914-%E5%87%BA%E5%93%81%E3%82%92%E7%A6%81%E6%AD%A2%E3%81%97%E3%81%A6%E3%81%84%E3%82%8B%E5%95%86%E5%93%81"
            class="article-list-link">出品を禁止している商品</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360004527393-%E8%B2%B8%E5%87%BA%E6%9C%9F%E9%96%93" class="article-list-link">貸出期間</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360003410453-%E5%A3%B2%E4%B8%8A%E9%87%91%E3%81%AF%E3%81%84%E3%81%A4%E6%8C%AF%E3%82%8A%E8%BE%BC%E3%81%BE%E3%82%8C%E3%81%BE%E3%81%99%E3%81%8B-"
            class="article-list-link">売上金はいつ振り込まれますか？</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360002356834-%E5%A3%B2%E4%B8%8A-%E6%8C%AF%E8%BE%BC%E7%94%B3%E8%AB%8B"
            class="article-list-link">売上・振込申請</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360001506034-ID%E8%AA%8D%E8%A8%BC%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6"
            class="article-list-link">ID認証について</a>
        </li>
        <li class="article-list-item ">
          <a href="/hc/ja/articles/360001168034-%E5%8F%96%E5%BC%95%E3%81%AE%E3%82%AD%E3%83%A3%E3%83%B3%E3%82%BB%E3%83%AB"
            class="article-list-link">取引のキャンセル</a>
        </li>
      </ul>
    </div>
    <!--/メイン-->

    <!--サイド-->
<<<<<<< HEAD

    <?php
      require_once('side.php');
      ?>


=======
    
      <?php
    require_once('side.php');
    ?>

    
>>>>>>> root/master
    <!--/サイド-->
>>>>>>> root/master
  </div>
  <?php
      require_once('side.php');
      ?>

<<<<<<< HEAD

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
				<li><a href="register.php">アカウント登録</a></li>
				<li><a href="login.php">ログイン</a></li>
			</ul>
		</div>
		<small>&copy; 2015 Bloom.</small>
	</footer>
	<!--/フッター-->

=======
  <!--フッター-->
  <!-- <footer>
    <div id="footer_nav">
    <ul>
        <li class="current"><a href="all.php">HOME</a></li>
        <li><a href="add_db.php">商品登録</a></li>
        <li><a href="list.php">一覧</a></li>
        <li><a href="mypage.php">マイページ</a></li>
        <li><?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?><a href="contact.php">お問い合わせ💛</a>
      <?php } else { ?><a href="register.php">アカウント登録</a><?php } ?></li><li><a href="login.php">ログイン</a></li>
      </ul>
>>>>>>> root/master
    </div>
    <div class="form-group">
      <label for="tel">お電話番号（半角英数字） 
        <span class="error-php"><?php if ( isset( $error['tel'] ) ) echo h( $error['tel'] ); ?></span>
      </label>
      <input type="tel" class="form-control" id="tel" name="tel" pattern="\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}" value="<?php echo h($tel); ?>" placeholder="電話番号">
    </div>
    <div class="form-group">
       <label for="subject">件名（必須） 
        <span class="error-php"><?php if ( isset( $error['subject'] ) ) echo h( $error['subject'] ); ?></span> 
      </label>
      <input type="text" class="form-control" id="subject" name="subject" placeholder="件名" required maxlength="50" value="<?php echo h($subject); ?>">
    </div>
    <div class="form-group">
       <label for="body">お問い合わせ内容（必須） 
        <span class="error-php"><?php if ( isset( $error['body'] ) ) echo h( $error['body'] ); ?></span>
      </label>
      <textarea class="form-control" id="body" name="body" placeholder="お問い合わせ内容" required  maxlength="300" rows="3"><?php echo h($body); ?></textarea>
    </div>
    <button name="submitted" type="submit" class="btn btn-primary">送信</button>
  </form>
</div>
>>>>>>> root/master
</body>

</html>