<?php
session_start();
require_once('../lib/util.php');
$myURL='map.php';
$gobackURL = 'index.php';
require_once "db_connect.php";
?>

<!DOCTYPE html>
<script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBKJXSpiVzHlWUGTwErL7dYWMOCkm7PHGI&callback=initMap" async></script>

<style>
#maps{
	height:600px;
	width:1000px
}
</style>
<?php require_once("head.php") ?>
<title>貸し借り|一覧</title>
</head>

<body>
  <script src="js/original.js"></script>
  <div id="cursor"></div>
  <audio id="audio"></audio>
  <div id="fb-root"></div>
  <!--ヘッダー-->
  <?php require_once("header.php"); ?>

  <div>
    <!-- 入力フォームを作る -->

    <div id="wrapper">
      <!--メイン-->
      <div id="main">
        <section id="point">
        <h2>現在の位置情報</h2>

<!-- google mapを表示するdiv -->
<div id="maps"></div>

<script>
</script>

<!-- Google Map を表示するjavascript -->
<script>
function initMap() {
	//現在位置を許可させ、位置を取得する javascript 参考URL：http://taitan916.info/blog/?p=2280
	var ret = new Array();
	if( navigator.geolocation ){
		navigator.geolocation.getCurrentPosition(
		function( pos ){ //位置取得成功
			ret['long'] = pos.coords.longitude; //経度
			ret['lat'] = pos.coords.latitude; //緯度
			
			//位置を指定して、Google mapに表示する javascript 参考URL：https://www.granfairs.com/blog/staff/google-maps-api-01
			var mapPosition = {}
			mapPosition["lat"] = ret['lat'];
			mapPosition["lng"] = ret['long'];
			var mapArea = document.getElementById('maps');
			var mapOptions = {
				center: mapPosition,
				zoom: 16,
			};
			var map = new google.maps.Map(mapArea, mapOptions);
			
			//現在地にマーカーを付けます。参考URL：https://developers.google.com/maps/documentation/javascript/markers?hl=ja
			var marker = new google.maps.Marker({
			    position: mapPosition,
			    title:"Your location"
			});
			marker.setMap(map);
			
			result( ret );
		},
		function( error ){ //失敗
			switch( error.code ){
				case 1: ret['msg'] = "位置情報の利用が許可されていません"; break;
				case 2: ret['msg'] = "デバイスの位置が判定できません"; break;
				case 3: ret['msg'] = "タイムアウトしました"; break;
			}
			result( ret );
		}
		);
	} else { //使用不可のブラウザ
		ret['msg'] = 'このブラウザでは位置取得が出来ません。';
		result( ret );
	}
	//コンソールにログを出力 ※本番環境ではログを出さないので、消しましょう。
	function result( ret ){
		console.log( ret );
	}
}
</script>
      </div>
      <!--/メイン-->

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