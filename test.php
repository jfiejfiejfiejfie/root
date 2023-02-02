<?php
// $pass = password_hash("thiduspenis", PASSWORD_DEFAULT);
$sql = "UPDATE users SET password=:pass WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
$stmt->bindValue(':id', $update_id, PDO::PARAM_STR);
$stmt->execute();
header("Location:login.php");
?>