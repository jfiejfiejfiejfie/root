<?php
use Vtiful\Kernel\Format;

session_start();

require_once "db_connect.php";
$myURL = 'user_chat.php';
define('MAX', '10');
$id = $_GET["id"];
$myURL = 'user_chat.php';
$option = "&id=$id";
$memo = "チャット";
$gobackURL = "profile.php?id={$id}";
$users_id = $_SESSION["id"];
if (!isset($_GET['page_id'])) {
  $now = 1;
} else {
  $now = $_GET['page_id'];
}
if (isset($_GET["chat"])) {
  $sql = "SELECT * FROM list WHERE id=$id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $user_id = $row["user_id"];
  }
  $errors = [];
  require_once('error.php');
  $text = $_POST["text"];
  $user_id = $_SESSION["id"];
  if ($_FILES["image"]["tmp_name"] == "") {
    $imgdat = "";
  } else {
    $upfile = $_FILES["image"]["tmp_name"];
    $imgdat = file_get_contents($upfile);
  }
  $name = $_SESSION["name"];
  $others_id = $_GET["id"];
  date_default_timezone_set('Asia/Tokyo');
  $date = date('Y-m-d H:i:s');
  if (($text != "") || ($imgdat != "")) {
    $sql = "INSERT INTO user_chat (user_id,created_at,text,image,others_id) VALUES(:user_id,:date,:text,:imgdat,:others_id)";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
    $stm->bindValue(':date', $date, PDO::PARAM_STR);
    $stm->bindValue(':text', $text, PDO::PARAM_STR);
    $stm->bindValue(':imgdat', $imgdat, PDO::PARAM_STR);
    $stm->bindValue(':others_id', $others_id, PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  }
  if (isset($_GET['page_id'])) {
    header('Location:user_chat.php?id=' . $id . '&page_id=' . $now);
  } else {
    header('Location:user_chat.php?id=' . $id);
  }

}

$sql = "SELECT * FROM users WHERE id=$id";
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $user_name2 = $row["name"];
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
            <h1 class="h3 mb-0 text-gray-800">
              <?php
              echo $user_name2;
              ?>とのチャット履歴
            </h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <div>
              <?php
              $id = $_GET["id"];
              $block_count = 0;
              $block_list = [];
              $sql = "SELECT * FROM blocklist WHERE my_id =:id";
              $stm = $pdo->prepare($sql);
              $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
              $stm->execute();
              $block_result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($block_result as $block_row) {
                $block_count += 1;
                $block_list[] = $block_row["user_id"];
              }
              if (!in_array($id, $block_list)) {
                ?>
                <div>
                  <?php if (isset($_GET["page_id"])) {
                    echo '<form action="user_chat.php?id=' . $id . '&chat=1&page_id=' . $now . '" method="POST"enctype="multipart/form-data">';
                  } else {
                    echo '<form action="user_chat.php?id=' . $id . '&chat=1" method="POST"enctype="multipart/form-data">';
                  }
                  ?>
                  <label>画像選択:<br>
                    <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                    <input type="file" multiple name="image" class="test" accept="image/*" onchange="previewImage(this);">
                  </label><br>
                  <div class="input-group col-12">
                    <input type="text" name="text" class="form-control form-control-user">
                    <!-- </div> -->
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"
                          aria-hidden="true"></i></button>
                    </div>
                  </div>
                  </form>
                </div>
              <?php } else { ?>
                <h2>ブロック中のため送信できません。</h2>
              <?php } ?>
              <hr>
              <div>
                <?php
                $day = null;
                $day_now = null;
                $count = 0;
                $sql = "SELECT * FROM user_chat WHERE (others_id=$users_id and user_id=$id) or (others_id = $id  and user_id = $users_id) ORDER BY created_at DESC";
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
                  if (($row["others_id"] == $users_id)) {
                    if ($row["checked"] == 0) {
                      $sql = "UPDATE user_chat SET checked=1 where id = " . $row["id"];
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                    }
                    echo '<table id="user_chat">';
                    echo '<thead><tr>';
                    if ($row["text"] != "" || $row["image"] != "") {
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
                      if ($row["image"] != "") {
                        echo '<a img data-lightbox="group" height="200" width="200" href="user_chat_image.php?id=', $row['id'], '"><img height="232" width="232" src="user_chat_image.php?id=' . $row["id"] . '"></a>';

                      }
                      if ($row["text"] != "") {
                        echo '<div style="font-size:35px; font-family: serif; text-align: left;" class="balloon1">' . $text . '</div>';
                        $time = new DateTime($row["created_at"]);
                        $time = $time->format("H:i");
                        echo '<div style="font-size:20px;">' . $time;
                        echo '</div>';
                      }
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
                    if ($row["image"] != "") {
                      echo '<div style="text-align: right;"><a img data-lightbox="group" height="200" width="200" href="user_chat_image.php?id=', $row['id'], '"><img height="232" width="232" src="user_chat_image.php?id=' . $row["id"] . '"></a></div>';
                      $time = new DateTime($row["created_at"]);
                      $time = $time->format("H:i");
                      echo '<div style="font-size:20px; text-align: right;">' . $time;
                      if ($row["checked"] == 1) {
                        echo ' 既読';
                      }
                    }
                    if ($row["text"] != "") {
                      $text = $row["text"];
                      echo '<div style="text-align: right; font-size:35px; font-family: serif;" class="balloon2 float-right">' . $text . '</div>';
                      if ($row["image"] == "") {
                        $time = new DateTime($row["created_at"]);
                        $time = $time->format("H:i");
                        echo '<div style="font-size:20px; text-align: right;">' . $time;
                        if ($row["checked"] == 1) {
                          echo ' 既読';
                        }
                      }
                    }
                    echo '</div>';
                    echo '</th>';
                    if ($row["text"] != "" || $row["image"] != "") {
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
                      }
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
              <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
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