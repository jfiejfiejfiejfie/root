
<?php
session_start();

$myURL='deleteacount.php';
$gobackURL = 'admin.php';
require_once "db_connect.php";
if(isset($_POST["id"])){
  $id=$_POST["id"];
}else if(isset($_GET["id"])){
  $id = $_GET["id"];
}else{
  $id = $_SESSION["id"];
}
try {

  $sql = "DELETE FROM list WHERE user_id = :id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':id', $id, PDO::PARAM_STR);
  if ($stm->execute()) {
    // $stm = $pdo->prepare($sql);
    // $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  } else {
    echo "ツイカエラーガアリマシタ。";
  }
} catch (Exception $e) {
  echo 'エラーがありました。2';
  echo $e->getMessage();
  exit();
}
try {

  $sql = "DELETE FROM list WHERE user_id = :id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':id', $id, PDO::PARAM_STR);
  if ($stm->execute()) {
    // $stm = $pdo->prepare($sql);
    // $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  } else {
    echo "ツイカエラーガアリマシタ。";
  }
} catch (Exception $e) {
  echo 'エラーがありました。2';
  echo $e->getMessage();
  exit();
}
try {

  $sql = "DELETE FROM users WHERE id = $id";
  $stm = $pdo->prepare($sql);
  if ($stm->execute()) {
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(!isset($_POST["id"])){
    header("location: logout.php");
    exit;
    }
  } else {
    echo "ツイカエラーガアリマシタ。";
  }
} catch (Exception $e) {
  echo 'エラーがありました。3';
  echo $e->getMessage();
  exit();
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

  <title>貸し借りサイト　Lab:G</title>

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

        <!-- Topbar -->
        <?php require_once("nav.php");?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">アカウント削除</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
          <div>
            <h1>垢BAN完了♪</h1>
            <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
          </div>
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
  <?php require_once("boot_modal.php");?>
</body>

</html>

