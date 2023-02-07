<?php
date_default_timezone_set('Asia/Tokyo');
$created_at = date("Y/m/d H:i:s", strtotime("-1 day"));
$id = $_SESSION["id"];
//フォローを確認
$sql = "SELECT * FROM followlist WHERE user_id=:id ORDER BY id DESC";
$stm = $pdo->prepare($sql);
$stm->bindValue(':id', $id, PDO::PARAM_STR);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    if ($created_at < $row["created_at"]) {
        $sql = "UPDATE followlist SET checked=1 WHERE id=:id";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':id', $row["id"], PDO::PARAM_STR);
        $stm->execute();
    }
}
//レンタルを確認
$sql = "SELECT * FROM list WHERE user_id=:id and loan=1 ORDER BY id DESC";
$stm = $pdo->prepare($sql);
$stm->bindValue(':id', $id, PDO::PARAM_STR);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    if ($created_at < $row["created_at"]) {
        $sql = "UPDATE list SET checked=1 WHERE id=:id";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':id', $row["id"], PDO::PARAM_STR);
        $stm->execute();
    }
}
//予約を確認
$reservation_count = 0;
$list_list = [];
$list_count = 0;
$sql = "SELECT * FROM list WHERE user_id=:id";
$stm = $pdo->prepare($sql);
$stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $list_count += 1;
    $list_list[] = $row["id"];
}
if ($list_count > 0) {
    $reservation_list = [];
    $list_list = implode(",", $list_list);
    $sql = "SELECT * FROM reservation_list WHERE list_id in($list_list) and checked=0";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $reservation_count += 1;
        $reservation_list[] = $row["id"];
    }
    if ($reservation_count > 1) {
        $reservation_list = implode(",", $reservation_list);
        $sql = "SELECT * FROM list WHERE id in($reservation_list)";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            if ($created_at < $row["created_at"]) {
                $sql = "UPDATE reservation_list SET checked=1 WHERE user_id=:id";
                $stm = $pdo->prepare($sql);
                $stm->bindValue(':id', $id, PDO::PARAM_STR);
                $stm->execute();
            }
        }
    }
}
?>