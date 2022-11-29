<?php
session_start();
$myURL='edit.php';
$gobackURL = 'mypage.php';
require_once "db_connect.php";
?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り</title>
</head>

<body>
  <div id="fb-root"></div>


  <?php require_once("header.php"); ?>


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <h1>編集タイム</h1>
      <form method="POST" action="edit_db.php" enctype="multipart/form-data">
        <?php
              $id=$_SESSION["id"];
              require_once('user_check.php');
              echo "<img src=my_image.php?id=$id style='max-width:200px;'>";
              echo "<hr>";
          ?>
        <ul>
          <li>
            <label>名前:
              <input type="text" name="name" placeholder="名前" value="<?php echo htmlspecialchars($row["name"]); ?>"
                required>
            </label>
          </li>
          </li>
            <label>年齢:
              <input type="number" name="age" placeholder="年齢" value="<?php echo htmlspecialchars($row["age"]); ?>"
                required>
            </label>
          </li>
          <li>性別:
            <label><input type="radio" name="sex" value="男" checked>男性</label>
            <label><input type="radio" name="sex" value="女">女性</label>
            <label><input type="radio" name="sex" value="無回答">無回答</label>
          </li>
          <?php if($row["checked"]==0){?>
          <li>
            <label>E-mail:
              <input type="text" name="email" placeholder="E-mail"
                value="<?php echo htmlspecialchars($row["email"]); ?>">
            </label>
          </li>
          <?php }?>
          <li>
            <label>コメント:
              <input type="text" name="comment" placeholder="comment"
                value="<?php echo htmlspecialchars($row["comment"]); ?>" required>
            </label>
          </li>
          <li>
            <label>画像選択:<br>
              <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
              <input type="file" multiple name="image" class="test" accept="image/*" onchange="previewImage(this);">
            </label>
          </li>
          <li><input type="submit" value="変更する"></li>
        </ul>
      </form>
      <hr>
      <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
      <br>
      <form method="POST" action="delete_conf.php" enctype="multipart/form-data">
        <ul>
          <li><input type="submit" value="退会する"></li>
        </ul>
      </form>
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