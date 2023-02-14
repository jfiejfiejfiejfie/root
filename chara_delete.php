<?php
session_start();

if (!isset($_SESSION["loggedin"])) {
    header('Location:login.php');
}
if (!isset($_SESSION["admin"])) {
    header('Location:404.php');
}
// if ("location:login.php")
//     ;
require_once "db_connect.php";
require_once('checked.php');
require_once "db_connect.php";
$myURL = 'add_db.php';
$gobackURL = 'index.php';
$message_text = "";
$point = 0;
if (isset($_GET["id"])) {
    $chara_id = $_GET["id"];
    $sql = "DELETE FROM char_data WHERE id=".$chara_id;
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $sql = "DELETE FROM box WHERE char_data_id=".$chara_id;
    $stm = $pdo->prepare($sql);
    $stm->execute();
    header('Location:chara_delete.php?suc='.$chara_id);
}
if(isset($_GET["suc"])){
    $message_text = "ID:".$_GET["suc"]."を削除しました。";
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

    <title>貸し借りサイト　Lab:G | キャラ削除</title>

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
                        <h1 class="h3 mb-0 text-gray-800">キャラ削除</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <?php
                        echo $message_text;
                        $sql = "SELECT * FROM char_data";
                        $stm = $pdo->prepare($sql);
                        $stm->execute();
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            echo "<div class='col-12'></div><img src='chara_image.php?id=" . $row["id"] . "' height='150' width='150'>"."<a href='chara_delete.php?id=" . $row["id"] . "' class='btn btn-danger'>消す</a>";
                            echo $row["rarity"].":".$row["name"];
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

    <?php require_once("boot_modal.php"); ?>

</body>

</html>