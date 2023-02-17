<?php
session_start();
$myURL = 'eturan.php';
require_once "db_connect.php";
?>
<!DOCTYPE html>
<html lang="ja">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>貸し借りサイト　Lab:G | 閲覧履歴</title>

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
            <h1 class="h3 mb-0 text-gray-800">閲覧履歴</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>
          <?php
          if (isset($_COOKIE['history_url'])) {
            $history_url = unserialize($_COOKIE['history_url']); //クッキーに保存されたURLを配列にする
          }
          if (isset($_COOKIE['history_item'])) {
            $history_item = unserialize($_COOKIE['history_item']); //クッキーに保存されたテキストを配列にする
            $i = 0;
            echo "<table><tr>";
            foreach ($history_item as $key => $val) {
              $sql = "SELECT * FROM list WHERE id=$val";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $row) {
              }
              echo '<td>';
              echo '<div class="sample5"><a href="' . $history_url[$i] . '"><img src="image?id=' . $val . '" id="parent" height="240" width="240"></img>'; //テキストを表示および同じ順番に保存されているURLを表示
              if ($row["loan"] == 1) {
                echo '<img id="child" src="images/sold.png" height="240" width="240"/>';
              }
              echo '<div class="mask">';
              echo '<div class="caption">', $row["item"], '</div></div></a></div></td>';
              // echo '<li><a href="'.$history_url[$i].'">'.$val.'</a></li>'."\n"; //テキストを表示および同じ順番に保存されているURLを表示
              $i++;
              if ($i % 4 == 0) {
                echo "</tr>";
                echo "<tr>";
              }
            }
            echo '</tr></table>';
          } else {
            echo '<p>過去に見たページはありません。</p>';
          }
          ?>
          <div class="row">

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