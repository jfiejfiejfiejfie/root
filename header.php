<div id="header">
<<<<<<< HEAD
    <div class="game_bar" style="background-image: url(images/main_visual.jpg);">
        <div class="game_title">
            <a href="index.php"><img src="" class="mr5" /></a>
            <a href="index.php">貸し借りサイト</a>
            <div id="menu_s">
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                    $main_id=$_SESSION["id"];
                    $sql = "SELECT * FROM users WHERE id=$main_id";
                    $stm = $pdo->prepare($sql);
                    $stm->execute();
                    $my_result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($my_result as $my_row) {
                        echo "<div style='color:white;'>".$my_row['name']."でログインしています。</div>";
                    }
                    
                }?>
                <div>
                    <div><a href="index.php"><img src="images/home.png" style="width:70px" /><span>HOME　　　</span></a>
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> root/master
    <div class="game_bar" style="background-image: url(images/main_visual.jpg);">
        <div class="game_title">
            <a href="all.php"><img src="" class="mr5" /></a>
            <a href="all.php">貸し借りサイト</a>
            <div id="menu_s">
                <div>
                    <div><a href="all.php"><img src="images/home.png" style="width:70px" /><span>HOME　　　</span></a>
>>>>>>> root/master
                    </div>
                    <div><a href="add_db.php"><img src="images/register.png"
                                style="width:70px" /><span>商品登録　　</span></span></a></div>
                    <div><a href="search_sp.php"><img src="images/search.png"
                                style="width:70px" /><span>検索　　　　</span></span></a></div>
<<<<<<< HEAD
                    <div><a href="user_chat_list.php"><img src="https://cdn08.net/dqwalk/data/img0/img2_5.png?6e1"
                                style="width:70px" /><span>チャット　　</span></a></div>
=======
                    <div><a href="list.php"><img src="https://cdn08.net/dqwalk/data/img0/img2_5.png?6e1"
                                style="width:70px" /><span>一覧　　　　</span></a></div>
>>>>>>> root/master
                    <div><a href="mypage.php"><img src="https://cdn08.net/dqwalk/data/img0/img93_5.png?87b"
                                style="width:70px" /><span>マイページ　</span></span></a></div>
                    <div><a href="contact.php"><img src="images/contact.png"
                                style="width:70px" /><span>お問い合わせ</span></a></div>
                </div>
            </div>
            <?php
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
<<<<<<< HEAD
            <a href="javascript:if(confirm('ログアウトしますか？')) location.href='logout.php';" style="width:100px;"><img
                    height="50" src="my_image.php?id=<?php echo $_SESSION['id']; ?>"
=======
            <a href="javascript:if(confirm('ログアウトしますか？')) location.href='logout.php';" style="width:30px;"><img
                    height="30" width="30" src="my_image.php?id=<?php echo $_SESSION['id']; ?>"
>>>>>>> root/master
                    style="border-radius: 50%" /></a>
            <?php } else { ?>
            <a href="javascript:location.href='login.php';" style="width:30px;" class="open_login_menu pl5 pr5"><img
                    src="https://cdn08.net/pokemongo/wiki/login.png" alt="ログイン"></a>
            <?php }
    ?>
        </div>
<<<<<<< HEAD
    </div>
=======
<<<<<<< HEAD
    </div>
=======
    </div>
=======
<div class="game_bar" style="background-image: url(images/main_visual.jpg);">
<div class="game_title">
<a href="all.php"></a>
<a  href="all.php">貸し借りサイト</a>
<div id="menu_s">
<div>
<div><a href="all.php"><img src="images/home.png"  style="width:70px" /><span>HOME　　　</span></a></div>
<div><a href="add_db.php"><img src="images/register.png"  style="width:70px" /><span>商品登録　　</span></span></a></div>
<div><a href="search_sp.php"><img src="images/search.png"  style="width:70px" /><span>検索　　　　</span></span></a></div>
<div><a href="list.php"><img src="https://cdn08.net/dqwalk/data/img0/img2_5.png?6e1"  style="width:70px" /><span>一覧　　　　</span></a></div>
<div><a href="mypage.php"><img src="https://cdn08.net/dqwalk/data/img0/img93_5.png?87b"  style="width:70px" /><span>マイページ　</span></span></a></div>
<div><a href="contact.php"><img src="images/contact.png"  style="width:70px" /><span>お問い合わせ</span></a></div>
</div>
</div>
    <?php
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true){
    echo '<a href="javascript:if(confirm(',"ログアウトしますか？",')) location.href=',"logout.php",';" style="width:30px;"><img height="30" width="30" src="my_image.php?id=',$_SESSION["id"],'" style="border-radius: 50%"/></a>';
    }else{
    echo '<a href="javascript:location.href=',"login.php",';" style="width:30px;" class="open_login_menu pl5 pr5"><img src="https://cdn08.net/pokemongo/wiki/login.png" alt="ログイン"></a>';
    }
    ?>
</div></div>
>>>>>>> root/master
>>>>>>> root/master
>>>>>>> root/master
