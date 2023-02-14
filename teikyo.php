<?php
session_start();

if (!isset($_SESSION["loggedin"])) {
    header('Location:login.php');
}
require_once "db_connect.php";
require_once('checked.php');
$myURL = 'add_db.php';
$gobackURL = 'index.php';
$gacha_id = $_GET["id"];
$sql = "SELECT * FROM gacha WHERE id=" . $gacha_id;
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $gacha_name = $row["name"];
    $pu_pro = $row["probability"];
}
$ssr = 690 - $pu_pro;
$raritys = [
    'UR' => 10,
    //0.1%
    'PU' => $pu_pro,
    'SSR' => $ssr,
    //6.9%
    'SR' => 2300,
    //23%
    'R' => 7000, //70%
];
$sr_raritys = [
    'UR' => 10,
    //0.1%
    'PU' => $pu_pro,
    'SSR' => $ssr,
    //6.9%
    'SR' => 9300, //93%
];
$sql = "SELECT char_data.rarity as rarity,char_data.name as name,gacha_list.PU as PU FROM char_data,gacha_list WHERE char_data.id = gacha_list.chara_id && gacha_list.gacha_id = " . $gacha_id;
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    if ($row["rarity"] == "UR") {
        $cards['UR'][] = $row["name"];
    } else if ($row["rarity"] == "SSR") {
        if ($row["PU"] == 1) {
            $cards['PU'][] = $row["name"];
        } else {
            $cards['SSR'][] = $row["name"];
        }
    } else if ($row["rarity"] == "SR") {
        $cards['SR'][] = $row["name"];
    } else {
        $cards['R'][] = $row["name"];
    }
}
$user_id = $_SESSION["id"];
?>
<!DOCTYPE html>
<html lang="ja">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>貸し借りサイト　Lab:G | 提供割合確率</title>

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
    <script type="text/javascript">
        function CloseWindow() {
            window.close();
        }
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
                        <h1 class="h3 mb-0 text-gray-800">
                            <?php echo $gacha_name . "の提供割合"; ?>
                        </h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <div>
                            <?php
                            echo "<div class='col-12'>UR:0.1%</div>";
                            echo "<div class='col-12'>";
                            foreach ($cards["UR"] as $ur) {
                                echo $ur . ',';
                            }
                            echo "</div><hr>";
                            echo "<div class='col-12'>SSR:6.9%</div>";
                            echo "<div class='col-12'>";
                            if (isset($cards["PU"])) {
                                foreach ($cards["PU"] as $ssr) {
                                    echo 'ピックアップ!:' . $ssr . '確率:' . ($pu_pro / 100) . '%<br>';
                                }
                            }
                            foreach ($cards["SSR"] as $ssr) {
                                echo $ssr . ',';
                            }
                            echo "</div><hr>";
                            echo "<div class='col-12'>SR:23%※10連時10個目93%</div>";
                            echo "<div class='col-12'>";
                            foreach ($cards["SR"] as $sr) {
                                echo $sr . ',';
                            }
                            echo "</div><hr>";
                            echo "<div class='col-12'>R:70%</div>";
                            echo "<div class='col-12'>";
                            foreach ($cards["R"] as $ra) {
                                echo $ra . ',';
                            }
                            echo "</div><hr>";
                            echo "<a class='btn btn-primary' href='gacha.php?id=" . $gacha_id . "'>ガチャる</a>";
                            echo "<a class='btn btn-primary' href='gacha.php?id=" . $gacha_id . "&custom=1'>10連</a><br>";
                            $sql = "SELECT * FROM gacha WHERE id=" . $gacha_id;
                            $stm = $pdo->prepare($sql);
                            $stm->execute();
                            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                echo "開催期間:" . $row["start_time"] . "～" . $row["end_time"] . "<br><hr>";
                            }
                            echo "<a onclick='CloseWindow();' class='btn btn-primary'>戻る</a>";
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