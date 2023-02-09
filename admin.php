<?php
session_start();
require_once('db_connect.php');
require_once('user_check.php');
$myURL = 'admin.php';
if ($row["admin"] == 0) {
  header('Location:./');
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
            <h1 class="h3 mb-0 text-gray-800">管理者ページ</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <?php
            echo "<h1>レンタル品の削除</h1><div class='col-12'></div>";
            $sql = "SELECT * FROM list";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
              echo '<div class="col-2">';
              echo "<table>";
              echo "<tr>";
              echo '<div class="col-12"></div>';
              echo $row["id"] . '<br>レンタル品名:';
              echo $row["item"] . '<br><div class="col-12"></div>';
              echo '<div class="sample5"><a href=detail.php?', "id={$row["id"]}>";
              echo '<img id="parent" src="image.php?id=', $row["id"], ' alt="" height="155" width="155"/>';
              if ($row["loan"] == 1) {
                echo '<img id="child" src="images/sold.png" height="155" width="155"/>';
              }
              echo "<div class='col-12'></div><a class='btn btn-danger col-8' href='mydelete.php?id=" . $row['id'] . "'>消す</a>";
              echo '</div></a></div>';
              echo "</tr>";
              echo "</table>";
              echo '</div>';
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
              echo 'IPアドレス->' . $line . '<a href="report.php?IP=' . $line . '">永久追放する</a><br>';
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
              echo 'ユーザーID->' . $line . '<a href="deleteacount.php?id=' . $line . '">永久追放する</a><br>';
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
            echo '<a href="chara_create.php" class="btn btn-primary col-12">ガチャキャラ作成</a>';
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
  <?php require_once("boot_modal.php"); ?>
</body>

</html>