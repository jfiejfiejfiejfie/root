<?php
session_start();
require_once('../lib/util.php');
//$gobackURL ="blocklist.php?id={$_SESSION["my_id"]}&user_id={$_SESSION["user_id"]}";
//$gobackURL = 'blocklist.php';
require_once "db_connect.php";
$my_id = $_GET["my_id"];
$room_id = $_GET["id"];
try {
    $sql = "SELECT * FROM roomlist WHERE room_id =:room_id and my_id=:my_id";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(':room_id', $room_id, PDO::PARAM_STR);
    $stm->bindValue(':my_id', $_SESSION["id"], PDO::PARAM_STR);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC); {
        $sql = "DELETE FROM roomlist WHERE my_id=$my_id and room_id=$room_id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    header('Location:room_member.php?id=' . $room_id);
} catch (Exception $e) {
    echo 'エラーがありました。';
    echo $e->getMessage();
    exit();
}
?>