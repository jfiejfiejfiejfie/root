<?php
  session_start(); 
  require_once "db_connect.php";
  $point=0;
?>
<!DOCTYPE html>
<?php require_once("head.php")?>
<title>貸し借り|商品登録  </title>
</head>
<body>
<audio id="audio"></audio>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5&appId=643231655816289";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  
  <!--ヘッダー-->
  <?php require_once("header.php");?>


  <div id="wrapper">
    <!--メイン-->
    <div id="main">
      <?php
      if(!isset($_SESSION["loggedin"])){
        echo "<h2>この機能を利用するにはログインしてください。</h2>";
        echo "<a href='login.php' class='btn btn-danger'>ログイン</a>";
      }else{?>
        <form method="POST" action="insert.php" enctype="multipart/form-data">
            <ul>
                  <li>
                    <label>貸出物　:
                        <input type="text" id="item_name" name="item" placeholder="貸出物">
                    </label>
                    <!-- <a class="btn btn-danger" onclick="test();">名前自動生成bot</a>
                    <button onclick="test()">名前自動生成bot</button> -->
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
                              echo '<option value="',$row["id"],'">',$row["name"],"</option>";
                            }
                          ?>
                        </select>
                    </label>
                  </li>
                  <li>
                    <label>コメント:
                        <input type="text" name="comment" placeholder="コメント"required>
                    </label>
                </li>
                <li>
                <label>金額　　:
                        <input type="number_format" name="money" placeholder="金額">
                    </label>
                </li>
                <li>画像選択:
                <li>
                  <label><img src="images/imageplus.png" id="preview" style="max-width:200px;"><br>
                        <input type="file" name="image" class="test" accept="image/*" onchange="previewImage(this);" required>
                          </label>
                  <label id="hidden1" style="visibility: hidden;"><img src="images/imageplus.png" id="preview2" style="max-width:200px;"><br>
                        <input type="file" name="image2" class="test" accept="image/*" onchange="previewImage2(this);">
                          </label>
                  <label id="hidden2" style="visibility: hidden;"><img src="images/imageplus.png" id="preview3" style="max-width:200px;"><br>
                        <input type="file" name="image3" class="test" accept="image/*" onchange="previewImage3(this);">
                          </label>
                  <label id="hidden3" style="visibility: hidden;"><img src="images/imageplus.png" id="preview4" style="max-width:200px;"><br>
                        <input type="file" name="image4" class="test" accept="image/*" onchange="previewImage4(this);">
                          </label>
                  <label id="hidden4" style="visibility: hidden;"><img src="images/imageplus.png" id="preview5" style="max-width:200px;"><br>
                        <input type="file" name="image5" class="test" accept="image/*" onchange="previewImage5(this);">
                          </label><br>
                          <li>
                          <label>
                        <input type="checkbox" required>規約に同意する
                          </label>
                          </li>
                <li><input type="submit" value="追加する">
                </li>
            </ul>
        </form><?php }?>
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
  <!-- <footer>
    <div id="footer_nav">
    <ul>
        <li class="current"><a href="all.php">HOME</a></li>
        <li><a href="add_db.php">商品登録</a></li>
        <li><a href="list.php">一覧</a></li>
        <li><a href="mypage.php">マイページ</a></li>
        <li><?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){?><a href="contact.php">お問い合わせ💛</a>
      <?php }else{?><a href="register.php">アカウント登録</a><?php }?></li><li><a href="login.php">ログイン</a></li>
      </ul>
    </div>
    <small>&copy; 2015 Bloom.</small>
  </footer> -->
  <!--/フッター-->

</body>
</html>