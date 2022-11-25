<?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
session_start();
require_once "db_connect.php";
$id = $_GET["id"];
define('MAX', '6');
if (isset($_SESSION["loggedin"])) {
<<<<<<< HEAD
  if($id==$_SESSION["id"]){
    header("Location:mypage.php");
  }
=======
>>>>>>> root/master
  $my_id = $_SESSION["id"];
} else {
  $my_id = 0;
}
$_SESSION["my_id"] = $_GET["id"];
#blockcount
$block_count = 0;
$block_count2 = 0;
try {
  //自分がブロックしているか
  $sql = "SELECT * FROM blocklist WHERE user_id =:user_id and my_id=:my_id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':user_id', $id, PDO::PARAM_STR);
  $stm->bindValue(':my_id', $my_id, PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $block_count += 1;
  }
  //相手にブロックされているか
  $sql = "SELECT * FROM blocklist WHERE user_id =:user_id and my_id=:my_id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':user_id', $my_id, PDO::PARAM_STR);
  $stm->bindValue(':my_id', $id, PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $block_count2 += 1;
  }
} catch (Exception $e) {
  echo 'エラーがありました。';
  echo $e->getMessage();
  exit();
}
<<<<<<< HEAD

$follow_count = 0;
$follow_count2 = 0;
try {
  //自分がフォローしているか
  $sql = "SELECT * FROM followlist WHERE user_id =:user_id and my_id=:my_id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':user_id', $id, PDO::PARAM_STR);
  $stm->bindValue(':my_id', $my_id, PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $follow_count += 1;
  }
  //相手にフォローされているか
  $sql = "SELECT * FROM followlist WHERE user_id =:user_id and my_id=:my_id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':user_id', $my_id, PDO::PARAM_STR);
  $stm->bindValue(':my_id', $id, PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $follow_count2 += 1;
  }
} catch (Exception $e) {
  echo 'エラーがありました。';
  echo $e->getMessage();
  exit();
}
=======
>>>>>>> root/master
$sql = "SELECT * FROM users WHERE id =:id";
$stm = $pdo->prepare($sql);
$stm->bindValue(':id', $id, PDO::PARAM_STR);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $name = $row["name"];
}
$myURL = 'profile.php';
$option = "&id=$id";
?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<<<<<<< HEAD
<title>貸し借り|マイページ</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>

  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
=======
<<<<<<< HEAD
<title>貸し借り|マイページ</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>

  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
=======
<title>貸し借り|マイページ</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>

  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
