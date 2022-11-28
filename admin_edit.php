<?php
session_start();
$gobackURL = 'mypage.php';
$myURL = 'admin_edit.php';
require_once "db_connect.php";
require_once('user_check.php');
if($row["admin"]==0){
    header('Location:index.php');
}
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
      <form method="POST" action="admin_edit_db.php" enctype="multipart/form-data">
        <?php
            $id=$_GET["id"];
            $sql = "SELECT * FROM users WHERE id=$id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
            }
            echo "<img src=my_image.php?id=$id style='max-width:200px;'>";
            echo "<hr>";
          ?>
        <ul>
          <li>
            <label>ユーザID:
                <input type="hidden" name="id" value="<?php echo $row['id'];?>">
              <input type="text" name="user_id" placeholder="ユーザID" value="<?php echo htmlspecialchars($row["user_id"]); ?>"
                required>
            </label>
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
          <li>
            <label>E-mail:
              <input type="text" name="email" placeholder="E-mail"
                value="<?php echo htmlspecialchars($row["email"]); ?>">
            </label>
          </li>
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
          <li>
            <label>金:
              <input type="text" name="money" placeholder="money"
                value="<?php echo htmlspecialchars($row["money"]); ?>" required>
            </label>
          </li>
          <li><input type="submit" value="変更する"></li>
        </ul>
      </form>
      <hr>
      <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
      <br>
      <form method="POST" action="deleteacount.php" enctype="multipart/form-data">
        <ul>
          <li>
            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
            <input type="submit" value="垢BANする"></li>
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