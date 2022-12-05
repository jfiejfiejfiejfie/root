
<?php
session_start();
require_once('../lib/util.php');
$myURL='map.php';
$gobackURL = 'index.php';
require_once "db_connect.php";
?>
<!DOCTYPE html>
<html lang="ja">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>貸し借りサイト　WACCA</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"><link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/original.css">
  <script src="js/original.js">
  </script>
  <script src="//maps.googleapis.com/maps/api/js?key=AIzaSyBKJXSpiVzHlWUGTwErL7dYWMOCkm7PHGI&callback=initMap" async></script>
</head>

<body id="page-top">
<style>
#maps{
	height:600px;
	width:1000px
}
</style>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once("sidebar.php");?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once("nav.php");?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">商品登録</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
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

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">本当にログアウトするのですね？</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">ログアウトしますか？</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">しない</button>
          <a class="btn btn-danger" href="logout.php">ログアウト</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>