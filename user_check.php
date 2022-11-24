<?php
if(isset($get)){
    $id=$_GET["id"];
    $sql = "SELECT * FROM users WHERE id=$id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
    }
}else if(isset($_SESSION["id"])){
    $id=$_SESSION["id"];
    $sql = "SELECT * FROM users WHERE id=$id";
    $stm = $pdo->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
    }
}
?>