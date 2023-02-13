<?php
session_start();

if (!isset($_SESSION["loggedin"])) {
    header('Location:login.php');
}
require_once "db_connect.php";
require_once('checked.php');
require_once "db_connect.php";
$bonus['1'] = ['10'];
$bonus['2'] = ['5'];
$bonus['3'] = ['15'];
$bonus['4'] = ['5'];
$bonus['5'] = ['30'];
$bonus['6'] = ['5'];
$bonus['0'] = ['100'];
$myURL = 'add_db.php';
$gobackURL = 'index.php';
$point = 0;
$flag = 0;
date_default_timezone_set('Asia/Tokyo');
$today = date("Y-m-d");
$sql = "SELECT * FROM login where user_id=" . $_SESSION["id"];
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    if ($row["time"] === $today) {
        $flag = 1;
    }
    $login_count = $row["count"];
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
                        <h1 class="h3 mb-0 text-gray-800">ログインボーナス</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <a class="dropdown-item" data-toggle="modal" data-target="#login_bonus">
                            <i class="fas fa-star fa-sm fa-fw mr-2 text-gray-400"></i>
                            ログインボーナス一覧
                        </a>
                        <?php

                        if ($flag == 0) {
                            echo $today;
                            echo 'のログインボーナスを受け取りました。';
                            if (!isset($login_count)) {
                                $sql = "INSERT INTO login (user_id,time,count) VALUES(:user_id,:time,:count)";
                                $stm = $pdo->prepare($sql);
                                $stm->bindValue(':user_id', $_SESSION["id"], PDO::PARAM_STR);
                                $stm->bindValue(':time', $today, PDO::PARAM_STR);
                                $stm->bindValue(':count', 1, PDO::PARAM_STR);
                                $stm->execute();
                                $sql = "UPDATE users set point = point+:add_point WHERE id=" . $_SESSION["id"];
                                $stm = $pdo->prepare($sql);
                                $stm->bindValue(':add_point', $bonus['1'][0], PDO::PARAM_STR);
                                $stm->execute();
                                $login_count = 1;
                                echo "<br>" . $bonus[$login_count][0] . "ポイントゲット!";
                                echo "<br>通算ログイン1日目";
                            } else {
                                $bonus_count = ($login_count+1) % 7;
                                $sql = "UPDATE login set time = :time,count=count+1 WHERE user_id=" . $_SESSION["id"];
                                $stm = $pdo->prepare($sql);
                                $stm->bindValue(':time', $today, PDO::PARAM_STR);
                                $stm->execute();
                                $sql = "UPDATE users set point = point+:add_point WHERE id=" . $_SESSION["id"];
                                $stm = $pdo->prepare($sql);
                                $stm->bindValue(':add_point', $bonus["$bonus_count"][0], PDO::PARAM_STR);
                                $stm->execute();
                                echo "<br>" . $bonus["$bonus_count"][0] . "ポイントゲット!";
                                $login_count += 1;
                                echo "<br>通算ログイン" . $login_count . "日目";
                            }
                        } else {
                            $bonus_flag = 1;
                            $bonus_count = $login_count % 7;
                            echo '本日のログインボーナスを既に受け取っています。';
                            echo "<br>通算ログイン" . $login_count . "日目";
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
                        <span>Copyright &copy; Lending and borrowing:GOD 2022-2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <div class="modal fade" id="login_bonus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">ログインボーナス一覧</div>
                <div class="modal-body">
                    <?php
                    if (!isset($bonus_flag)) {
                        if ($login_count == 1) {
                            $bonus_count = 1;
                        }
                    }
                    for ($i = 1; $i < 8; $i++) {
                        if ($bonus_count == $i) {
                            echo "<div class='col-12' style='color:red;'>" . $i . "日目:" . $bonus[$bonus_count][0] . "ポイント</div>";
                        } else {
                            if (($bonus_count == 0) && ($i == 7)) {
                                echo "<div class='col-12' style='color:red;'>" . $i . "日目:" . $bonus[$bonus_count][0] . "ポイント</div>";
                            } else {
                                if ($i != 7) {
                                    echo "<div class='col-12'>" . $i . "日目:" . $bonus[$i][0] . "ポイント</div>";
                                }else{
                                    echo "<div class='col-12'>" . $i . "日目:" . $bonus[0][0] . "ポイント</div>";
                                }
                            }
                        }

                    }
                    echo "以下同周期";
                    ?>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php require_once("boot_modal.php"); ?>

</body>

</html>