<?php
session_start();
require_once('../lib/util.php');
$myURL = 'search_sp.php';
$gobackURL = 'index.php';
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
            <h1 class="h3 mb-0 text-gray-800">検索</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <br>
            <div>
              <form method="POST" action="search1.php" class="form-inline">

                <ul>
                  <h1>商品検索</h1>
                  <label>名前を検索します（部分一致）：<br>
                    <div class="input-group">
                      <input type="text" name="item" class="form-control form-control-user" placeholder="名前を入れてください。">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </label>
                </ul>
              </form>
              <form method="POST" action="search_kind.php" class="form-inline">

                <ul>
                  <h1>ジャンル検索</h1>
                  <label>ジャンルで検索します：<br>
                    <div class="input-group">
                      <select name="kind_name" class="form-control form-control-user">
                        <?php
                        try {

                          $sql = "SELECT * FROM kind";
                          $stm = $pdo->prepare($sql);
                          $stm->execute();
                          $kind = $stm->fetchAll(PDO::FETCH_ASSOC);
                        } catch (Exception $e) {
                          echo 'エラーがありました。';
                          echo $e->getMessage();
                          exit();
                        }
                        foreach ($kind as $row) {
                          echo '<option value="', $row["id"], '">', $row["name"], "</option>";
                        }
                        ?>
                      </select>
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </label>

                </ul>
              </form>
              <form method="POST" action="search_money.php" class="form-inline">
                <ul>
                  <h1>金額検索</h1>
                  <label>金額で検索します:<br>
                    <div class="input-group">
                      <input type="number_format" class="form-control form-control-user" name="money1" placeholder="以上">
                      <input type="number_format" class="form-control form-control-user" name="money2" placeholder="以下">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </label>
                </ul>
              </form>
              <form method="POST" action="search_user.php" class="form-inline">
                <ul>
                  <h1>ユーザ検索</h1>
                  <label>ユーザを検索します（部分一致）：<br>
                    <div class="input-group">
                      <input type="text" name="user_name" class="form-control form-control-user"
                        placeholder="名前を入れてください。">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </label>
                </ul>
              </form>
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