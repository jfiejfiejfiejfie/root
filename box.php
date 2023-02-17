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
if (isset($_POST["kind"])) {
    require_once('insert.php');
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

    <title>貸し借りサイト　Lab:G | MyBOX</title>

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
                        <h1 class="h3 mb-0 text-gray-800">ボックス</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <a href='box_delete' class="btn btn-danger">一括売却</a>
                        <div class="col-12"></div>
                        <?php if (!isset($_GET["custom"])) { ?>
                            <a href='box?custom=1' class="btn btn-danger">レアリティ昇順</a>
                        <?php } else { ?>
                            <a href='box' class="btn btn-success">レアリティ降順</a>
                        <?php } ?>
                        <div class='col-12'></div>
                        <?php
                        $sql = "SELECT count(*) as box_count FROM box,char_data where box.user_id=" . $_SESSION["id"] . " && box.char_data_id = char_data.id";
                        $stm = $pdo->prepare($sql);
                        $stm->execute();
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $box_count = $row["box_count"];
                        }
                        if (isset($_GET["custom"])) {
                            $sql = "SELECT box.user_id,box.char_data_id as char_data_id,char_data.name as name,char_data.rarity as RA,box.id as box_id FROM box,char_data where box.user_id=" . $_SESSION["id"] . " && box.char_data_id = char_data.id ORDER BY char_data.star ASC,char_data.id ASC";
                        } else {
                            $sql = "SELECT box.user_id,box.char_data_id as char_data_id,char_data.name as name,char_data.rarity as RA,box.id as box_id FROM box,char_data where box.user_id=" . $_SESSION["id"] . " && box.char_data_id = char_data.id ORDER BY char_data.star DESC,char_data.id ASC";
                        }
                        $stm = $pdo->prepare($sql);
                        $stm->execute();
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            echo '<div class="border col-2">';
                            echo $row["RA"] . ":" . $row["name"];
                            echo '<br><a href="chara_detail?id=' . $row["box_id"] . '">';
                            echo "<img src='chara_image.php?id=" . $row["char_data_id"] . "' height='232' width='232'></a>";
                            echo '</div>';
                        }
                        echo '<div class="col-12"></div>';
                        echo "ボックス容量:" . $box_count . "/300";
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
    <?php require_once("boot_modal.php"); ?>

</body>

</html>