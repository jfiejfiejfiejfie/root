<?php
session_start();

$myURL = 'detail2.php';
$gobackURL = "room_member.php?id={$_POST["id"]}";
?>
<!DOCTYPE html>
<html lang="ja">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>貸し借りサイト　Lab:G | ルーム変更完了</title>

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
          exit();
        }
        require_once "db_connect.php";
        ?>
        <!-- Topbar -->
        <?php require_once("nav.php"); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"></h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <h1>変更完了しました。</h1>
            <?php
            date_default_timezone_set('Asia/Tokyo');
            $created_at = date("Y/m/d H:i:s");
            $id = $_SESSION["loan_id"];
            $item = $_POST["item"];
            $comment = $_POST["comment"];
            try {

              $sql = "UPDATE room SET item = :item, comment = :comment, created_at = :created_at where id = $id";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':item', $item, PDO::PARAM_STR);
              $stm->bindValue(':comment', $comment, PDO::PARAM_STR);
              $stm->bindValue(':created_at', $created_at, PDO::PARAM_STR);
              if ($stm->execute()) {
                if (isset($_FILES["image"]) && ($_FILES["image"]["tmp_name"] != '')) {
                  $upfile = $_FILES["image"]["tmp_name"];
                  $imgdat = file_get_contents($upfile);
                  $sql = "UPDATE room SET image = :imgdat WHERE id=$id";
                  $stm = $pdo->prepare($sql);
                  $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
                  $stm->execute();
                }
              } else {
                echo "ツイカエラーガアリマシタ。";
              }
            } catch (Exception $e) {
              echo 'エラーがありました。';
              echo $e->getMessage();
              exit();
            }
            ?>
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
            <span>Copyright &copy; Lending and borrowing:GOD 2022-2023</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <?php require_once("boot_modal.php"); ?>
</body>

</html>