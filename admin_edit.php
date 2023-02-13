<?php
session_start();
$gobackURL = 'mypage.php';
$myURL = 'admin_edit.php';
require_once "db_connect.php";
require_once('user_check.php');
if ($row["admin"] == 0) {
  header('Location:index.php');
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
            <h1 class="h3 mb-0 text-gray-800">編集タイム</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <form method="POST" action="admin_edit_db.php" enctype="multipart/form-data">
              <?php
              $id = $_GET["id"];
              $sql = "SELECT * FROM users WHERE id=$id";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $row) {
              }
              echo "<img src=my_image.php?id=$id style='max-width:300px;'>";
              echo "<hr>";
              ?>
              <ul>
                <li>
                  <label>ユーザID:
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="user_id" placeholder="ユーザID"
                      value="<?php echo htmlspecialchars($row["user_id"]); ?>" required>
                  </label>
                  <label>名前:
                    <input type="text" name="name" placeholder="名前"
                      value="<?php echo htmlspecialchars($row["name"]); ?>" required>
                  </label>
                </li>
                </li>
                <label>年齢:
                  <input type="number" name="age" placeholder="年齢" value="<?php echo htmlspecialchars($row["age"]); ?>"
                    required>
                </label>
                </li>
                <li>性別:
                  <label><input type="radio" name="sex" value="男" checked>男性</label>
                  <label><input type="radio" name="sex" value="女">女性</label>
                  <label><input type="radio" name="sex" value="無回答">無回答</label>
                </li>
                <li>
                  <label>E-mail:
                    <input type="text" name="email" placeholder="E-mail"
                      value="<?php echo htmlspecialchars($row["email"]); ?>">
                  </label>
                </li>
                <li>
                  <label>コメント:
                    <input type="text" name="comment" placeholder="comment"
                      value="<?php echo htmlspecialchars($row["comment"]); ?>" required>
                  </label>
                </li>
                <li>
                  <label>画像選択:<br>
                    <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                    <input type="file" multiple name="image" class="test" accept="image/*"
                      onchange="previewImage(this);">
                  </label>
                </li>
                <li>
                  <label>評価:
                    <input type="text" name="evaluation" placeholder="evaluation"
                      value="<?php echo htmlspecialchars($row["evaluation"]); ?>" required>
                  </label>
                </li>
                <li><input type="submit" value="変更する"></li>
              </ul>
            </form>

            <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
            <br>
            <form method="POST" action="deleteacount.php" enctype="multipart/form-data">
              <ul>
                <li>
                  <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                  <input type="submit" value="垢BANする">
                </li>
              </ul>
            </form>
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