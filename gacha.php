<?php
session_start();
require_once "db_connect.php";
if (!isset($_SESSION["loggedin"])) {
    header('Location:login.php');
}
if (isset($_GET["id"])) {
    $gacha_id = $_GET["id"];
} else {
    $gacha_id = 0;
}
if ($gacha_id == 0) {
    $raritys = [
        'UR' => 10,
        //0.1%
        'SSR' => 690,
        //6.9%
        'SR' => 2300,
        //23%
        'R' => 7000, //70%
    ];
    $sr_raritys = [
        'UR' => 10,
        //0.1%
        'SSR' => 690,
        //6.9%
        'SR' => 9300, //93%
    ];
    $gacha_name = "ノーマルガチャ";
    $sql = "SELECT * FROM char_data";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($row["rarity"] == "UR") {
            $cards['UR'][] = $row["name"];
        } else if ($row["rarity"] == "SSR") {
            $cards['SSR'][] = $row["name"];
        } else if ($row["rarity"] == "SR") {
            $cards['SR'][] = $row["name"];
        } else {
            $cards['R'][] = $row["name"];
        }
    }
    $user_id = $_SESSION["id"];
    $PU_id = 0;
} else {
    $sql = "SELECT * FROM gacha WHERE id=" . $gacha_id;
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $PU_id = $row["PU_chara_id"];
        $gacha_name = $row["name"];
        $pu_pro = $row["probability"];
        $s_time = $row["start_time"];
        $e_time = $row["end_time"];
    }
    date_default_timezone_set('Asia/Tokyo');
    $today = date("Y-m-d");
    if (($s_time >= $today) || ($e_time <= $today)) {
        header("Location:404.php");
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
}

require_once('checked.php');
require_once "db_connect.php";
$myURL = 'add_db.php';
$gobackURL = 'gacha.php';

