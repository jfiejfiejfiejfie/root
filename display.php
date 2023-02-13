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
                        <h1 class="h3 mb-0 text-gray-800">出品一覧</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <?php
                        try {
                            $id = $_SESSION["id"];
                            $sql = "SELECT * FROM list WHERE user_id=$id and loan=0";
                            $stm = $pdo->prepare($sql);
                            $stm->execute();
                            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                            echo '<table class="table table-striped">';
                            echo '<thead><tr>';
                            echo '<th>', '掲載日', '</th>';
                            echo '<th>', '貸出物', '</th>';
                            echo '<th>', 'ジャンル', '</th>';
                            // echo '<th>', '金額', '</th>';
                            echo '<th>', '画像', '</th>';
                            echo '</tr></thead>';
                            echo '<tbody>';
                            foreach ($result as $row) {
                                echo '<tr>';
                                echo '<td>', $row['created_at'], '</td>';
                                echo '<td>', $row['item'], '</td>';
                                echo '<td>', $row['kind'], '</td>';
                                // echo '<td>￥', number_format($row['money']), '</td>';
                                echo "<td><a href=detail.php?id={$row["id"]}>", '<img height="200" width="200" src="image.php?id=', $row['id'], '"></a></td>';
                                echo '</tr>';
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