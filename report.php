<?php
session_start();
require_once "db_connect.php";
$myURL = 'report.php';
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
?>
<?php
require_once('../lib/util.php');
$gobackURL = 'index.php';
?>

<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|通報</title>
</head>

<body>
    <audio id="audio"></audio>
    <div id="fb-root"></div>


    <!--ヘッダー-->
    <?php require_once("header.php"); ?>

    <div>
        <!-- 入力フォームを作る -->

        <div id="wrapper">
            <!--メイン-->
            <div id="main">
                <section id="point">
                    <br>
                    <?php
                    echo '<h2>';
                    if(isset($_GET["line"])){
                        echo $_GET["line"].'行目を削除しました。';
                    }
                    if(isset($_GET["id"])){
                        echo '通報しました・';
                    }
                    if(isset($_GET["IP"])){
                        $IP=$_GET["IP"];
                        echo $IP.'を永久追放しました。';
                    }
                    echo '</h2>';
                    ?>
                    <?php
                    if (isset($_GET["id"])) {
                        $sql = "SELECT * FROM message WHERE id=$id";
                        $stm = $pdo->prepare($sql);
                        $stm->execute();
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                            $text = '名前:'.$row["view_name"].' IPアドレス->'.$row["IP"] . "\n";
                        }
                        $a = fopen("report.txt", "a");
                        @fwrite($a, $text);
                        fclose($a);
                    }
                    if (isset($_GET["IP"])) {
                        $text = "deny from " . $_GET["IP"] . "\n";
                        $a = fopen(".htaccess", "a");
                        @fwrite($a, $text);
                        fclose($a);
                    }
                    if (isset($_GET["line"])) {
                        $line = $_GET["line"];
                        $myFile = file('.htaccess');
                        unset($myFile[$line]);
                        file_put_contents('.htaccess', $myFile);
                    }
                    if(isset($_GET["id"])){
                        $gobackURL="keijiban.php";
                    }else{
                        $gobackURL="admin.php";
                    }
                    echo '<p><a href="'.$gobackURL.'">戻る</a></p>';
                    ?>
            </div>
            <!--/メイン-->

            <!--サイド-->

            <?php
            require_once('side.php');
            ?>


            <!--/サイド-->
        </div>
        <!--/wrapper-->

        <!--フッター-->
        <footer>
            <div id="footer_nav">
                <ul>
                    <li class="current"><a href="index.php">HOME</a></li>
                    <li><a href="add_db.php">商品登録</a></li>
                    <li><a href="user_chat_list.php">一覧</a></li>
                    <li><a href="mypage.php">マイページ</a></li>
                    <li><a href="register.php">アカウント登録</a></li>
                    <li><a href="login.php">ログイン</a></li>
                </ul>
            </div>
            <small>&copy; 2015 Bloom.</small>
        </footer>
        <!--/フッター-->
</body>

</html>