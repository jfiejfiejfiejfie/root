<?php
session_start();
<<<<<<< HEAD
$gobackURL = 'index.php';
=======
$gobackURL = 'all.php';
>>>>>>> root/master
$myURL = 'keijiban.php';
$option = '';
require_once "db_connect.php";
?>
 <body>
  <div class="container">
    <h1>返信内容</h1>
    <div class="row">
    <?php
      echo $_POST['name']."さんに返信する";
      echo "内容:",$_POST['comment'];
      echo '<form action="keijiban.php" method="post">';
      echo 'コメント';
      echo '<input type="text" name="message">';
      echo '<input type="hidden" name="message_id" value="'.$_POST["message_id"].'">';
      echo '<input type="submit" value="投稿" name="btn_submit" class="btn  btn-outline-primary">';
      // echo '<input type="hidden" value="<?php echo $_POST['line_number'];" name="line_number">';
      ?>
      </form>
    </div>
  </div>
</body>