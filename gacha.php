<?php
session_start();
require_once "db_connect.php";
// $cards['SSR'] = ['大坂A', '大坂GOD',];
// $cards['SR'] = ['聡一郎', '聡次郎', '聡三郎', '聡五郎',];
// $cards['R'] = ['Oさん', 'ラッキー・聡', 'オオサカ', 'O-SAKA-088'];
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
$sql = "SELECT * FROM char_data";
$stm = $pdo->prepare($sql);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    if ($row["rarity"] == "UR") {
        // array_push($cards['SSR'], $row["name"]);
        $cards['UR'][] = $row["name"];
    }
    else if ($row["rarity"] == "SSR") {
        // array_push($cards['SSR'], $row["name"]);
        $cards['SSR'][] = $row["name"];
    } else if ($row["rarity"] == "SR") {
        // array_push($cards['SR'], $row["name"]);
        $cards['SR'][] = $row["name"];
    } else {
        // array_push($cards['R'], $row["name"]);
        $cards['R'][] = $row["name"];
    }
}
$user_id = $_SESSION["id"];
// array_push($cards['SSR'], $ssr);
// array_push($cards['SR'], $sr);
// array_push($cards['R'], $ra);
function post_request($url, $param)
{
    //リクエスト時のオプション指定
    $options = array(
        'http' => array(
            'method' => 'POST',
            //ここでPOSTを指定
            'header' => array(
                'Content-type: application/x-www-form-urlencoded',
                'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:13.0) Gecko/20100101 Firefox/13.0.1'
            ),
            'content' => http_build_query($param),
            'ignore_errors' => true,
            'protocol_version' => '1.1'
        ),
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false
        )
    );

    //リクエスト実行
    $contents = @file_get_contents($url, false, stream_context_create($options));

    //ステータスコード抜粋
    preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header[0], $matches);
    $statusCode = (int) $matches[1];

    //配列で返すためにjsonのエンコード
    $contents_array = array();
    if ($statusCode === 200) {
        $contents_array = json_decode($contents);
    }
    return $contents_array;
}
if (!isset($_SESSION["loggedin"])) {
    header('Location:login.php');
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
            }
            for ($i = 0; $i < 9; $i++) {
                // require_once("10ren.php");
                $rand = mt_rand(0, 10000);
                $probability = 0;
                foreach ($raritys as $rarity => $rarity_probability) {
                    $probability += $rarity_probability;
                    if ($rand <= $probability) { // 排出レアリティ確定
                        $r[] = $rarity;
                        $card_id = array_rand($cards[$rarity], 1); // 排出レアリティ内からランダムに1枚取得
                        $card_result[] = $card_id;
                        $sql = "SELECT * FROM char_data";
                        $stm = $pdo->prepare($sql);
                        $stm->execute();
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            if (($row["rarity"] == $rarity) && ($row["name"] == $cards[$rarity][$card_id])) {
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
                    $r[] = $rarity;
                    $card_id = array_rand($cards[$rarity], 1); // 排出レアリティ内からランダムに1枚取得
                    $card_result[] = $card_id;
                    $sql = "SELECT * FROM char_data";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        if (($row["rarity"] == $rarity) && ($row["name"] == $cards[$rarity][$card_id])) {
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
            // 結果表示
            // $count = 0;
            // foreach ($card_result as $v) {
            //     echo $cards[$r[$count]][$v] . "<br>";
            //     $count += 1;
            // }
            // echo var_dump( $result );
        } else { //単発
            $rand = mt_rand(0, 10000); // 乱数生成
            $probability = 0;
            foreach ($raritys as $rarity => $rarity_probability) {
                $probability += $rarity_probability;
                if ($rand <= $probability) { // 排出レアリティ確定
                    $gacha_result = array_rand($cards[$rarity], 1); // 排出レアリティ内からランダムに1枚取得
                    $sql = "SELECT * FROM char_data";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        if (($row["rarity"] == $rarity) && ($row["name"] == $cards[$rarity][$gacha_result])) {
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
            header("Location:gacha.php?result=" . $gacha_result . "&r=" . $rarity);
        }

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
                        if (isset($_GET["custom"])) {
                            $count = 0;
                            foreach ($card_result as $v) {
                                $sql = "SELECT * FROM char_data";
                                $stm = $pdo->prepare($sql);
                                $stm->execute();
                                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    if ($cards[$r[$count]][$v] == $row["name"]) {
                                        $chara_id = $row["id"];
                                    }
                                }
                                // echo $r[$count] . ':' . $cards[$r[$count]][$v] . "をGET!";
                                // echo $cards[$r[$count]][$v] . "<br>";
                                if ($count == 0 || $count == 5) {
                                    echo "<div class='col-12'>";
                                }
                                echo "<img src='chara_image.php?id=$chara_id' height='150' width='150'>";
                                if ($count == 4 || $count == 9) {
                                    echo "</div>";
                                }
                                $count += 1;
                            }
                            $count = 0;
                            foreach ($card_result as $v) {
                                echo $r[$count] . ':' . $cards[$r[$count]][$v] . "をGET!<br>";
                                $count += 1;
                            }
                            echo "<a class='btn btn-success col-12' data-toggle='modal' data-target='#kakuritu'>提供割合</a>";
                            echo "<a href='gacha.php?custom=1' class='btn btn-primary col-12'>もう一回10連ガチャる</a>";
                            if ($point >= 100) {
                                echo "<br><div class='col-12'>あと" . floor($point / 100) . "回引けます</div>";
                            }
                        } else {
                            echo "<div class='col-12'>" . $_GET["r"] . ':' . $cards[$_GET["r"]][$_GET["result"]] . "をGET!</div>";
                            $sql = "SELECT * FROM char_data";
                            $stm = $pdo->prepare($sql);
                            $stm->execute();
                            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                if (($row["rarity"] == $_GET["r"]) && ($row["name"] == $cards[$_GET["r"]][$_GET["result"]])) {
                                    $chara_id = $row["id"];
                                }
                            }
                            echo "<img src='chara_image.php?id=$chara_id' height='150' width='150'>";
                            echo "<div class='col-12'>所持ポイント:" . $point . "p</div>";
                            echo "<a class='btn btn-success col-12' data-toggle='modal' data-target='#kakuritu'>提供割合</a>";
                            echo "<a href='gacha.php' class='btn btn-primary col-12'>もう一回ガチャる</a>";
                            if ($point >= 10) {
                                echo "<br><div class='col-12'>あと" . floor($point / 10) . "回引けます</div>";
                            }
                        }
                        // $count = 0;
                        // foreach($cards["SSR"] as $ca){
                        //     $ca[$count];
                        //     $count += 1;
                        // }
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