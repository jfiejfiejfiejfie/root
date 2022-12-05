<?php
session_start();
require_once('../lib/util.php');
require_once "db_connect.php";
$myURL = 'search_money.php';
$gobackURL = "search_sp.php";
define('MAX', '5');
// 文字エンコードの検証
if (!cken($_POST)) {
  header("Location:{$gobackURL}");
  exit();
}
?>
<?php
// 簡単なエラー処理
$errors = [];
if (isset($_GET["money1"])) {
  $money1 = $_GET["money1"];
  $money2 = $_GET["money2"];
} else {
  $money1 = $_POST["money1"];
  $money2 = $_POST["money2"];
  if (!(is_numeric($_POST["money1"])) || ($_POST["money1"] < 0)) {
    $money1 = 100;
  }
  if (!(is_numeric($_POST["money2"])) || ($_POST["money2"] < 0)) {
    $money2 = 9999999;
  }
  if ($money1 > $money2) {
    $errors[] = "そんなもの存在しない。";
  }
}
//エラーがあったとき
if (count($errors) > 0) {
  echo "<script> rikki(); </script>";
  echo "<img src='images/main_visual.jpg'>";
  echo "<h1>Error!!!</h1>";
  echo '<ol class="error">';
  foreach ($errors as $value) {
    echo "<li>", $value, "</li>";
  }
  echo "</ol>";
  echo "<hr>";
  echo "<h1>ヒント:</h1>";
  echo "<ol>";
  echo "<li>数字をちゃんと確認しよう!!!</li>";
  echo "</ol>";
  echo "<a href=", $gobackURL, ">戻る</a><br>";
  exit();
}
$myURL = 'search_money.php';
$option = "&money1=$money1&money2=$money2";
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
            <h1 class="h3 mb-0 text-gray-800">金額検索</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <form method="POST" action="search_money.php">
              <label>金額で検索します:<br>
                <div class="input-group">
                  <input type="number_format" class="form-control form-control-user" name="money1" placeholder="以上" value="<?php echo $money1;?>">
                  <input type="number_format" class="form-control form-control-user" name="money2" placeholder="以下" value="<?php echo $money2;?>">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              </label>
            </form>
            <div class="col-12"></div>
            <h2>出品物一覧</h2>
            <div class="col-12">
              <?php
              //MySQLデータベースに接続する
              
              try {
                if (isset($_SESSION["loggedin"])) {
                  $block = 0;
                  require_once('block_check.php');
                  if ($block_count != 0) {
                    $block_list = implode(",", $block_list);
                    $sql = "SELECT * FROM list WHERE money BETWEEN $money1 AND $money2  AND loan=0 and user_id not in ($block_list) ORDER BY money";
                  } else {
                    $sql = "SELECT * FROM list WHERE money BETWEEN $money1 AND $money2  AND loan=0 ORDER BY money";
                  }
                } else {
                  $sql = "SELECT * FROM list WHERE money BETWEEN $money1 AND $money2  AND loan=0 ORDER BY money";
                }
                $stm = $pdo->prepare($sql);
                $stm->execute();
                // 結果の取得（連想配列で受け取る）
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                require_once('paging.php');
                if (count($disp_data) > 0) {
                  echo "{$money1}以上{$money2}以下の商品";
                  // テーブルのタイトル行
                  echo '<table class="table table-striped table-hover">';
                  echo '<thead><tr>';
                  echo '<th>', '貸出者', '</th>';
                  echo '<th>', '貸出物', '</th>';
                  echo '<th>', 'ジャンル', '</th>';
                  echo '<th>', 'コメント', '</th>';
                  echo '<th>', '金額', '</th>';
                  echo '<th>', '画像', '</th>';
                  echo '</tr></thead>';
                  echo '<tbody>';
                  foreach ($disp_data as $row) {
                    echo '<tr><td>';
                    echo "<a href='profile.php?id={$row['user_id']}'><img height='100' width='100'src='my_image.php?id={$row['user_id']}'></a><br>";
                    $user_id = $row["user_id"];
                    $sql = "SELECT * FROM users WHERE id=$user_id";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result2 as $row2) {
                      echo $row2["name"] . "</td>";
                    }
                    echo '<td class="col-2">', $row['item'], '</td>';
                    echo '<td>', $row['kind'], '</td>';
                    $text = $row["comment"];
                    $text = strip_tags($text);
                    $limit = 265;
                    if (mb_strlen($text) > $limit) {
                      $title = mb_substr($text, 0, $limit);
                      $text = $title . '･･･';
                    }
                    echo '<td class="col-4">', $text, '</td>';
                    echo '<td>￥', number_format($row['money']), '</td>';
                    echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="200" width="200" src="image.php?id=', $row['id'], '"></a></td>';
                    echo '</tr>';
                  }
                  echo '</tbody>';
                  echo '</table>';
                } else {
                  echo "{$money1}以上{$money2}以下の商品は見つかりませんでした。";
                }
              } catch (Exception $e) {
                echo '<span class="error">エラーがありました。</span><br>';
                echo $e->getMessage();
              }
              require_once('paging2.php');
              ?>
              <hr>
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