<?php
session_start();
$myURL = 'reservation_auth.php';
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
            <h1 class="h3 mb-0 text-gray-800"></h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <?php
            if (!isset($_GET["user_id"])) {
              if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                $id = $_SESSION["id"];
                $list_id = $_GET["id"];
                $sql = "SELECT * FROM list WHERE id=:id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $list_id, PDO::PARAM_STR);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                  echo '<div class="col-12"></div>';
                  echo '<h2>' . $row["item"] . 'を予約している人</h2>';
                  echo '<div class="col-12"><br></div>';
                }
                // $list_list = [];
                // $list_count = 0;
                $sql = "SELECT * FROM list WHERE  id=:id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $list_id, PDO::PARAM_STR);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                  $sql = "SELECT * FROM reservation_list WHERE  list_id =$list_id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result2 as $row2) {
                    // $sql = "UPDATE reservation_list SET checked=1 where list_id = :id and user_id=:user_id";
                    // $stm = $pdo->prepare($sql);
                    // $stm->bindValue(':id', $list_id, PDO::PARAM_STR);
                    // $stm->bindValue(':user_id', $row2["user_id"], PDO::PARAM_STR);
                    // $stm->execute();
                    echo '<table class="table table-striped">';
                    echo "<a href='profile.php?id={$row2['user_id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row2['user_id']}'></a><br>";
                    $user_id = $row2["user_id"];
                    $sql = "SELECT * FROM users WHERE id=$user_id";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $result3 = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result3 as $row3) {
                      echo '<div class="col-12"></div>';
                      echo $row3["name"], "<a href='reservation_auth.php?id=$list_id&user_id=$user_id' class='btn btn-primary'>認可する</a></td>";
                    }
                    echo "<hr>";
                    echo '</tr>';
                  }
                  echo '</tbody>';
                  echo '</table>';
                }
              }
            } else {
              $data = $_SESSION["id"];
              $id = $_GET["id"];
              $user_id = $_GET["user_id"];
              $sql = "SELECT * FROM users WHERE id=$user_id";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result2 as $row2) {
                echo $row2["name"], 'を認可しました。';
              }
              $sql = "UPDATE reservation_list SET auth=1 where list_id = :id and user_id=:user_id";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':id', $id, PDO::PARAM_STR);
              $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
              $stm->execute();
              $sql = "SELECT * FROM list WHERE id=$id";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result3 = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result3 as $row3) {
                $item = $row3["item"];
              }
              $text = "あなたが予約した<a href='detail.php?id=" . $id . "'>" . $item . "</a>の認可はされました。
                    ※これは自動送信です。";
              date_default_timezone_set('Asia/Tokyo');
              $date = date('Y-m-d H:i:s');
              $sql = "INSERT INTO user_chat (user_id,created_at,text,others_id) VALUES(:user_id,:date,:text,:others_id)";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':user_id', $data, PDO::PARAM_STR);
              $stm->bindValue(':date', $date, PDO::PARAM_STR);
              $stm->bindValue(':text', $text, PDO::PARAM_STR);
              $stm->bindValue(':others_id', $user_id, PDO::PARAM_STR);
              $stm->execute();
              $sql = "SELECT * FROM reservation_list where list_id = :id and user_id != :user_id";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':id', $id, PDO::PARAM_STR);
              $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $row) {
                $text = "あなたが予約した<a href='detail.php?id=" . $id . "'>" . $item . "</a>の認可はされませんでした。
                    ※これは自動送信です。";
                date_default_timezone_set('Asia/Tokyo');
                $date = date('Y-m-d H:i:s');
                $sql = "INSERT INTO user_chat (user_id,created_at,text,others_id) VALUES(:user_id,:date,:text,:others_id)";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':user_id', $data, PDO::PARAM_STR);
                $stm->bindValue(':date', $date, PDO::PARAM_STR);
                $stm->bindValue(':text', $text, PDO::PARAM_STR);
                $stm->bindValue(':others_id', $row["user_id"], PDO::PARAM_STR);
                $stm->execute();
              }
              $sql = "DELETE FROM reservation_list where list_id = :id and user_id != :user_id";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':id', $id, PDO::PARAM_STR);
              $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
              $stm->execute();
              echo '<a href="mypage.php">マイページに戻る</a>';
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

  <?php require_once("boot_modal.php"); ?>
</body>

</html>