<?php
<<<<<<< HEAD
session_start();
require_once('db_connect.php');
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|マイページ</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>

  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
session_start();
$user = 'root';
$password = '';
$dbName = 'loan_db';
$host = 'localhost:3306';
$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
<<<<<<< HEAD
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|マイページ</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>

  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
=======
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|マイページ</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>

  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
=======
  session_start();
  $user='root';
  $password='';
  $dbName = 'loan_db';
  $host = 'localhost:3306';
  $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
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

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master

      <?php
    if (!isset($_SESSION["loggedin"])) {
      echo "<h2>この機能を利用するにはログインしてください。</h2>";
      echo "<a href='login.php' class='btn btn-danger'>ログイン</a>";
    } else {
      echo "<h2>プロフィール</h2>";
      if (isset($_SESSION["id"])) {
        $id = $_SESSION["id"];
      } else {
        $id = 0;
      }
      try {
<<<<<<< HEAD
=======
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
>>>>>>> root/master
        $sql = "SELECT * FROM users WHERE id =:id";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':id', $id, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
          if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            echo '<img id="image" height="150" width="150" src="my_image.php?id=', $row["id"], '"><br>';
            echo '<font size="10">', $row["name"], '</font><hr>';
            echo '<font size="5">', $row["age"], '歳</font><br>';
            echo '<font size="5">', $row["sex"], '</font><br>';
            echo '<font size="3">', $row["email"], '</font><br>';
<<<<<<< HEAD
            if($row["checked"]==0 && $row["email"]!=""){
              echo "<div style='color:red;'>認証してください。</div><a class='btn btn-primary' href='mb_send_mail.php?email=".$row["email"]."'>認証する</a>";
            }
            echo '<hr>コメント<br><font size="10">', $row["comment"], '</font><br>';
            echo '<hr>残金<br><font size="10">￥', number_format($row['money']), '</font>';
            echo '<hr>ポイント<br><font size="10">', number_format($row['point']), 'p</font>';
            echo '<br><a href="shop_list.php"><img src="images/point.png"></a>';
            ?>
            <?php
            $sql = "SELECT * FROM followlist WHERE my_id =$id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $sth = $pdo->query($sql);
            $count = $sth->rowCount();
            echo '<hr>フォロー<br><font size="5">','<a href="followlist.php">';
            echo $count."人</a><br></font><hr>";
            ?>
            <?php
            $sql = "SELECT * FROM followlist WHERE user_id =$id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            $sth = $pdo->query($sql);
            $count2 = $sth->rowCount();
            echo 'フォロワー<br><font size="5">','<a href="followerlist.php">';
            echo $count2."人</a><br></font><hr>";
            ?>
            <?php
            echo '<a href="edit.php" class="btn btn-primary">編集する</a><hr>';
            echo '<a href="blocklist.php" class="btn btn-primary">ブロックリスト</a><hr>';
            echo '<a href="reservation_list.php" class="btn btn-primary">予約された商品</a><hr>';
            echo '<a href="eturan.php" class="btn btn-primary">閲覧履歴</a><hr>';
            if($row["admin"]==1){
              echo "<a href='admin.php' class='btn btn-danger'>管理者ページに行く</a>";
            }
          }
=======
            echo '<hr>コメント<br><font size="10">', $row["comment"], '</font><br>';
            echo '<hr>残金<br><font size="10">￥', number_format($row['money']), '</font><hr>';
            echo '<a href="edit.php" class="btn btn-primary">編集する</a><hr>';
<<<<<<< HEAD
            echo '<a href="blocklist.php" class="btn btn-primary">ブロックリスト</a><hr>';
            echo '<a href="eturan.php" class="btn btn-primary">閲覧履歴</a><hr>';
          }
=======
            echo '<a href="blocklist.php" class="btn btn-primary">ブロックリスト</a><hr>';
            echo '<a href="eturan.php" class="btn btn-primary">閲覧履歴</a><hr>';
          }
