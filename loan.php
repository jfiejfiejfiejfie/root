<?php
session_start();
require_once('../lib/util.php');
require_once "db_connect.php";
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
define('MAX', '5');
$id = $_GET["id"];
$myURL = 'loan.php';
$option = "&id=$id";
$memo = "チャット";
$gobackURL = "detail.php?id={$id}";
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
<<<<<<< HEAD
  $errors = [];
=======
>>>>>>> root/master
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
  date_default_timezone_set('Asia/Tokyo');
  $date = date('Y-m-d H:i:s');
  try {
    $sql = "INSERT INTO chat (user_id,created_at,text,list_id,image) VALUES(:user_id,:date,:text,:list_id,:imgdat)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stm->bindValue(':date', $date, PDO::PARAM_STR);
    $stm->bindValue(':text', $text, PDO::PARAM_STR);
    $stm->bindValue(':list_id', $id, PDO::PARAM_STR);
    $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e) {
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
define('MAX','5');
$id=$_GET["id"];
$gobackURL ="detail.php?id={$id}";
if(!isset($_GET['page_id'])){
  $now = 1;
}else{
  $now = $_GET['page_id'];
}
if(isset($_GET["chat"])){
  $text=$_POST["text"];
  $user_id=$_SESSION["id"];
  if($_FILES["image"]["tmp_name"]==""){
    $imgdat="";
  }else{
    $upfile = $_FILES["image"]["tmp_name"];
    $imgdat = file_get_contents($upfile);
  }
  $name=$_SESSION["name"];
  date_default_timezone_set('Asia/Tokyo');
  $date = date('Y-m-d H:i:s');
  try{
    $sql = "INSERT INTO chat (user_id,created_at,text,list_id,image) VALUES(:user_id,:date,:text,:list_id,:imgdat)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id',$user_id,PDO::PARAM_STR);
    $stm->bindValue(':date',$date,PDO::PARAM_STR);
    $stm->bindValue(':text',$text,PDO::PARAM_STR);
    $stm->bindValue(':list_id',$id,PDO::PARAM_STR);
    $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
  }catch(Exception $e){
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
  if (isset($_GET['page_id'])) {
    header('Location:loan.php?id=' . $id . '&page_id=' . $now);
  } else {
    header('Location:loan.php?id=' . $id);
  }

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
  if(isset($_GET['page_id'])){
    header('Location:loan.php?id='.$id.'&page_id='.$now);
  }else{
    header('Location:loan.php?id='.$id);
  }
  
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
}

$sql = "SELECT * FROM list WHERE id=$id";
$stm = $pdo->prepare($sql);
$stm->execute();
<<<<<<< HEAD
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $item_name = $row["item"];
=======
<<<<<<< HEAD
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $item_name = $row["item"];
=======
<<<<<<< HEAD
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $item_name = $row["item"];
=======
$result=$stm->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row){
  $item_name=$row["item"];
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
}
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
<title>貸し借り|詳細</title>
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
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <img src="image.php?id=<?php echo $id; ?>" style="max-width:350px;">
          <h2>
            <?php
        echo $item_name;
        ?>についてのチャット履歴
          </h2>
          <?php if (isset($_GET["page_id"])) {
          echo '<form action="loan.php?id=' . $id . '&chat=1&page_id=' . $now . '" method="POST"enctype="multipart/form-data">';
        } else {
          echo '<form action="loan.php?id=' . $id . '&chat=1" method="POST"enctype="multipart/form-data">';
        }
        ?>
          チャット:<input type="text" name="text" required>
          <label>画像選択:<br>
            <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
            <input type="file" multiple name="image" class="test" accept="image/*" onchange="previewImage(this);">
          </label>
          <!-- </div> -->
          <input type="hidden" name="list_id" value="<?php echo $id; ?>"><br>
          <input type="submit" value="送信">
          </form>
          <hr>
          <div>
            <?php
    try {
      $sql = "SELECT * FROM chat WHERE list_id=$id";
      $stm = $pdo->prepare($sql);
      $stm->execute();
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
      require_once("paging.php");
      foreach ($disp_data as $row) {
        echo '<table class="table table-striped">';
        echo '<thead><tr>';
        echo '<th><a href="profile.php?id=', $row["user_id"], '">', '<img id="image" height="100" width="100" src="my_image.php?id=', $row["user_id"], '"></a>';
        $user_id = $row["user_id"];
        $sql = "SELECT * FROM users WHERE id=$user_id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result2 as $row2) {
          echo $row2["name"], ":";
        }
        echo $row["created_at"], '</th>';
        echo '</tr>';
        echo '<tr>';
        if ($row["image"] != "") {
          echo '<td><img id="parent" src="chat_image.php?id=', $row["id"], ' alt="" height="232" width="232"/></td>';
          echo '</tr>';
          echo '<tr>';
        }
        echo '<td>', $row["text"], '</td>';
        echo '</tr>';
        echo '</thead>';
        echo '</table>';
      }
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
    }
    require_once("paging2.php");
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
=======
<<<<<<< HEAD
  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <img src="image.php?id=<?php echo $id; ?>" style="max-width:350px;">
          <h2>
            <?php
        echo $item_name;
        ?>についてのチャット履歴
          </h2>
          <?php if (isset($_GET["page_id"])) {
          echo '<form action="loan.php?id=' . $id . '&chat=1&page_id=' . $now . '" method="POST"enctype="multipart/form-data">';
        } else {
          echo '<form action="loan.php?id=' . $id . '&chat=1" method="POST"enctype="multipart/form-data">';
        }
        ?>
          チャット:<input type="text" name="text" required>
          <label>画像選択:<br>
            <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
            <input type="file" multiple name="image" class="test" accept="image/*" onchange="previewImage(this);">
          </label>
          <!-- </div> -->
          <input type="hidden" name="list_id" value="<?php echo $id; ?>"><br>
          <input type="submit" value="送信">
          </form>
          <hr>
          <div>
            <?php
    try {
      $sql = "SELECT * FROM chat WHERE list_id=$id";
      $stm = $pdo->prepare($sql);
      $stm->execute();
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
      require_once("paging.php");
      foreach ($disp_data as $row) {
        echo '<table class="table table-striped">';
        echo '<thead><tr>';
        echo '<th><a href="profile.php?id=', $row["user_id"], '">', '<img id="image" height="100" width="100" src="my_image.php?id=', $row["user_id"], '"></a>';
        $user_id = $row["user_id"];
        $sql = "SELECT * FROM users WHERE id=$user_id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result2 as $row2) {
          echo $row2["name"], ":";
        }
        echo $row["created_at"], '</th>';
        echo '</tr>';
        echo '<tr>';
        if ($row["image"] != "") {
          echo '<td><img id="parent" src="chat_image.php?id=', $row["id"], ' alt="" height="232" width="232"/></td>';
          echo '</tr>';
          echo '<tr>';
        }
        echo '<td>', $row["text"], '</td>';
        echo '</tr>';
        echo '</thead>';
        echo '</table>';
      }
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
    }
    require_once("paging2.php");
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
          <li class="current"><a href="all.php">HOME</a></li>
          <li><a href="add_db.php">商品登録</a></li>
          <li><a href="list.php">一覧</a></li>
          <li><a href="mypage.php">マイページ</a></li>
          <li><a href="register.php">アカウント登録</a></li>
          <li><a href="login.php">ログイン</a></li>
        </ul>
      </div>
      <small>&copy; 2015 Bloom.</small>
    </footer>
    <!--/フッター-->
