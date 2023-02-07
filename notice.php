<?php
session_start();

$myURL = 'notice.php';
$gobackURL = 'index.php';
require_once "db_connect.php";
if (isset($_GET["check"])) {
  $check = $_GET["check"];
  if ($check == 1) {
    $id = $_GET["good"];
    $sql = "SELECT * FROM likes WHERE list_id=$id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result_likes = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result_likes as $row_likes) {
      $likes_list[] = $row_likes["id"];
    }
    $likes_list = implode(",", $likes_list);
    $sql = "UPDATE likes SET checked=1 where id in ($likes_list)";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    header('Location:notice.php');
  } elseif ($check == 2) {
    $id = $_GET["loan"];
    $sql = "UPDATE list SET checked=1 where id = $id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    header('Location:notice.php');
  } elseif ($check == 3) {
    $id = $_GET["chat"];
    $sql = "UPDATE chat SET checked=1 where id = $id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    header('Location:notice.php');
  } elseif ($check == 4) {
    $id = $_GET["user_chat"];
    $sql = "UPDATE user_chat SET checked=1 where id = $id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    header('Location:notice.php');
  }
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
            <h1 class="h3 mb-0 text-gray-800">通知一覧</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <?php
            $list_list = [];
            $count = 0;
            $count2 = 0;
            $count_chat = 0;
            $count_chat2 = 0;
            $all_count = 0;
            $id = $_SESSION["id"];
            $sql = "SELECT * FROM list WHERE user_id=$id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result_chat = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result_chat as $row_chat) {
              $count_chat += 1;
              $chat_list[] = $row_chat["id"];
            }
            if ($count_chat != 0) {
              $chat_list = implode(",", $chat_list);
              $sql = "SELECT * FROM chat WHERE list_id IN ($chat_list) and checked=0";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $chat_result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($chat_result as $row_chat2) {
                $count_chat2 += 1;
                $chat_list2[] = $row_chat2["list_id"];
              }
            }
            $sql = "SELECT * FROM list WHERE user_id=$id";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result2 as $row2) {
              $count += 1;
              $list_list[] = $row2["id"];
            }
            if ($count != 0) {
              $list_list = implode(",", $list_list);
              $sql = "SELECT * FROM likes WHERE list_id IN ($list_list) and checked=0";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $row) {
                $count2 += 1;
                $main_list[] = $row["list_id"];
              }
            }
            ?>
            <?php
            if ($count2 != 0) {
              $main_list = implode(",", $main_list);
              $sql = "SELECT * FROM list WHERE id IN ($main_list) and checked=0";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              echo "<h2>この商品が「いいね」されました。</h2>";
              echo '<table class="table table-striped">';
              echo '<thead><tr>';
              echo '<th>', '貸出物', '</th>';
              // echo '<th>', '金額', '</th>';
              echo '<th>', '画像', '</th>';
              echo '<th>', 'いいね数', '</th>';
              echo '<th>', '既読にする', '</th>';
              echo '</tr></thead>';
              echo '<tbody>';
              foreach ($result as $row) {
                $good_count = 0;
                echo '<tr>';
                echo '<td>', $row['item'], '</td>';
                // echo '<td>￥', number_format($row['money']), '</td>';
                echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
                $sql = "SELECT * FROM likes WHERE list_id=" . $row["id"];
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result_good = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result_good as $row_good) {
                  $good_count += 1;
                }
                echo "<td><img src='images/good.png' style='max-width:50px'><div style='font-size:35px;'>", $good_count, '</div></td>';
                echo '<td><form method="POST" action="notice.php?good=' . $row["id"] . '&check=1"><input id="check" type="submit" value="〆" name="#" ></form></td>';
                echo '</tr>';
              }
              echo '</tbody>';
              echo '</table>';
            } else {
              $all_count += 1;
            }
            ?>
            <?php
            $loan_count = 0;
            $sql = "SELECT * FROM list WHERE  user_id=:id and loan=1 and checked=0";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':id', $id, PDO::PARAM_STR);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
              $loan_count += 1;
            }
            if ($loan_count > 0) {
              $sql = "SELECT * FROM list WHERE  user_id=:id and loan=1 and checked=0";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':id', $id, PDO::PARAM_STR);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              echo "<h2>この商品が「レンタル」されました。</h2>";
              echo '<table class="table table-striped">';
              echo '<thead><tr>';
              echo '<th>', '掲載日', '</th>';
              echo '<th>', '貸出物', '</th>';
              echo '<th>', 'ジャンル', '</th>';
              // echo '<th>', '金額', '</th>';
              echo '<th>', '画像', '</th>';
              echo '<th>', '既読にする', '</th>';
              echo '</tr></thead>';
              echo '<tbody>';
              foreach ($result as $row) {
                echo '<tr>';
                echo '<td>', $row['created_at'], '</td>';
                echo '<td>', $row['item'], '</td>';
                echo '<td>', $row['kind'], '</td>';
                // echo '<td>￥', number_format($row['money']), '</td>';
                echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="100" width="100" src="image.php?id=', $row['id'], '"></a></td>';
                echo '<td><form method="POST" action="notice.php?loan=' . $row["id"] . '&check=2"><input id="check" type="submit" value="〆" name="#" ></form></td>';
                echo '</tr>';
              }
              echo '</tbody>';
              echo '</table>';
            } else {
              $all_count += 1;
            }
            $user_chat_count = 0;
            $sql = "SELECT * FROM user_chat WHERE others_id=:id and checked=0";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':id', $id, PDO::PARAM_STR);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
              $user_chat_count += 1;
            }
            if ($user_chat_count > 0) {
              $sql = "SELECT * FROM user_chat WHERE others_id=:id and checked=0";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':id', $id, PDO::PARAM_STR);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              echo "<h2>この人から個人チャットが届きました。</h2>";
              echo '<table class="table table-striped">';
              echo '<thead><tr>';
              echo '<th>', '掲載日', '</th>';
              echo '<th>', '名前', '</th>';
              echo '<th>', 'コメント', '</th>';
              echo '<th>', '既読にする', '</th>';
              echo '</tr></thead>';
              echo '<tbody>';
              foreach ($result as $row) {
                echo '<tr>';
                echo '<td>', $row['created_at'], '</td>';
                $sql = "SELECT * FROM users WHERE id=:id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $row["user_id"], PDO::PARAM_STR);
                $stm->execute();
                $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result2 as $row2) {
                }
                echo "<td>", $row2['name'], "<br><a href=user_chat.php?id={$row2["id"]}>", '<img height="100" width="100" src="my_image.php?id=', $row2['id'], '"></a></td>';
                echo '<td>', $row['text'], '</td>';
                echo '<td><form method="POST" action="notice.php?user_chat=' . $row["id"] . '&check=4"><input id="check" type="submit" value="〆" name="#" ></form></td>';
                echo '</tr>';
              }
              echo '</tbody>';
              echo '</table>';
            } else {
              $all_count += 1;
            }
            ?>
            <?php
            if ($count_chat2 != 0) {
              $chat_list2 = implode(",", $chat_list2);
              $sql = "SELECT * FROM chat WHERE list_id IN ($chat_list2) and checked=0";
              $stm = $pdo->prepare($sql);
              // $stm->bindValue(':id',$id,PDO::PARAM_STR);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              echo "<h2>この商品に「チャット」が届きました。</h2>";
              echo '<table class="table table-striped">';
              echo '<thead><tr>';
              echo '<th>', '時間', '</th>';
              echo '<th>', 'コメント内容', '</th>';
              echo '<th>', '画像', '</th>';
              echo '<th>', '既読にする', '</th>';
              echo '</tr></thead>';
              echo '<tbody>';
              foreach ($result as $row) {
                echo '<tr>';
                echo '<td>', $row['created_at'], '</td>';
                echo '<td>', $row['text'], '</td>';
                echo "<td><a href=loan.php?id={$row["list_id"]}>", '<img height="100" width="100" src="image.php?id=', $row['list_id'], '"></a></td>';
                echo '<td><form method="POST" action="notice.php?chat=' . $row["id"] . '&check=3"><input id="check" type="submit" value="〆" name="#" ></form></td>';
                echo '</tr>';
              }
              echo '</tbody>';
              echo '</table>';
            } else {
              $all_count += 1;
            }
            if ($all_count == 4) {
              echo "<h2>現在お知らせはありません。</h2>";
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