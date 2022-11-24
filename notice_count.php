<?php
$count = 0;
$count2 = 0;
$count_chat = 0;
$count_chat2 = 0;
$all_count = 0;
$chat_list = null;
$list_list = null;
$id = $_SESSION["id"];
$sql = "SELECT * FROM list WHERE user_id=$id";
$stm = $pdo->prepare($sql);
$stm->execute();
$result_chat = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result_chat as $row_chat) {
    $count_chat += 1;
    $chat_list[] = $row_chat["id"];
}
if ($count_chat != 0) {
    $chat_list = implode(",", $chat_list);
    $sql = "SELECT * FROM chat WHERE list_id IN ($chat_list) and checked=0";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $chat_result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($chat_result as $row_chat2) {
        $count_chat2 += 1;
        // $chat_list2[]=$row_chat2["list_id"];
    }
}
$sql = "SELECT * FROM list WHERE user_id=$id";
$stm = $pdo->prepare($sql);
$stm->execute();
$result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result2 as $row2) {
    $count += 1;
    $list_list[] = $row2["id"];
}
if ($count != 0) {
    $list_list = implode(",", $list_list);
    $sql = "SELECT * FROM likes WHERE list_id IN ($list_list) and checked=0";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $count2 += 1;
        // $main_list[]=$row["list_id"];
    }
}
$loan_count = 0;
$sql = "SELECT * FROM list WHERE  user_id=:id and loan=1 and checked=0";
$stm = $pdo->prepare($sql);
$stm->bindValue(':id', $id, PDO::PARAM_STR);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $loan_count += 1;
}
$user_chat_count = 0;
$sql = "SELECT * FROM user_chat WHERE others_id=:id and checked=0";
$stm = $pdo->prepare($sql);
$stm->bindValue(':id', $id, PDO::PARAM_STR);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
$user_chat_count += 1;
}
if ($count2 != 0) {
    $all_count += 1;
}
if ($loan_count != 0) {
    $all_count += 1;
}
if ($count_chat2 != 0) {
    $all_count += 1;
}
if ($user_chat_count != 0) {
    $all_count += 1;
}
$chat_list = [];
?>