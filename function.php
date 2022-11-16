<?php
// データベースに接続
<<<<<<< HEAD
function connectDB()
{
=======
<<<<<<< HEAD
function connectDB()
{
=======
function connectDB() {
>>>>>>> root/master
>>>>>>> root/master
    $param = 'mysql:dbname=loan_db;host=localhost';
    try {
        $pdo = new PDO($param, 'root', '');
        return $pdo;

    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}
?>