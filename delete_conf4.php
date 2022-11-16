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
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 class="my-5"><b>
            <?php echo htmlspecialchars($_SESSION["name"]); ?>
        </b>、退会しないんですね?</h1>
    <p>
        <a href="all.php" class="btn btn-danger ml-3">はい</a>
        <a href="all.php" class="btn btn-danger ml-3">Yes</a>
    </p>
</body>

</html>