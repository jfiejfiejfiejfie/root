
<?php
session_start();
require_once('db_connect.php');
require_once('user_check.php');
$myURL = 'admin.php';
if ($row["admin"] == 0) {
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
            <h1 class="h3 mb-0 text-gray-800">管理者ページ</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
          <?php
            echo "<h1>商品の削除</h1>";
            $sql = "SELECT * FROM list";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                echo "<table>";
                echo "<tr>";
                echo '<div class="col-12"></div>';
                echo $row["id"];
                echo $row["item"];
                echo "<a href='mydelete.php?id=" . $row['id'] . "'>消す</a>";
                echo "</tr>";
                echo "</table>";
            }
            echo '<div class="col-12"><br></div>';
            echo "<h1>ユーザを編集する</h1>";
            $sql = "SELECT * FROM users";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                echo "<table>";
                echo "<tr>";
                echo '<div class="col-12"></div>';
                echo $row["id"];
                echo $row["name"];
                echo "<a href='admin_edit.php?id=" . $row['id'] . "'>編集する</a>";
                echo "</tr>";
                echo "</table>";
            }
            echo '<div class="col-12"><br></div>';
            echo '<h1>ユーザを永久追放する</h1>';
            $filename = "report.txt";
            $data = array();
            if (is_readable($filename) === TRUE) {
                if (($fp = fopen($filename, 'r')) !== FALSE) {
                    while (($tmp = fgets($fp)) !== FALSE) {
                        echo '<div class="col-12"></div>';
                        $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');
                    }
                    fclose($fp);
                }
            } else {
                $data[] = 'ファイルがありません';
            }
            foreach ($data as $line) {
                echo '<div class="col-12"></div>';
                echo 'IPアドレス->'.$line . '<a href="report.php?IP=' . $line . '">永久追放する</a><br>';
            }
            // echo '<h1>ユーザを永久追放する</h1>';
            $filename = "user_report.txt";
            $data = array();
            if (is_readable($filename) === TRUE) {
                if (($fp = fopen($filename, 'r')) !== FALSE) {
                    while (($tmp = fgets($fp)) !== FALSE) {
                        $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');
                    }
                    fclose($fp);
                }
            } else {
                $data[] = 'ファイルがありません';
            }
            foreach ($data as $line) {
                echo '<div class="col-12"></div>';
                echo 'ユーザーID->'.$line . '<a href="deleteacount.php?id=' . $line . '">永久追放する</a><br>';
            }
            echo '<div class="col-12"><br></div>';
            echo '<h1>IP追放編集</h1>';
            $filename = ".htaccess";
            $data = array();
            if (is_readable($filename) === TRUE) {
                if (($fp = fopen($filename, 'r')) !== FALSE) {
                    while (($tmp = fgets($fp)) !== FALSE) {
                        echo '<div class="col-12"></div>';
                        $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');
                    }
                    fclose($fp);
                }
            } else {
                $data[] = 'ファイルがありません';
            }
            $data_count = 0;
            foreach ($data as $line) {
                echo '<div class="col-12"></div>';
                echo $line . '<a href="report.php?line=' . $data_count . '">削除</a><br>';
                $data_count += 1;
            }
            ?>
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