=======
    
    <?php
    if(!isset($_SESSION["loggedin"])){
      echo "<h2>この機能を利用するにはログインしてください。</h2>";
      echo "<a href='login.php' class='btn btn-danger'>ログイン</a>";
    }else{
    echo "<h2>プロフィール</h2>";
    if(isset($_SESSION["id"])){
    $id=$_SESSION["id"];
    }else{
      $id=0;
    }
    try{
      $pdo=new PDO($dsn,$user,$password);
      $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
      $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT * FROM users WHERE id =:id";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':id',$id,PDO::PARAM_STR);
      $stm->execute();
      $result=$stm->fetchAll(PDO::FETCH_ASSOC);
      foreach($result as $row){
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true){
            echo '<img id="image" height="150" width="150" src="my_image.php?id=',$row["id"],'"><br>';
            echo '<font size="10">',$row["name"],'</font><hr>';
            echo '<font size="5">',$row["age"],'歳</font><br>';
            echo '<font size="5">',$row["sex"],'</font><br>';
            echo '<font size="3">',$row["email"],'</font><br>';
            echo '<hr>コメント<br><font size="10">',$row["comment"],'</font><br>';
            echo '<hr>残金<br><font size="10">￥',number_format($row['money']),'</font><hr>';
            echo '<a href="edit.php" class="btn btn-primary">編集する</a><hr>';
            echo '<a href="blocklist.php" class="btn btn-primary">ブロックリスト</a><hr>';
            echo '<a href="eturan.php" class="btn btn-primary">閲覧履歴</a><hr>';
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
        }
      } catch (Exception $e) {
        echo 'エラーがありました。';
        echo $e->getMessage();
        exit();
      }
<<<<<<< HEAD

    ?>
      <h2>出品中</h2>
      <?php
      try {
        $sql = "SELECT * FROM list WHERE user_id=$id and loan=0";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo '<table class="table table-striped">';
        echo '<thead><tr>';
        echo '<th>', '掲載日', '</th>';
        echo '<th>', '貸出物', '</th>';
        echo '<th>', 'ジャンル', '</th>';
        echo '<th>', '金額', '</th>';
        echo '<th>', '画像', '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($result as $row) {
          echo '<tr>';
          echo '<td>', $row['created_at'], '</td>';
          echo '<td>', $row['item'], '</td>';
          echo '<td>', $row['kind'], '</td>';
          echo '<td>￥', number_format($row['money']), '</td>';
          echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
          echo '</tr>';
=======
<<<<<<< HEAD

    ?>
      <h2>出品中</h2>
      <?php
      try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM list WHERE user_id=$id and loan=0";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo '<table class="table table-striped">';
        echo '<thead><tr>';
        echo '<th>', '掲載日', '</th>';
        echo '<th>', '貸出物', '</th>';
        echo '<th>', 'ジャンル', '</th>';
        echo '<th>', '金額', '</th>';
        echo '<th>', '画像', '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($result as $row) {
          echo '<tr>';
          echo '<td>', $row['created_at'], '</td>';
          echo '<td>', $row['item'], '</td>';
          echo '<td>', $row['kind'], '</td>';
          echo '<td>￥', number_format($row['money']), '</td>';
          echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
          echo '</tr>';
=======
<<<<<<< HEAD

    ?>
      <h2>出品中</h2>
      <?php
      try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM list WHERE user_id=$id and loan=0";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo '<table class="table table-striped">';
        echo '<thead><tr>';
        echo '<th>', '掲載日', '</th>';
        echo '<th>', '貸出物', '</th>';
        echo '<th>', 'ジャンル', '</th>';
        echo '<th>', '金額', '</th>';
        echo '<th>', '画像', '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($result as $row) {
          echo '<tr>';
          echo '<td>', $row['created_at'], '</td>';
          echo '<td>', $row['item'], '</td>';
          echo '<td>', $row['kind'], '</td>';
          echo '<td>￥', number_format($row['money']), '</td>';
          echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
          echo '</tr>';
=======
    }catch(Exception $e){
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
  }
  
    ?>
      <h2>出品中</h2>
      <?php
        try{
            $pdo=new PDO($dsn,$user,$password);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM list WHERE user_id=$id and loan=0";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            echo '<table class="table table-striped">';
            echo '<thead><tr>';
            echo '<th>','掲載日','</th>';
            echo '<th>','貸出物','</th>';
            echo '<th>','ジャンル','</th>';
            echo '<th>','金額','</th>';
            echo '<th>','画像','</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            foreach($result as $row){
                echo '<tr>';
                echo '<td>',$row['created_at'],'</td>';
                echo '<td>',$row['item'],'</td>';
                echo '<td>',$row['kind'],'</td>';
                echo '<td>￥',number_format($row['money']),'</td>';
                echo "<td><a href=detail.php?id={$row["id"]}>",'<img height="100" width="100" src="image.php?id=',$row['id'],'"></a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
        }
      ?>
      <?php
      try{
        $count=0;
        $pdo=new PDO($dsn,$user,$password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM likes WHERE my_id=$id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result=$stm->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
          $count+=1;
          $main_list[]=$row["list_id"];
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
        }
        echo '</tbody>';
        echo '</table>';
      } catch (Exception $e) {
        echo 'エラーがありました。';
        echo $e->getMessage();
        exit();
      }
      ?>
      <?php
<<<<<<< HEAD
      try {
        $count = 0;
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
      try {
        $count = 0;
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
>>>>>>> root/master
        $sql = "SELECT * FROM likes WHERE my_id=$id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
          $count += 1;
          $main_list[] = $row["list_id"];
<<<<<<< HEAD
        }
      } catch (Exception $e) {
        echo 'エラーがありました。';
        echo $e->getMessage();
        exit();
      }
      ?>
      <?php
      if ($count != 0) {
        $main_list = implode(",", $main_list);
        $sql = "SELECT * FROM list WHERE id IN ($main_list)";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo "<h2>「いいね」した商品</h2>";
        echo '<table class="table table-striped">';
        echo '<thead><tr>';
        echo '<th>', '掲載日', '</th>';
        echo '<th>', '貸出物', '</th>';
        echo '<th>', 'ジャンル', '</th>';
        echo '<th>', '金額', '</th>';
        echo '<th>', '画像', '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($result as $row) {
          echo '<tr>';
          echo '<td>', $row['created_at'], '</td>';
          echo '<td>', $row['item'], '</td>';
          echo '<td>', $row['kind'], '</td>';
          echo '<td>￥', number_format($row['money']), '</td>';
          echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
          echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
      }
    }
