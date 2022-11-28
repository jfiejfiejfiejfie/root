<?php
session_start();
require_once('../lib/util.php');
require_once "db_connect.php";
define('MAX', '10');
$id = $_GET["id"];
$myURL = 'user_chat.php';
$option = "&id=$id";
$memo = "チャット";
$gobackURL = "profile.php?id={$id}";
$user_id = $_SESSION["id"];
if (!isset($_GET['page_id'])) {
  $now = 1;
} else {
  $now = $_GET['page_id'];
}
if (isset($_GET["chat"])) {
  $sql = "SELECT * FROM list WHERE id=$id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $user_id = $row["user_id"];
  }
  $errors = [];
  require_once('error.php');
  $text = $_POST["text"];
  $user_id = $_SESSION["id"];
  if ($_FILES["image"]["tmp_name"] == "") {
    $imgdat = "";
  } else {
    $upfile = $_FILES["image"]["tmp_name"];
    $imgdat = file_get_contents($upfile);
  }
  $name = $_SESSION["name"];
  $others_id = $_GET["id"];
  date_default_timezone_set('Asia/Tokyo');
  $date = date('Y-m-d H:i:s');
  try {
    $sql = "INSERT INTO user_chat (user_id,created_at,text,image,others_id) VALUES(:user_id,:date,:text,:imgdat,:others_id)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stm->bindValue(':date', $date, PDO::PARAM_STR);
    $stm->bindValue(':text', $text, PDO::PARAM_STR);
    $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
    $stm->bindValue(':others_id', $others_id, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }
  if (isset($_GET['page_id'])) {
    header('Location:user_chat.php?id=' . $id . '&page_id=' . $now);
  } else {
    header('Location:user_chat.php?id=' . $id);
  }

}

$sql = "SELECT * FROM users WHERE id=$id";
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $user_name = $row["name"];
}
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|詳細</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <h2>
            <?php
            echo $user_name;
            ?>とのチャット履歴
          </h2>
          <?php
          $block_count = 0;
          $block_list = [];
          $sql = "SELECT * FROM blocklist WHERE my_id =:id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
          $stm->execute();
          $block_result = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($block_result as $block_row) {
            $block_count += 1;
            $block_list[] = $block_row["user_id"];
          }
          if (!in_array($id, $block_list)) {
          ?>
          <?php if (isset($_GET["page_id"])) {
              echo '<form action="user_chat.php?id=' . $id . '&chat=1&page_id=' . $now . '" method="POST"enctype="multipart/form-data">';
            } else {
              echo '<form action="user_chat.php?id=' . $id . '&chat=1" method="POST"enctype="multipart/form-data">';
            }
          ?>
          <label>画像選択:<br>
            <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
            <input type="file" multiple name="image" class="test" accept="image/*" onchange="previewImage(this);">
          </label><br>
          チャット:<input type="text" name="text" required>
          <br>
          <!-- </div> -->
          <input type="submit" value="送信">
          </form>
          <?php } else { ?>
          <h2>ブロック中のため送信できません。</h2>
          <?php } ?>
          <hr>
          <div>
            <?php
            $sql = "SELECT * FROM user_chat WHERE (others_id=$user_id and user_id=$id) or (others_id = $id  and user_id = $user_id) ORDER BY created_at DESC";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            require_once('paging.php');
            foreach ($disp_data as $row) {
              if (($row["others_id"] == $user_id)) {
                  echo '<table id="user_chat">';
                  echo '<thead><tr>';
                  echo '<th><a href="profile.php?id=', $row["user_id"], '">', '<img id="image" height="100" width="100" src="my_image.php?id=', $row["user_id"], '"></a>';
                  $user_id = $row["user_id"];
                  $sql = "SELECT * FROM users WHERE id=$user_id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result2 as $row2) {
                    $block_list = [];
                    $sql = "SELECT * FROM blocklist WHERE my_id =:id";
                    $stm = $pdo->prepare($sql);
                    $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
                    $stm->execute();
                    $block_result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($block_result as $block_row) {
                      $block_list[] = $block_row["user_id"];
                    }
                    echo '<br>';
                    if (in_array($user_id, $block_list)) {
                      echo $row2["name"], "<c style='color:red;'>※ブロック中!</c></th>";
                    } else {
                      echo $row2["name"], "</th>";
                    }
                  }
                  $user_id = $row["user_id"];
                  $sql = "SELECT * FROM users WHERE id=$user_id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result2 as $row2) {
                    echo "<td>";
                    //整形したい文字列
                    $text = $row["text"];
                    echo $text;
                    if ($row["image"] != "") {
                      echo '<img "height="150" width="150" src="user_chat_image.php?id='.$row["id"].'"><br>';;

                    }
                    echo '<br>', $row["created_at"];
                    echo '</td>';
                  }
                  echo '</tr>';
                  echo '</thead>';
                  echo '</table>';
              } else{
                  echo '<table id="user_chat">';
                  echo '<thead><tr>';
                  echo '<td>';
                  if ($row["image"] != "") {
                    echo '<img "height="150" width="150" src="user_chat_image.php?id='.$row["id"].'"><br>';
                  }
                  $text = $row["text"];
                  echo $text;
                  echo '<br>', $row["created_at"];
                  echo '</td>';
                  echo '<th><a href="profile.php?id=', $row["user_id"], '">', '<img id="image" height="100" width="100" src="my_image.php?id=', $row["user_id"], '"></a>';
                  $user_id = $row["user_id"];
                  $sql = "SELECT * FROM users WHERE id=$user_id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result2 as $row2) {
                    $block_list = [];
                    $sql = "SELECT * FROM blocklist WHERE my_id =:id";
                    $stm = $pdo->prepare($sql);
                    $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
                    $stm->execute();
                    $block_result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($block_result as $block_row) {
                      $block_list[] = $block_row["user_id"];
                    }
                    echo '<br></th>';
                  echo '</tr>';
                  echo '</thead>';
                  echo '</table>';
                }
              }
            }
            require_once('paging2.php');
            ?>
            <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
          </div>
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