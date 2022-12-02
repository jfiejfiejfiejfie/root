<?php
  // 簡単なエラー処理
  $errors = [];
  $money = $_POST["money"];
  if((!isset($_POST["item"]))){
    $errors[]="名前入れろカス";
  }
  if((!isset($_FILES["image"])) || ($_FILES["image"]["tmp_name"] == '')){
    $errors[]="画像入れろカス";
  }
  if (!isset($_POST["money"]) || (!ctype_digit($_POST["money"]))) {
    $money = 100;
  }
  if ($money < 100 || 10000000 <= $money) {
    $errors[] = "金額を100円以上10,000,000未満にしてください。";
  }
  require_once('user_check.php');
  if($row["checked"]==0){
    $errors[] = "メール認証をしてください。";
  }
  //エラーがあったとき
  if (count($errors) > 0) {
    echo "<script> rikki(); </script>";
    echo "<img src='images/main_visual.jpg'>";
    echo '<ol class="error">';
    foreach ($errors as $value) {
      echo "<li>", $value, "</li>";
    }
    echo "</ol>";
    echo "<hr>";
    echo "<a href=", $gobackURL, ">戻る</a><br>";
    $_SESSION["insert_text"]="";
    exit();
  }
  $kind_id = $_POST["kind"];
  try {
    $sql = "SELECT * FROM kind WHERE id=$kind_id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $kind = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($kind as $row) {
      $kind_name = $row["name"];
    }
  } catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }
  $state_id = $_POST["state"];
  try {
    $sql = "SELECT * FROM state WHERE id=$state_id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $state = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($state as $row) {
      $state_name = $row["name"];
    }
  } catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }
  ?>
  <?php
    $id = $_SESSION["id"];
    date_default_timezone_set('Asia/Tokyo');
    $created_at = date("Y/m/d H:i:s");
    $item = $_POST["item"];
    $comment = $_POST["comment"];
    $upfile = $_FILES["image"]["tmp_name"];
    $imgdat = file_get_contents($upfile);
    try {


      $sql = "INSERT INTO list (created_at,user_id,item,comment,money,kind,image,state) VALUES(:created_at,:id,:item,:comment,:money,:kind,:imgdat,:state)";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':created_at', $created_at, PDO::PARAM_STR);
      $stm->bindValue(':id', $id, PDO::PARAM_STR);
      $stm->bindValue(':item', $item, PDO::PARAM_STR);
      $stm->bindValue(':comment', $comment, PDO::PARAM_STR);
      $stm->bindValue(':money', $money, PDO::PARAM_STR);
      $stm->bindValue(':kind', $kind_name, PDO::PARAM_STR);
      $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
      $stm->bindValue(':state', $state_name, PDO::PARAM_STR);
      if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        $sql = 'SELECT * FROM list WHERE created_at = :created_at';
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':created_at', $created_at, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
          $list_id = $row["id"];
        }
        if (isset($_FILES["image2"]) && ($_FILES["image2"]["tmp_name"] != '')) {
          $upfile = $_FILES["image2"]["tmp_name"];
          $imgdat = file_get_contents($upfile);
          $sql = "INSERT INTO image_list (list_id,image,number) VALUES(:list_id,:imgdat,:number)";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':list_id', $list_id, PDO::PARAM_STR);
          $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
          $stm->bindValue(':number', 1, PDO::PARAM_STR);
          $stm->execute();
        }
        if (isset($_FILES["image3"]) && ($_FILES["image3"]["tmp_name"] != '')) {
          $upfile = $_FILES["image3"]["tmp_name"];
          $imgdat = file_get_contents($upfile);
          $sql = "INSERT INTO image_list (list_id,image,number) VALUES(:list_id,:imgdat,:number)";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':list_id', $list_id, PDO::PARAM_STR);
          $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
          $stm->bindValue(':number', 2, PDO::PARAM_STR);
          $stm->execute();
        }
        if (isset($_FILES["image4"]) && ($_FILES["image4"]["tmp_name"] != '')) {
          $upfile = $_FILES["image4"]["tmp_name"];
          $imgdat = file_get_contents($upfile);
          $sql = "INSERT INTO image_list (list_id,image,number) VALUES(:list_id,:imgdat,:number)";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':list_id', $list_id, PDO::PARAM_STR);
          $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
          $stm->bindValue(':number', 3, PDO::PARAM_STR);
          $stm->execute();
        }
        if (isset($_FILES["image5"]) && ($_FILES["image5"]["tmp_name"] != '')) {
          $upfile = $_FILES["image5"]["tmp_name"];
          $imgdat = file_get_contents($upfile);
          $sql = "INSERT INTO image_list (list_id,image,number) VALUES(:list_id,:imgdat,:number)";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':list_id', $list_id, PDO::PARAM_STR);
          $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
          $stm->bindValue(':number', 4, PDO::PARAM_STR);
          $stm->execute();
        }
        $_SESSION["insert_text"]="登録完了しました。";
      } else {
        echo "ツイカエラーガアリマシタ。";
        $_SESSION["insert_text"]="";
      }
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
    }
    header('Location:add_db.php');
    ?>