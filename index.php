<?php
session_start();
require_once('../lib/util.php');
if (!isset($_SESSION["loggedin"])) {
    header('Location:login.php');
}
// if ("location:login.php")
//     ;
$myURL = './';
$option = '';
$gobackURL = './';
require_once "db_connect.php";
require_once('checked.php');
$block_count = 0;
$block = 0;
define('MAX', '12');
// require_once("block_check.php");
if (!isset($_SESSION["check"])) {
    $check = 0;
} else {
    $check = $_SESSION["check"];
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
                        <h1 class="h3 mb-0 text-gray-800">出品商品</h1>
                        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
                    </div>
                    <?php
                    $gURL = "";
                    $sURL = "";
                    $g = "?";
                    $s = "?";
                    if (isset($_GET["good"])) {
                        $gURL = "?good=1";
                        $g = "&";
                    }
                    if(isset($_GET["sold"])){
                        $sURL = "?sold=1";
                        $s = "&";
                    }
                    if (isset($_GET["good"])) {
                        echo "<a href='./".$sURL."' class='btn btn-danger'>元に戻す</a>";
                    } else {
                        echo "<a href='".$sURL.$s."good=1' class='btn btn-primary'>いいね降順</a>";
                    }
                    if (isset($_GET["sold"])) {
                        echo "<a href='./".$gURL."' class='btn btn-danger'>全部表示</a>";
                    } else {
                        echo "<a href='".$gURL.$g."sold=1' class='btn btn-primary'>売り切れ削除</a>";
                    }
                    echo "<a href='./' class='btn btn-danger'>リセット</a>";
                    ?>
                    <div class="row">
                        <?php
                        $block = 0;
                        require_once('block_check.php');
                        try {
                            $count = 0;
                            if ($block_count != 0) {
                                $block_list = implode(",", $block_list);
                                if (!isset($_GET["sold"])) {
                                    if (!isset($_GET["good"])) {
                                        $sql = "SELECT A.id as main_id,A.item,A.loan,A.money,A.created_at,A.user_id,COUNT(B.list_id) as likes_count 
                                FROM list as A
                                LEFT JOIN likes as B
                                ON A.id=B.list_id WHERE A.user_id not in ($block_list)
                                GROUP BY A.id,A.item,A.loan,A.money,A.created_at,A.user_id
                                ORDER BY A.created_at desc";
                                    } else {
                                        $sql = "SELECT A.id as main_id,A.item,A.loan,A.money,A.created_at,A.user_id,COUNT(B.list_id) as likes_count 
                                FROM list as A
                                LEFT JOIN likes as B
                                ON A.id=B.list_id WHERE A.user_id not in ($block_list)
                                GROUP BY A.id,A.item,A.loan,A.money,A.created_at,A.user_id
                                ORDER BY likes_count desc";
                                    }
                                } else {
                                    if (!isset($_GET["good"])) {
                                        $sql = "SELECT A.id as main_id,A.item,A.loan,A.money,A.created_at,A.user_id,COUNT(B.list_id) as likes_count 
                                FROM list as A
                                LEFT JOIN likes as B
                                ON A.id=B.list_id WHERE A.user_id not in ($block_list) && A.loan=0
                                GROUP BY A.id,A.item,A.loan,A.money,A.created_at,A.user_id
                                ORDER BY A.created_at desc";
                                    } else {
                                        $sql = "SELECT A.id as main_id,A.item,A.loan,A.money,A.created_at,A.user_id,COUNT(B.list_id) as likes_count 
                                FROM list as A
                                LEFT JOIN likes as B
                                ON A.id=B.list_id WHERE A.user_id not in ($block_list) && A.loan=0
                                GROUP BY A.id,A.item,A.loan,A.money,A.created_at,A.user_id
                                ORDER BY likes_count desc";
                                    }
                                }
                            } else {
                                if (!isset($_GET["sold"])) {
                                    if (!isset($_GET["good"])) {
                                        $sql = "SELECT A.id as main_id,A.item,A.loan,A.money,A.created_at,COUNT(B.list_id) as likes_count 
                                FROM list as A
                                LEFT JOIN likes as B
                                ON A.id=B.list_id
                                GROUP BY A.id,A.item,A.loan,A.money,A.created_at
                                 ORDER BY A.created_at desc";
                                    } else {
                                        $sql = "SELECT A.id as main_id,A.item,A.loan,A.money,A.created_at,COUNT(B.list_id) as likes_count 
                                FROM list as A
                                LEFT JOIN likes as B
                                ON A.id=B.list_id
                                GROUP BY A.id,A.item,A.loan,A.money,A.created_at
                                 ORDER BY likes_count desc";
                                    }
                                } else {
                                    if (!isset($_GET["good"])) {
                                        $sql = "SELECT A.id as main_id,A.item,A.loan,A.money,A.created_at,COUNT(B.list_id) as likes_count 
                                FROM list as A
                                LEFT JOIN likes as B
                                ON A.id=B.list_id WHERE A.loan=0
                                GROUP BY A.id,A.item,A.loan,A.money,A.created_at
                                 ORDER BY A.created_at desc";
                                    } else {
                                        $sql = "SELECT A.id as main_id,A.item,A.loan,A.money,A.created_at,COUNT(B.list_id) as likes_count 
                                FROM list as A
                                LEFT JOIN likes as B
                                ON A.id=B.list_id WHERE A.loan=0
                                GROUP BY A.id,A.item,A.loan,A.money,A.created_at
                                 ORDER BY likes_count desc";
                                    }
                                }
                            }
                            $stm = $pdo->prepare($sql);
                            $stm->execute();
                            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                            require_once("paging.php");
                            foreach ($disp_data as $row) {
                                $count += 1;
                                echo '<div class="col-xl-3 col-md-6 mb-4">';
                                if ($count % 3 == 2) {
                                    echo '<div class="card border-left-success shadow h-100 py-2">';
                                } else if ($count % 3 == 1) {
                                    echo '<div class="card border-left-primary shadow h-100 py-2">';
                                } else {
                                    echo '<div class="card border-left-danger shadow h-100 py-2">';
                                }
                                echo '<div class="card-body">';
                                echo '<div class="row no-gutters align-items-center">';
                                echo '<div class="container mt-3">';
                                // echo '<td class="border border-dark">';
                                echo '<div class="sample5"><a href=detail.php?', "id={$row["main_id"]}>";
                                echo '<img id="parent" src="image.php?id=', $row["main_id"], ' alt="" height="232" width="232"/>';
                                if ($row["loan"] == 1) {
                                    echo '<img id="child" src="images/sold.png" height="232" width="232"/>';
                                }
                                echo '<div class="mask">';
                                echo '</div></div></a></td></div>';
                                echo '商品名:', $row["item"];
                                echo '<br>金額:￥', number_format($row["money"]);
                                echo '<br>いいね:', $row["likes_count"];
                                echo '
                            </div>
                        </div>
                    </div>
                </div>';
                            }
                            while ($count % 12 != 0) {
                                $count += 1;
                                echo '<div class="col-xl-3 col-md-6 mb-4">';
                                if ($count % 3 == 2) {
                                    echo '<div class="card border-left-success shadow h-100 py-2">';
                                } else if ($count % 3 == 1) {
                                    echo '<div class="card border-left-primary shadow h-100 py-2">';
                                } else {
                                    echo '<div class="card border-left-danger shadow h-100 py-2">';
                                }
                                echo '<div class="card-body">';
                                echo '<div class="row no-gutters align-items-center">';
                                echo '<div class="container mt-3">';
                                echo '<div class="sample5"><a href="http://www.jp.square-enix.com/DFF/character/10/tidus.html">';
                                echo "<img id='parent' src='images/te.png' height='232' width='232'>";
                                echo '<img id="child" src="images/PR.png" height="232" width="232"/>';
                                echo '<div class="mask">';
                                echo '</div>';
                                echo '</a></div></div>';
                                echo '
                            </div>
                        </div>
                    </div>
                </div>';
                            }
                            // echo "</tr>";
                            // echo '</tbody>';
                            // echo '</table>';
                        } catch (Exception $e) {
                            echo 'エラーがありました。';
                            echo $e->getMessage();
                            exit();
                        }
                        require_once('paging2.php');
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">本当にログアウトするのですね？</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">ログアウトしますか？</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">しない</button>
                    <a class="btn btn-danger" href="logout.php">ログアウト</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>