<?php
session_start();

$myURL = 'edit_db.php';
$gobackURL = 'mypage.php';
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
            <h1 class="h3 mb-0 text-gray-800">編集完了</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>
          <?php
          $id = $_SESSION["id"];
          $name = $_POST["name"];
          $age = $_POST["age"];
          $sex = $_POST["sex"];
          $comment = $_POST["comment"];
          $_SESSION["name"] = $_POST["name"];
          // $_SESSION["age"] = $_POST["age"];
          // $_SESSION["sex"] = $_POST["sex"];
          // $_SESSION["email"] = $_POST["email"];
          // $_SESSION["comment"] = $_POST["comment"];
          try {

            $sql = "UPDATE users SET name=:name ,age = :age,sex = :sex,comment = :comment where id = $id";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':name', $name, PDO::PARAM_STR);
            $stm->bindValue(':age', $age, PDO::PARAM_STR);
            $stm->bindValue(':sex', $sex, PDO::PARAM_STR);
            $stm->bindValue(':comment', $comment, PDO::PARAM_STR);
            if ($stm->execute()) {
              if (isset($_FILES["image"]) && $_FILES["image"]["tmp_name"] != "") {
                $upfile = $_FILES["image"]["tmp_name"];
                $imgdat = file_get_contents($upfile);
                $sql = "UPDATE users SET image=:imgdat where id = $id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
                $stm->execute();
              }
              if (isset($_POST["email"]) && $_POST["email"] != "") {
                $email = $_POST["email"];
                $sql = "UPDATE users SET email=:email where id = $id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':email', $email, PDO::PARAM_STR);
                $stm->execute();
              }
              $sql = "SELECT * FROM users WHERE id = $id";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              echo '<table>';
              echo '<thead><tr>';
              echo '<th>', '年齢', '</th>';
              echo '<th>', '性別', '</th>';
              echo '<th>', 'E-mail', '</th>';
              echo '<th>', 'コメント', '</th>';
              echo '<th>', 'プロフィール画像', '</th>';
              echo '</tr></thead>';
              echo '<tbody>';
              foreach ($result as $row) {
                echo '<tr>';
                echo '<td>', $row['age'], '</td>';
                echo '<td>', $row['sex'], '</td>';
                echo '<td>', $row['email'], '</td>';
                echo '<td>', $row['comment'], '</td>';
                echo '<td><img height="150" width="150" src="my_image.php?id=', $row['id'], '"></td>';
                echo '</tr>';
              }
              echo '</tbody>';
              echo '</table>';
            } else {
              echo "ツイカエラーガアリマシタ。";
            }
          } catch (Exception $e) {
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
          }
          ?>
          <hr>
          <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
          <div class="row">

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