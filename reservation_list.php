<?php
session_start();
$myURL = 'reservation_list.php';
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

  <title>貸し借りサイト　Lab:G | レンタル品予約リスト</title>

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
            <h1 class="h3 mb-0 text-gray-800">予約されたレンタル品</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>


              <?php
              $id = $_SESSION["id"];
              $list_list = [];
              $list_count = 0;
              $sql = "SELECT * FROM list WHERE  user_id=:id";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':id', $id, PDO::PARAM_STR);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $row) {
                $list_count += 1;
                $list_list[] = $row["id"];
              }
              try {
                if ($list_count > 0) {
                  $reservation_list = [];
                  $list_list = implode(",", $list_list);
                  $sql = "SELECT * FROM reservation_list WHERE  list_id IN ($list_list) and auth=0";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result as $row) {
                    if (!in_array($row["list_id"], $reservation_list)) {
                      $reservation_list[] = $row["list_id"];
                      echo '<table class="table table-striped">';
                      echo "<a href='reservation_auth?id={$row['list_id']}'><img id='image' height='100' width='100'src='image?id={$row['list_id']}'></a><br>";
                      $list_id = $row["list_id"];
                      $sql = "SELECT * FROM list WHERE id=$list_id";
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                        echo $row2["item"], "</td>";
                      }
                      echo "<hr>";
                      echo '</tr>';
                    }
                  }
                  echo '</tbody>';
                  echo '</table>';
                } else {
                  echo "<h1>現在予約はありません。</h1>";
                }
              } catch (Exception $e) {
                echo 'エラーがありました。';
                echo $e->getMessage();
                exit();
              }
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