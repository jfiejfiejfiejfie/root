<?php
session_start();
require_once('db_connect.php');
$myURL = 'mypage.php';
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
            <h1 class="h3 mb-0 text-gray-800">プロフィール</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <?php
            echo '<br>';
            $id = $_SESSION["id"];
            try {
              $sql = "SELECT * FROM users WHERE id =:id";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':id', $id, PDO::PARAM_STR);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $row) {
                echo '<img class="img-profile rounded-circle" height="150" width="150" src="my_image.php?id=', $row["id"], '"><div class="col-2"></div>';
                echo '<div class="col-12"></div>';
                echo '<font class="col-8" size="10">', $row["name"], '</font>';
                echo '<div class="col-4"></div>';
                echo '<font class="col-6" size="5">', $row["age"], '歳</font>';
                  echo '<a href="edit.php"  class="btn btn-primary col-3">編集する <div class="fa fa-cog"></div></a><hr>';
                  echo '<a href="blocklist.php" class="btn btn-primary col-3">ブロックリスト <div class="fa fa-address-book"></div></a><hr>';
                  echo '<font class="col-6" size="5">', $row["sex"], '</font>';
                  echo '<a href="reservation_list.php" class="btn btn-primary col-3">予約された商品 <div class="fa fa-gavel"></div></a><hr>';
                  echo '<a href="eturan.php" class="btn btn-primary col-3">閲覧履歴 <i class="fa fa-list"></i></a><hr>';
                  echo '<font class="col-6" size="5">', $row["email"], '</font>';
                  if ($row["admin"] == 1) {
                    echo "<a href='admin.php' class='btn btn-danger col-6'>管理者ページに行く <i class='fa fa-user-secret'></i></a>";
                  }
                if ($row["checked"] == 0 && $row["email"] != "") {
                  echo "<div style='color:red;' class='col-2'>認証してください。</div><a class='btn btn-primary' href='mb_send_mail.php?email=" . $row["email"] . "'>認証する</a><div class='col-10'></div>";
                }
                echo '<hr><div class="col-8">コメント<br><font size="10">', $row["comment"], '</font></div>';
                echo '<hr><div class="col-8">残金<br><font size="10">￥', number_format($row['money']), '</font></div>';
                echo '<hr><div class="col-8">ポイント<br><font size="10">', number_format($row['point']), 'p</font></div>';
                //echo '<br><a href="shop_list.php"><img src="images/point.png"></a>';
            ?>
            <?php
                $sql = "SELECT * FROM followlist WHERE my_id =$id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                $sth = $pdo->query($sql);
                $count = $sth->rowCount();
                echo '<hr><div class="col-8">フォロー<br><font size="5">', '<a href="followlist.php">';
                echo $count . "人</a><br></font></div>";
            ?>
            <?php
                $sql = "SELECT * FROM followlist WHERE user_id =$id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                $sth = $pdo->query($sql);
                $count2 = $sth->rowCount();
                echo '<div class="col-8">フォロワー<br><font size="5">', '<a href="followerlist.php">';
                echo $count2 . "人</a><br></font></div><div class='col-4'></div>";
                echo "<div class='col-12'><br></div>";
            ?>
            <?php
              }
            } catch (Exception $e) {
              echo 'エラーがありました。';
              echo $e->getMessage();
              exit();
            }

            ?>
            <h2>出品中</h2>
            <?php
            try {
              $sql = "SELECT * FROM list WHERE user_id=$id and loan=0";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              echo '<table class="table table-striped">';
              echo '<thead><tr>';
              echo '<th>', '掲載日', '</th>';
              echo '<th>', '貸出物', '</th>';
              echo '<th>', 'ジャンル', '</th>';
              echo '<th>', '金額', '</th>';
              echo '<th>', '画像', '</th>';
              echo '</tr></thead>';
              echo '<tbody>';
              foreach ($result as $row) {
                echo '<tr>';
                echo '<td>', $row['created_at'], '</td>';
                echo '<td>', $row['item'], '</td>';
                echo '<td>', $row['kind'], '</td>';
                echo '<td>￥', number_format($row['money']), '</td>';
                echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="200" width="200" src="image.php?id=', $row['id'], '"></a></td>';
                echo '</tr>';
              }
              echo '</tbody>';
              echo '</table>';
            } catch (Exception $e) {
              echo 'エラーがありました。';
              echo $e->getMessage();
              exit();
            }
            ?>
            <?php
            try {
              $count = 0;
              $sql = "SELECT * FROM likes WHERE my_id=$id";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $row) {
                $count += 1;
                $main_list[] = $row["list_id"];
              }
            } catch (Exception $e) {
              echo 'エラーがありました。';
              echo $e->getMessage();
              exit();
            }
            ?>
            <?php
            if ($count != 0) {
              $main_list = implode(",", $main_list);
              $sql = "SELECT * FROM list WHERE id IN ($main_list)";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              echo "<h2>「いいね」した商品</h2>";
              echo '<table class="table table-striped">';
              echo '<thead><tr>';
              echo '<th>', '掲載日', '</th>';
              echo '<th>', '貸出物', '</th>';
              echo '<th>', 'ジャンル', '</th>';
              echo '<th>', '金額', '</th>';
              echo '<th>', '画像', '</th>';
              echo '</tr></thead>';
              echo '<tbody>';
              foreach ($result as $row) {
                echo '<tr>';
                echo '<td>', $row['created_at'], '</td>';
                echo '<td>', $row['item'], '</td>';
                echo '<td>', $row['kind'], '</td>';
                echo '<td>￥', number_format($row['money']), '</td>';
                echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="200" width="200" src="image.php?id=', $row['id'], '"></a></td>';
                echo '</tr>';
              }
              echo '</tbody>';
              echo '</table>';
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