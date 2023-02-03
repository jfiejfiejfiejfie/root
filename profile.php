<?php
session_start();
require_once "db_connect.php";
$myURL = 'profile.php';
$id = $_GET["id"];
define('MAX', '6');
if ($id == $_SESSION["id"]) {
  header("Location:mypage.php");
}
$my_id = $_SESSION["id"];
$_SESSION["my_id"] = $_GET["id"];
#blockcount
$block_count = 0;
$block_count2 = 0;
try {
  //自分がブロックしているか
  $sql = "SELECT * FROM blocklist WHERE user_id =:user_id and my_id=:my_id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':user_id', $id, PDO::PARAM_STR);
  $stm->bindValue(':my_id', $my_id, PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $block_count += 1;
  }
  //相手にブロックされているか
  $sql = "SELECT * FROM blocklist WHERE user_id =:user_id and my_id=:my_id";
  $stm = $pdo->prepare($sql);
  $stm->bindValue(':user_id', $my_id, PDO::PARAM_STR);
  $stm->bindValue(':my_id', $id, PDO::PARAM_STR);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $block_count2 += 1;
  }
} catch (Exception $e) {
  echo 'エラーがありました。';
  echo $e->getMessage();
  exit();
}

$follow_count = 0;
$follow_count2 = 0;
//自分がフォローしているか
$sql = "SELECT * FROM followlist WHERE user_id =:user_id and my_id=:my_id";
$stm = $pdo->prepare($sql);
$stm->bindValue(':user_id', $_SESSION["id"], PDO::PARAM_STR);
$stm->bindValue(':my_id', $_GET["id"], PDO::PARAM_STR);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $follow_count += 1;
}
//相手にフォローされているか
$sql = "SELECT * FROM followlist WHERE user_id =:user_id and my_id=:my_id";
$stm = $pdo->prepare($sql);
$stm->bindValue(':user_id', $_GET["id"], PDO::PARAM_STR);
$stm->bindValue(':my_id', $_SESSION["id"], PDO::PARAM_STR);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $follow_count2 += 1;
}

