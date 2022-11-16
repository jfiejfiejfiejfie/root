<?php
require_once 'function.php';

$pdo = connectDB();

$sql = 'SELECT * FROM list WHERE id = :id LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', (int) $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$image = $stmt->fetch();

echo $image['image'];
exit();
?>