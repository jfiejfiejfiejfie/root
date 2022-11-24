<?php
session_start();
// セッション変数 $_SESSION["loggedin"]を確認。ログイン済だったらウェルカムページへリダイレクト
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
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
    <script src="js/original.js">
    </script>
</head>

<body>
    <audio id="audio"></audio>
    <h1 class="my-5">お帰りなさい。<b>
            <?php echo htmlspecialchars($_SESSION["name"]); ?>
        </b>。</h1>
    <p>
        <a href="index.php" class="btn btn-danger ml-3">HOME</a>
    </p>
</body>

</html>