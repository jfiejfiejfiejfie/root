<?php
session_start();
require_once "db_connect.php";

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
                        <h1 class="h3 mb-0 text-gray-800">ガチャ一覧</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php
                            date_default_timezone_set('Asia/Tokyo');
                            $today = date("Y-m-d");
                            $sql = "SELECT gacha.probability as pro,gacha.name as gacha_name,char_data.id as PU_id,gacha.id as gacha_id,gacha.start_time as ST,gacha.end_time as ET FROM gacha,char_data WHERE gacha.PU_chara_id = char_data.id && gacha.checked=1";
                            $stm = $pdo->prepare($sql);
                            $stm->execute();
                            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                if (($row["ST"] <= $today) && ($row["ET"] >= $today)) {
                                    echo $row["gacha_name"] . ":ピックアップ確率:" . ($row["pro"] / 100) . "%!!<br>";
                                    echo "<img src='chara_image.php?id=" . $row["PU_id"] . "' height='150' width='150'><br>";
                                    echo "<a class='btn btn-primary' href='gacha.php?id=" . $row["gacha_id"] . "'>ガチャる</a>";
                                    echo "<a class='btn btn-primary' href='gacha.php?id=" . $row["gacha_id"] . "&custom=1'>10連</a><br>";
                                    echo "開催期間:".$row["ST"]."～".$row["ET"]."<br><hr>";
                                }
                            }
                            echo "ノーマルガチャ";
                            echo "<a class='btn btn-primary' href='gacha.php'>ガチャる</a>";
                            echo "<a class='btn btn-primary' href='gacha.php?custom=1'>10連</a>";
                            ?>
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