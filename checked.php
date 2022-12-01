<?php
date_default_timezone_set('Asia/Tokyo');
$created_at = date("Y/m/d H:i:s", strtotime("-1 day"));
$id = $_SESSION["id"];
$sql = "SELECT * FROM followlist WHERE user_id=:id ORDER BY id DESC";
$stm = $pdo->prepare($sql);
$stm->bindValue(':id', $id, PDO::PARAM_STR);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    if ($created_at > $row["created_at"]) {
        $sql = "INSERT INTO followlist WHERE user_id=:id ORDER BY id DESC";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':id', $id, PDO::PARAM_STR);
        $stm->execute();
    }
}
?>