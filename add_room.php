<?php
session_start();

if (!isset($_SESSION["loggedin"])) {
  header('Location:login.php');
}
// if ("location:login.php")
//     ;
require_once "db_connect.php";
require_once('checked.php');
require_once "db_connect.php";
$myURL = 'add_room.php';
$gobackURL = 'index.php';
$point = 0;
if (isset($_POST["item"])) {
  require_once('create_room.php');
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

  <title>貸し借りサイト　Lab:G | ルーム作成</title>

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
            <h1 class="h3 mb-0 text-gray-800">チャットルーム登録</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <div class="col-6">
              <form method="POST" action="add_room.php" enctype="multipart/form-data">
                <?php
                if (isset($_SESSION["create_text"])) {
                  echo '<label>' . $_SESSION["create_text"] . '</label>';
                } ?>
                <br>
                ルーム名:
                <input type="text" id="item_name" class="form-control form-control-user" name="item"
                  placeholder="必須(30文字まで)" required>
                コメント(任意):
                <script>
                  function countLength(text, field) {
                    document.getElementById(field).innerHTML = text.length + "文字/1000文字";
                  }
                </script>
                <textarea id="message" name="comment" class="form-control form-control-user" placeholder="ルール、注意事項など"
                  onKeyUp="countLength(value, 'textlength2');"></textarea>
                <p id="textlength2">0文字/1000文字</p>
                サムネ画像選択:
                <br>
                <label><img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                  <input type="file" name="image" class="test" accept="image/*" onchange="previewImage(this);" required>
                </label><br>
                <label>
                  <input type="checkbox" required>規約に同意する
                </label>
                <br>
                <input type="submit" class="btn btn-primary btn-user" value="作成する">
              </form>
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