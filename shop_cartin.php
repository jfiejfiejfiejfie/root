<?php
session_start();
require_once('../lib/util.php');
$gobackURL = 'index.php';
require_once "db_connect.php";
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|一覧</title>
</head>

<body>
  <script src="js/original.js"></script>
  <div id="cursor"></div>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <!-- 入力フォームを作る -->

    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
        <?php
    
    $code = $_GET["code"];
    
    if(isset($_SESSION["cart"]) === true) {
        $cart = $_SESSION["cart"];
        $kazu = $_SESSION["kazu"];
            if(in_array($code, $cart) === true) {
            print "すでにカートにあります。<br><br>";
            print "<a href='shop_list.php'>ショップ一覧へ戻る</a>";
            } 
            }
    if(empty($_SESSION["cart"]) === true or in_array($code, $cart) === false) {
    $cart[] = $code;
    $kazu[] = 1;
    $_SESSION["cart"] = $cart;
    $_SESSION["kazu"] = $kazu;
    
    print "カートに追加しました。<br><br>";
    print "<a href='shop_list.php'>ショップ一覧へ戻る</a>";
    }
    
    ?>
    <br><br>
    
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
</body>

</html>