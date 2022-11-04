<?php
require_once 'function.php';

$pdo = connectDB();

$sql = 'SELECT * FROM image_list WHERE list_id = :id and number = :number LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', (int)$_GET['id'], PDO::PARAM_INT);
$stmt->bindValue(':number', (int)$_GET['number'], PDO::PARAM_INT);
$stmt->execute();
$image = $stmt->fetch();

echo $image['image'];
exit();
?>