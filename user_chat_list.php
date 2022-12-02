<?php
session_start();
require_once('../lib/util.php');
$myURL = 'user_chat_list.php';
$option = '';
$gobackURL = 'index.php';
require_once "db_connect.php";
$block_count = 0;
$block = 0;
define('MAX', '12');
// require_once("block_check.php");
if (!isset($_SESSION["check"])) {
  $check = 0;
} else {
  $check = $_SESSION["check"];
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
            <h1 class="h3 mb-0 text-gray-800">商品登録</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <?php
            echo '<br><h2 class="col-12">個人チャット一覧</h2>';
            $chat_count = 0;
            $user_id_list = [];
            $id = $_SESSION["id"];
            $sql = "SELECT * FROM user_chat WHERE others_id=$id or user_id=$id ORDER BY created_at DESC";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
              if ($row["others_id"] == $id) {
                if (!in_array($row["user_id"], $user_id_list)) {
                  $chat_count += 1;
                  echo '<table id="user_chat" class="table table-striped">';
                  echo '<thead><tr>';
                  echo '<th><a href="profile.php?id=', $row["user_id"], '">', '<img id="image" height="100" width="100" src="my_image.php?id=', $row["user_id"], '"></a>';
                  $user_id = $row["user_id"];
                  $sql = "SELECT * FROM users WHERE id=$user_id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result2 as $row2) {
                    $block_list = [];
                    $sql = "SELECT * FROM blocklist WHERE my_id =:id";
                    $stm = $pdo->prepare($sql);
                    $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
                    $stm->execute();
                    $block_result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($block_result as $block_row) {
                      $block_list[] = $block_row["user_id"];
                    }
                    echo '<br>';
                    if (in_array($user_id, $block_list)) {
                      echo $row2["name"], "<c style='color:red;'>※ブロック中!</c>";
                    } else {
                      echo $row2["name"];
                    }
                    echo '</th>';
                  }
                  $user_id_list[] = $row["user_id"];
                  $user_id = $row["user_id"];
                  $sql = "SELECT * FROM users WHERE id=$user_id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result2 as $row2) {
                    echo "<td>" . $row2["name"] . ':';
                    //整形したい文字列
                    $text = $row["text"];
                    $text = strip_tags($text);
                    //文字数の上限
                    $limit = 120;
                    if (mb_strlen($text) > $limit) {
                      $title = mb_substr($text, 0, $limit);
                      echo $title . '･･･';
                    } else {
                      echo $text;
                    }
                    if ($row["image"] != "") {
                      echo '<br>画像が添付されています。';
                    }
                    echo '<br>', $row["created_at"] . '<d class="col-3"></d>';
                    echo "<a class='btn btn-primary col-10' href='user_chat.php?id=$user_id'>チャット</a>";
                    echo '</td>';
                  }
                  echo '</tr>';
                  echo '</thead>';
                  echo '</table>';
                }
              } else {
                if (!in_array($row["others_id"], $user_id_list)) {
                  $chat_count += 1;
                  echo '<table id="user_chat" class="table table-striped">';
                  echo '<thead><tr>';
                  echo '<th><a href="profile.php?id=', $row["others_id"], '">', '<img id="image" height="100" width="100" src="my_image.php?id=', $row["others_id"], '"></a>';
                  $user_id = $row["others_id"];
                  $sql = "SELECT * FROM users WHERE id=$user_id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result2 as $row2) {
                    $block_list = [];
                    $sql = "SELECT * FROM blocklist WHERE my_id =:id";
                    $stm = $pdo->prepare($sql);
                    $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
                    $stm->execute();
                    $block_result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($block_result as $block_row) {
                      $block_list[] = $block_row["user_id"];
                    }
                    echo '<br>';
                    if (in_array($user_id, $block_list)) {
                      echo $row2["name"], "<c style='color:red;'>※ブロック中!</c></th>";
                    } else {
                      echo $row2["name"], "</th>";
                    }
                  }
                  $user_id_list[] = $row["others_id"];
                  echo '<td>あなた:';
                  $text = $row["text"];
                  $text = strip_tags($text);
                  //文字数の上限
                  $limit = 120;
                  if (mb_strlen($text) > $limit) {
                    $title = mb_substr($text, 0, $limit);
                    echo $title . '･･･';
                  } else {
                    echo $text;
                  }
                  if ($row["image"] != "") {
                    echo '<br>画像が添付されています。';
                  }
                  echo '<br>', $row["created_at"] . '<d class="col-3"></d>';
                  echo "<a class='btn btn-primary col-10' href='user_chat.php?id=$user_id'>チャット</a>";
                  echo '</td>';
                  echo '</tr>';
                  echo '</thead>';
                  echo '</table>';
                }
              }
            }
            if ($chat_count == 0) {
              echo '<h1 class="col-12 ">チャットはありません</h1>';
            }
            ?>
          </div>
          </section>
          <div>
            <?php

            echo '<div> <div class="">
            <br><h2>チャットルーム一覧</h2>
            <div class="text-right"><a href="add_room.php" class="btn btn-primary col-4" >作成する</a></div></div>';
            try {
              $sql = "SELECT * FROM room";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              echo '<table class="table table-striped">';
              echo '<thead><tr>';
              echo '<th>', 'サムネ画像', '</th>';
              echo '<th>', 'ホストユーザー名', '</th>';
              echo '<th>', 'ルーム名', '</th>';
              echo '<th>', '概要欄', '</th>';
              echo '<th>', '参加人数', '</th>';
              echo '</tr></thead>';
              echo '<tbody>';
              foreach ($result as $row) {
            ?>
            <form action="attend.php" method="POST" enctype="multipart/form-data">
              <?php
                $attend_count = 0;
                $sql = "SELECT * FROM roomlist WHERE room_id =:room_id and my_id=:my_id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':room_id', $row["id"], PDO::PARAM_STR);
                $stm->bindValue(':my_id', $_SESSION["id"], PDO::PARAM_STR);
                $stm->execute();
                $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result2 as $row2) {
                  $attend_count += 1;
                }
                echo '<tr>';
                echo "<td><a href=room.php?id={$row["id"]}>", '<img height="150" width="150" src="room_image.php?id=', $row['id'], '"></a>';
                if ($attend_count == 0) {
                  echo "<br><div><a href='attend.php?id={$row["id"]}' class='btn btn-danger col-4'>参加する</a></td></div>";
                } else {
                  echo "<br><a href='attend.php?id={$row["id"]}' class='btn btn-primary'>脱退する</a>";
                }
              ?>
              <?php
                $user_id = $row["user_id"];
                $sql = "SELECT * FROM users WHERE id=$user_id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result2 as $row2) {
                  echo '<td>', $row2["name"], "</td>";
                }
                echo '<td>', $row['item'], '</td>';
                echo '<td>', $row['comment'], '</td>';
                $sql = "SELECT * FROM roomlist WHERE my_id =$id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                $sth = $pdo->query($sql);
                $count = $sth->rowCount();
                echo '<td>', '<font size="5">', "<a href='room_member.php?id={$row["id"]}'>";
                echo $count . "人</a></font>";
                echo '</td>';
                echo '</tr>';
              }
              echo '</tbody>';
              echo '</table>';
            } catch (Exception $e) {
              echo 'エラーがありました。';
              echo $e->getMessage();
              exit();
            }
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