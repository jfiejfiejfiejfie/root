<?php
  // 簡単なエラー処理
  $errors = [];
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
    $_SESSION["create_text"]="";
    exit();
  }
  ?>
  <?php
    $id = $_SESSION["id"];
    date_default_timezone_set('Asia/Tokyo');
    $created_at = date("Y/m/d H:i:s");
    if ($_POST["item"] != "") {
      $item = $_POST["item"];
    } else {
      $lines = file("named1.txt", FILE_IGNORE_NEW_LINES);
      $lines2 = file("named2.txt", FILE_IGNORE_NEW_LINES);
      $item = "{$lines[rand(0, 7)]}{$lines2[rand(0, 6)]}";
    }
    $comment = $_POST["comment"];
    $upfile = $_FILES["image"]["tmp_name"];
    $imgdat = file_get_contents($upfile);

    try {
      $sql = "INSERT INTO room (item,created_at,user_id,comment,image) VALUES(:item,:created_at,:id,:comment,:imgdat)";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':created_at', $created_at, PDO::PARAM_STR);
      $stm->bindValue(':id', $id, PDO::PARAM_STR);
      // $stm->bindValue(':host_user_id', $host_user_id, PDO::PARAM_STR);
      $stm->bindValue(':item', $item, PDO::PARAM_STR);
      $stm->bindValue(':comment', $comment, PDO::PARAM_STR);
      $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
      if ($stm->execute()) {
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        $sql = 'SELECT * FROM room WHERE created_at = :created_at';
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':created_at', $created_at, PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["create_text"]="作成完了しました。";
      } else {
        echo "ツイカエラーガアリマシタ。";
        $_SESSION["create_text"]="";
      }
    } catch (Exception $e) {
      echo 'エラーがありました。';
      echo $e->getMessage();
      exit();
    }
    header('Location:add_room.php');
    ?>