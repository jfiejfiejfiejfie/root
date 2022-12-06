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
          <?php
          $id = $_SESSION["id"];
          $sql = "SELECT * FROM users WHERE id =:id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id', $id, PDO::PARAM_STR);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            $name=$row["name"];
            $age=$row["age"];
            $sex=$row["sex"];
            $email=$row["email"];
            $check=$row["checked"];
            $comment=$row["comment"];
            $money=$row["money"];
            $point=$row["point"];
          }
          ?>
          <div class="col-12 d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="col-4 h3 mb-0 text-gray-800">プロフィール</h1>
            <div class="col-8">
            <?php
            echo '<a href="edit.php"  class="btn btn-primary col-3">編集する <div class="fa fa-cog"></div></a>';
            echo '<a href="blocklist.php" class="btn btn-primary col-3">ブロックリスト <div class="fa fa-address-book"></div></a>';
            echo '<a href="reservation_list.php" class="btn btn-primary col-3">予約された商品 <div class="fa fa-gavel"></div></a>';
            echo '<a href="eturan.php" class="btn btn-primary col-3">閲覧履歴 <i class="fa fa-list"></i></a>';
            if ($row["admin"] == 1) {
              echo "<a href='admin.php' class='btn btn-danger col-12'>管理者ページに行く <i class='fa fa-user-secret'></i></a>";
            }
            ?>
            </div>
          </div>

          <div class="row">
            <div class="col-4">
              <?php
              try {
                  echo '<img class="img-profile rounded-circle" height="150" width="150" src="my_image.php?id='.$id.'"><div class="col-2"></div>';
                  echo '<div class="col-12"></div>';
                  echo '<font class="col-8" size="10">'.$name.'</font>';
                  echo '<div class="col-4"></div>';
                  echo '<font class="col-8" size="5">'.$age.'歳</font>';
                  echo '<div class="col-4"></div>';
                  echo '<font class="col-8" size="5">'.$sex.'</font>';
                  echo '<div class="col-4"></div>';
                  echo '<font class="col-8" size="5">'.$email.'</font>';
                  if ($check == 0 && $email != "") {
                    echo "<div style='color:red;' class='col-2'>認証してください。</div><a class='btn btn-primary' href='mb_send_mail.php?email=" .$email. "'>認証する</a><div class='col-10'></div>";
                  }
                  echo '<hr><div class="col-12">コメント<br><font size="10">', $comment, '</font></div>';
                  echo '<hr><div class="col-6">残金<font size="10">￥', number_format($money), '</font></div>';
                  echo '<div class="col-6">ポイント<font size="10">', number_format($point), 'p</font></div>';
                  //echo '<br><a href="shop_list.php"><img src="images/point.png"></a>';
              ?>
              <?php
                  $sql = "SELECT * FROM followlist WHERE my_id =$id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                  $sth = $pdo->query($sql);
                  $count = $sth->rowCount();
                  echo '<hr><div class="col-12">フォロー中<font size="5"><a href="followlist.php">';
                  echo $count . "人</a></font>";
              ?>
              <?php
                  $sql = "SELECT * FROM followlist WHERE user_id =$id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                  $sth = $pdo->query($sql);
                  $count2 = $sth->rowCount();
                  echo 'フォロワー<font size="5"><a href="followerlist.php">';
                  echo $count2 . "人</a></font></div>";
              ?>
              <?php
              } catch (Exception $e) {
                echo 'エラーがありました。';
                echo $e->getMessage();
                exit();
              }

              ?>
            </div>
            <div class="col-8">
              <h2>出品中</h2>
              <?php
              try {
                $sql = "SELECT * FROM list WHERE user_id=$id and loan=0 LIMIT 3";
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
                echo '<a class="btn btn-primary col-12" href="./">一覧で見る</a><hr>';
              } catch (Exception $e) {
                echo 'エラーがありました。';
                echo $e->getMessage();
                exit();
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