$sql = "SELECT * FROM users WHERE id =:id";
$stm = $pdo->prepare($sql);
$stm->bindValue(':id', $id, PDO::PARAM_STR);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $admin = $row["admin"];
  $name = $row["name"];
}
$myURL = 'profile.php';
$option = "&id=$id";
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
            <h1 class="col-6 h3 mb-0 text-gray-800">プロフィール</h1>
            <h1 class="col-6 h3 mb-0 text-gray-800">
                  <?php echo htmlspecialchars($name); ?>が出品している物
                </h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>
          <div class="row">
            <br>
            <div class="col-4">
              <?php
              $id = $_GET["id"];
              ?>
              <img class="img-profile rounded-circle" height="150" width="150" src="my_image.php?id=<?php echo $id; ?>">
              <div class="col-12"></div>
              <?php
              if ($admin == 0) {
                echo '<font size="10">', $name, '</font><br>';
              } else {
                echo '<font size="10">', $name, '<img src="images/admin.png" style="height:70px;"></font><br>';
              }
              echo '<div class="col-12"></div>';
              if ($block_count == 0 && $block_count2 == 0) {
                try {
                  $sql = "SELECT * FROM users WHERE id =:id";
                  $stm = $pdo->prepare($sql);
                  $stm->bindValue(':id', $id, PDO::PARAM_STR);
                  $stm->execute();
                  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result as $row) {
                    echo '<font size="5">', htmlspecialchars($row["age"]), '歳</font><div class="col-12"></div>';
                    echo '<font size="5">', htmlspecialchars($row["sex"]), '</font><div class="col-12"></div>';
                    // echo '<font size="3">', htmlspecialchars($row["email"]), '</font><div class="col-12"></div>';
                    echo '<hr>コメント<div class="col-12"></div><font size="10">', htmlspecialchars($row["comment"]), '</font><div class="col-12"></div>';
                    echo '<hr>評価<div class="col-12"></div><font size="10">';
                    $score = $row["evaluation"];
                    if($score>=9500){
                      echo '<div class="rainbow">S+</div>';
                    }else if($score>=7700){
                      echo '<div style="color:gold">S</div>';
                    }
                    else if($score>=5800){
                      echo '<div style="color:red">A</div>';
                    }
                    else if($score>=3500){
                      echo '<div style="color:blue">B</div>';
                    }
                    else if($score>=1300){
                      echo '<div style="color:green">C</div>';
                    }
                    else{
                      echo '<div style="color:black">D</div>';
                    }
                    echo number_format($score), '点</font><div class="col-12"></div>';
                  }
                } catch (Exception $e) {
                  echo 'エラーがありました。';
                  echo $e->getMessage();
                  exit();
                }
                $sql = "SELECT * FROM followlist WHERE my_id =$id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                $sth = $pdo->query($sql);
                $count = $sth->rowCount();
                echo '<hr>フォロー<div class="col-12"></div><font size="5">', '<a href="followlist.php?id=' . $_GET["id"] . '">';
                echo $count . "人</a><br></font><div class='col-12'></div>";
              ?>
              <?php
                $sql = "SELECT * FROM followlist WHERE user_id =$id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                $sth = $pdo->query($sql);
                $count2 = $sth->rowCount();
                echo 'フォロワー<div class="col-12"></div><font size="5">', '<a href="followerlist.php?id=' . $_GET["id"] . '">';
                echo $count2 . "人</a><br></font><hr>";
              ?>
              <?php
                echo "<a href='user_chat.php?id={$row["id"]}' class='btn btn-success col-6'>チャットをする<div class='fa fa-comment'></div></a>";
                // echo '<form method="POST" action="detail.php?id=' . $row["id"] . '&good=1">';
                // echo '</form>';
                // if ($_SESSION['id'] !== $id) {
                if ($follow_count2 == 0) {
                  echo "<a href='follow.php?id=$id' class='btn btn-primary col-6'>フォローする<div class='fa fa-user-plus'></div></a>";
                } else {
                  echo "<a href='follow.php?id=$id' class='btn btn-danger col-6'>フォロー解除する<div class='fa fa-user-times'></div></a>";
                }
                // echo "<div class='col-12'></div>";
                echo '<br>';
              } else if ($block_count != 0 && $block_count2 != 0) {
                echo "<h1>相互ブロックです。</h1><div class='col-12'></div>";
              } else if ($block_count2 != 0) {
                echo "<h1>あなたはこのユーザにブロックされています。</h1><div class='col-12'></div>";
              } else if ($block_count != 0) {
                echo "<h1>あなたはこのユーザをブロックしています。</h1><div class='col-12'></div>";
              }
              if ($block_count == 0) {
                echo "<a href='block.php?id=$id' class='btn btn-danger col-6'>ブロックする<div class='fa fa-ban'></div></a>";
              } else {
                echo "<a href='block.php?id=$id' class='btn btn-primary col-6'>ブロックを解除する<div class='fa fa-times-circle'></div></a>";
              }
              echo '<a class="btn btn-warning col-6" href="report.php?user_id=' . $id . '">通報<div class="fa fa-exclamation-triangle"></div></a></th>';
              echo "<div class='col-8'></div>";
              // }
              ?>
            </div>
            <div class="col-8">
              
              <?php
              try {
                $sql = "SELECT * FROM list WHERE user_id=:id AND loan=0";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $id, PDO::PARAM_STR);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                require_once('paging.php');
                echo '<table class="table table-striped">';
                echo '<thead><tr>';
                echo '<th>', '掲載日', '</th>';
                echo '<th>', '貸出物', '</th>';
                echo '<th>', '画像', '</th>';
                echo '</tr></thead>';
                echo '<tbody>';
                foreach ($disp_data as $row) {
                  echo '<tr>';
                  echo '<td>', $row['created_at'], '</td>';
                  echo '<td>', $row['item'], '</td>';
                  echo "<td><a target='_blank' href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
                  echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
              } catch (Exception $e) {
                echo 'エラーがありました。';
                echo $e->getMessage();
                exit();
              }
              require_once('paging2.php');
              ?>
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