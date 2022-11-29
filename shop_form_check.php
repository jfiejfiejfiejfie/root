<?php
session_start();
require_once('../lib/util.php');
$myURL='shop_form_check.php';
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
    try {

$menber_code = $_SESSION["menber_code"];
$cart = $_SESSION["cart"];
$kazu = $_SESSION["kazu"];
$max = count($kazu);
        
$dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
$user = "root";
$password = "";
$dbh = new PDO($dsn, $user, $password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
$sql = "SELECT name, email, address, tel FROM menber WHERE code=?";
$stmt = $dbh -> prepare($sql);
$data[] = $menber_code;
$stmt -> execute($data);
       
$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
        
print "下記内容でよろしいでしょうか？<br><br>";
print "【宛先】<br>";
print "お名前:".$rec['name']."様<br>";
print "mail:".$rec['email']."<br>";
print "ご住所:".$rec['address']."<br>";
print "ご連絡先:".$rec['tel']."<br><br>";
$name = $rec["name"];
$email = $rec["email"];
$address = $rec["address"];
$tel = $rec["tel"];

print "【ご注文内容】<br>";
for($i = 0; $i < $max; $i++) {
  $sql = "SELECT name, price, gazou FROM mst_product WHERE code=?";
  $stmt = $dbh -> prepare($sql);
  $data = array();
  $data[] = $cart[$i];
  $stmt -> execute($data);
    
$rec = $stmt -> fetch(PDO::FETCH_ASSOC);
    
if(empty($rec["gazou"]) === true) {
$disp_gazou = "";
} else {
$disp_gazou = "<img src='../product/gazou/".$rec['gazou']."'>";
}
print "<div class='box'>";
print "<div class='list'>";
print "<div class='img'>";
print $disp_gazou;
print "</div>";
print "<div class='npe'>";
print "商品名:".$rec['name']."<br>";
print "価格:".$rec['price']."円　<br>";
print "数量:".$kazu[$i]."<br>";
print "合計価格:".$rec['price'] * $kazu[$i]."円<br><br>";
$goukei[] = $rec['price'] * $kazu[$i];
print "</div></div></div><br>";
}
$dbh = null; 
print "【ご請求金額】---".array_sum($goukei)."円<br><br>";
print "<form action='shop_form_done.php' method='post'>";
print "<input type='hidden' name='name' value='".$name."'>";
print "<input type='hidden' name='email' value='".$email."'>";
print "<input type='hidden' name='address' value='".$address."'>";
print "<input type='hidden' name='tel' value='".$tel."'>";
print "<input type='button' onclick='history.back()' value='戻る'>";
print "<input type='submit' value='OK'>";
print "</form>";
}

catch(Exception $e) {
    print "只今障害が発生しております。<br><br>";
    print "<a href='../staff_login/staff_login.html'>ログイン画面へ</a>";
}
?>
    
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