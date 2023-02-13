<?php
session_start();

$gobackURL = 'index.php';
if (!isset($_SESSION["loggedin"])) {
  header('Location:login.php');
}
// if ("location:login.php")
//     ;
require_once "db_connect.php";
require_once('checked.php');
require_once "db_connect.php";
$myURL = 'report.php';
if (isset($_GET["id"])) {
  $id = $_GET["id"];
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
    <?php require_once("sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->

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
            <br>
            <?php
            echo '<h2>';
            if (isset($_GET["line"])) {
              echo $_GET["line"] . '行目を削除しました。';
            }
            if (isset($_GET["id"]) || isset($_GET["user_id"])) {
              echo '通報しました。';
            }
            if (isset($_GET["IP"])) {
              $IP = $_GET["IP"];
              echo $IP . 'を永久追放しました。';
            }
            echo '</h2>';
            ?>
            <?php
            if (isset($_GET["id"])) {
              $sql = "SELECT * FROM message WHERE id=$id";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $row) {
                $text = $row["IP"] . "\n";
              }
              $a = fopen("report.txt", "a");
              @fwrite($a, $text);
              fclose($a);
            }
            if (isset($_GET["user_id"])) {
              $text = $_GET["user_id"] . "\n";
              $a = fopen("user_report.txt", "a");
              @fwrite($a, $text);
              fclose($a);
            }
            if (isset($_GET["IP"])) {
              $text = "deny from " . $_GET["IP"] . "\n";
              $a = fopen(".htaccess", "a");
              @fwrite($a, $text);
              fclose($a);
            }
            if (isset($_GET["line"])) {
              $line = $_GET["line"];
              $myFile = file('.htaccess');
              unset($myFile[$line]);
              file_put_contents('.htaccess', $myFile);
            }
            if (isset($_GET["id"])) {
              $gobackURL = "keijiban.php";
            } else {
              $gobackURL = "admin.php";
            }
            echo '<p><a href="' . $gobackURL . '">戻る</a></p>';
            ?>
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

  <?php require_once("boot_modal.php"); ?>
</body>

</html>