<?php
session_start();
$myURL = 'edit.php';
$gobackURL = 'mypage';
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

  <title>貸し借りサイト　Lab:G | 編集中</title>

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
            <h1 class="h3 mb-0 text-gray-800">編集タイム</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <div class="col-12">
              <form method="POST" action="edit_db" enctype="multipart/form-data">
                <?php
                $id = $_SESSION["id"];
                require_once('user_check.php');
                echo "<img src=my_image?id=$id style='max-width:200px;'>";
                echo "<hr>";
                ?>
                名前:
                <input type="text" class="form-control form-control-user col-2" name="name" placeholder="名前"
                  value="<?php echo htmlspecialchars($row["name"]); ?>" required>
                年齢:
                <input type="number" name="age" class="form-control form-control-user col-1" placeholder="年齢"
                  value="<?php echo htmlspecialchars($row["age"]); ?>" required>
                <div>性別:
                  <label><input type="radio" name="sex" value="男" <?php if ($row["sex"] == "男")
                    echo 'checked'; ?>>男性</label>
                  <label><input type="radio" name="sex" value="女" <?php if ($row["sex"] == "女")
                    echo 'checked'; ?>>女性</label>
                  <label><input type="radio" name="sex" value="無回答" <?php if ($row["sex"] == "無回答")
                    echo 'checked'; ?>>無回答</label>
                </div>
                <div>コメント:
                  <input type="text" name="comment" placeholder="comment" class="form-control form-control-user col-4"
                    value="<?php echo htmlspecialchars($row["comment"]); ?>" required>
                </div>
                <label>画像選択:<br>
                  <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                  <input type="file" multiple name="image" class="test" accept="image/*" onchange="previewImage(this);">
                </label>
                <br>
                <button type="submit" class="btn btn-primary col-1">編集</button>
              </form>
              <hr>
              <a class="btn btn-primary" href="<?php echo $gobackURL ?>">戻る</a>
              <div class="col-12"><br></div>
              <a class="btn btn-danger" data-toggle="modal" data-target="#delete_conf">退会する</a>
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
  <div class="modal fade" id="delete_conf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">退会-1</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">本当に退会しますか？</div>
        <div class="modal-footer">
          <a class="btn btn-secondary" href="./">退会しない</a>
          <a class="btn btn-danger" data-toggle="modal" data-target="#delete_conf2">退会する</a>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="delete_conf2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">退会-2</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">本当の本当に退会しますか？</div>
        <div class="modal-footer">
          <a class="btn btn-secondary" href="./">退会しない</a>
          <a class="btn btn-danger" data-toggle="modal" data-target="#delete_conf3">退会する</a>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="delete_conf3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">退会-LAST</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">本当の本当の本当に退会しますか？</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#delete_conf4">退会しない</button>
          <a class="btn btn-danger" href="deleteacount.php">退会する</a>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="delete_conf4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">退会</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">本当の本当に退会しませんか？</div>
        <div class="modal-footer">
          <a class="btn btn-secondary" href="./">はい</a>
          <a class="btn btn-secondary" href="./">YES</a>
        </div>
      </div>
    </div>
  </div>
  <?php require_once("boot_modal.php"); ?>
</body>

</html>