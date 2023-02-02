<?php
if (!isset($_SESSION["loggedin"])&& $myURL != "auth.php") {
    header('Location:login.php');
}
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sticky-top" id="accordionSidebar">

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
        <a class="nav-link" href="mypage.php">
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
            <span>HOME</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-user"></i>
            <span>Users Page</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="notice.php">通知一覧</a>
                <a class="collapse-item" href="buy_list.php">購入したもの</a>
                <a class="collapse-item" href="bought_list.php">購入されたもの</a>
                <a class="collapse-item" href="reservation_list.php">予約されたもの</a>
                <a class="collapse-item" href="good_list.php">いいね一覧</a>
                <a class="collapse-item" href="eturan.php">閲覧履歴</a>
                <a class="collapse-item" href="admin.php">管理者ページ</a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="search_sp.php">
            <i class="fas fa-fw fa-search"></i>
            <span>検索</span></a>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="user_chat_list.php">
            <i class="fas fa-fw fa-comment"></i>
            <span>チャット</span></a>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="chat_room.php">
            <i class="fas fa-fw fa-comments"></i>
            <span>チャットルーム</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="add_db.php">
            <i class="fas fa-fw fa-download"></i>
            <span>商品登録</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="map.php">
            <i class="fas fa-fw fa-map"></i>
            <span>マップ</span></a>
    </li> -->

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="keijiban.php">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>掲示板</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="contact.php">
            <i class="fas fa-fw fa-envelope"></i>
            <span>お問い合わせ</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <a href="../phpmyadmin" target="_blank"><img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg"
                alt="..."></a>
        <p class="text-center mb-2"><strong>課金</strong>しろks</p>
        <a class="btn btn-success btn-sm" href="charge.php">いますぐ課金だ!</a>
    </div>

</ul>