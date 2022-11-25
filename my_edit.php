<?php
  session_start(); 
  require_once('../lib/util.php');
<<<<<<< HEAD
  $gobackURL ='detail.php?id='.$_GET['id'];
=======
  $gobackURL ='list.php';
>>>>>>> root/master
  require_once "db_connect.php";
  ?>
<!DOCTYPE html>
<?php require_once("head.php")?>
<title>貸し借り|登録</title>
</head>
<body>
<audio id="audio"></audio>
<div id="fb-root"></div>

  
  <!--ヘッダー-->
		<?php require_once("header.php");?>


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
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
            <ul>
                  <li>
                    <label>貸出物　:
                        <input type="text" name="item" value="<?php echo htmlspecialchars($item); ?>" placeholder="貸出物">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET["id"]);?>">
                    </label>
                  </li>
                  <li>
                    <label>ジャンル:
                        <select name="kind">
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
                  </li>
                  <li>
                <label>金額　　:
                        <input type="number_format" name="money" value="<?php echo htmlspecialchars($money); ?>" placeholder="金額" required>
                    </label>
                </li>
                <li>
                  <label>画像選択:<br>
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
                <li><input type="submit" value="編集する">
                </li>
            </ul>
        </form>
        <p><a href="<?php echo $gobackURL ?>">戻る</a></p>
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
        <li><?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){?><a href="contact.php">お問い合わせ💛</a>
      <?php }else{?><a href="register.php">アカウント登録</a><?php }?></li><li><a href="login.php">ログイン</a></li>
      </ul>
    </div>
    <small>&copy; 2015 Bloom.</small>
  </footer>
  <!--/フッター-->

</body>
</html>