=======
  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <img src="image.php?id=<?php echo $id; ?>" style="max-width:350px;">
          <h2>
            <?php
        echo $item_name;
        ?>についてのチャット履歴
          </h2>
          <?php if (isset($_GET["page_id"])) {
          echo '<form action="loan.php?id=' . $id . '&chat=1&page_id=' . $now . '" method="POST"enctype="multipart/form-data">';
        } else {
          echo '<form action="loan.php?id=' . $id . '&chat=1" method="POST"enctype="multipart/form-data">';
        }
        ?>
          チャット:<input type="text" name="text" required>
          <label>画像選択:<br>
            <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
            <input type="file" multiple name="image" class="test" accept="image/*" onchange="previewImage(this);">
          </label>
          <!-- </div> -->
          <input type="hidden" name="list_id" value="<?php echo $id; ?>"><br>
          <input type="submit" value="送信">
          </form>
          <hr>
          <div>
            <?php
    try {
      $sql = "SELECT * FROM chat WHERE list_id=$id";
      $stm = $pdo->prepare($sql);
      $stm->execute();
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
      require_once("paging.php");
      foreach ($disp_data as $row) {
        echo '<table class="table table-striped">';
        echo '<thead><tr>';
        echo '<th><a href="profile.php?id=', $row["user_id"], '">', '<img id="image" height="100" width="100" src="my_image.php?id=', $row["user_id"], '"></a>';
        $user_id = $row["user_id"];
        $sql = "SELECT * FROM users WHERE id=$user_id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result2 as $row2) {
          echo $row2["name"], ":";
        }
        echo $row["created_at"], '</th>';
        echo '</tr>';
        echo '<tr>';
        if ($row["image"] != "") {
          echo '<td><img id="parent" src="chat_image.php?id=', $row["id"], ' alt="" height="232" width="232"/></td>';
          echo '</tr>';
          echo '<tr>';
        }
        echo '<td>', $row["text"], '</td>';
        echo '</tr>';
        echo '</thead>';
        echo '</table>';
      }
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
    }
    require_once("paging2.php");
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
          <li class="current"><a href="all.php">HOME</a></li>
          <li><a href="add_db.php">商品登録</a></li>
          <li><a href="list.php">一覧</a></li>
          <li><a href="mypage.php">マイページ</a></li>
          <li><a href="register.php">アカウント登録</a></li>
          <li><a href="login.php">ログイン</a></li>
        </ul>
      </div>
      <small>&copy; 2015 Bloom.</small>
    </footer>
    <!--/フッター-->
