<?php
session_start();
require_once('../lib/util.php');
$myURL='detail1.php';
$gobackURL = "my_edit.php?id={$_POST["id"]}";
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
    <?php require_once("sidebar.php");?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
      <?php
// 簡単なエラー処理
$errors = [];
// if (!isset($_POST["money"]) || (!ctype_digit($_POST["money"]))) {
//   $errors[] = "金額が整数値ではありません。";
// }
// if ($_POST["money"] < 100) {
//   $errors[] = "金額を100円以上にしてください。";
// }
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
        <?php require_once("nav.php");?>
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
  // $money = $_POST["money"];
  $kind = $_POST["kind"];
  $state=$_POST["state"];
  $comment=$_POST["comment"];
  try {

    $sql = "UPDATE list SET item = :item,created_at=:created_at,kind=:kind,state=:state,comment=:comment where id = $id";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':item', $item, PDO::PARAM_STR);
    // $stm->bindValue(':imgdat',$imgdat,PDO::PARAM_STR);
  
    $stm->bindValue(':created_at', $created_at, PDO::PARAM_STR);
    // $stm->bindValue(':money', $money, PDO::PARAM_STR);
    $stm->bindValue(':kind', $kind, PDO::PARAM_STR);
    $stm->bindValue(':state', $state, PDO::PARAM_STR);
    $stm->bindValue(':comment', $comment, PDO::PARAM_STR);
    if ($stm->execute()) {
      if (isset($_FILES["image"]) && ($_FILES["image"]["tmp_name"] != '')) {
        $upfile = $_FILES["image"]["tmp_name"];
        $imgdat = file_get_contents($upfile);
        $sql = "UPDATE list SET image = :imgdat WHERE id=$id";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
        $stm->execute();
      }
      if (isset($_FILES["image2"]) && ($_FILES["image2"]["tmp_name"] != '')) {
        $upfile = $_FILES["image2"]["tmp_name"];
        $imgdat = file_get_contents($upfile);
        $sql = "UPDATE image_list SET image = :imgdat WHERE list_id=$id and number=:number";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
        $stm->bindValue(':number', 1, PDO::PARAM_STR);
        $stm->execute();
      }
      if (isset($_FILES["image3"]) && ($_FILES["image3"]["tmp_name"] != '')) {
        $upfile = $_FILES["image3"]["tmp_name"];
        $imgdat = file_get_contents($upfile);
        $sql = "UPDATE image_list SET image = :imgdat WHERE list_id=$id and number=:number";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
        $stm->bindValue(':number', 2, PDO::PARAM_STR);
        $stm->execute();
      }
      if (isset($_FILES["image4"]) && ($_FILES["image4"]["tmp_name"] != '')) {
        $upfile = $_FILES["image4"]["tmp_name"];
        $imgdat = file_get_contents($upfile);
        $sql = "UPDATE image_list SET image = :imgdat WHERE list_id=$id and number=:number";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
        $stm->bindValue(':number', 3, PDO::PARAM_STR);
        $stm->execute();
      }
      if (isset($_FILES["image5"]) && ($_FILES["image5"]["tmp_name"] != '')) {
        $upfile = $_FILES["image5"]["tmp_name"];
        $imgdat = file_get_contents($upfile);
        $sql = "UPDATE image_list SET image = :imgdat WHERE list_id=$id and number=:number";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
        $stm->bindValue(':number', 4, PDO::PARAM_STR);
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
            <span>Copyright &copy; Your Website 2021</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">本当にログアウトするのですね？</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">ログアウトしますか？</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">しない</button>
          <a class="btn btn-danger" href="logout.php">ログアウト</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>







