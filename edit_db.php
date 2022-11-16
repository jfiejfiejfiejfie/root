<?php
session_start();
require_once('../lib/util.php');
<<<<<<< HEAD
$gobackURL = 'mypage.php';
=======
<<<<<<< HEAD
$gobackURL = 'mypage.php';
=======
$gobackURL ='mypage.php';
>>>>>>> root/master
>>>>>>> root/master
require_once "db_connect.php";

?>

<!DOCTYPE html>
<<<<<<< HEAD
<?php require_once("head.php") ?>
<title>貸し借り</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
=======
<<<<<<< HEAD
<?php require_once("head.php") ?>
<title>貸し借り</title>
</head>

<body>
  <audio id="audio"></audio>
  <div id="fb-root"></div>


  <!--ヘッダー-->
  <?php require_once("header.php"); ?>
=======
<?php require_once("head.php")?>
<title>貸し借り</title>
</head>
<body>
<audio id="audio"></audio>
<div id="fb-root"></div>

  
  <!--ヘッダー-->
		<?php require_once("header.php");?>
>>>>>>> root/master
>>>>>>> root/master


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
      <div>
        <?php
    $id = $_SESSION["id"];
    $age = $_POST["age"];
    $sex = $_POST["sex"];
    $email = $_POST["email"];
    $comment = $_POST["comment"];
    $_SESSION["age"] = $_POST["age"];
    $_SESSION["sex"] = $_POST["sex"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["comment"] = $_POST["comment"];
    try {

      $sql = "UPDATE users SET age = :age,sex = :sex,email = :email,comment = :comment where id = $id";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':age', $age, PDO::PARAM_STR);
      $stm->bindValue(':sex', $sex, PDO::PARAM_STR);
      $stm->bindValue(':email', $email, PDO::PARAM_STR);
      $stm->bindValue(':comment', $comment, PDO::PARAM_STR);
      if ($stm->execute()) {
        if (isset($_FILES["image"]) && $_FILES["image"]["tmp_name"] != "") {
          $upfile = $_FILES["image"]["tmp_name"];
          $imgdat = file_get_contents($upfile);
          $sql = "UPDATE users SET image=:imgdat where id = $id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
          $stm->execute();
<<<<<<< HEAD
=======
=======
    <div>
    <?php
    $id=$_SESSION["id"];
    $age=$_POST["age"];
    $sex=$_POST["sex"];
    $email=$_POST["email"];
    $comment=$_POST["comment"];
    $_SESSION["age"]=$_POST["age"];
    $_SESSION["sex"]=$_POST["sex"];
    $_SESSION["email"]=$_POST["email"];
    $_SESSION["comment"]=$_POST["comment"];
        try{
            
            $sql="UPDATE users SET age = :age,sex = :sex,email = :email,comment = :comment where id = $id";
            $stm=$pdo->prepare($sql);
            $stm->bindValue(':age',$age,PDO::PARAM_STR);
            $stm->bindValue(':sex',$sex,PDO::PARAM_STR);
            $stm->bindValue(':email',$email,PDO::PARAM_STR);
            $stm->bindValue(':comment',$comment,PDO::PARAM_STR);
            if($stm->execute()){
            if(isset($_FILES["image"])&&$_FILES["image"]["tmp_name"]!=""){
            $upfile = $_FILES["image"]["tmp_name"];
            $imgdat = file_get_contents($upfile);
            $sql="UPDATE users SET image=:imgdat where id = $id";
            $stm=$pdo->prepare($sql);
            $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
            $stm->execute();
            }
            $sql = "SELECT * FROM users WHERE id = $id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            echo '<table>';
            echo '<thead><tr>';
            echo '<th>','年齢','</th>';
            echo '<th>','性別','</th>';
            echo '<th>','E-mail','</th>';
            echo '<th>','コメント','</th>';
            echo '<th>','プロフィール画像','</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            foreach($result as $row){
                echo '<tr>';
                echo '<td>',es($row['age']),'</td>';
                echo '<td>',es($row['sex']),'</td>';
                echo '<td>',es($row['email']),'</td>';
                echo '<td>',es($row['comment']),'</td>';
                echo '<td><img height="150" width="150" src="my_image.php?id=',$row['id'],'"></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }else{
            echo "ツイカエラーガアリマシタ。";
>>>>>>> root/master
>>>>>>> root/master
        }
        $sql = "SELECT * FROM users WHERE id = $id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo '<table>';
        echo '<thead><tr>';
        echo '<th>', '年齢', '</th>';
        echo '<th>', '性別', '</th>';
        echo '<th>', 'E-mail', '</th>';
        echo '<th>', 'コメント', '</th>';
        echo '<th>', 'プロフィール画像', '</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        foreach ($result as $row) {
          echo '<tr>';
          echo '<td>', es($row['age']), '</td>';
          echo '<td>', es($row['sex']), '</td>';
          echo '<td>', es($row['email']), '</td>';
          echo '<td>', es($row['comment']), '</td>';
          echo '<td><img height="150" width="150" src="my_image.php?id=', $row['id'], '"></td>';
          echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
      } else {
        echo "ツイカエラーガアリマシタ。";
      }
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
    }
    ?>
        <hr>
        <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
      </div>
    </div>
    <!--/メイン-->

    <!--サイド-->
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master

    <?php
      require_once('side.php');
      ?>


<<<<<<< HEAD
=======
=======
    
      <?php
    require_once('side.php');
    ?>

    
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