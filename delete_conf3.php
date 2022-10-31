<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ 
            font: 14px sans-serif;
            text-align: center; 
        }
    </style>
</head>
<body>
    <h1 class="my-5"><b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>、本当の本当の本当に退会しないというのですね?</h1>
    <p>
        <a href="delete_conf4.php" class="btn btn-danger ml-3">はい</a>
        <a href="deleteacount.php" class="btn btn-info ml-3">いいえ</a>
    </p>
</body>
</html>