<?php
session_start();

$myURL = 'search_user.php';
require_once "db_connect.php";
$gobackURL = "search_sp.php";


// nameが未設定、空のときはエラー
if (empty($_POST)) {
  header("Location:search_sp.php");
  exit();
} else if (!isset($_POST["user_name"]) || ($_POST["user_name"] === "")) {
  header("Location:{$gobackURL}");
  exit();
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
        <?php require_once("nav.php"); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">ユーザ検索</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <form method="POST" action="search_user.php">
              <label>ユーザ名を検索します（部分一致）：<br>
                <div class="input-group">
                  <input type="text" name="user_name" class="form-control form-control-user" placeholder="名前を入れてください。"
                    value="<?php echo htmlspecialchars($_POST["user_name"]); ?>">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              </label>
            </form>
            <div class="col-12"></div>
            <?php
            $user_name = $_POST["user_name"];
            //MySQLデータベースに接続する
            try {
              if (isset($_SESSION["loggedin"])) {
                $block = 0;
                require_once('block_check.php');
                if ($block_count != 0) {
                  $block_list = implode(",", $block_list);
                  $sql = "SELECT * FROM users WHERE name LIKE(:name) and id not in ($block_list)";
                } else {
                  $sql = "SELECT * FROM users WHERE name LIKE(:name)";
                }
              } else {
                $sql = "SELECT * FROM users WHERE name LIKE(:name)";
              }
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':name', "%{$user_name}%", PDO::PARAM_STR);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              if (count($result) > 0) {
                echo "ユーザ名に「{$user_name}」が含まれているレコード";
                // テーブルのタイトル行
                echo '<table class="table table-striped">';
                echo '<thead><tr>';
                echo '<th>', 'ユーザ', '</th>';
                echo '<th>', 'コメント', '</th>';
                echo '</tr></thead>';
                echo '<tbody>';
                foreach ($result as $row) {
                  echo '<tr>';
                  echo '<td>', $row['name'];
                  echo "<br><a target='_blank' href='profile.php?id={$row['id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row['id']}'></a></td>";
                  echo '<td>', $row['comment'];
                  echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
              } else {
                echo "名前に「{$user_name}」は見つかりませんでした。";
              }
            } catch (Exception $e) {
              echo '<span class="error">エラーがありました。</span><br>';
              echo $e->getMessage();
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