<?php
session_start();

require_once "db_connect.php";
$myURL = 'detail.php';
$gobackURL = 'index.php';
$id = $_GET["id"];
$flag = 0;
$sql = "SELECT * FROM list WHERE id=$id";
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $item_name = $row["item"];
  $flag += 1;
}
if ($flag == 0) {
  header('Location:404.php');
}
$list_id = $_GET["id"];
require_once('reservation.php');
require_once('good.php');
require_once('detail_chat.php');
?>
<?php
if (isset($_SESSION["id"])) {

  ?>
  <?php
  $sql = "SELECT * FROM list WHERE id =$list_id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
  }
  $text = $_SERVER["REQUEST_URI"];
  // 部分一致
  if (preg_match("/&good=1/", $text)) {
    exit;
  }
  if (preg_match("/&chat=1/", $text)) {
    exit;
  }
  $text = "{$row["id"]}";
  //  $text="{$row["id"]}:{$row["item"]}";
  $data_item = array($text); //ここに保存したいテキスト（配列にしとく）
  $data_url = array($_SERVER["REQUEST_URI"]); //現在のURL（配列にしとく）
  $max = '10'; //保存する数

  //テキストの保存
  if (isset($_COOKIE['history_item'])) { //現在クッキーに保存されているものがあれば
    $status = unserialize($_COOKIE['history_item']); //まずアンシリアライズ（？）で配列に
    foreach ($status as $key => $name) {
      if (!in_array($name, $data_item)) { // data_itemにnameがなければ
        array_push($data_item, $name); // data_itemに突っ込む
      }
      if (count($data_item) == $max) { //保存する数で終了
        break;
      }
    }
  }

  //URL保存　テキスト保存とやってることは一緒
  if (isset($_COOKIE['history_url'])) {
    $status = unserialize($_COOKIE['history_url']);
    foreach ($status as $key => $name) {
      if (!in_array($name, $data_url)) {
        array_push($data_url, $name);
      }
      if (count($data_url) == $max) {
        break;
      }
    }
  }

  //クッキーセット
  setcookie('history_item', serialize($data_item), time() + 3600, '/');
  setcookie('history_url', serialize($data_url), time() + 3600, '/');
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

  <title>貸し借りサイト　Lab:G | <?php echo $item_name."の詳細";?></title>

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
            <h1 class="h3 mb-0 text-gray-800"></h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
            <!-- <h2>出品物詳細</h2> -->
            <div class="col-12">
              <div class="row">
                <div class="col-12">
                  <?php
                  $data = $_GET["id"];
                  echo '<h1>出品物詳細</h1>';
                  try {
                    $sql = "SELECT * FROM image_list WHERE list_id=$data";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    $image_count = 0;
                    foreach ($result as $row) {
                      $image_count += 1;
                    }
                  } catch (Exception $e) {
                    echo 'エラーがありました。';
                    echo $e->getMessage();
                    exit();
                  }
                  try {
                    $sql = "SELECT * FROM likes WHERE list_id=$data";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    $count = 0;
                    foreach ($result as $row) {
                      $count += 1;
                    }
                  } catch (Exception $e) {
                    echo 'エラーがありました。';
                    echo $e->getMessage();
                    exit();
                  }

                  try {
                    $sql = "SELECT item,kind,state,users.point,
                      buy_user_id,list.id as list_id,list.created_at as time,users.id as user_id,users.name as name,list.comment as comment
                     FROM list,users WHERE list.id=$data && users.id=list.user_id";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                      echo '<table class="table table-striped">';
                      echo '<thead><tr><th class="col-1">画像一覧</th>';
                      echo '<td class="col-3"><a img data-lightbox="group" height="200" width="200" href="image.php?id=', $row['list_id'], '">
                  <img src="image.php?id=', $row['list_id'], '"height="150" width="150"></a>';
                      if ($image_count > 0) {
                        echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=', $row['list_id'], '&number=1">
                        <img src="image_next.php?id=', $row['list_id'], '&number=1"height="150" width="150"></a>';
                        if ($image_count > 1) {
                          echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=', $row['list_id'], '&number=2">
                          <img src="image_next.php?id=', $row['list_id'], '&number=2"height="150" width="150"></a>';
                          if ($image_count > 2) {
                            echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=', $row['list_id'], '&number=3">
                            <img src="image_next.php?id=', $row['list_id'], '&number=3"height="150" width="150"></a>';
                            if ($image_count > 3) {
                              echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=', $row['list_id'], '&number=4">
                              <img src="image_next.php?id=', $row['list_id'], '&number=4"height="150" width="150"></a></td>';
                            }
                          }
                        }
                      }
                      echo '</tr>';
                      // echo '<tr>';
                      echo '<tr>';
                      echo '<th>最終編集時間</th>';
                      echo '<td>', $row["time"], '</td>';
                      echo '</tr>';
                      echo '<tr>';
                      echo '<th>レンタル品名</th>';
                      echo '<td>', $row["item"], '</td>';
                      echo '</tr>';
                      echo '<tr>';
                      echo '<th>ジャンル</th>';
                      echo '<td><a href="search_kind.php?kind_name=', $row["kind"], '">', ($row['kind']), '</a></td>';
                      echo '</tr>';
                      echo '<tr>';
                      echo '<th>レンタル品の状態</th>';
                      echo '<td>', $row["state"], '</td>';
                      echo '</tr>';
                      // echo '<tr>';
                      // echo '<th>金額</th>';
                      // echo '<td>￥', number_format($row['price']), '</td>';
                      // $price = $row["price"];
                      // echo '</tr>';
                      echo '<tr>';
                      echo '<th>出品者</th>';
                      echo '<td>';
                      echo "<a href='profile.php?id={$row['user_id']}'><img class='img-profile rounded-circle' height='100' width='100'src='my_image.php?id={$row['user_id']}'></a><br>";
                      echo $row["name"], "</td>";

                      echo '</tr>';
                      echo '<tr>';
                      echo '<th>コメント</th>';
                      echo '<td>', $row["comment"], '</td>';
                      echo '</tr>';
                      if ($row["buy_user_id"] !== 0) {
                        $buy_user_id = $row["buy_user_id"];
                        echo '<tr>';
                        echo '<th>レンタル者</th>';
                        echo '<td>';
                        echo "<a href='profile.php?id=$buy_user_id'><img id='image' height='100' width='100'src='my_image.php?id=$buy_user_id'></a><br>";
                        $user_id = $row["buy_user_id"];
                        echo '</tr>';
                      } else {
                        $user_id = $row["buy_user_id"];
                      }
                      echo '</thead>';
                      echo '</table>';
                    }
                  } catch (Exception $e) {
                    echo 'エラーがありました。';
                    echo $e->getMessage();
                    exit();
                  }
                  ?>
                  <?php
                  $buy_user_id = $row["buy_user_id"];
                  // echo "<a href='favorite.php?id={$row["id"]}' class='btn'><img src='images/good.png' style='max-width:50px'>$count</a><br>";
                  if ($buy_user_id === 0) {
                    // echo "<a href='loan.php?id={$row["id"]}' class='btn btn-success col-2'>チャットをする</a><br>";
                    echo '<form method="POST" action="detail.php?id=' . $row["list_id"] . '&good=1">';
                    echo "<button type='submit'><div class='w-100 mw-100'><i class='fa fa-thumbs-up' aria-hidden='true'>$count</i></div></button><br>";
                    echo '</form>';
                    echo '<a class="btn btn-success col-3" data-toggle="modal" data-target="#chat">チャット</div>';
                  }

                  if ($_SESSION['id'] === $row["user_id"]) {
                    if ($buy_user_id === 0) {
                      echo "<a href='my_edit.php?id={$row["list_id"]}' class='btn btn-primary col-2'>編集する</a>";
                      echo "<a href='mydelete.php?id={$row["list_id"]}' class='btn btn-danger col-2'>削除する</a>";
                      echo '<div class="col-12"></div>';
                      echo "<a href='reservation_auth.php?id={$row["list_id"]}' class='btn btn-danger col-4'>予約一覧</a>";
                    } else {
                      echo '<div class="col-12"></div>';
                      echo "<a href='loan_chat.php?id={$row["list_id"]}' class='btn btn-success col-4'>取引チャット</a>";
                    }
                  } else {
                    if ($user_id === 0) {
                      $checked = 100;
                      $sql = "SELECT * FROM reservation_list WHERE user_id=$id and list_id=" . $row["list_id"];
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $result3 = $stm->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result3 as $row3) {
                        $checked = $row3["auth"];
                      }
                      $sql = "SELECT * FROM reservation_list WHERE list_id=" . $row["list_id"];
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $result3 = $stm->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($result3 as $row3) {
                        if ($row3["user_id"] != $id && $row3["auth"] == 1) {
                          $checked = 2;
                        }
                      }

                      if ($checked == 100) {
                        echo "<a href='detail.php?id={$_GET['id']}&reservation=1' class='btn btn-danger'>予約する</a>";
                      } else if ($checked == 0) {
                        echo "<a href='detail.php?id={$_GET['id']}&reservation=1' class='btn btn-danger'>予約中</a>";
                      } else if ($checked == 1) {
                        echo "<a href='buy.php?id={$_GET['id']}&user_id={$_SESSION["id"]}' class='btn btn-danger'>レンタルする</a>";
                      } else if ($checked == 2) {
                        echo "<a class='btn btn-danger'>予約は終了しました。</a>";
                      }
                    } else {
                      echo "<div style='color:red;'>※このレンタル品は売り切れのため、チャットをすることはできません。</div><br>";
                      echo "<a href='#' class='btn btn-danger'>売り切れ</a>";
                      echo '<div class="col-12"></div>';
                      if ($buy_user_id === $_SESSION["id"]) {
                        echo "<a href='loan_chat.php?id={$row["list_id"]}' class='btn btn-success col-4'>取引チャット</a>";
                      }
                    }
                  }
                  ?>
                  <div class="col-12"></div>
                  <a class="btn btn-primary col-4" href="<?php echo $gobackURL ?>">戻る</a>
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
              <span>Copyright &copy; Lending and borrowing:GOD 2022-2023</span>
            </div>
          </div>
        </footer>
        <!-- End of Footer -->

      </div>
      <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <div class="modal fade" id="chat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              チャット</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">送信できます</div>
          <div class="modal-footer">
            <div class="row">
              <?php
              $chat_count = 0;
              $sql = "SELECT text,chat.image as chat_image,chat.id as chat_id,chat.created_at as time,chat.user_id as user_id,users.name as name FROM chat,users WHERE chat.list_id=$list_id && users.id=chat.user_id";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $chat_result = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($chat_result as $chat_row) {
                echo '<table class="table table-striped col-4">';
                echo '<thead>';
                echo '<tr>';
                echo '<td><a href="profile.php?id=', $chat_row["user_id"], '">', '<img id="image" height="100" width="100" src="my_image.php?id=', $chat_row["user_id"], '"></a><br>';
                echo $chat_row["name"], "<br>";
                echo $chat_row["time"], '</td>';
                // echo '</tr>';
                // echo '<tr>';
                echo '</thead></table>';
                echo '<table class="table table-striped col-8"><tbody><td>';
                if ($chat_row["chat_image"] != "") {
                  echo '<img id="parent" src="chat_image.php?id=', $chat_row["chat_id"], '" alt="" height="150" width="150"/>';
                  // echo '</tr>';
                  // echo '<tr>';
                }
                echo $chat_row["text"], '</td>';
                echo '</tr>';
                echo '</tbody>';
                echo '</table>';
                $chat_count += 1;
              }
              if ($chat_count == 0) {
                echo "<div class='col-12 h1'>チャットはありません</div>";
              }
              if ($user_id === 0) {
                ?>
                <form action="detail.php?id=<?php echo $_GET["id"]; ?>&chat=1" method="POST"
                  enctype="multipart/form-data">
                  <label>画像選択:<br>
                    <img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                    <input type="file" multiple name="image" class="test" accept="image/*" onchange="previewImage(this);">
                  </label><br>
                  <div class="input-group col-12">
                    <input type="text" name="text" class="form-control form-control-user" required>
                    <!-- </div> -->
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"
                          aria-hidden="true"></i></button>
                    </div>
                  </div>
                </form>
                <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require_once("boot_modal.php"); ?>
</body>

</html>