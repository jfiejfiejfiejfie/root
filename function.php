<?php
// データベースに接続
function connectDB()
{
    $param = 'mysql:dbname=loan_db;host=localhost';
    try {
        $pdo = new PDO($param, 'root', '');
        return $pdo;

    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}
?>