=======
<<<<<<< HEAD
        }
      } catch (Exception $e) {
        echo 'エラーがありました。';
        echo $e->getMessage();
        exit();
      }
      ?>
      <?php
      if ($count != 0) {
        $main_list = implode(",", $main_list);
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM list WHERE id IN ($main_list)";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo "<h2>「いいね」した商品</h2>";
        echo '<table class="table table-striped">';
        echo '<thead><tr>';
        echo '<th>', '掲載日', '</th>';
        echo '<th>', '貸出物', '</th>';
        echo '<th>', 'ジャンル', '</th>';
        echo '<th>', '金額', '</th>';
        echo '<th>', '画像', '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($result as $row) {
          echo '<tr>';
          echo '<td>', $row['created_at'], '</td>';
          echo '<td>', $row['item'], '</td>';
          echo '<td>', $row['kind'], '</td>';
          echo '<td>￥', number_format($row['money']), '</td>';
          echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
          echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
      }
    }
=======
        }
      } catch (Exception $e) {
        echo 'エラーがありました。';
        echo $e->getMessage();
        exit();
      }
      ?>
      <?php
      if ($count != 0) {
        $main_list = implode(",", $main_list);
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM list WHERE id IN ($main_list)";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo "<h2>「いいね」した商品</h2>";
        echo '<table class="table table-striped">';
        echo '<thead><tr>';
        echo '<th>', '掲載日', '</th>';
        echo '<th>', '貸出物', '</th>';
        echo '<th>', 'ジャンル', '</th>';
        echo '<th>', '金額', '</th>';
        echo '<th>', '画像', '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($result as $row) {
          echo '<tr>';
          echo '<td>', $row['created_at'], '</td>';
          echo '<td>', $row['item'], '</td>';
          echo '<td>', $row['kind'], '</td>';
          echo '<td>￥', number_format($row['money']), '</td>';
          echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
          echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
      }
    }
=======
        if($count!=0){
          $main_list=implode(",",$main_list);
          $pdo=new PDO($dsn,$user,$password);
          $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
          $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
          $sql = "SELECT * FROM list WHERE id IN ($main_list)";
          $stm = $pdo->prepare($sql);
          $stm->execute();
          $result=$stm->fetchAll(PDO::FETCH_ASSOC);
          echo "<h2>「いいね」した商品</h2>";
          echo '<table class="table table-striped">';
          echo '<thead><tr>';
          echo '<th>','掲載日','</th>';
          echo '<th>','貸出物','</th>';
          echo '<th>','ジャンル','</th>';
          echo '<th>','金額','</th>';
          echo '<th>','画像','</th>';
          echo '</tr></thead>';
          echo '<tbody>';
          foreach($result as $row){
              echo '<tr>';
              echo '<td>',$row['created_at'],'</td>';
              echo '<td>',$row['item'],'</td>';
              echo '<td>',$row['kind'],'</td>';
              echo '<td>￥',number_format($row['money']),'</td>';
              echo "<td><a href=detail.php?id={$row["id"]}>",'<img height="100" width="100" src="image.php?id=',$row['id'],'"></a></td>';
              echo '</tr>';
          }
          echo '</tbody>';
          echo '</table>';
        }
      }
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
      ?>
    </div>
    <!--/メイン-->

    <!--サイド-->
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
>>>>>>> root/master

    <?php
      require_once('side.php');
      ?>


<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
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
  <!-- <footer>
    <div id="footer_nav">
    <ul>
        <li class="current"><a href="index.php">HOME</a></li>
        <li><a href="add_db.php">商品登録</a></li>
        <li><a href="user_chat_list.php">一覧</a></li>
        <li><a href="mypage.php">マイページ</a></li>
        <li><a href="register.php">アカウント登録</a></li><li><a href="login.php">ログイン</a></li>
      </ul>
    </div>
    <small>&copy; 2015 Bloom.</small>
  </footer> -->
  <!--/フッター-->

</body>

</html>