<?php
if (!isset($_SESSION["loggedin"]) && $myURL != "auth.php") {
    header('Location:login');
}
?>

<head>
    <style>
        .wrap {
            display: grid;
            grid-template-columns: 3fr 1fr;
        }

        .main_content {
            background: #e0efff;
        }

        .side {
            background: #e0ffe0;
        }

        .side_content {
            position: sticky;
            top: 0px;
            background: #ffe0ff;
        }
    </style>
</head>
<div class="side" style="z-index:10000">
    <div class="side_content">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sticky-top" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="./">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="sidebar-brand-text mx-2">Lab:G</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="mypage">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <span>マイページ</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                貸し借り情報
            </div>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Addons
            </div> -->

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="./">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <span>ホーム</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-user"></i>
                    <span>ユーザー</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="login_bonus">ログインボーナス</a>
                        <a class="collapse-item" href="buy_list">レンタルしたもの</a>
                        <a class="collapse-item" href="bought_list">レンタルされたもの</a>
                        <a class="collapse-item" href="reservation_list">予約されたもの</a>
                        <a class="collapse-item" href="good_list">いいね一覧</a>
                        <a class="collapse-item" href="eturan">閲覧履歴</a>
                        <?php
                        if ($_SESSION["admin"] != 0) {
                            ?>
                            <a class="collapse-item" href="admin">管理者ページ</a>
                        <?php } ?>
                        <div class="collapse-divider"></div>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="add_db">
                    <i class="fas fa-fw fa-download"></i>
                    <span>レンタル品登録</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="search_sp">
                    <i class="fas fa-fw fa-search"></i>
                    <span>検索</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="ranking">
                    <i class="fa fa-road" aria-hidden="true"></i>
                    <span>ランキング</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2"
                    aria-expanded="true" aria-controls="collapsePages2">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                    <span>ガチャ</span></a>
                </a>
                <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="gacha_list"><i class="fa fa-globe" aria-hidden="true"></i>　ガチャ一覧</a>
                        <a class="collapse-item" href="chara_dictionary"><i class="fa fa-book" aria-hidden="true"></i>　図鑑</a>
                        <a class="collapse-item" href="box"><i class="fa fa-cube" aria-hidden="true"></i>　ボックス</a>
                        <div class="collapse-divider"></div>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="user_chat_list">
                    <i class="fas fa-fw fa-comment"></i>
                    <span>チャット</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="chat_room">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>チャットルーム</span></a>
            </li>



            <!-- Nav Item - Tables -->
            <!-- <li class="nav-item">
        <a class="nav-link" href="map.php">
            <i class="fas fa-fw fa-map"></i>
            <span>マップ</span></a>
    </li> -->

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="keijiban">
                    <i class="fas fa-fw fa-newspaper"></i>
                    <span>掲示板</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="contact">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>お問い合わせ</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
    </div>
</div>

</ul>