<?php
session_start();
require_once('../lib/util.php');
$myURL = 'search1.php';
$gobackURL = "user_chat_list.php";
require_once "db_connect.php";
define('MAX', '5');
// 文字エンコードの検証
if (!cken($_POST)) {
  header("Location:{$gobackURL}");
  exit();
}

// nameが未設定、空のときはエラー
if (!isset($_GET["item"])) {
  if (empty($_POST)) {
    header("Location:{$gobackURL}");
    exit();
  } else if (!isset($_POST["item"]) || ($_POST["item"] === "")) {
    header("Location:{$gobackURL}");
    exit();
  }
}
if (isset($_GET["item"])) {
  $item = $_GET["item"];
} else {
  $item = $_POST["item"];
}
$myURL = 'search1.php';
$option = "&item=$item";
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
            <h1 class="h3 mb-0 text-gray-800">商品登録</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <section id="point">
              <form method="POST" action="search1.php">
                <ul>
                  <h2>検索</h2>
                  <label>名前を検索します（部分一致）：<br>
                    <input type="text" name="item" placeholder="名前を入れてください。"
                      value="<?php echo htmlspecialchars($item); ?>">
                    <input type="submit" value="検索する">
                  </label>
                </ul>
              </form>
            </section>
            <div class="col-12"></div>
            <section id="point">
              <h2>出品物一覧</h2>
              <div>
                <?php

                //MySQLデータベースに接続する
                try {
                  $block = 0;
                  require_once('block_check.php');
                  if ($block_count != 0) {
                    $block_list = implode(",", $block_list);
                    $sql = "SELECT * FROM list WHERE item LIKE(:item) and user_id not in ($block_list)";
                  } else {
                    $sql = "SELECT * FROM list WHERE item LIKE(:item)";
                  }
                  $stm = $pdo->prepare($sql);
                  $stm->bindValue(':item', "%{$item}%", PDO::PARAM_STR);
                  $stm->execute();
                  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                  require_once('paging.php');
                  if (count($disp_data) > 0) {
                    echo "名前に「{$item}」が含まれているレコード";
                    // テーブルのタイトル行
                    echo '<table class="table">';
                    echo '<thead class="col-12"><tr>';
                    echo '<th class="col-3">', '貸出者', '</th>';
                    echo '<th class="col-3">', '貸出物', '</th>';
                    echo '<th class="col-3">', '金額', '</th>';
                    echo '<th class="col-3">', '画像', '</th>';
                    if ($_SESSION["admin"] == 1) {
                      echo '<th class="col-3">', '削除', '</th>';
                    }
                    echo '</tr></thead>';
                    echo '<tbody>';
                    foreach ($disp_data as $row) {
                      echo '<tr>';
                      $user_id = $row["user_id"];
                      $sql = "SELECT * FROM users WHERE id=$user_id";
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result2 as $row2) {
                        echo '<td class="col-3">', $row2["name"];
                      }
                      echo "<br><a href='profile.php?id={$row['user_id']}'><img height='100' width='100'src='my_image.php?id={$row['user_id']}'></a></td>";
                      echo '<td class="col-3">', $row['item'], '</td>';
                      echo '<td class="col-3">￥', number_format($row['money']), '</td>';
                      echo "<td class='col-3'><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
                      if ($_SESSION["admin"] == 1) {
                        $row['id'] = rawurlencode($row['id']);
                        echo "<td class='col-3'><a class = 'btn btn-primary' href=delete.php?id={$row["id"]}>", "消す", '</a></td>';
                      }
                      echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                  } else {
                    echo "名前に「{$item}」は見つかりませんでした。";
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
            </section>
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