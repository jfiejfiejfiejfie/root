<?php
session_start();

$myURL = 'admin_edit_db.php';
$gobackURL = 'mypage.php';
require_once "db_connect.php";
require_once('user_check.php');
if($row["admin"]==0){
    header('Location:index.php');
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
            <h1 class="h3 mb-0 text-gray-800">編集完了</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
          <?php
    $id = $_POST["id"];
    $user_id = $_POST["user_id"];
    $name = $_POST["name"];
    $age = $_POST["age"];
    $sex = $_POST["sex"];
    $comment = $_POST["comment"];
    $evaluation = $_POST["evaluation"];
    try {

      $sql = "UPDATE users SET user_id=:user_id,name=:name ,age = :age,sex = :sex,comment = :comment,evaluation=:evaluation where id = $id";
      $stm = $pdo->prepare($sql);
      $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
      $stm->bindValue(':name', $name, PDO::PARAM_STR);
      $stm->bindValue(':age', $age, PDO::PARAM_STR);
      $stm->bindValue(':sex', $sex, PDO::PARAM_STR);
      $stm->bindValue(':comment', $comment, PDO::PARAM_STR);
      $stm->bindValue(':evaluation', $evaluation, PDO::PARAM_STR);
      if ($stm->execute()) {
        if (isset($_FILES["image"]) && $_FILES["image"]["tmp_name"] != "") {
          $upfile = $_FILES["image"]["tmp_name"];
          $imgdat = file_get_contents($upfile);
          $sql = "UPDATE users SET image=:imgdat where id = $id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
          $stm->execute();
        }
        if (isset($_POST["email"]) && $_POST["email"] != "") {
          $email = $_POST["email"];
          $sql = "UPDATE users SET email=:email where id = $id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':email', $email, PDO::PARAM_STR);
          $stm->execute();
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
          echo '<td>',$row['age'], '</td>';
          echo '<td>',$row['sex'], '</td>';
          echo '<td>',$row['email'], '</td>';
          echo '<td>',$row['comment'], '</td>';
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