=======
  session_start();
  require_once "db_connect.php";
  $id=$_GET["id"];
  define('MAX','6');
  if(isset($_SESSION["loggedin"])){
  $my_id=$_SESSION["id"];
  }else{
    $my_id=0;
  }
  $_SESSION["my_id"]=$_GET["id"];
  #blockcount
  $block_count=0;
  $block_count2=0;
  try{
    //自分がブロックしているか
    $sql = "SELECT * FROM blocklist WHERE user_id =:user_id and my_id=:my_id";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id',$id,PDO::PARAM_STR);
    $stm->bindValue(':my_id',$my_id,PDO::PARAM_STR);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
      $block_count+=1;
    }
    //相手にブロックされているか
    $sql = "SELECT * FROM blocklist WHERE user_id =:user_id and my_id=:my_id";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id',$my_id,PDO::PARAM_STR);
    $stm->bindValue(':my_id',$id,PDO::PARAM_STR);
    $stm->execute();
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
      $block_count2+=1;
    }
}catch(Exception $e){
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
}
$sql = "SELECT * FROM users WHERE id =:id";
$stm = $pdo->prepare($sql);
$stm->bindValue(':id',$id,PDO::PARAM_STR);
$stm->execute();
$result=$stm->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row){
    $name=$row["name"];
}
?>
<!DOCTYPE html>
<?php require_once("head.php")?>
<title>貸し借り|マイページ</title>
</head>
<body>
<audio id="audio"></audio>
<div id="fb-root"></div>

  <!--ヘッダー-->
		<?php require_once("header.php");?>
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <h2>プロフィール</h2>
      <img id="image" height="150" width="150" src="my_image.php?id=<?php echo htmlspecialchars($id); ?>"><br>
      <?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master
      if ($row["admin"] == 0) {
        echo '<font size="10">', htmlspecialchars($row["name"]), '</font><br>';
      } else {
        echo '<font size="10">', htmlspecialchars($row["name"]), '<img src="images/admin.png" style="height:70px;"></font><br>';
<<<<<<< HEAD
      }
      if ($block_count == 0 && $block_count2 == 0) {
        try {
          $sql = "SELECT * FROM users WHERE id =:id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id', $id, PDO::PARAM_STR);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            echo '<font size="5">', htmlspecialchars($row["age"]), '歳</font><br>';
            echo '<font size="5">', htmlspecialchars($row["sex"]), '</font><br>';
            echo '<font size="3">', htmlspecialchars($row["email"]), '</font><br>';
            echo '<hr>コメント<br><font size="10">', htmlspecialchars($row["comment"]), '</font>';
          }
        } catch (Exception $e) {
          echo 'エラーがありました。';
          echo $e->getMessage();
          exit();
        }
            $sql = "SELECT * FROM followlist WHERE my_id =$id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $sth = $pdo->query($sql);
            $count = $sth->rowCount();
            echo '<hr>フォロー<br><font size="5">','<a href="followlist.php?id='.$_GET["id"].'">';
            echo $count."人</a><br></font><hr>";
            ?>
            <?php
            $sql = "SELECT * FROM followlist WHERE user_id =$id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $sth = $pdo->query($sql);
            $count2 = $sth->rowCount();
            echo 'フォロワー<br><font size="5">','<a href="followerlist.php?id='.$_GET["id"].'">';
            echo $count2."人</a><br></font><hr>";
            ?>
            <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        echo "<a href='user_chat.php?id={$row["id"]}' class='btn btn-success'>チャットをする</a>";
        echo '<form method="POST" action="detail.php?id=' . $row["id"] . '&good=1">';
        echo '</form>';
      }
    ?>
          <form action="follow.php" method="POST" enctype="multipart/form-data">
          <?php
          if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            if ($_SESSION['id'] !== $id) {
              if ($follow_count == 0) {
                echo "<br><a href='follow.php?id=$id' class='btn btn-danger'>フォローする</a>";
              } else {
                echo "<br><a href='follow.php?id=$id' class='btn btn-primary'>フォロー解除する</a>";
              }
            }
          }
          ?>
      <h2>
        <?php echo htmlspecialchars($name); ?>が出品している物
      </h2>
      <?php
        try {
          $sql = "SELECT * FROM list WHERE user_id=:id AND loan=0";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id', $id, PDO::PARAM_STR);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          require_once('paging.php');
          echo '<table class="table table-striped">';
          echo '<thead><tr>';
          echo '<th>', '掲載日', '</th>';
          echo '<th>', '貸出物', '</th>';
          echo '<th>', '画像', '</th>';
          echo '</tr></thead>';
          echo '<tbody>';
          foreach ($disp_data as $row) {
            echo '<tr>';
            echo '<td>', $row['created_at'], '</td>';
            echo '<td>', $row['item'], '</td>';
            echo "<td><a target='_blank' href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
            echo '</tr>';
          }
          echo '</tbody>';
          echo '</table>';
        } catch (Exception $e) {
          echo 'エラーがありました。';
          echo $e->getMessage();
          exit();
        }
        require_once('paging2.php');
      ?>
      <form action="block.php" method="POST" enctype="multipart/form-data">
        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
          if ($_SESSION['id'] !== $id) {
            if ($block_count == 0) {
              echo "<br><a href='block.php?id=$id' class='btn btn-danger'>ブロックする</a>";
            } else {
              echo "<br><a href='block.php?id=$id' class='btn btn-primary'>ブロックを解除する</a>";
            }
          }
        }
      } else if($block_count != 0 && $block_count2 != 0){
        echo "<h1>相互ブロックです。</h1>";
        if ($block_count == 0) {
          echo "<a href='block.php?id=$id' class='btn btn-danger'>ブロックする</a>";
        } else {
          echo "<a href='block.php?id=$id' class='btn btn-primary'>ブロックを解除する</a>";
        }
      } else if($block_count2 != 0){
        echo "<h1>あなたはこのユーザにブロックされています。</h1>";
        if ($block_count == 0) {
          echo "<a href='block.php?id=$id' class='btn btn-danger'>ブロックする</a>";
        } else {
          echo "<a href='block.php?id=$id' class='btn btn-primary'>ブロックを解除する</a>";
        }
      } else if($block_count != 0){
        echo "<h1>あなたはこのユーザをブロックしています。</h1>";
        if ($block_count == 0) {
          echo "<a href='block.php?id=$id' class='btn btn-danger'>ブロックする</a>";
        } else {
          echo "<a href='block.php?id=$id' class='btn btn-primary'>ブロックを解除する</a>";
        }
      }
        ?>
      </form>
    </div>
    <!--/メイン-->
    <!--サイド-->
    <?php
    require_once('side.php');
    ?>
