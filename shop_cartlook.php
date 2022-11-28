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
        
        if(empty($_SESSION["cart"]) === true) {
            print "カートに商品はありません。<br><br>";
            print "<a href='shop_list.php'>商品一覧へ戻る</a>";
        }
        
        try{
        $cart = $_SESSION["cart"];
        $kazu = $_SESSION["kazu"];
        $max = count($cart);
            
        $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
        $user = "root";
        $password = "";
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        foreach($cart as $key => $val) {
            
        $sql = "SELECT code, name, price, gazou FROM mst_product WHERE code=?";
        $stmt = $dbh -> prepare($sql);
        $data[0] = $val;
        $stmt -> execute($data);
            
        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
            
        $name[] = $rec["name"];
        $price[] = $rec["price"];
        $gazou[] = $rec["gazou"];
        }
        $dbh = null;
        }
        catch(Exception $e) {
            print "只今障害が発生しております。<br><br>";
            print "<a href='../staff_login/staff_login.html'>ログイン画面へ</a>";
        }
        ?>
            
        <form action="shop_kazu.php" method="post">
        カート一覧<br><br>
        <?php for($i = 0; $i < $max; $i++) {;?>
        <?php if(empty($gazou[$i]) === true) {;?>
        <?php $disp_gazou = "";?>
        <?php } else {;?>
        <?php $disp_gazou = "<img src='../product/gazou/".$gazou[$i]."'>";?>
        <?php };?>
        <?php print $disp_gazou;?>
        商品名:<?php print $name[$i];?><br>
        価格:<?php print $price[$i]."円　";?><br>
        数量:<input type="text" name="kazu<?php print $i;?>" value="<?php print $kazu[$i];?>"><br>
        合計価格:<?php print $price[$i] * $kazu[$i]."円";?><br><br>
        削除:<input type="checkbox" name="delete<?php print $i;?>">
        <br>
        
        <?php };?>
        
        <br><br>
        <input type="hidden" name="max" value="<?php print $max;?>">
        <input type="submit" value="数量変更/削除">
        <br><br>
        <input type="button" onclick="history.back()" value="戻る">
        </form>
        <br>
        <a href="shop_form_check.php">ご購入手続きへ進む</a><br>
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