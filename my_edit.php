<?php
  session_start(); 
  require_once('../lib/util.php');
  $myURL='my_edit.php';
  $gobackURL ='detail.php?id='.$_GET['id'];
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
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/original.css">
  <script src="js/original.js">
  </script>
</head>

<body id="page-top">

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
            <h1 class="h3 mb-0 text-gray-800">編集</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>

          <div class="row">
          <div class="col-6">
          <?php
    $data=$_GET["id"];
    $_SESSION["loan_id"]=$data;
    try{
      
      $sql = "SELECT * FROM image_list WHERE list_id=$data";
      $stm = $pdo->prepare($sql);
      $stm->execute();
      $result=$stm->fetchAll(PDO::FETCH_ASSOC);
      $image_count=0;
      foreach($result as $row){
        $image_count+=1;
      }
    }catch(Exception $e){
        echo 'エラーがありました。';
        echo $e->getMessage();
        exit();
    }
        try{
            
            $sql = "SELECT * FROM list WHERE id=$data";
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result=$stm->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $row){
            echo '<table class="table table-striped">';
            echo '<thead><tr>';
            echo '<td><img src="image.php?id=',$row['id'],'"style="max-width:200px;">';
            if($image_count>0){
              echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=',$row['id'],'&number=1">
                    <img src="image_next.php?id=',$row['id'],'&number=1"height="150" width="150"></a>';
              if($image_count>1){
                echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=',$row['id'],'&number=2">
                      <img src="image_next.php?id=',$row['id'],'&number=2"height="150" width="150"></a>';
                if($image_count>2){
                  echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=',$row['id'],'&number=3">
                        <img src="image_next.php?id=',$row['id'],'&number=3"height="150" width="150"></a>';
                  if($image_count>3){
                    echo '<a img data-lightbox="group" height="200" width="200  "href="image_next.php?id=',$row['id'],'&number=4">
                          <img src="image_next.php?id=',$row['id'],'&number=4"height="150" width="150"></a></td>';
                  }
                }
              }
        }
            echo '</tr>';
            echo '<tr>';
            echo '</thead>';
            echo '</table>';
            //echo "<td><a href=detail.php?id={$row["id"]}>"
            $item=$row["item"];
            $money=$row["money"];
            }
        }catch(Exception $e){
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
        }
    ?><hr>
        <form method="POST" action="detail1.php" enctype="multipart/form-data">
                  
                    <label>貸出物:
                        <input type="text" name="item" class="form-control form-control-user" value="<?php echo htmlspecialchars($item); ?>" placeholder="貸出物" required>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET["id"]);?>">
                    </label>
                  
            

                   <br> <label>ジャンル:
                        <select name="kind" class="form-control form-control-user">
                          <?php
                                  try{
                                    
                                    $sql = "SELECT * FROM kind";
                                    $stm = $pdo->prepare($sql);
                                    $stm->execute();
                                    $kind=$stm->fetchAll(PDO::FETCH_ASSOC);
                                }catch(Exception $e){
                                    echo 'エラーがありました。';
                                    echo $e->getMessage();
                                    exit();
                                }
                            foreach($kind as $row){
                              echo '<option value="',$row["name"],'">',$row["name"],"</option>";
                            }
                          ?>
                        </select>
                    </label>

                    <br>商品の状態:
                  <select name="state" class="form-control form-control-user">
                    <?php
                    try {

                      $sql = "SELECT * FROM state";
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $state = $stm->fetchAll(PDO::FETCH_ASSOC);
                    } catch (Exception $e) {
                      echo 'エラーがありました。';
                      echo $e->getMessage();
                      exit();
                    }
                    foreach ($state as $row) {
                      echo '<option value="', $row["name"], '">', $row["name"], "</option>";
                    }
                    ?>
                  </select>
                  コメント(任意):
                  <script>
                    function countLength(text, field) {
                      document.getElementById(field).innerHTML = text.length + "文字/1000文字";
                    }
                  </script>
                  <textarea id="message" name="comment" class="form-control form-control-user"
                    placeholder="色、素材、重さ、定価、注意点など" onKeyUp="countLength(value, 'textlength2');"></textarea>
                  <p id="textlength2">0文字/1000文字</p>
                 
                <label>金額:
                        <input type="number_format" name="money" class="form-control form-control-user" value="<?php echo htmlspecialchars($money); ?>" placeholder="金額" required>
                    </label>
                
                
                  <br>画像選択:<br>
                <label><img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                        <input type="file" name="image"class="test" accept="image/*"  onchange="previewImage(this);">
                          </label>
                          <?php if($image_count>0){?>
                  <label><img src="images/imageplus.png" id="preview2" style="max-width:200px;"><br>
                        <input type="file" name="image2"class="test" accept="image/*"  onchange="previewImage2(this);">
                          </label>
                          <?php if($image_count>1){?>
                  <label><img src="images/imageplus.png" id="preview3" style="max-width:200px;"><br>
                        <input type="file" name="image3"class="test" accept="image/*"  onchange="previewImage3(this);">
                          </label>
                          <?php if($image_count>2){?>
                  <label><img src="images/imageplus.png" id="preview4" style="max-width:200px;"><br>
                        <input type="file" name="image4"class="test" accept="image/*"  onchange="previewImage4(this);">
                          </label>
                          <?php if($image_count>3){?>
                  <label><img src="images/imageplus.png" id="preview5" style="max-width:200px;"><br>
                        <input type="file" name="image5"class="test" accept="image/*"  onchange="previewImage5(this);">
                          </label>
                          <?php }}}}?>
                <br><input type="submit" value="編集する">
                
          
            <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
        </form>
        </div>
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






