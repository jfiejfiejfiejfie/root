<?php
session_start();
require_once('db_connect.php');
require_once('user_check.php');
$myURL = 'admin.php';
if ($row["admin"] == 0) {
    header('Location:index.php');
}
?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|HOME</title>
<link rel="stylesheet" href="css/top.css">
</head>

<body>
    <audio id="audio"></audio>
    <div id="fb-root"></div>


    <!--ヘッダー-->
    <?php require_once("header.php"); ?>

    <div id="wrapper">
        <!--メイン-->
        <div id="main">
            <?php
        echo "<h1>消す</h1>";
        $sql = "SELECT * FROM list";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            echo "<table>";
            echo "<tr>";
            echo $row["id"];
            echo $row["item"];
            echo "<a href='mydelete.php?id=" . $row['id'] . "'>消す</a>";
            echo "</tr>";
            echo "</table>";
        }
        echo "<h1>ユーザを編集する</h1>";
        $sql = "SELECT * FROM users";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            echo "<table>";
            echo "<tr>";
            echo $row["id"];
            echo $row["name"];
            echo "<a href='admin_edit.php?id=" . $row['id'] . "'>編集する</a>";
            echo "</tr>";
            echo "</table>";
        }
        echo '<h1>ユーザを永久追放する</h1>';
        $filename = "report.txt";
        $data = array();
        if (is_readable($filename) === TRUE) {
            if (($fp = fopen($filename, 'r')) !== FALSE) {
                while (($tmp = fgets($fp)) !== FALSE) {
                    $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');
                }
                fclose($fp);
            }
        } else {
            $data[] = 'ファイルがありません';
        }
        foreach($data as $line){
            echo $line.'<a href="report.php?IP='.$line.'">永久追放する</a><br>';
        }
        ?>
        </div>
        <!-- /sec-faq -->
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