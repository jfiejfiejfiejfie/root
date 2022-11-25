<?php
session_start();
require_once('../lib/util.php');
<<<<<<< HEAD
$gobackURL = 'index.php';
=======
<<<<<<< HEAD
$gobackURL = 'all.php';
=======
<<<<<<< HEAD
$gobackURL = 'all.php';
=======
$gobackURL ='all.php';
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
require_once "db_connect.php";
?>

<!DOCTYPE html>
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<?php require_once("head.php")?>
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
<title>貸し借り|一覧</title>
</head>

<body>
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
  <audio id="audio"></audio>
  <div id="fb-root"></div>


<<<<<<< HEAD
  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <!-- 入力フォームを作る -->

    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <h2>検索</h2>
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
      </div>
      <!--/メイン-->

=======
<<<<<<< HEAD
  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <!-- 入力フォームを作る -->

    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <h2>検索</h2>
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
      </div>
      <!--/メイン-->

=======
  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <!-- 入力フォームを作る -->
=======
<audio id="audio"></audio>
<div id="fb-root"></div>

  
  <!--ヘッダー-->
		<?php require_once("header.php");?>
>>>>>>> root/master

    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <h2>検索</h2>
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
      </div>
      <!--/メイン-->

>>>>>>> root/master
>>>>>>> root/master
      <!--サイド-->

      <?php
      require_once('side.php');
      ?>


      <!--/サイド-->
    </div>
    <!--/wrapper-->

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
    <!--フッター-->
    <footer>
      <div id="footer_nav">
        <ul>
<<<<<<< HEAD
          <li class="current"><a href="index.php">HOME</a></li>
          <li><a href="add_db.php">商品登録</a></li>
          <li><a href="user_chat_list.php">一覧</a></li>
=======
          <li class="current"><a href="all.php">HOME</a></li>
          <li><a href="add_db.php">商品登録</a></li>
          <li><a href="list.php">一覧</a></li>
>>>>>>> root/master
          <li><a href="mypage.php">マイページ</a></li>
          <li><a href="register.php">アカウント登録</a></li>
          <li><a href="login.php">ログイン</a></li>
        </ul>
      </div>
      <small>&copy; 2015 Bloom.</small>
    </footer>
    <!--/フッター-->
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
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
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master

</body>

</html>