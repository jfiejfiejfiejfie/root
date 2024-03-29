<?php
session_start();

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

  <title>貸し借りサイト　Lab:G | 個人チャット一覧</title>

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
            <!-- <h1 class="h3 mb-0 text-gray-800">レンタル品登録</h1> -->
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
                  echo '<th><a href="profile?id=', $row["user_id"], '">', '<img id="image" height="150" width="150" src="my_image?id=', $row["user_id"], '"></a>';
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
                    echo "<td><a class='btn col-12' href='user_chat?id=" . $user_id . "'>" . $row2["name"] . ':';
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
                    echo '<br><br><br><br><br><br>', $row["created_at"];
                    // echo "<a class='btn btn-primary col-5' href='user_chat.php?id=$user_id'>チャット</a>";
                    echo '</a></td>';
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
                  echo '<th><a href="profile?id=', $row["others_id"], '">', '<img id="image" height="150" width="150" src="my_image?id=', $row["others_id"], '"></a>';
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
                  echo '<td><a class="btn col-12" href="user_chat?id=' . $user_id . '">あなた:';
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
                  echo '<br><br><br><br><br><br>' . $row["created_at"];
                  // echo "<a class='btn btn-primary col-12' href='user_chat.php?id=$user_id'>チャット</a>";
                  echo '</a></td>';
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