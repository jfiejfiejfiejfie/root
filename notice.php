<?php
session_start();
require_once('../lib/util.php');
<<<<<<< HEAD
$gobackURL = 'all.php';
require_once "db_connect.php";
if (isset($_GET["check"])) {
  $check = $_GET["check"];
  if ($check == 1) {
    $id = $_GET["good"];
    $sql = "SELECT * FROM likes WHERE list_id=$id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result_likes = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_likes as $row_likes) {
      $likes_list[] = $row_likes["id"];
    }
    $likes_list = implode(",", $likes_list);
    $sql = "UPDATE likes SET checked=1 where id in ($likes_list)";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    header('Location:notice.php');
  } elseif ($check == 2) {
    $id = $_GET["loan"];
    $sql = "UPDATE list SET checked=1 where id = $id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    header('Location:notice.php');
  } elseif ($check == 3) {
    $id = $_GET["chat"];
    $sql = "UPDATE chat SET checked=1 where id = $id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    header('Location:notice.php');
=======
$gobackURL ='all.php';
require_once "db_connect.php";
if(isset($_GET["check"])){
  $check=$_GET["check"];
  if($check==1){
    $id=$_GET["good"];
    $sql = "SELECT * FROM likes WHERE list_id=$id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result_likes=$stm->fetchAll(PDO::FETCH_ASSOC);
    foreach($result_likes as $row_likes){
      $likes_list[]=$row_likes["id"];
    }
    $likes_list=implode(",",$likes_list);
    $sql="UPDATE likes SET checked=1 where id in ($likes_list)";
    $stm=$pdo->prepare($sql);
    $stm->execute();
    header('Location:notice.php');
  }elseif($check==2){
    $id=$_GET["loan"];
    $sql="UPDATE list SET checked=1 where id = $id";
    $stm=$pdo->prepare($sql);
    $stm->execute();
    header('Location:notice.php');
  }elseif ($check==3) {
  $id=$_GET["chat"];
  $sql="UPDATE chat SET checked=1 where id = $id";
  $stm=$pdo->prepare($sql);
  $stm->execute();
  header('Location:notice.php');
>>>>>>> root/master
  }
}
?>

<!DOCTYPE html>
<<<<<<< HEAD
<?php require_once("head.php") ?>
=======
<?php require_once("head.php")?>
>>>>>>> root/master
<title>貸し借り|一覧</title>
</head>

<body>
<<<<<<< HEAD
  <script src="js/original.js"></script>
  <div id="cursor"></div>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <!-- 入力フォームを作る -->

    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
          <h1>お知らせ欄</h1>
          <?php
        if (!isset($_SESSION["loggedin"])) {
          echo "<h2>この機能を利用するにはログインしてください。</h2>";
          echo "<a href='login.php' class='btn btn-danger'>ログイン</a>";
        } else {
          $count = 0;
          $count2 = 0;
          $count_chat = 0;
          $count_chat2 = 0;
          $all_count = 0;
          $id = $_SESSION["id"];
          $sql = "SELECT * FROM list WHERE user_id=$id";
          $stm = $pdo->prepare($sql);
          $stm->execute();
          $result_chat = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result_chat as $row_chat) {
            $count_chat += 1;
            $chat_list[] = $row_chat["id"];
          }
          if ($count_chat != 0) {
            $chat_list = implode(",", $chat_list);
            $sql = "SELECT * FROM chat WHERE list_id IN ($chat_list) and checked=0";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $chat_result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($chat_result as $row_chat2) {
              $count_chat2 += 1;
              $chat_list2[] = $row_chat2["list_id"];
            }
          }
          $sql = "SELECT * FROM list WHERE user_id=$id";
          $stm = $pdo->prepare($sql);
          $stm->execute();
          $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result2 as $row2) {
            $count += 1;
            $list_list[] = $row2["id"];
          }
          if ($count != 0) {
            $list_list = implode(",", $list_list);
            $sql = "SELECT * FROM likes WHERE list_id IN ($list_list) and checked=0";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
              $count2 += 1;
              $main_list[] = $row["list_id"];
            }
          }
        ?>
          <?php
          if ($count2 != 0) {
            $main_list = implode(",", $main_list);
            $sql = "SELECT * FROM list WHERE id IN ($main_list) and checked=0";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            echo "<h2>この商品が「いいね」されました。</h2>";
            echo '<table class="table table-striped">';
            echo '<thead><tr>';
            echo '<th>', '貸出物', '</th>';
            echo '<th>', '金額', '</th>';
            echo '<th>', '画像', '</th>';
            echo '<th>', 'いいね数', '</th>';
            echo '<th>', '既読にする', '</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            foreach ($result as $row) {
              $good_count = 0;
              echo '<tr>';
              echo '<td>', $row['item'], '</td>';
              echo '<td>￥', number_format($row['money']), '</td>';
              echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
              $sql = "SELECT * FROM likes WHERE list_id=" . $row["id"];
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result_good = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result_good as $row_good) {
                $good_count += 1;
              }
              echo "<td><img src='images/good.png' style='max-width:50px'><div style='font-size:35px;'>", $good_count, '</div></td>';
              echo '<td><form method="POST" action="notice.php?good=' . $row["id"] . '&check=1"><input id="check" type="submit" value="〆" name="#" ></form></td>';
              echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
          } else {
            $all_count += 1;
          }
        ?>
          <?php
          $loan_count = 0;
          $sql = "SELECT * FROM list WHERE  user_id=:id and loan=1 and checked=0";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id', $id, PDO::PARAM_STR);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            $loan_count += 1;
          }
          if ($loan_count > 0) {
            $sql = "SELECT * FROM list WHERE  user_id=:id and loan=1 and checked=0";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':id', $id, PDO::PARAM_STR);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            echo "<h2>この商品が「購入」されました。</h2>";
            echo '<table class="table table-striped">';
            echo '<thead><tr>';
            echo '<th>', '掲載日', '</th>';
            echo '<th>', '貸出物', '</th>';
            echo '<th>', 'ジャンル', '</th>';
            echo '<th>', '金額', '</th>';
            echo '<th>', '画像', '</th>';
            echo '<th>', '既読にする', '</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            foreach ($result as $row) {
              echo '<tr>';
              echo '<td>', $row['created_at'], '</td>';
              echo '<td>', $row['item'], '</td>';
              echo '<td>', $row['kind'], '</td>';
              echo '<td>￥', number_format($row['money']), '</td>';
              echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
              echo '<td><form method="POST" action="notice.php?loan=' . $row["id"] . '&check=2"><input id="check" type="submit" value="〆" name="#" ></form></td>';
              echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
          } else {
            $all_count += 1;
          }
        ?>
          <?php
          if ($count_chat2 != 0) {
            $chat_list2 = implode(",", $chat_list2);
            $sql = "SELECT * FROM chat WHERE list_id IN ($chat_list2) and checked=0";
            $stm = $pdo->prepare($sql);
            // $stm->bindValue(':id',$id,PDO::PARAM_STR);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            echo "<h2>この商品に「チャット」が届きました。</h2>";
            echo '<table class="table table-striped">';
            echo '<thead><tr>';
            echo '<th>', '時間', '</th>';
            echo '<th>', 'コメント内容', '</th>';
            echo '<th>', '画像', '</th>';
            echo '<th>', '既読にする', '</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            foreach ($result as $row) {
              echo '<tr>';
              echo '<td>', $row['created_at'], '</td>';
              echo '<td>', $row['text'], '</td>';
              echo "<td><a href=loan.php?id={$row["list_id"]}>", '<img height="100" width="100" src="image.php?id=', $row['list_id'], '"></a></td>';
              echo '<td><form method="POST" action="notice.php?chat=' . $row["id"] . '&check=3"><input id="check" type="submit" value="〆" name="#" ></form></td>';
              echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
          } else {
            $all_count += 1;
          }
          if ($all_count == 3) {
            echo "<h2>現在お知らせはありません。</h2>";
          }
        }
            ?>

          <!-- <style>
