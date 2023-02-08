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
if (!isset($_GET["result"])) {
    $sql = "SELECT * FROM users WHERE id=" . $_SESSION["id"];
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $point = $row["point"];
    }
    if ($point >= 10) {
        $sql = "UPDATE users SET point=point-10 where id = " . $_SESSION["id"];
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $gacha_result = mt_rand(0, 4);
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
                            echo "大当たり。大坂聡一郎GODをプレゼント!";
                            echo "<img src='stamp/16.png'>";
                        }
                        if ($_GET["result"] == 1) {
                            echo "大当たり。大坂聡一郎の歯をプレゼント!";
                            echo "<img src='stamp/13.png'>";
                        }
                        if ($_GET["result"] == 2) {
                            echo "残念500円負けをプレゼント!";
                            echo "<img src='stamp/17.png'>";
                        }
                        if ($_GET["result"] == 3) {
                            echo "残念500円負けをプレゼント!";
                            echo "<img src='stamp/17.png'>";
                        }
                        if ($_GET["result"] == 4) {
                            echo "残念500円負けをプレゼント!";
                            echo "<img src='stamp/17.png'>";
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