=======
<audio id="audio"></audio>
<div id="fb-root"></div>

  
  <!--ヘッダー-->
  <?php require_once("header.php");?>

<div>
  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <section id="point">
        <img src="image.php?id=<?php echo $id;?>" style="max-width:350px;">
        <h2>
        <?php
        echo $item_name;
        ?>についてのチャット履歴</h2>
        <?php if(isset($_GET["page_id"])){
          echo '<form action="loan.php?id='.$id.'&chat=1&page_id='.$now.'" method="POST"enctype="multipart/form-data">';
        }
        else{
          echo '<form action="loan.php?id='.$id.'&chat=1" method="POST"enctype="multipart/form-data">';
        }
        ?>
        チャット:<input type="text" name="text" required>
    <label>画像選択:<br>
                    <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                            <input type="file" multiple name="image"class="test" accept="image/*"  onchange="previewImage(this);">
                              </label>
                  <!-- </div> -->
                  <input type="hidden" name="list_id" value="<?php echo $id;?>"><br>
                  <input type="submit" value="送信" >
          </form>
          <hr>
        <div>
    <?php
        try{
            $sql = "SELECT * FROM chat WHERE list_id=$id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            $books_num = count($result);
            $max_page = ceil($books_num / MAX);
            $start_no = ($now - 1) * MAX;
            $disp_data = array_slice($result, $start_no, MAX, true);
            foreach($disp_data as $row){
            echo '<table class="table table-striped">';
            echo '<thead><tr>';
            echo '<th><a href="profile.php?id=',$row["user_id"],'">','<img id="image" height="100" width="100" src="my_image.php?id=',$row["user_id"],'"></a>';
            $user_id=$row["user_id"];
            $sql = "SELECT * FROM users WHERE id=$user_id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result2=$stm->fetchAll(PDO::FETCH_ASSOC);
            foreach($result2 as $row2){
              echo $row2["name"],":";
            }
            echo $row["created_at"],'</th>';
            echo '</tr>';
            echo '<tr>';
            if($row["image"]!=""){
            echo '<td><img id="parent" src="chat_image.php?id=',$row["id"],' alt="" height="232" width="232"/></td>';
            echo '</tr>';
            echo '<tr>';
            }
            echo '<td>',$row["text"],'</td>';
            echo '</tr>';
            echo '</thead>';
            echo '</table>';
            }
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
        }
        echo '全件数'. $books_num. '件'. '　';
            if($now > 1){ // リンクをつけるかの判定
                echo '<a href=loan.php?id='.$id.'&page_id='.($now - 1).'>前へ</a>'. '　';
            } else {
                echo '前へ'. '　';
            }
            
            for($i = 1; $i <= $max_page; $i++){
                if ($i == $now) {
                    echo $now. '　'; 
                } else {
                    echo '<a href=loan.php?id='.$id.'&page_id='. $i. '>'. $i. '</a>'. '　';
                }
            }
             
            if($now < $max_page){ // リンクをつけるかの判定
                echo '<a href=loan.php?id='.$id.'&page_id='.($now + 1).'>次へ</a>'. '　';
            } else {
                echo '次へ';
            }
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