<?php
session_start();
require_once "db_connect.php";
$myURL = 'add_room.php';
$gobackURL = 'user_chat_list.php';
$point = 0;
?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|商品登録 </title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
  <?php if (isset($_POST["kind"])) {
    require_once('insert.php');
  } ?>

  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <br>
      <?php
      if (isset($_SESSION["insert_text"])) {
        echo $_SESSION["insert_text"];
      }
      if (!isset($_SESSION["loggedin"])) {
        echo "<h2>この機能を利用するにはログインしてください。</h2>";
        echo "<a href='login.php' class='btn btn-danger'>ログイン</a>";
      } else { ?>
      <h2>チャットルーム登録</h2>
      <form method="POST" action="add_db.php" enctype="multipart/form-data">
        <ul>
          <li>
            <br>
            <label>ルーム名:
              <input type="text" id="item_name" name="item" placeholder="必須(30文字まで)">
            </label>
          </li>
          <li>
            <label>コメント(任意):
              <script>
                function countLength(text, field) {
                  document.getElementById(field).innerHTML = text.length + "文字/1000文字";
                }
              </script>
              <textarea id="message" name="comment" placeholder="ルール、注意事項など"
                onKeyUp="countLength(value, 'textlength2');"></textarea>
              <p id="textlength2">0文字/1000文字</p>
            </label>
          </li>
          <li>画像選択:
          <li>
            <label><img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
              <input type="file" name="image" class="test" accept="image/*" onchange="previewImage(this);" required>
            </label>
          <li>
            <label>
              <input type="checkbox" required>規約に同意する
            </label>
          </li>
          <li><input type="submit" value="追加する">
          </li>
        </ul>
      </form>
      <?php } ?>
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
  <!-- <footer>
    <div id="footer_nav">
    <ul>
        <li class="current"><a href="index.php">HOME</a></li>
        <li><a href="add_db.php">商品登録</a></li>
        <li><a href="user_chat_list.php">一覧</a></li>
        <li><a href="mypage.php">マイページ</a></li>
        <li><?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?><a href="contact.php">お問い合わせ💛</a>
      <?php } else { ?><a href="register.php">アカウント登録</a><?php } ?></li><li><a href="login.php">ログイン</a></li>
      </ul>
    </div>
    <small>&copy; 2015 Bloom.</small>
  </footer> -->
  <!--/フッター-->

</body>

</html>