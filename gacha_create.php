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
if (isset($_POST["name"])) {
    $name = $_POST["name"];
    $chara_id = $_POST["PU_chara"];
    $start_time = $_POST["start"];
    $end_time = $_POST["end"];
    $probability = $_POST["probability"];
    if ($probability >= 100 && $probability <= 690) {
        $sql = "INSERT INTO gacha (name,PU_chara_id,start_time,end_time,probability) VALUES(:name,:chara_id,:start_time,:end_time,:probability)";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':name', $name, PDO::PARAM_STR);
        $stm->bindValue(':chara_id', $chara_id, PDO::PARAM_STR);
        $stm->bindValue(':start_time', $start_time, PDO::PARAM_STR);
        $stm->bindValue(':end_time', $end_time, PDO::PARAM_STR);
        $stm->bindValue(':probability', $probability, PDO::PARAM_STR);
        $stm->execute();
        header('Location:gacha_create.php');
    } else {
        header('Location:gacha_create.php');
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
                        <h1 class="h3 mb-0 text-gray-800">ガチャ登録</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>

                    <div class="row">
                        <form method="POST" action="gacha_create.php" enctype="multipart/form-data">
                            ガチャの名前
                            <input type="text" id="item_name" class="form-control form-control-user" name="name"
                                placeholder="必須(30文字まで)" required>
                            PUキャラ:
                            <select name="PU_chara" class="form-control form-control-user">
                                <?php
                                $sql = "SELECT * FROM char_data where rarity='SSR'";
                                $stm = $pdo->prepare($sql);
                                $stm->execute();
                                $state = $stm->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($state as $row) {
                                    echo '<option value="', $row["id"], '">', $row["name"], "</option>";
                                }
                                ?>
                            </select>
                            開催期間始まり:
                            <input type="date" name="start" required></input>
                            終わり:
                            <input type="date" name="end" required></input><br>
                            PU確率:1%~6.9%まで
                            <input type="number" class="form-control form-control-user" name="probability"
                                placeholder="入力は1%->100,6.9->690" required>
                            <br>
                            <input type="submit" class="btn btn-primary btn-user" value="登録する">
                        </form>
                        <div class="col-12"></div>
                        <a href="gacha_create_2.php" class="btn btn-primary col-3">ガチャ内訳登録</a>
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