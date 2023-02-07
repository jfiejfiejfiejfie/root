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
$myURL = 'add_db.php';
$gobackURL = 'index.php';
$point = 0;
if (isset($_GET["delete"])) {
  $sql = "DELETE FROM room WHERE id =" . $_GET['id'];
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $sql = "DELETE FROM roomlist WHERE room_id =" . $_GET['id'];
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $sql = "DELETE FROM roomchat WHERE room_id =" . $_GET['id'];
  $stm = $pdo->prepare($sql);
  $stm->execute();
  header("Location:chat_room.php");
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

          <div class="row">
            <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
              <h2>ルームメンバーリスト</h2>
              <div class="col-12"></div>
              <?php
              if (isset($_GET["id"])) {
                $id = $_GET["id"];
              }
              try {
                $sql = "SELECT roomlist.id as roomlist_id,my_id,room.user_id as host_id,users.name as name FROM roomlist,room,users WHERE room.id=:id && roomlist.room_id=room.id && roomlist.my_id=users.id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $id, PDO::PARAM_STR);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                echo '<table class="table table-striped">';
                foreach ($result as $row) {
                  if ($row["host_id"] == $row["my_id"]) {
                    echo '<div class="col-12">ホストユーザー</div>';
                    echo "<a href='profile.php?id={$row['my_id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row['my_id']}'></a><br>";
                    echo $row["name"];
                    if ($row["host_id"] == $_SESSION["id"]) {
                      echo '<div class="col-12">　</div>';
                      echo "<a href='room_edit.php?id={$_GET["id"]}'  class='btn btn-primary col-3'>ルーム編集する <div class='fa fa-cog'></div></a>";
                    }
                    echo '<div class="col-12">　</div><hr>';
                    echo '<div class="col-12">ゲストユーザー</div>';
                  } else {
                    echo "<div class='col-12'>　</div><a href='profile.php?id={$row['my_id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row['my_id']}'></a><br>";
                    echo $row["name"];
                    if ($row["host_id"] == $_SESSION["id"]) {
                      echo '<div class="col-12">　</div>';
                      echo "<a href='leave_room.php?id=$id&my_id=" . $row["my_id"] . "'  class='btn btn-primary col-3'>脱退させる <div class='fa fa-times'></div></a>";
                    }
                  }
                  echo "<hr>";
                  echo '</tr>';
                }
                if ($row["host_id"] == $_SESSION["id"]) {
                  echo '<div class="col-12">　</div>';
                  echo "<a href='room_member.php?id={$_GET["id"]}&delete=1'  class='btn btn-danger col-3'>ルームを削除する <div class='fa fa-times'></div></a>";
                }
                echo '</tbody>';
                echo '</table>';
              } catch (Exception $e) {
                echo 'エラーがありました。';
                echo $e->getMessage();
                exit();
              }
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