<?php
session_start();
require_once('../lib/util.php');
<<<<<<< HEAD
$gobackURL = 'list.php';
=======
<<<<<<< HEAD
$gobackURL = 'list.php';
=======
$gobackURL ='list.php';
>>>>>>> root/master
>>>>>>> root/master
require_once "db_connect.php";

if ($_SESSION["admin"] == 0) {
  header("location: all.php");
  exit;
}
?>

<!DOCTYPE html>
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<?php require_once("head.php")?>
>>>>>>> root/master
>>>>>>> root/master
<title>貸し借り|一覧</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <div id="header">
    <div class="game_bar" style="background-image: url(images/main_visual.jpg);">
      <div class="game_title">
        <a href="all.php"><img src="images/logo.png" class="mr5" /></a>
        <a id='hsb_name' href="all.php">貸し借りサイト</a>
        <div id="hsb_l_search" class="wiki_center hsb_search_box l_size_only">
          <div class="hsb_content">
            <i id="hsb_search_icon" class="fa fa-search hsb_icon"></i>
            <input type="search" data-id="header-search-l" value="" class="textbox hsb_text_area">
          </div>
        </div>
        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        ?>
        <a href="javascript:if(confirm('ログアウトしますか？')) location.href='logout.php';" style="width:30px;"><img height="30"
            src="my_image.php?id=<?php echo $_SESSION["id"]; ?>" style="border-radius: 50%" /></a>

        <?php } else { ?>
        <a href="javascript:void(0);" style="width:30px;" class="open_login_menu pl5 pr5"><img
            src="https://cdn08.net/pokemongo/wiki/login.png" alt="ログイン"></a>
        <?php } ?>
      </div>
      <div id="menu_s">
        <div>
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
          <div><a href="all.php"><img src="images/home.png" style="width:70px" /><span>HOME</span></a></div>
          <div><a href="add_db.php"><img src="images/register.png" style="width:70px" /><span>商品登録</span></span></a>
          </div>
          <div><a href="list.php"><img src="https://cdn08.net/dqwalk/data/img0/img2_5.png?6e1"
                style="width:70px" /><span>一覧</span></a></div>
          <div><a href="mypage.php"><img src="https://cdn08.net/dqwalk/data/img0/img93_5.png?87b"
                style="width:70px" /><span>マイページ</span></span></a></div>
          <div><a href="contact.php"><img src="images/contact.png" style="width:70px" /><span>お問い合わせ</span></a></div>
        </div>
      </div>
      <span class="after"></span>
<<<<<<< HEAD
    </div>

=======
=======
    <?php
    $data=$_GET["id"];
        try{
            echo $data,'を';
            
            $sql = "DELETE FROM list WHERE id =$data";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            echo "削除しました。";
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
        }
            
            $sql = "DELETE FROM chat WHERE chat_id = $data";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);

            
            $sql = "DELETE FROM image_list WHERE list_id = $data";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            
            
            $sql = "DELETE FROM likes WHERE list_id = $data";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <hr>
    <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
</div>
      </section>
>>>>>>> root/master
    </div>

<<<<<<< HEAD
=======
    <!--サイド-->
    
      <?php
    require_once('side.php');
    ?>

    
    <!--/サイド-->
>>>>>>> root/master
>>>>>>> root/master
  </div>
  <div>
    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <h2>お知らせ</h2>
          <div>
            <?php
    $data = $_GET["id"];
    try {
      echo $data, 'を';

      $sql = "DELETE FROM list WHERE id =$data";
      $stm = $pdo->prepare($sql);
      $stm->execute();
      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
      echo "削除しました。";
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
    }

    $sql = "DELETE FROM chat WHERE chat_id = $data";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);


    $sql = "DELETE FROM image_list WHERE list_id = $data";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);


    $sql = "DELETE FROM likes WHERE list_id = $data";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    ?>
            <hr>
            <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
          </div>
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
          <li><a href="register.php">アカウント登録</a></li>
          <li><a href="login.php">ログイン</a></li>
        </ul>
      </div>
      <small>&copy; 2015 Bloom.</small>
    </footer>
    <!--/フッター-->

</body>

</html>