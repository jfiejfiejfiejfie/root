<?php
session_start();
require_once('../lib/util.php');
if ("location:login.php")
    ;
$myURL = 'index2.php';
$option = '';
$gobackURL = 'index2.php';
require_once "db_connect.php";
$block_count = 0;
$block = 0;
define('MAX', '8');
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

    <title>貸し借りサイトだお</title>

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
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i><img height='65px' src='images/human.png'></i>
                </div>
                <div class="sidebar-brand-text mx-3">WACCA <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="./">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>メニュー</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                貸し借り情報
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>検索</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">いろいろあるよ:</h6>
                        <a class="collapse-item" href="buttons.html">名前</a>
                        <a class="collapse-item" href="cards.html">ジャンル</a>
                        <a class="collapse-item" href="buttons.html">金額</a>
                        <a class="collapse-item" href="cards.html">ユーザ</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.php">Login</a>
                        <a class="collapse-item" href="register.php">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>課金</strong>しろks</p>
                <a class="btn btn-success btn-sm" href="charge.php">いますぐ課金だ!</a>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="検索しなさい"
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    通知だよ
                                </h6>
                                <?php
                                    $follow_count=0;
                                    $sql = "SELECT * FROM followlist WHERE user_id=:id and checked=0 ORDER BY id DESC";
                                    $stm = $pdo->prepare($sql);
                                    $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
                                    $stm->execute();
                                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $follow_count+=1;
                                        $sql = "SELECT * FROM users WHERE id=".$row["my_id"];
                                        $stm = $pdo->prepare($sql);
                                        $stm->execute();
                                        $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result2 as $row2) {
                                            $name2=$row2["name"];
                                        }
                                    }
                                    if($follow_count>1){
                                        $follow_count-=1;
                                        $name=$name2."さん。他".$follow_count."人にフォローされました。";
                                    }else if($follow_count==1){
                                        $name=$name2."さんにフォローされました。";
                                    }else{
                                        $name='最近フォローされていません。';
                                    }
                                ?>
                                <a class="dropdown-item d-flex align-items-center" href="followerlist.php">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">フォローについて</div>
                                        <span class="font-weight-bold"><?php echo $name;?></span>
                                    </div>
                                </a>
                                <?php
                                    $buy_count=0;
                                    $sql = "SELECT * FROM list WHERE user_id=:id and loan=1 and checked=0";
                                    $stm = $pdo->prepare($sql);
                                    $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
                                    $stm->execute();
                                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                        $buy_count+=1;
                                        $name2=$row["item"];
                                    }
                                    if($follow_count>1){
                                        $follow_count-=1;
                                        $name=$name2."。他".$follow_count."件が購入されました。";
                                    }else if($follow_count==1){
                                        $name=$name2."が購入されました。";
                                    }else{
                                        $name='最近、購入されていません。';
                                    }
                                ?>
                                <a class="dropdown-item d-flex align-items-center" href="buy_list.php">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">購入されたものについて</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <?php
                                    $user_chat_count = 0;
                                    $sql = "SELECT * FROM user_chat WHERE others_id=:id and checked=0";
                                    $stm = $pdo->prepare($sql);
                                    $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
                                    $stm->execute();
                                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                    $user_chat_count += 1;
                                    }
                                ?>
                                <span class="badge badge-danger badge-counter"><?php echo $user_chat_count;?></span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    メッセージが来てますよ
                                </h6>
                                <?php
                                $chat_count = 0;
                                $user_id_list = [];
                                $id = $_SESSION["id"];
                                $sql = "SELECT * FROM user_chat WHERE others_id=$id or user_id=$id ORDER BY created_at DESC";
                                $stm = $pdo->prepare($sql);
                                $stm->execute();
                                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    if (($row["others_id"] == $id) && ($chat_count < 3)) {
                                        if (!in_array($row["user_id"], $user_id_list)) {
                                            $chat_count += 1;
                                            echo '<a class="dropdown-item d-flex align-items-center" href="user_chat.php?id=' . $row["user_id"] . '">';
                                            echo '<div class="dropdown-list-image mr-3">';
                                            echo '<img class="rounded-circle" src="my_image.php?id=' . $row["user_id"] . '" alt="...">';
                                            echo '<div class="status-indicator bg-success"></div>';
                                            echo '</div>';
                                            if ($row["checked"] == 0) {
                                                echo '<div class="font-weight-bold">';
                                            } else {
                                                echo '<div>';
                                            }
                                            echo '<div class="text-truncate">';
                                            $user_id_list[] = $row["user_id"];
                                            $user_id = $row["user_id"];
                                            $sql = "SELECT * FROM users WHERE id=$user_id";
                                            $stm = $pdo->prepare($sql);
                                            $stm->execute();
                                            $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result2 as $row2) {
                                                //整形したい文字列
                                                $text = $row["text"];
                                                $text = strip_tags($text);
                                                echo $text;
                                                if ($row["image"] != "") {
                                                    echo '<br>画像が添付されています。';
                                                }
                                                echo '</div>';
                                                echo '<div class="small text-gray-500">';
                                                echo $row2["name"] . ' ' . $row["created_at"] . '</div>';
                                                echo '</div>';
                                                echo '</a>';
                                            }
                                        }
                                    }
                                }
                                ?>
                                <!-- <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">ちょっとお願いがあるんだな～</div>
                                        <div class="small text-gray-500">Yuna's Guard Wakka · 58m</div>
                                    </div>
                                </a> -->
                                <a class="dropdown-item text-center small text-gray-500" href="user_chat_list.php">Read
                                    More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                $main_id = $_SESSION["id"];
                                $sql = "SELECT * FROM users WHERE id=$main_id";
                                $stm = $pdo->prepare($sql);
                                $stm->execute();
                                $my_result = $stm->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($my_result as $my_row) {
                                    echo $my_row['name'];
                                }
                                ?>
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <img class="img-profile rounded-circle"
                                    src="<?php echo 'my_image.php?id=' . $main_id; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="mypage.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    マイページ
                                </a>
                                <a class="dropdown-item" href="edit.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    編集
                                </a>
                                <a class="dropdown-item" href="eturan.php">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    閲覧履歴
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php" data-toggle="modal"
                                    data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    ログアウト
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">出品商品</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a>
                    </div>

                    <div class="row">
                        <?php
                        $block = 0;
                        require_once('block_check.php');
                        try {
                            $count = 0;
                            if ($block_count != 0) {
                                $block_list = implode(",", $block_list);
                                $sql = "SELECT * FROM list WHERE user_id not in ($block_list) ORDER BY created_at desc";
                            } else {
                                $sql = "SELECT * FROM list ORDER BY created_at desc";
                            }
                            $stm = $pdo->prepare($sql);
                            $stm->execute();
                            $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                            require_once("paging.php");
                            // echo '<table>';
                            // echo '<thead><tr>';
                            // echo '</tr></thead>';
                            // echo '<tbody>';
                            // echo '<tr>';
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
                                echo '<div class="sample5"><a href=detail.php?', "id={$row["id"]}>";
                                echo '<img id="parent" src="image.php?id=', $row["id"], ' alt="" height="232" width="232"/>';
                                if ($row["loan"] == 1) {
                                    echo '<img id="child" src="images/sold.png" height="232" width="232"/>';
                                }
                                echo '<div class="mask">';
                                echo '<div class="caption">', $row["item"], '</div>';
                                echo '<div class="bottom">  </div>';
                                echo '<div class="price"><p class="rainbow">￥', number_format($row["money"]), '</p></div>';
                                echo '</div></div></a></td></div>';
                                echo '
                            </div>
                        </div>
                    </div>
                </div>';
                            }
                            while ($count % 8 != 0) {
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
                                echo "  ";
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