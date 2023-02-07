<?php
session_start();

require_once "db_connect.php";
require_once('user_check.php');
$myURL = 'buyp.php';
$point = $row["point"];
$money = $row["money"];
$name = $row["name"];
$checked = $row["checked"];
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $data = $_SESSION["id"];
  $gobackURL = "detail.php?id={$id}";
  try {
    $sql = "SELECT * FROM list WHERE id=$id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $user_id = $row["user_id"];
      $item = $row["item"];
    }
  } catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
  }
  // 簡単なエラー処理
  $errors = [];
  $memo = "レンタル";
  if ($point < $_GET["money"]) {
    $errors[] = "ポイントが足りません";
  }
  if ($checked == 0) {
    $errors[] = 'メール認証が完了していないためレンタルできません';
  }
  require_once('error.php');
  //エラーがあったとき
  if (count($errors) > 0) {
    echo "<script> rikki(); </script>";
    echo "<img src='images/main_visual.jpg'>";
    echo "<h1>Error!!!</h1>";
    echo '<ol class="error">';
    foreach ($errors as $value) {
      echo "<li>", $value, "</li>";
    }
    echo "</ol>";
    echo "<hr>";
    echo "<a href=", $gobackURL, ">戻る</a><br>";
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>貸し借りサイト　WACCA</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/original.css">
  <script src="js/original.js">
  </script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once("nav.php"); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">レンタル品登録</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <?php
          if (isset($_GET["id"])) {
            try {
              $loan = 1;
              $sql = "UPDATE list SET loan=$loan,buy_user_id=$data WHERE id=$id";
              $stm = $pdo->prepare($sql);
              if ($stm->execute()) {
                $sql = 'SELECT * FROM list';
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              } else {
                echo "ツイカエラーガアリマシタ。";
              }
            } catch (Exception $e) {
              echo 'エラーがありました。';
              echo $e->getMessage();
              exit();
            }
            try {
              $point = $point - $_GET["money"];

              $sql = "UPDATE users SET point=$point WHERE id=$data";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
              echo 'エラーがありました。';
              echo $e->getMessage();
              exit();
            }
            try {
              $user_id = $_GET["user_id"];
              $money = $_GET["money"];

              $sql = "UPDATE users SET point=point+$money WHERE id=$user_id";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
              echo 'エラーがありました。';
              echo $e->getMessage();
              exit();
            }
            try {
              $text = "<a href='detail.php?id=" . $id . "'>" . $item . "</a>をレンタルしました。
            ※これは自動送信です。";
              date_default_timezone_set('Asia/Tokyo');
              $date = date('Y-m-d H:i:s');
              $sql = "INSERT INTO user_chat (user_id,created_at,text,others_id) VALUES(:user_id,:date,:text,:others_id)";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':user_id', $data, PDO::PARAM_STR);
              $stm->bindValue(':date', $date, PDO::PARAM_STR);
              $stm->bindValue(':text', $text, PDO::PARAM_STR);
              $stm->bindValue(':others_id', $user_id, PDO::PARAM_STR);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
              echo 'エラーがありました。';
              echo $e->getMessage();
              exit();
            }
            header('Location:buyp.php');
          } else {
            echo "<h1>レンタルしました。</h1>";
            $gobackURL = "list.php";
          }
          ?>
            <hr>
            <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->
  <?php require_once("boot_modal.php");?>
</body>

</html>