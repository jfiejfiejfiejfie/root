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
$point = 0;
if (isset($_GET["create"])) {
    $sql = "UPDATE gacha SET checked=1 where id = " . $_GET["id"];
    $stm = $pdo->prepare($sql);
    $stm->execute();
    header('Location:gacha_create_2.php');
}
if (isset($_GET["add"])) {
    $flag = 0;
    $chara_id = $_POST["chara_id"];
    $gacha_id = $_POST["gacha_id"];
    $sql = "SELECT * FROM gacha WHERE id=" . $gacha_id;
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($row["PU_chara_id"] == $chara_id) {
            $PU = 1;
        } else {
            $PU = 0;
        }
    }
    $sql = "SELECT * FROM gacha_list WHERE gacha_id=" . $gacha_id;
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        if ($row["chara_id"] == $chara_id) {
            $flag = 1;
        }
    }
    if ($flag == 0) {
        $sql = "INSERT INTO gacha_list (gacha_id,chara_id,PU) VALUES(:gacha_id,:chara_id,:PU)";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':gacha_id', $gacha_id, PDO::PARAM_STR);
        $stm->bindValue(':chara_id', $chara_id, PDO::PARAM_STR);
        $stm->bindValue(':PU', $PU, PDO::PARAM_STR);
        $stm->execute();
        header('Location:gacha_create_2.php?id=' . $gacha_id);
    }
    header('Location:gacha_create_2.php?id=' . $gacha_id);
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
                        <h1 class="h3 mb-0 text-gray-800">ガチャ登録-2</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <?php
                        if (!isset($_GET["id"])) {
                            echo "<div class='col-12'></div>内訳を決めるガチャを選択してください。<br>";
                            $sql = "SELECT * FROM gacha where checked=0";
                            $stm = $pdo->prepare($sql);
                            $stm->execute();
                            $state = $stm->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($state as $row) {
                                echo "<div class='col-12'></div>" . $row["name"] . "<a href='gacha_create_2.php?id=" . $row["id"] . "' class='btn btn-primary'>選択</a>";
                            }
                        } else {
                            ?>
                            <div class='col-12'>
                                <?php
                                $sql = "SELECT gacha.id,gacha.name as gacha_name,char_data.name as chara_name FROM gacha,char_data where gacha.id=" . $_GET["id"] . "&& gacha.PU_chara_id =char_data.id";
                                $stm = $pdo->prepare($sql);
                                $stm->execute();
                                $state = $stm->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($state as $row) {
                                    echo "<div class='col-12'></div>選択ガチャ:" . $row["gacha_name"];
                                    echo "<br><div class='col-12'></div>PUキャラ:" . $row["chara_name"];
                                }
                                $sql = "SELECT gacha_list.PU as pickup,char_data.id as chara_id,char_data.rarity as rarity,char_data.name as chara_name FROM gacha_list,char_data WHERE gacha_list.gacha_id=" . $_GET["id"] . "&& gacha_list.chara_id=char_data.id";
                                $stm = $pdo->prepare($sql);
                                $stm->execute();
                                $state = $stm->fetchAll(PDO::FETCH_ASSOC);
                                echo "実装されているキャラ<br>";
                                foreach ($state as $row) {
                                    echo $row["rarity"] . ':' . $row["chara_name"] . '<br>';
                                }
                                ?>
                                <form method="POST" action="gacha_create_2.php?add=1" enctype="multipart/form-data">
                                    キャラ選択:
                                    <select name="chara_id" class="form-control form-control-user">
                                        <?php
                                        $sql = "SELECT * FROM char_data";
                                        $stm = $pdo->prepare($sql);
                                        $stm->execute();
                                        $state = $stm->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($state as $row) {
                                            echo '<option value="', $row["id"], '">', $row["rarity"] . ":" . $row["name"], "</option>";
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" name="gacha_id" value="<?php echo $_GET["id"]; ?>">
                                    <br>
                                    <input type="submit" class="btn btn-primary btn-user" value="登録する">
                                </form>
                                <?php
                                $ssr_flag = 0;
                                $sql = "SELECT char_data.rarity as rarity,gacha_list.PU as PU FROM gacha_list,char_data WHERE char_data.id=gacha_list.chara_id && gacha_list.gacha_id=" . $_GET["id"];
                                $stm = $pdo->prepare($sql);
                                $stm->execute();
                                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    if ($row["rarity"] == 'UR') {
                                        $ur_flag = 1;
                                    } else if ($row["rarity"] == 'SSR') {
                                        $ssr_flag += 1;
                                        if ($row["PU"] == 1) {
                                            $PU_flag = 1;
                                        }
                                    } else if ($row["rarity"] == 'SR') {
                                        $sr_flag = 1;
                                    } else if ($row["rarity"] == 'R') {
                                        $r_flag = 1;
                                    }
                                }
                                if (isset($ur_flag) && ($ssr_flag > 1) && (isset($sr_flag)) && isset($r_flag) && isset($PU_flag)) {
                                    echo '<a href="gacha_create_2.php?id=' . $_GET["id"] . '&create=1" class="btn btn-success">ガチャを完成させる</a>';
                                }

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