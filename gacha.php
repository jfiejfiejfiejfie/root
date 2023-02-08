<?php
session_start();

if (!isset($_SESSION["loggedin"])) {
    header('Location:login.php');
}
require_once "db_connect.php";
require_once('checked.php');
require_once "db_connect.php";
$myURL = 'add_db.php';
$gobackURL = 'index.php';
$sql = "SELECT * FROM users WHERE id=" . $_SESSION["id"];
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $point = $row["point"];
}
if (!isset($_GET["result"])) {
    if ($point >= 10) {
        $sql = "UPDATE users SET point=point-10 where id = " . $_SESSION["id"];
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $gacha_result = mt_rand(0, 100);
        header("Location:gacha.php?result=" . $gacha_result);
    } else {
        header("Location:404.php");
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
                        <h1 class="h3 mb-0 text-gray-800">ガチャ結果</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <?php
                        if ($_GET["result"] == 0) {
                            echo "<div class='col-12'>大当たり!!<br>大坂聡一郎GODをプレゼント!</div>";
                            echo "<img src='stamp/16.png' height='200' width='200'>";
                        } else if ($_GET["result"] <= 10) {
                            echo "<div class='col-12'>大当たり!<br>大坂聡一郎の歯をプレゼント!</div>";
                            echo "<img src='stamp/13.png' height='200' width='200'>";
                        } else {
                            echo "<div class='col-12'>残念!<br>500円負けをプレゼント!</div>";
                            echo "<img src='stamp/17.png' height='200' width='200'>";
                        }
                        echo "<div class='col-12'>所持ポイント:" . $point . "p</div>";
                        echo "<a class='btn btn-success col-12' data-toggle='modal' data-target='#kakuritu'>提供割合</a>";
                        echo "<a href='gacha.php' class='btn btn-primary col-12'>もう一回ガチャる</a>";
                        if ($point >= 10) {
                            echo "<br><div class='col-12'>あと" . floor($point / 10) . "回引けます</div>";
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
                <div class="modal-body">ピックアップガチャ:大坂聡一郎GOD</div>
                <div class="modal-footer">
                    <?php
                    echo "<div class='col-12'>大坂聡一郎:GOD:1%</div>";
                    echo "<div class='col-12'>大坂聡一郎の歯:10%</div>";
                    echo "<div class='col-12'>500円負けた:89%</div>";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once("boot_modal.php"); ?>
</body>

</html>