<?php
session_start();

$myURL = 'my_edit.php';
$gobackURL = 'room_member.php?id=' . $_GET['id'];
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
            <h1 class="h3 mb-0 text-gray-800">編集</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <div class="col-6">
              <?php
              $data = $_GET["id"];
              $_SESSION["loan_id"] = $data;
              try {
                $sql = "SELECT * FROM room WHERE id=$data";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                  echo '<table class="table table-striped">';
                  echo '<thead><tr>';
                  echo '<td><img src="room_image.php?id=', $row['id'], '"style="max-width:200px;">';
                  echo '</tr>';
                  echo '<tr>';
                  echo '</thead>';
                  echo '</table>';
                  //echo "<td><a href=detail.php?id={$row["id"]}>"
                  $item = $row["item"];
                  $comment = $row["comment"];
                }
              } catch (Exception $e) {
                echo 'エラーがありました。';
                echo $e->getMessage();
                exit();
              }
              ?>
              <hr>
              <form method="POST" action="detail2.php" enctype="multipart/form-data">
                <label>貸出物:
                  <input type="text" name="item" class="form-control form-control-user "
                    value="<?php echo htmlspecialchars($item); ?>" placeholder="貸出物" required>
                  <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET["id"]); ?>">
                </label><br>
                <br>コメント(任意):
                <script>
                  function countLength(text, field) {
                    document.getElementById(field).innerHTML = text.length + "文字/1000文字";
                  }
                </script>
                <textarea id="message" name="comment" class="form-control form-control-user"
                  placeholder="色、素材、重さ、定価、注意点など" onKeyUp="countLength(value, 'textlength2');"></textarea>
                <p id="textlength2">0文字/1000文字</p>

                <br>画像選択:<br>
                <label><img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                  <input type="file" name="image" class="test" accept="image/*" onchange="previewImage(this);">
                </label><br>
                <br><input type="submit" class="btn btn-primary col-2" value="編集する">
                <p><br><a href="<?php echo $gobackURL ?>">戻る</a></p>
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