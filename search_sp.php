<?php
session_start(); 
require_once('../lib/util.php');
$gobackURL ='all.php';
require_once "db_connect.php";
?>

<!DOCTYPE html>
<?php require_once("head.php")?>
<title>貸し借り|一覧</title>
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
		<?php require_once("header.php");?>

<div>
  <!-- 入力フォームを作る -->
  
  <div id="wrapper">
    <!--メイン-->
    <div id="main">
    <section id="point">
    <h2>検索</h2>
  <form method="POST" action="search1.php">
    <ul>
      <li>
        <label>名前を検索します（部分一致）：<br>
        <input type="text" name="item" placeholder="名前を入れてください。">
        </label>
      </li>
      <li><input type="submit" value="検索する"></li>
    </ul>
  </form>
        <h2>ジャンル検索</h2>
    <form method="POST" action="search_kind.php">
    <ul>
      <li>
        <label>ジャンルで検索します：<br>
        <select name="kind_name">
                          <?php
                                  try{
                                    
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
                              echo '<option value="',$row["id"],'">',$row["name"],"</option>";
                            }
                          ?>
                        </select>
        </label>
      </li>
      <li><input type="submit" value="検索する"></li>
    </ul>
    </form>
    </section>
    <section id="point">
        <h2>金額検索</h2>
    <form method="POST" action="search_money.php">
    <ul>
      <li>
        <label>金額で検索します:<br>
        <input type="number_format" name="money1">以上
        <input type="number_format" name="money2">以下
      </li>
      <li><input type="submit" value="検索する"></li>
    </ul>
    </form>
    <h2>ユーザ検索</h2>
    <form method="POST" action="search_user.php">
    <ul>
      <li>
        <label>ユーザを検索します（部分一致）：<br>
        <input type="text" name="user_name" placeholder="名前を入れてください。">
        </label>
      </li>
      <li><input type="submit" value="検索する"></li>
    </ul>
  </form>
    </section>
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