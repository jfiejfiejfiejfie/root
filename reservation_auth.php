<?php
session_start();
$myURL='reservation_auth.php';
require_once "db_connect.php";
?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|マイページ</title>
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
            if (!isset($_GET["user_id"])) {
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                    $id = $_SESSION["id"];
                    $list_id = $_GET["id"];
                    $sql = "SELECT * FROM list WHERE id=:id";
                    $stm = $pdo->prepare($sql);
                    $stm->bindValue(':id', $list_id, PDO::PARAM_STR);
                    $stm->execute();
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        echo '<h2>' . $row["item"] . 'を予約している人</h2>';
                    }
                    // $list_list = [];
                    // $list_count = 0;
                    $sql = "SELECT * FROM list WHERE  id=:id";
                    $stm = $pdo->prepare($sql);
                    $stm->bindValue(':id', $list_id, PDO::PARAM_STR);
                    $stm->execute();
                    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                        $sql = "SELECT * FROM reservation_list WHERE  list_id =$list_id";
                        $stm = $pdo->prepare($sql);
                        $stm->execute();
                        $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result2 as $row2) {
                            echo '<table class="table table-striped">';
                            echo "<a href='profile.php?id={$row2['user_id']}'><img id='image' height='100' width='100'src='my_image.php?id={$row2['user_id']}'></a><br>";
                            $user_id = $row2["user_id"];
                            $sql = "SELECT * FROM users WHERE id=$user_id";
                            $stm = $pdo->prepare($sql);
                            $stm->execute();
                            $result3 = $stm->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result3 as $row3) {
                                echo $row3["name"], "<a href='reservation_auth.php?id=$list_id&user_id=$user_id' class='btn btn-primary'>認可する</a></td>";
                            }
                            echo "<hr>";
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                    }
                }
            } else {
                $data = $_SESSION["id"];
                $id = $_GET["id"];
                $user_id = $_GET["user_id"];
                $sql = "SELECT * FROM users WHERE id=$user_id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result2 as $row2) {
                    echo $row2["name"], 'を認可しました。';
                }
                $sql = "UPDATE reservation_list SET checked=1 where list_id = :id and user_id=:user_id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $id, PDO::PARAM_STR);
                $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
                $stm->execute();
                $sql = "SELECT * FROM list WHERE id=$id";
                $stm = $pdo->prepare($sql);
                $stm->execute();
                $result3 = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result3 as $row3) {
                    $item = $row3["item"];
                }
                $text = "あなたが予約した<a href='detail.php?id=" . $id . "'>" . $item . "</a>の認可はされました。
                    ※これは自動送信です。";
                date_default_timezone_set('Asia/Tokyo');
                $date = date('Y-m-d H:i:s');
                $sql = "INSERT INTO user_chat (user_id,created_at,text,others_id) VALUES(:user_id,:date,:text,:others_id)";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':user_id', $data, PDO::PARAM_STR);
                $stm->bindValue(':date', $date, PDO::PARAM_STR);
                $stm->bindValue(':text', $text, PDO::PARAM_STR);
                $stm->bindValue(':others_id', $user_id, PDO::PARAM_STR);
                $stm->execute();
                $sql = "SELECT * FROM reservation_list where list_id = :id and user_id != :user_id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $id, PDO::PARAM_STR);
                $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                foreach ($result as $row) {
                    $text = "あなたが予約した<a href='detail.php?id=" . $id . "'>" . $item . "</a>の認可はされませんでした。
                    ※これは自動送信です。";
                    date_default_timezone_set('Asia/Tokyo');
                    $date = date('Y-m-d H:i:s');
                    $sql = "INSERT INTO user_chat (user_id,created_at,text,others_id) VALUES(:user_id,:date,:text,:others_id)";
                    $stm = $pdo->prepare($sql);
                    $stm->bindValue(':user_id', $data, PDO::PARAM_STR);
                    $stm->bindValue(':date', $date, PDO::PARAM_STR);
                    $stm->bindValue(':text', $text, PDO::PARAM_STR);
                    $stm->bindValue(':others_id', $row["user_id"], PDO::PARAM_STR);
                    $stm->execute();
                }
                $sql = "DELETE FROM reservation_list where list_id = :id and user_id != :user_id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $id, PDO::PARAM_STR);
                $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
                $stm->execute();
                echo '<a href="mypage.php">マイページに戻る</a>';
            }
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