=======
      }
      if ($block_count2 == 0) {
        try {
          $sql = "SELECT * FROM users WHERE id =:id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id', $id, PDO::PARAM_STR);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            echo '<font size="5">', htmlspecialchars($row["age"]), '歳</font><br>';
            echo '<font size="5">', htmlspecialchars($row["sex"]), '</font><br>';
            echo '<font size="3">', htmlspecialchars($row["email"]), '</font><br>';
            echo '<hr>コメント<br><font size="10">', htmlspecialchars($row["comment"]), '</font><hr>';
          }
        } catch (Exception $e) {
          echo 'エラーがありました。';
          echo $e->getMessage();
          exit();
<<<<<<< HEAD
=======
=======
      if($row["admin"]==0){
        echo '<font size="10">',htmlspecialchars($row["name"]),'</font><br>';
      }else{
        echo '<font size="10">',htmlspecialchars($row["name"]),'<img src="images/admin.png" style="height:70px;"></font><br>';
      }
      if($block_count2==0){
        try{
            $sql = "SELECT * FROM users WHERE id =:id";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':id',$id,PDO::PARAM_STR);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
                echo '<font size="5">',htmlspecialchars($row["age"]),'歳</font><br>';
                echo '<font size="5">',htmlspecialchars($row["sex"]),'</font><br>';
                echo '<font size="3">',htmlspecialchars($row["email"]),'</font><br>';
                echo '<hr>コメント<br><font size="10">',htmlspecialchars($row["comment"]),'</font><hr>';
            }
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
>>>>>>> root/master
>>>>>>> root/master
        }
      ?>

      <h2>
        <?php echo htmlspecialchars($name); ?>が出品している物
      </h2>
      <?php
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
        try {
          $sql = "SELECT * FROM list WHERE user_id=:id AND loan=0";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id', $id, PDO::PARAM_STR);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          require_once('paging.php');
          echo '<table class="table table-striped">';
          echo '<thead><tr>';
          echo '<th>', '掲載日', '</th>';
          echo '<th>', '貸出物', '</th>';
          echo '<th>', '画像', '</th>';
          echo '</tr></thead>';
          echo '<tbody>';
          foreach ($disp_data as $row) {
            echo '<tr>';
            echo '<td>', $row['created_at'], '</td>';
            echo '<td>', $row['item'], '</td>';
            echo "<td><a target='_blank' href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
            echo '</tr>';
          }
          echo '</tbody>';
          echo '</table>';
        } catch (Exception $e) {
          echo 'エラーがありました。';
          echo $e->getMessage();
          exit();
<<<<<<< HEAD
        }
        require_once('paging2.php');
      ?>
      <form action="block.php" method="POST" enctype="multipart/form-data">
        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
          if ($_SESSION['name'] !== $name) {
            if ($block_count == 0) {
              echo "<a href='block.php?id=$id' class='btn btn-danger'>ブロックする</a>";
            } else {
              echo "<a href='block.php?id=$id' class='btn btn-primary'>ブロックを解除する</a>";
            }
          }
        }
      } else {
        echo "<h1>あなたはこのユーザにブロックされています。</h1>";
        if ($block_count == 0) {
          echo "<a href='block.php?id=$id' class='btn btn-danger'>ブロックする</a>";
        } else {
          echo "<a href='block.php?id=$id' class='btn btn-primary'>ブロックを解除する</a>";
        }
      }
        ?>
      </form>
    </div>
    <!--/メイン-->
    <!--サイド-->
    <?php
    require_once('side.php');
    ?>
