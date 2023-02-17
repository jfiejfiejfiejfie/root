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
if (isset($_GET["id"])) {
    $box_id = $_GET["id"];
} else if (isset($_GET["result"])) {
    $chara_id = $_GET["card_id"];
} else {
    header('Location:404.php');
}
if (isset($_GET["delete"])) {
    $point = 1;
    $sql = "SELECT char_data.rarity as RA,char_data.id as chara_id FROM char_data,box WHERE box.id = " . $box_id . " && box.char_data_id=char_data.id && box.user_id=" . $_SESSION["id"];
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($row["RA"] == "SSR") {
            $point = 200;
        } else if ($row["RA"] == "SR") {
            $point = 70;
        } else if ($row["RA"] == "UR") {
            $point = 1000;
        }
        $chara_id = $row["chara_id"];
    }
    $sql = "DELETE FROM box WHERE id=" . $_GET["id"];
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $sql = "UPDATE users SET point = point + :point where id = " . $_SESSION["id"];
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':point', $point, PDO::PARAM_STR);
    $stm->execute();
    header('Location:chara_detail.php?result=1&card_id=' . $chara_id);
} else if (isset($_GET["result"])) {
    $sql = "SELECT * FROM char_data WHERE id=" . $chara_id;
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($row["rarity"] == "SSR") {
            $point = 200;
        } else if ($row["rarity"] == "SR") {
            $point = 70;
        } else if ($row["rarity"] == "UR") {
            $point = 1000;
        } else {
            $point = 1;
        }
        $chara_name = $row["name"];
    }
} else if (isset($_GET["lock"])) {
    if ($_GET["lock"] == 1) {
        $sql = "UPDATE box SET lock_check=1 where id = " . $_GET["id"];
        $stm = $pdo->prepare($sql);
        $stm->execute();
    } else {
        $sql = "UPDATE box SET lock_check=0 where id = " . $_GET["id"];
        $stm = $pdo->prepare($sql);
        $stm->execute();
    }
    header('Location:chara_detail?id=' . $_GET["id"]);
} else {
    $level = 0;
    $sql = "SELECT box.lock_check as lc,char_data.name as chara_name,box.level as chara_level,char_data.id as chara_id,char_data.rarity as RA FROM char_data,box WHERE box.id = " . $box_id . " && box.char_data_id=char_data.id && box.user_id=" . $_SESSION["id"];
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $lc = $row["lc"];
        $chara_id = $row["chara_id"];
        $chara_name = $row["chara_name"];
        $level = $row["chara_level"];
        $RA = $row["RA"];
    }
    if ($level == 0) {
        header('Location:404.php');
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
        <?php
        if (isset($_GET["result"])) {
            echo $chara_name . "売却";
        } else {
            echo $chara_name . "の詳細";
        }
        ?>
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
                        <h1 class="h3 mb-0 text-gray-800">
                            <?php echo $chara_name; ?>
                        </h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php
                            if (isset($_GET["result"])) {
                                echo "<img src='chara_image.php?id=" . $_GET["card_id"] . "' height='232' width='232'>";
                                echo '<div class="col-12"></div>';
                                echo $chara_name . "を売却して、" . $point . "ポイントを入手しました。";
                                echo '<div class="col-12"></div>';
                            } else if (!isset($_GET["delete"])) {
                                echo "<img src='chara_image.php?id=" . $chara_id . "' height='232' width='232'>";
                                echo '<div class="col-12"></div>';
                                echo "レアリティ:" . $RA;
                                echo '<div class="col-12"></div>';
                                echo "現在のレベル:" . $level;
                                echo '<div class="col-12"></div>';
                                if ($lc == 0) {
                                    echo "<a class='btn btn-primary' href='chara_detail?id=" . $box_id . "&lock=1'><i class='fa fa-lock' aria-hidden='true'></i>ロックする</a>";
                                } else {
                                    echo "<a class='btn btn-danger' href='chara_detail?id=" . $box_id . "&lock=0'><i class='fa fa-unlock' aria-hidden='true'></i>ロックを解除する</a>";
                                }
                                echo '<div class="col-12"></div>';
                                echo "<a class='btn btn-primary' href=''>限界突破(未実装)</a>";
                                echo '<div class="col-12"></div>';
                                if ($lc == 0) {
                                    echo "<a class='btn btn-danger' href='chara_detail.php?id=" . $box_id . "&delete=1'>売却</a>";
                                }                                
                                echo '<div class="col-12"></div>';
                            }
                            ?>
                            <a class="btn btn-primary" href="box.php">戻る</a>
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