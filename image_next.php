<?php
require_once 'function.php';

$pdo = connectDB();

<<<<<<< HEAD
$sql = 'SELECT * FROM image_list WHERE list_id = :id and number = :number LIMIT 1';
=======
$sql = 'SELECT * FROM image_list WHERE image_id = :id and number = :number LIMIT 1';
>>>>>>> root/master
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', (int)$_GET['id'], PDO::PARAM_INT);
$stmt->bindValue(':number', (int)$_GET['number'], PDO::PARAM_INT);
$stmt->execute();
$image = $stmt->fetch();

echo $image['image'];
exit();
?>