<?php
session_start();
require_once('db_connect.php');
$sql = "SELECT * FROM char_data";
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  if ($row["rarity"] == "UR") {
    // array_push($cards['SSR'], $row["name"]);
    $cards['UR'][] = $row["name"];
  }
  else if ($row["rarity"] == "SSR") {
    // array_push($cards['SSR'], $row["name"]);
    $cards['SSR'][] = $row["name"];
  } else if ($row["rarity"] == "SR") {
    // array_push($cards['SR'], $row["name"]);
    $cards['SR'][] = $row["name"];
  } else {
    // array_push($cards['R'], $row["name"]);
    $cards['R'][] = $row["name"];
  }
}
$myURL = 'mypage.php';
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
          <?php
          $id = $_SESSION["id"];
          $sql = "SELECT * FROM users WHERE id =:id";
          $stm = $pdo->prepare($sql);
          $stm->bindValue(':id', $id, PDO::PARAM_STR);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            $name = $row["name"];
            $age = $row["age"];
            $sex = $row["sex"];
            $email = $row["email"];
            $check = $row["checked"];
            $comment = $row["comment"];
            $score = $row["evaluation"];
            $point = $row["point"];
          }
          ?>
          <div class="col-12 d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="col-5 h3 mb-0 text-gray-800">プロフィール</h1>
            <div class="col-7">
              <?php
              echo '<a href="edit.php"  class="btn btn-primary col-3">編集する <div class="fa fa-cog"></div></a>';
              echo '<a href="blocklist.php" class="btn btn-primary col-3">ブロックリスト <div class="fa fa-address-book"></div></a>';
              echo '<a href="reservation_list.php" class="btn btn-primary col-3">予約されたレンタル品 <div class="fa fa-gavel"></div></a>';
              echo '<a href="eturan.php" class="btn btn-primary col-3">閲覧履歴 <i class="fa fa-list"></i></a>';
              if ($row["admin"] == 1) {
                echo "<a href='admin.php' class='btn btn-danger col-12'>管理者ページに行く <i class='fa fa-user-secret'></i></a>";
              }
              ?>
            </div>
          </div>

          <div class="row">
            <div class="col-5">
              <?php
              try {
                echo '<img class="img-profile rounded-circle" height="150" width="150" src="my_image.php?id=' . $id . '"><div class="col-2"></div>';
                echo '<div class="col-12"></div>';
                echo '<font class="col-8" size="10">' . $name . '</font>';
                echo '<div class="col-4"></div>';
                echo '<font class="col-8" size="5">' . $age . '歳</font>';
                echo '<div class="col-4"></div>';
                echo '<font class="col-8" size="5">' . $sex . '</font>';
                echo '<div class="col-4"></div>';
                echo '<font class="col-8" size="5">' . $email . '</font>';
                echo '<hr><div class="col-12">コメント<br><font size="10">', $comment, '</font></div>';
                echo '<hr><div class="col-6">評価<font size="10">';
                if ($score >= 9500) {
                  echo '<div class="rainbow">S+</div>';
                } else if ($score >= 7700) {
                  echo '<div style="color:gold">S</div>';
                  $next = 9500;
                } else if ($score >= 5800) {
                  echo '<div style="color:red">A</div>';
                  $next = 7700;
                } else if ($score >= 3500) {
                  echo '<div style="color:blue">B</div>';
                  $next = 5800;
                } else if ($score >= 1300) {
                  echo '<div style="color:green">C</div>';
                  $next = 3500;
                } else {
                  echo '<div style="color:black">D</div>';
                  $next = 1300;
                }
                echo number_format($score), ' 点</font></div>';
                if (isset($next)) {
                  echo '次のクラスまで残り' . ($next - $score) . '点';
                }
                echo '<div class="col-6">ポイント<font size="10">', number_format($point), 'p</font></div>';
                echo '<a class="btn btn-primary" data-toggle="modal" data-target="#gacha">ポイントでガチャる</a>';
                //echo '<br><a href="shop_list.php"><img src="images/point.png"></a>';
                ?>
                <?php
                $sql = "SELECT * FROM followlist WHERE my_id =$id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                $sth = $pdo->query($sql);
                $count = $sth->rowCount();
                echo '<hr><div class="col-12">フォロー中<font size="5"><a href="followlist.php">';
                echo $count . "人</a></font>";
                ?>
                <?php
                $sql = "SELECT * FROM followlist WHERE user_id =$id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                $sth = $pdo->query($sql);
                $count2 = $sth->rowCount();
                echo 'フォロワー<font size="5"><a href="followerlist.php">';
                echo $count2 . "人</a></font></div>";
                ?>
                <?php
              } catch (Exception $e) {
                echo 'エラーがありました。';
                echo $e->getMessage();
                exit();
              }

              ?>
            </div>
            <div class="col-7">
              <h2>出品中</h2>
              <?php
              try {
                $sql = "SELECT * FROM list WHERE user_id=$id and loan=0 LIMIT 3";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                echo '<table class="table table-striped">';
                echo '<thead><tr>';
                echo '<th>', '掲載日', '</th>';
                echo '<th>', '貸出物', '</th>';
                echo '<th>', 'ジャンル', '</th>';
                echo '<th>', '画像', '</th>';
                echo '</tr></thead>';
                echo '<tbody>';
                foreach ($result as $row) {
                  echo '<tr>';
                  echo '<td>', $row['created_at'], '</td>';
                  echo '<td>', $row['item'], '</td>';
                  echo '<td>', $row['kind'], '</td>';
                  echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="200" width="200" src="image.php?id=', $row['id'], '"></a></td>';
                  echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '<a class="btn btn-primary col-12" href="display.php">一覧で見る</a><hr>';
              } catch (Exception $e) {
                echo 'エラーがありました。';
                echo $e->getMessage();
                exit();
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
    <div class="modal fade" id="gacha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              ガチャ</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">10pで一回ガチャが回せます</div>
          <div class="modal-footer">
            <?php
            echo "<div class='col-12'>所持ポイント:" . $point . "p</div>";
            echo "<a class='btn btn-success col-12' data-toggle='modal' data-target='#kakuritu'>提供割合</a>";
            echo "<a href='gacha.php' class='btn btn-primary col-12'>ガチャる</a>";
            echo "<a href='gacha.php?custom=1' class='btn btn-primary col-12'>10連ガチャ</a>";
            if ($point >= 10) {
              echo "<br><div class='col-12'>あと" . floor($point / 10) . "回引けます</div>";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="kakuritu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              排出確率</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">ノーマルガチャ</div>
          <div class="modal-footer">
            <?php
            echo "<div class='col-12'>UR:0.1%</div><hr>";
            echo "<div class='col-12'>";
            foreach ($cards["UR"] as $ur) {
              echo $ur . ',';
            }
            echo "</div>";
            echo "<div class='col-12'>SSR:6.9%</div><hr>";
            echo "<div class='col-12'>";
            foreach ($cards["SSR"] as $ssr) {
              echo $ssr . ',';
            }
            echo "</div>";
            echo "<div class='col-12'>SR:23%※10連時10個目93%</div>";
            echo "<div class='col-12'>";
            foreach ($cards["SR"] as $sr) {
              echo $sr . ',';
            }
            echo "</div>";
            echo "<div class='col-12'>R:70%</div>";
            echo "<div class='col-12'>";
            foreach ($cards["R"] as $ra) {
              echo $ra . ',';
            }
            echo "</div>";
            ?>
          </div>
        </div>
      </div>
    </div>
    <?php require_once("boot_modal.php"); ?>
</body>

</html>