=======
        }
        require_once('paging2.php');
      ?>
      <form action="block.php" method="POST" enctype="multipart/form-data">
        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
          if ($_SESSION['name'] !== $name) {
            if ($block_count == 0) {
              echo "<a href='block.php?id=$id' class='btn btn-danger'>ブロックする</a>";
            } else {
              echo "<a href='block.php?id=$id' class='btn btn-primary'>ブロックを解除する</a>";
            }
          }
        }
      } else {
        echo "<h1>あなたはこのユーザにブロックされています。</h1>";
        if ($block_count == 0) {
          echo "<a href='block.php?id=$id' class='btn btn-danger'>ブロックする</a>";
        } else {
          echo "<a href='block.php?id=$id' class='btn btn-primary'>ブロックを解除する</a>";
        }
      }
        ?>
      </form>
=======
        try{
            $sql = "SELECT * FROM list WHERE user_id=:id AND loan=0";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':id',$id,PDO::PARAM_STR);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            $books_num = count($result);
            $max_page = ceil($books_num / MAX);
            if(!isset($_GET['page_id'])){
                $now = 1;
            }else{
                $now = $_GET['page_id'];
            }
            $start_no = ($now - 1) * MAX;
            $disp_data = array_slice($result, $start_no, MAX, true);
            echo '<table class="table table-striped">';
            echo '<thead><tr>';
            echo '<th>','掲載日','</th>';
            echo '<th>','貸出物','</th>';
            echo '<th>','画像','</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            foreach($disp_data as $row){
                echo '<tr>';
                echo '<td>',$row['created_at'],'</td>';
                echo '<td>',$row['item'],'</td>';
                echo "<td><a target='_blank' href=detail.php?id={$row["id"]}>",'<img height="100" width="100" src="image.php?id=',$row['id'],'"></a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
        }
        echo '全件数'. $books_num. '件'. '　';
            if($now > 1){ // リンクをつけるかの判定
                echo '<a href=profile.php?id='.$id.'&page_id='.($now - 1).'>前へ</a>'. '　';
            } else {
                echo '前へ'. '　';
            }
            
            for($i = 1; $i <= $max_page; $i++){
                if ($i == $now) {
                    echo $now. '　'; 
                } else {
                    echo '<a href=profile.php?id='.$id.'&page_id='. $i. '>'. $i. '</a>'. '　';
                }
            }
             
            if($now < $max_page){ // リンクをつけるかの判定
                echo '<a href=profile.php?id='.$id.'&page_id='.($now + 1).'>次へ</a>'. '　';
            } else {
                echo '次へ';
            }
      ?>
      <form action="block.php" method="POST"enctype="multipart/form-data">
      <?php 
      if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      if($_SESSION['name']!==$name){
        if($block_count==0){
          echo "<a href='block.php?id=$id' class='btn btn-danger'>ブロックする</a>";
        }else{
          echo "<a href='block.php?id=$id' class='btn btn-primary'>ブロックを解除する</a>";
        }
      }
    } }else{
      echo "<h1>あなたはこのユーザにブロックされています。</h1>";
      if($block_count==0){
        echo "<a href='block.php?id=$id' class='btn btn-danger'>ブロックする</a>";
      }else{
        echo "<a href='block.php?id=$id' class='btn btn-primary'>ブロックを解除する</a>";
      }
    }?>
          </form>
>>>>>>> root/master
    </div>
    <!--/メイン-->
    <!--サイド-->
<<<<<<< HEAD
    <?php
    require_once('side.php');
    ?>
=======
    
      <?php
    require_once('side.php');
    ?>

    
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
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