=======
<script src="js/original.js"></script>
<div id="cursor"></div>
<audio id="audio"></audio>
<div id="fb-root"></div>

  
  <!--ヘッダー-->
		  <?php require_once("header.php");?>

<div>
  <!-- 入力フォームを作る -->
  
  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <section id="point">
        <h1>お知らせ欄</h1>
        <?php
        if(!isset($_SESSION["loggedin"])){
          echo "<h2>この機能を利用するにはログインしてください。</h2>";
          echo "<a href='login.php' class='btn btn-danger'>ログイン</a>";
        }else{
        $count=0;
        $count2=0;
        $count_chat=0;
        $count_chat2=0;
        $all_count=0;
        $id=$_SESSION["id"];
        $sql = "SELECT * FROM list WHERE user_id=$id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result_chat=$stm->fetchAll(PDO::FETCH_ASSOC);
        foreach($result_chat as $row_chat){
          $count_chat+=1;
          $chat_list[]=$row_chat["id"];
        }
        if($count_chat!=0){
          $chat_list=implode(",",$chat_list);
          $sql = "SELECT * FROM chat WHERE list_id IN ($chat_list) and checked=0";
          $stm = $pdo->prepare($sql);
          $stm->execute();
          $chat_result=$stm->fetchAll(PDO::FETCH_ASSOC);
          foreach($chat_result as $row_chat2){
            $count_chat2+=1;
            $chat_list2[]=$row_chat2["list_id"];
          }
        }
        $sql = "SELECT * FROM list WHERE user_id=$id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result2=$stm->fetchAll(PDO::FETCH_ASSOC);
        foreach($result2 as $row2){
          $count+=1;
          $list_list[]=$row2["id"];
        }
        if($count!=0){
        $list_list=implode(",",$list_list);
        $sql = "SELECT * FROM likes WHERE list_id IN ($list_list) and checked=0";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result=$stm->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
          $count2+=1;
          $main_list[]=$row["list_id"];
        }
      }
      ?>
      <?php
        if($count2!=0){
          $main_list=implode(",",$main_list);
          $sql = "SELECT * FROM list WHERE id IN ($main_list) and checked=0";
          $stm = $pdo->prepare($sql);
          $stm->execute();
          $result=$stm->fetchAll(PDO::FETCH_ASSOC);
          echo "<h2>この商品が「いいね」されました。</h2>";
          echo '<table class="table table-striped">';
          echo '<thead><tr>';
          echo '<th>','貸出物','</th>';
          echo '<th>','金額','</th>';
          echo '<th>','画像','</th>';
          echo '<th>','いいね数','</th>';
          echo '<th>','既読にする','</th>';
          echo '</tr></thead>';
          echo '<tbody>';
          foreach($result as $row){
              $good_count=0;
              echo '<tr>';
              echo '<td>',$row['item'],'</td>';
              echo '<td>￥',number_format($row['money']),'</td>';
              echo "<td><a href=detail.php?id={$row["id"]}>",'<img height="100" width="100" src="image.php?id=',$row['id'],'"></a></td>';
              $sql = "SELECT * FROM likes WHERE list_id=".$row["id"];
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result_good=$stm->fetchAll(PDO::FETCH_ASSOC);
              foreach($result_good as $row_good){
                $good_count+=1;
              }
              echo "<td><img src='images/good.png' style='max-width:50px'><div style='font-size:35px;'>",$good_count,'</div></td>';
              echo '<td><form method="POST" action="notice.php?good='.$row["id"].'&check=1"><input id="check" type="submit" value="〆" name="#" ></form></td>';
              echo '</tr>';
          }
          echo '</tbody>';
          echo '</table>';
        }else{
          $all_count+=1;
        }
      ?>
      <?php
        $loan_count=0;
        $sql = "SELECT * FROM list WHERE  user_id=:id and loan=1 and checked=0";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':id',$id,PDO::PARAM_STR);
        $stm->execute();
        $result=$stm->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row){
          $loan_count+=1;
        }
        if($loan_count>0){
          $sql = "SELECT * FROM list WHERE  user_id=:id and loan=1 and checked=0";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id',$id,PDO::PARAM_STR);
          $stm->execute();
          $result=$stm->fetchAll(PDO::FETCH_ASSOC);
          echo "<h2>この商品が「購入」されました。</h2>";
          echo '<table class="table table-striped">';
          echo '<thead><tr>';
          echo '<th>','掲載日','</th>';
          echo '<th>','貸出物','</th>';
          echo '<th>','ジャンル','</th>';
          echo '<th>','金額','</th>';
          echo '<th>','画像','</th>';
          echo '<th>','既読にする','</th>';
          echo '</tr></thead>';
          echo '<tbody>';
          foreach($result as $row){
              echo '<tr>';
              echo '<td>',$row['created_at'],'</td>';
              echo '<td>',$row['item'],'</td>';
              echo '<td>',$row['kind'],'</td>';
              echo '<td>￥',number_format($row['money']),'</td>';
              echo "<td><a href=detail.php?id={$row["id"]}>",'<img height="100" width="100" src="image.php?id=',$row['id'],'"></a></td>';
              echo '<td><form method="POST" action="notice.php?loan='.$row["id"].'&check=2"><input id="check" type="submit" value="〆" name="#" ></form></td>';
              echo '</tr>';
          }
          echo '</tbody>';
          echo '</table>';
      }else{
        $all_count+=1;
      }
      ?>
            <?php
        if($count_chat2!=0){
          $chat_list2=implode(",",$chat_list2);
          $sql = "SELECT * FROM chat WHERE list_id IN ($chat_list2) and checked=0";
          $stm = $pdo->prepare($sql);
          // $stm->bindValue(':id',$id,PDO::PARAM_STR);
          $stm->execute();
          $result=$stm->fetchAll(PDO::FETCH_ASSOC);
          echo "<h2>この商品に「チャット」が届きました。</h2>";
          echo '<table class="table table-striped">';
          echo '<thead><tr>';
          echo '<th>','時間','</th>';
          echo '<th>','コメント内容','</th>';
          echo '<th>','画像','</th>';
          echo '<th>','既読にする','</th>';
          echo '</tr></thead>';
          echo '<tbody>';
          foreach($result as $row){
              echo '<tr>';
              echo '<td>',$row['created_at'],'</td>';
              echo '<td>',$row['text'],'</td>';
              echo "<td><a href=loan.php?id={$row["list_id"]}>",'<img height="100" width="100" src="image.php?id=',$row['list_id'],'"></a></td>';
              echo '<td><form method="POST" action="notice.php?chat='.$row["id"].'&check=3"><input id="check" type="submit" value="〆" name="#" ></form></td>';
              echo '</tr>';
          }
          echo '</tbody>';
          echo '</table>';
      }else{
        $all_count+=1;
      }
      if($all_count==3){
        echo "<h2>現在お知らせはありません。</h2>";
      }
    }
      ?>
      
      <!-- <style>
>>>>>>> root/master
input.big {
	transform: scale(2.0);
}
</style> -->
<<<<<<< HEAD
      </div>
      <!--/メイン-->

      <!--サイド-->

      <?php
    require_once('side.php');
    ?>


      <!--/サイド-->
=======
>>>>>>> root/master
    </div>
    <!--/wrapper-->

<<<<<<< HEAD
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
</body>

</html>