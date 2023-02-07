<?php
session_start();

if (!isset($_SESSION["loggedin"])) {
    header('Location:login.php');
}
// if ("location:login.php")
//     ;
require_once "db_connect.php";
$myURL = 'ranking.php';
$gobackURL = 'index.php';
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
                        <h1 class="h3 mb-0 text-gray-800">ランキング</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <?php
                        try {
                            $id = $_SESSION["id"];
                            $count = 1;
                            $sql = "SELECT * FROM users WHERE evaluation > 0 ORDER BY evaluation DESC";
                            $stm = $pdo->prepare($sql);
                            $stm->execute();
                            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                            echo '<table class="table table-striped">';
                            echo '<thead><tr>';
                            echo '<th>', '順位', '</th>';
                            echo '<th>', 'ユーザ名', '</th>';
                            echo '<th>', '評価点数', '</th>';
                            echo '<th>', 'クラス', '</th>';
                            echo '</tr></thead>';
                            echo '<tbody>';
                            foreach ($result as $row) {
                                if ($id == $row["id"]) {
                                    echo '<tr style="background-color:skyblue;">';
                                } else {
                                    echo '<tr>';
                                }
                                echo '<td>', $count, '位</td>';
                                $score = $row["evaluation"];
                                if ($score >= 9500) {
                                    $rank = '<div class="rainbow">S+</div>';
                                } else if ($score >= 7700) {
                                    $rank = '<div style="color:gold">S</div>';
                                } else if ($score >= 5800) {
                                    $rank = '<div style="color:red">A</div>';
                                } else if ($score >= 3500) {
                                    $rank = '<div style="color:blue">B</div>';
                                } else if ($score >= 1300) {
                                    $rank = '<div style="color:green">C</div>';
                                } else {
                                    $rank = '<div style="color:black">D</div>';
                                }
                                // if ($id == $row["id"]) {
                                //     echo '<td style="color:red">', $row['name'], '</td>';
                                //     echo '<td style="color:red">', number_format($score), '点</td>';
                                // } else {
                                echo '<td>', $row['name'], '</td>';
                                echo '<td>', number_format($score), '点</td>';
                                // }
                                echo '<td>', $rank, '</td>';
                                echo '</tr>';
                                $count += 1;
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