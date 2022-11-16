<?php
if (isset($_SESSION["id"])) {
    $block_count=0;
    if($block==0){
        // echo "ちんちん<br>";
        $sql = "SELECT * FROM blocklist WHERE my_id =:id";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $block_count += 1;
            $block_list[] = $row["user_id"];
        }
    }else{
        //購入時に使う
        $sql = "SELECT * FROM blocklist WHERE user_id =:my_id and my_id=:user_id";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stm->bindValue(':my_id', $_SESSION["id"], PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $block_count += 1;
        }
    }
}
?>