$sql = "SELECT * FROM users WHERE id=" . $_SESSION["id"];
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $point = $row["point"];
}
if (!isset($_GET["result"])) {
    if ($point >= 10) {
        // $my_host = $_SERVER['HTTP_HOST'];
        // $url = 'http://' . $my_host . 'gacha.php';
        if (isset($_GET["custom"])) { //10連
            // $rand = mt_rand(0, 10000); // 乱数生成
            // 普通に9連
            if ($point < 100) {
                header('Location:404.php');
            } else {
                for ($i = 0; $i < 9; $i++) {
                    // require_once("10ren.php");
                    $rand = mt_rand(0, 10000);
                    $probability = 0;
                    foreach ($raritys as $rarity => $rarity_probability) {
                        $probability += $rarity_probability;
                        if ($rand <= $probability) { // 排出レアリティ確定
                            if ($rarity == "PU") {
                                $main_rarity = "SSR";
                            } else {
                                $main_rarity = $rarity;
                            }
                            $r[] = $rarity;
                            $card_id = array_rand($cards[$rarity], 1); // 排出レアリティ内からランダムに1枚取得
                            $card_result[] = $card_id;
                            $sql = "SELECT * FROM char_data";
                            $stm = $pdo->prepare($sql);
                            $stm->execute();
                            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                if (($row["rarity"] == $main_rarity) && ($row["name"] == $cards[$rarity][$card_id])) {
                                    $chara_id = $row["id"];
                                }
                            }
                            $sql = "INSERT INTO box (user_id,char_data_id,level) VALUES(:user_id,:chara_data,1)";
                            $stm = $pdo->prepare($sql);
                            $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
                            $stm->bindValue(':chara_data', $chara_id, PDO::PARAM_STR);
                            $stm->execute();
                            break 1;
                        }
                    }
                }

                // SR以上確定ガチャ
                $rand = mt_rand(0, 10000);
                $probability = 0;
                foreach ($sr_raritys as $rarity => $rarity_probability) {
                    $probability += $rarity_probability;
                    if ($rand <= $probability) { // 排出レアリティ確定
                        if ($rarity == "PU") {
                            $main_rarity = "SSR";
                        } else {
                            $main_rarity = $rarity;
                        }
                        $r[] = $rarity;
                        $card_id = array_rand($cards[$rarity], 1); // 排出レアリティ内からランダムに1枚取得
                        $card_result[] = $card_id;
                        $sql = "SELECT * FROM char_data";
                        $stm = $pdo->prepare($sql);
                        $stm->execute();
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            if (($row["rarity"] == $main_rarity) && ($row["name"] == $cards[$rarity][$card_id])) {
                                $chara_id = $row["id"];
                            }
                        }
                        $sql = "INSERT INTO box (user_id,char_data_id,level) VALUES(:user_id,:chara_data,1)";
                        $stm = $pdo->prepare($sql);
                        $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
                        $stm->bindValue(':chara_data', $chara_id, PDO::PARAM_STR);
                        $stm->execute();
                        break;
                    }
                }
                $sql = "UPDATE users SET point=point-100 WHERE id=:id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
                $stm->execute();
                if (isset($_GET["id"])) {
                    header("Location:gacha.php?result=1&custom=1&id=" . $_GET["id"]);
                } else {
                    header("Location:gacha.php?result=1&custom=1");
                }

            }
        } else { //単発
            $rand = mt_rand(0, 10000); // 乱数生成
            $probability = 0;
            foreach ($raritys as $rarity => $rarity_probability) {
                $probability += $rarity_probability;
                if ($rand <= $probability) { // 排出レアリティ確定
                    if ($rarity == "PU") {
                        $main_rarity = "SSR";
                    } else {
                        $main_rarity = $rarity;
                    }
                    $gacha_result = array_rand($cards[$rarity], 1); // 排出レアリティ内からランダムに1枚取得
                    $sql = "SELECT * FROM char_data";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        if (($row["rarity"] == $main_rarity) && ($row["name"] == $cards[$rarity][$gacha_result])) {
                            $chara_id = $row["id"];
                        }
                    }
                    $sql = "INSERT INTO box (user_id,char_data_id,level) VALUES(:id,:chara_data,1)";
                    $stm = $pdo->prepare($sql);
                    $stm->bindValue(':id', $user_id, PDO::PARAM_STR);
                    $stm->bindValue(':chara_data', $chara_id, PDO::PARAM_STR);
                    $stm->execute();
                    break;
                }
            }
            // $gacha_result = mt_rand(0, 100);
            // $contents_array = post_request($url, $param);
            $sql = "UPDATE users SET point=point-10 WHERE id=:id";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
            $stm->execute();
            if (isset($_GET["id"])) {
                header("Location:gacha.php?result=1&id=" . $_GET["id"]);
            } else {
                header("Location:gacha.php?result=1");
            }
        }

    } else {
        header("Location:404.php");
    }
} else {
    if (isset($_GET["custom"])) {
        $char[] = "";
        $Rare[] = "";
        $char_name[] = "";
        $sql = "SELECT char_data.id as ch_id,char_data.rarity as ch_ra,char_data.name as ch_name FROM box,char_data WHERE char_data.id = box.char_data_id && box.user_id=" . $_SESSION["id"] . " order by box.id desc LIMIT 10";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $char[] = $row["ch_id"];
            $char_name[] = $row["ch_name"];
            $Rare[] = $row["ch_ra"];
        }
    } else {
        $sql = "SELECT char_data.id as ch_id,char_data.rarity as ch_ra,char_data.name as ch_name FROM box,char_data WHERE char_data.id = box.char_data_id && box.user_id=" . $_SESSION["id"] . " order by box.id desc LIMIT 10";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $char = $row["ch_id"];
            $char_name = $row["ch_name"];
            $Rare = $row["ch_ra"];
        }
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

    <title>貸し借りサイト　Lab:G |
        <?php echo $gacha_name . "のガチャ結果"; ?>
    </title>

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
                        <!-- <div class='col-12'> -->
                        <?php
                        if (isset($_GET["custom"])) {
                            for ($count = 10; $count > 0; $count--) {
                                echo "<div class='col-2 border'>";
                                if ($Rare[$count] == "UR") {
                                    echo "<img src='chara_image.php?id=" . $char[$count] . "' height='150' width='150' class='border border-secondary border-4 rounded'><br>";
                                    echo "<div style='color:purple;'>" . $Rare[$count];
                                } else if ($Rare[$count] == "SSR") {
                                    if ($char[$count] == $PU_id) {
                                        echo "<img src='chara_image.php?id=" . $char[$count] . "' height='150' width='150' class='border border-danger border-4 rounded rainbow'><br>";
                                        echo "<div class='rainbow'>SSR";
                                    } else {
                                        echo "<img src='chara_image.php?id=" . $char[$count] . "' height='150' width='150' class='border border-danger border-4 rounded'><br>";
                                        echo "<div style='color:gold;'>" . $Rare[$count];
                                    }
                                } else if ($Rare[$count] == "SR") {
                                    echo "<img src='chara_image.php?id=" . $char[$count] . "' height='150' width='150' class='border border-primary border-4 rounded'><br>";
                                    echo "<div style='color:silver;'>" . $Rare[$count];
                                } else if ($Rare[$count] == "R") {
                                    echo "<img src='chara_image.php?id=" . $char[$count] . "' height='150' width='150' class='border border-dark border-4 rounded'><br>";
                                    echo "<div style='color:blue;'>" . $Rare[$count];
                                }
                                echo ':' . $char_name[$count] . "をGET!</div>";
                                echo "</div>";
                                if ($count == 6 || $count == 0) {
                                    echo "<div class='col-12'>";
                                    echo "</div>";
                                }
                            }

                            $text2 = "";
                            echo "<a class='btn btn-success col-12' data-toggle='modal' data-target='#kakuritu'>提供割合</a>";
                            if (isset($_GET["id"])) {
                                echo "<a href='gacha.php?id=" . $_GET["id"] . "' class='btn btn-primary col-6'>ガチャる</a>";
                            } else {
                                echo "<a href='gacha.php' class='btn btn-primary col-6'>ガチャる</a>";
                            }
                            if (isset($_GET["id"])) {
                                echo "<a href='gacha.php?id=" . $_GET["id"] . "&custom=1' class='btn btn-primary col-6'>もう一回10連を引く</a>";
                            } else {
                                echo "<a href='gacha.php?custom=1' class='btn btn-primary col-6'>もう一回10連を引く</a>";
                            }
                            if ($point >= 100) {
                                echo "<br><div class='col-12'>あと" . floor($point / 100) . "回引けます</div>";
                            }
                            echo '<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" data-text="10連ガチャを引きました。 #Temaki" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
                        } else {
                            echo "<div class='col-2 border'>";
                            if ($Rare == "UR") {
                                echo "<img src='chara_image.php?id=" . $char . "' height='150' width='150' class='border border-secondary border-4 rounded'><br>";
                                echo "<div style='color:purple;'>" . $Rare;
                            } else if ($Rare == "SSR") {
                                if ($char == $PU_id) {
                                    echo "<img src='chara_image.php?id=" . $char . "' height='150' width='150' class='border border-danger border-4 rounded rainbow'><br>";
                                    echo "<div class='rainbow'>SSR";
                                } else {
                                    echo "<img src='chara_image.php?id=" . $char . "' height='150' width='150' class='border border-danger border-4 rounded'><br>";
                                    echo "<div style='color:gold;'>" . $Rare;
                                }
                            } else if ($Rare == "SR") {
                                echo "<img src='chara_image.php?id=" . $char . "' height='150' width='150' class='border border-primary border-4 rounded'><br>";
                                echo "<div style='color:silver;'>" . $Rare;
                            } else if ($Rare == "R") {
                                echo "<img src='chara_image.php?id=" . $char . "' height='150' width='150' class='border border-dark border-4 rounded'><br>";
                                echo "<div style='color:blue;'>" . $Rare;
                            }
                            echo ':' . $char_name . "をGET!</div>";
                            echo "</div>";
                            echo "<div class='col-12'>所持ポイント:" . $point . "p</div>";
                            echo "<a class='btn btn-success col-12' data-toggle='modal' data-target='#kakuritu'>提供割合</a>";
                            if (isset($_GET["id"])) {
                                echo "<a href='gacha.php?id=" . $_GET["id"] . "' class='btn btn-primary col-6'>もう一回ガチャる</a>";
                            } else {
                                echo "<a href='gacha.php' class='btn btn-primary col-6'>もう一回ガチャる</a>";
                            }
                            if (isset($_GET["id"])) {
                                echo "<a href='gacha.php?id=" . $_GET["id"] . "&custom=1' class='btn btn-primary col-6'>10連を引く</a>";
                            } else {
                                echo "<a href='gacha.php?custom=1' class='btn btn-primary col-6'>10連を引く</a>";
                            }
                            if ($point >= 10) {
                                echo "<br><div class='col-12'>あと" . floor($point / 10) . "回引けます</div>";
                            }
                            echo '<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" data-text="ガチャを引きました。 #Temaki" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
                        }
                        ?>
                        <!-- </div> -->
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
                <div class="modal-body">
                    <?php
                    echo $gacha_name;
                    ?>
                </div>
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
                    if (isset($cards["PU"])) {
                        foreach ($cards["PU"] as $ssr) {
                            echo 'ピックアップ!:' . $ssr . '確率:' . ($pu_pro / 100) . '%<br>';
                        }
                    }
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