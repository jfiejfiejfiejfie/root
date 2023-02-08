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
$myURL = 'room.php';
define('MAX', '30');
$id = $_GET["id"];
$option = "&id=$id";
$memo = "ルームチャット";
$gobackURL = 'chat_room.php';
$list_id = $_GET["id"];
$point = 0;
if (!isset($_GET['page_id'])) {
  $now = 1;
} else {
  $now = $_GET['page_id'];
}
if (isset($_POST["kind"])) {
  require_once('insert.php');
}
if (isset($_GET["chat"])) {
  // $name = $_SESSION["name"];
  $room_id = $_GET["id"];
  date_default_timezone_set('Asia/Tokyo');
  $date = date('Y-m-d H:i:s');
  if (isset($_GET["img"])) {
    $text = "stamp_123456789";
    if ($_GET["img"] == 0) {
      $img = file_get_contents("stamp/" . $_GET["img"] . ".gif");
    } else {
      $img = file_get_contents("stamp/" . $_GET["img"] . ".png");
    }
    $sql = "INSERT INTO roomchat (user_id,room_id,created_at,text,image) VALUES(:user_id,:room_id,:date,:text,:imgdat)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id', $_SESSION["id"], PDO::PARAM_STR);
    $stm->bindValue(':room_id', $room_id, PDO::PARAM_STR);
    $stm->bindValue(':date', $date, PDO::PARAM_STR);
    $stm->bindValue(':text', $text, PDO::PARAM_STR);
    $stm->bindValue(':imgdat', $img, PDO::PARAM_STR);
    $stm->execute();
    if (isset($_GET['page_id'])) {
      header('Location:room.php?id=' . $id . '&page_id=' . $now);
    } else {
      header('Location:room.php?id=' . $id);
    }
  }
  if ($_FILES["image"]["tmp_name"] == "") {
    $imgdat = "";
  } else {
    $upfile = $_FILES["image"]["tmp_name"];
    $imgdat = file_get_contents($upfile);
  }
  if ((($_POST["text"] != "") || ($imgdat != "")) && ($_POST["text"] != "stamp_123456789")) {
    $sql = "INSERT INTO roomchat (user_id,room_id,created_at,text,image) VALUES(:user_id,:room_id,:date,:text,:imgdat)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id', $_SESSION["id"], PDO::PARAM_STR);
    $stm->bindValue(':room_id', $room_id, PDO::PARAM_STR);
    $stm->bindValue(':date', $date, PDO::PARAM_STR);
    $stm->bindValue(':text', $_POST["text"], PDO::PARAM_STR);
    $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  }
  if (isset($_GET['page_id'])) {
    header('Location:room.php?id=' . $id . '&page_id=' . $now);
  } else {
    header('Location:room.php?id=' . $id);
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js"
    type="text/javascript"></script>
  <script src="js/original.js">
  </script>
  <script>
    $(function () {
      $(".B").toggleClass("C");
      $(".A").click(function () {
        $(".B").toggleClass("C");
      });
    });
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
          <div class="row">
            <div class="col-4">
              <?php
              if (isset($_GET["id"])) {
                $id = $_GET["id"];
              } else {
                $id = $_SESSION["id"];
              }
              try {
                $sql = "SELECT * FROM roomlist WHERE room_id=:id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $id, PDO::PARAM_STR);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                  echo "<a href='profile.php?id={$row['my_id']}'><img id='image' height='50' width='50'src='my_image.php?id={$row['my_id']}'></a>";
                  $room_id = $row["room_id"];
                  $sql = "SELECT * FROM users WHERE id=" . $row["my_id"];
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                }
                echo '</tbody>';
                echo '</table>';
              } catch (Exception $e) {
                echo 'エラーがありました。';
                echo $e->getMessage();
                exit();
              }
              ?>
            </div>
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4 col-12">
              <h1 class="h3 mb-0 text-gray-800"><br>
                <div>ルーム名
                  <?php
                  try {
                    $sql = "SELECT * FROM room WHERE id=$id";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                      echo '「' . $row['item'] . '」';
                      ?>
                      <!-- <form action="attend.php" method="POST" enctype="multipart/form-data"> -->
                      <?php
                      $attend_count = 0;
                      $sql = "SELECT * FROM roomlist WHERE room_id =:room_id and my_id=:my_id";
                      $stm = $pdo->prepare($sql);
                      $stm->bindValue(':room_id', $row["id"], PDO::PARAM_STR);
                      $stm->bindValue(':my_id', $_SESSION["id"], PDO::PARAM_STR);
                      $stm->execute();
                      $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                      ?>
                      <?php
                      $user_id = $row["user_id"];
                      $sql = "SELECT * FROM users WHERE id=$user_id";
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);

                      $sql = "SELECT * FROM roomlist WHERE room_id =" . $row['id'];
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $sth = $pdo->query($sql);
                      $count = $sth->rowCount();
                    }
                  } catch (Exception $e) {
                    echo 'エラーがありました。';
                    echo $e->getMessage();
                    exit();
                  }
                  ?>
              </h1>
            </div>
            <div class="col-12">
              <?php
              $key = 0;
              if (isset($_GET["page_id"])) {
                echo '<form action="room.php?id=' . $id . '&chat=1&page_id=' . $now . '" method="POST"enctype="multipart/form-data">';
                $key = 1;
              } else {
                echo '<form action="room.php?id=' . $id . '&chat=1" method="POST"enctype="multipart/form-data">';
              }
              ?>
              <label>画像:<br>
                <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                <input type="file" multiple class="test" name="image" accept="image/*" onchange="previewImage(this);">
              </label>
              <div class="col-12">
                <!-- <img src="images/aaaa.png"> -->
              </div>
              <br>
              <div class="input-group col-12">
                <input type="text" name="text" class="form-control form-control-user">
                <!-- </div> -->
                <!-- <div class="input-group-append">
                  
                  <a class="btn btn-success"><i class="fa fa-file-image" aria-hidden="true"></i></a>
                </div> -->
                <div class="input-group-append">
                  <a class="A btn btn-danger" data-toggle="modal" data-target="#stamp"><i class="fa fa-smile"
                      aria-hidden="true"></i></a>
                  <!-- <div style="position:absolute; left:20px; top:20px; background-color:#fbff96;">レイヤーです。</div> -->
                </div>
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"
                      aria-hidden="true"></i></button>
                </div>
              </div>
              </form>
            </div>
            <div>
              <?php
              $day = null;
              $day_now = null;
              $count = 0;
              $sql = "SELECT * FROM roomchat WHERE room_id=$id ORDER BY created_at DESC";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result = $stm->fetchAll(PDO::FETCH_ASSOC);
              require_once('paging.php');
              foreach ($disp_data as $row) {
                if ($count == 0) {
                  $day_now = new DateTime($row["created_at"]);
                  $day_now = $day_now->format("m月d日");
                  echo $day_now . '<hr>';
                }
                $day = new DateTime($row["created_at"]);
                $day = $day->format("m月d日");
                if ($day_now !== $day) {
                  $day_now = $day;
                  echo $day_now . '<hr>';
                }
                // echo "<div class='center-block'>" . $day . "</div>";
                if (($row["user_id"] != $_SESSION["id"])) {
                  echo '<table id="user_chat">';
                  echo '<thead><tr>';
                  echo '<th><a href="profile.php?id=', $row["user_id"], '">', '<img id="image" height="150" width="150" src="my_image.php?id=', $row["user_id"], '"></a>';
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
                      echo $row2["name"], "<c style='color:red;'>※ブロック中!</c></th>";
                    } else {
                      echo $row2["name"], "</th>";
                    }
                  }
                  $user_id = $row["user_id"];
                  $sql = "SELECT * FROM users WHERE id=$user_id";
                  $stm = $pdo->prepare($sql);
                  $stm->execute();
                  $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($result2 as $row2) {
                    echo "<td>";
                    //整形したい文字列
                    $text = $row["text"];
                    if ($text != "stamp_123456789") {
                      if ($row["image"] != "") {
                        echo '<a img data-lightbox="group" height="200" width="200" href="room_chat_image.php?id=', $row['id'], '"><img height="232" width="232" src="room_chat_image.php?id=' . $row["id"] . '"></a>';
                      }
                      if ($row["text"] != "") {
                        echo '<div style="font-size:35px; font-family: serif; text-align: left;" class="balloon1">' . $text . '</div>';
                      }
                    } else {
                      echo '<img height="232" width="232" src="room_chat_image.php?id=' . $row["id"] . '">';
                    }
                    $time = new DateTime($row["created_at"]);
                    $time = $time->format("H:i");
                    echo '<div style="font-size:20px;">' . $time;
                    echo '</div>';
                    echo '</td>';
                  }
                  echo '</tr>';
                  echo '</thead>';
                  echo '</table>';
                } else {
                  echo '<table id="user_chat2">';
                  echo '<thead><tr>';
                  echo '<th>';
                  // echo '<div class="clearfix">';
                  $text = $row["text"];
                  $time = new DateTime($row["created_at"]);
                  $time = $time->format("H:i");
                  if ($text != "stamp_123456789") {
                    if ($row["image"] != "") {
                      echo '<div style="text-align: right;"><a img data-lightbox="group" height="200" width="200" href="room_chat_image.php?id=', $row['id'], '"><img height="232" width="232" src="room_chat_image.php?id=' . $row["id"] . '"></a></div>';
                      echo '<div style="font-size:20px; text-align: right;">' . $time;
                    }
                    if ($row["text"] != "") {
                      echo '<div style="text-align: right; font-size:35px; font-family: serif;" class="balloon2 float-right">' . $text . '</div>';
                      if ($row["image"] == "") {
                        echo '<div style="font-size:20px; text-align: right;">' . $time;

                      }
                    }
                  } else {
                    echo '<div style="text-align: right;"><img height="232" width="232" src="room_chat_image.php?id=' . $row["id"] . '"></div>';
                    echo '<div style="font-size:20px; text-align: right;">' . $time;
                  }
                  echo '</div>';
                  echo '</th>';
                  echo '<td><a href="profile.php?id=', $row["user_id"], '">', '<img id="image" height="150" width="150" src="my_image.php?id=', $row["user_id"], '"></a>';
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
                    echo '<br></td>';

                    echo '</tr>';
                    echo '</thead>';
                    echo '</table>';
                  }
                }
                $count += 1;
              }
              require_once('paging2.php');
              ?>
            </div>
          </div>

          <div class="col-12"></div>
          <hr>
          <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
        </div>
      </div>
    </div>
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
  <div class="modal fade" id="stamp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            スタンプ</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">押したら送信できます</div>
        <div class="modal-footer">
          <?php
          for ($i = 0; $i < 21; $i++) {
            if ($key == 0) {
              echo "<a href='room.php?id=$id&chat=1&img=$i'>";
            } else {
              echo "<a href='room.php?id=$id&chat=1&page_id=$now&img=$i'>";
            }
            if ($i == 0) {
              echo '<img src="stamp/' . $i . '.gif" height="100" width="100"></a>';
            } else {
              echo '<img src="stamp/' . $i . '.png" height="100" width="100"></a>';
            }
          } ?>
        </div>
      </div>
    </div>
  </div>
  <?php require_once("boot_modal.php"); ?>
</body>

</html>