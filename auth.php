<?php
session_start();
require_once "db_connect.php";
$id=$_GET["id"];
$sql = "UPDATE users SET checked=1 where id = $id";
$stm = $pdo->prepare($sql);
$stm->execute();
require_once('user_check.php');
$email=$row["email"];
?>
<!DOCTYPE html>
<?php require_once("head.php") ?>
<title>貸し借り|HOME</title>
<link rel="stylesheet" href="css/top.css">
</head>

<body>
	<audio id="audio"></audio>
	<div id="fb-root"></div>


	<!--ヘッダー-->
	<?php require_once("header.php"); ?>

	<div id="wrapper">
		<!--メイン-->
		<div id="main">
		<!--/メイン-->
        <h1><?php echo $email;?>のメールアドレスを認証しました。</h1>
        </div>
		<!--サイド-->

		<?php
      require_once('side.php');
      ?>


		<!--/サイド-->

	</div>
	<!--/wrapper-->

	<!--フッター-->
	<footer>
		<div id="footer_nav">
			<ul>
				<li class="current"><a href="index.php">HOME</a></li>
				<li><a href="add_db.php">商品登録</a></li>
				<li><a href="user_chat_list.php">一覧</a></li>
				<li><a href="mypage.php">マイページ</a></li>
				<li><a href="register.php">アカウント登録</a></li>
				<li><a href="login.php">ログイン</a></li>
			</ul>
		</div>
		<small>&copy; 2015 Bloom.</small>
	</footer>
	<!--/フッター-->

</body>

</html>