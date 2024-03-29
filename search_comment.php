<?php
session_start();

if (!isset($_SESSION["loggedin"])) {
  header('Location:login');
}
// if ("location:login.php")
//     ;
require_once "db_connect.php";
require_once('checked.php');
require_once "db_connect.php";
$myURL = 'add_db.php';
$gobackURL = 'keijiban';
?>

<!DOCTYPE html>
<html lang="ja">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>貸し借りサイト　Lab:GA | 掲示板検索</title>

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
            <h1 class="h3 mb-0 text-gray-800">検索結果</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <?php
            $message = $_POST["message"];
            try {
              $sql = "SELECT * FROM message WHERE message LIKE(:message)";
              // プリペアドステートメントを作る
              $stm = $pdo->prepare($sql);
              // プレースホルダに値をバインドする
              $stm->bindValue(':message', "%{$message}%", PDO::PARAM_STR);
              // SQL文を実行する
              $stm->execute();
              // 結果の取得（連想配列で受け取る）
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              if (count($result) > 0) {
                // echo "<script> final(); </script>";
                echo "コメントに「{$message}」が含まれているレコード";
                // テーブルのタイトル行
                //   echo '<table class="table table-striped">';
                //   echo '<thead><tr>';
                //   echo '<th>','ユーザ','</th>';
                //   echo '<th>','コメント','</th>';
                //   echo '</tr></thead>';
                //   echo '<tbody>';
                foreach ($result as $row) {
                  echo '<table class="table table-striped">';
                  echo '<thead><tr>';
                  echo '<th>No', $row["id"], ' ', $row["view_name"], ':';
                  echo $row["post_date"], '</th>';
                  echo '</tr>';
                  echo '<tr>';
                  echo '<td>', $row["message"], '</td>';
                  echo '</tr>';
                  echo '</thead>';
                  echo '</table>';
                }
              } else {
                echo "名前に「{$message}」は見つかりませんでした。";
                // echo "<script> suteki(); </script>";
              }
            } catch (Exception $e) {
              echo '<span class="error">エラーがありました。</span><br>';
              echo $e->getMessage();
            }
            ?>
            <hr>
            <p><a class="btn btn-primary" href="<?php echo $gobackURL ?>">戻る</a></p>
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