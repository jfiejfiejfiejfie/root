<?php
session_start();
$gobackURL = 'index.php';
$myURL = 'keijiban.php';
$option = '';
require_once "db_connect.php";
?>
<?php
define('MAX', '5');
// メッセージを保存するファイルのパス設定
define('FILENAME', './message.txt');

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
// $current_date = null;
// $data = null;
// $file_handle = null;
// $split_data = null;
// $message = array();
// $message_array = array();
// $success_message = null;
// $error_message = array();
// $clean = array();
// $pdo = null;
// $stmt = null;
// $res = null;
// $option = null;
function ngWordCheck($word = '')
{
  $ngArray = array(
    '事故',
    '死亡',
    '骨折',
    '重傷',
    '殺害',
    '傷害',
    '暴力',
    '被害者',
    '放送事故',
    'ポルノ',
    'アダルト',
    'セックス',
    'バイブレーター',
    'マスターベーション',
    'オナニー',
    'スケベ',
    '羞恥',
    'セクロス',
    'エッチ',
    'SEX',
    '風俗',
    '童貞',
    'ペニス',
    '巨乳',
    'ロリ',
    '触手',
    '羞恥',
    'ノーブラ',
    '手ブラ',
    'ローアングル',
    '禁断',
    'Tバック',
    'グラビア',
    '美尻',
    'お尻',
    'セクシー',
    '無修正',
    '児童ポルノ',
    '青姦',
    '大麻',
    '麻薬',
    '基地外',
    '糞',
    '死ね',
    '殺す',
    'shit',
    'piss',
    'fuck',
    'cunt',
    'cocksucker',
    'motherfucker',
    'tits',
  );
  $ngList = '/' . implode('|', $ngArray) . '/';
  $f = preg_match($ngList, $word);

  if ($f == '1') {
    return true;
  } else {
    return false;
  }
}
if (isset($_SESSION["loggedin"])) {
  $id = $_SESSION["id"];
  $sql = "SELECT * FROM users WHERE id =$id";
  $stm = $pdo->prepare($sql);
  $stm->execute();
  $result = $stm->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $name = $row["name"];
  }
} else {
  $name = "匿名";
}
// データベースに接続
if (!empty($_POST['btn_submit'])) {
  $f = ngWordCheck($_POST['message']);
  if ($f == true) {
    // ①$alertにjavascriptのalert関数を代入する。
    $alert = "<script type='text/javascript'>alert('NGワードが含まれています。');</script>";

    // ②echoで①を表示する
    echo $alert;
  } else {
    // 表示名の入力チェック
    // if( empty($_POST['view_name']) ) {
    // 	$error_message[] = '表示名を入力してください。';
    // }else {
    $clean['view_name'] = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $clean['view_name'] = preg_replace('/\\r\\n|\\n|\\r/', '', $clean['view_name']);
    // }
    // メッセージの入力チェック
    if (empty($_POST['message'])) {
      $error_message[] = 'ひと言メッセージを入力してください。';
    } else {
      $clean['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
      $clean['message'] = preg_replace('/\\r\\n|\\n|\\r/', '<br>', $clean['message']);
    }
    if (empty($error_message)) {
      // 書き込み日時を取得
      $current_date = date("Y-m-d H:i:s");
      // SQL作成
      if (isset($_POST["message_id"])) {
        $message_id = $_POST["message_id"];
        $sql = "INSERT INTO message (view_name, message, post_date,message_id,IP) VALUES ( :view_name, :message, :current_date,$message_id,:IP)";
        $stmt = $pdo->prepare($sql);
        // $stmt->bindParam(':message_id', $_POST['message_id'], PDO::PARAM_STR);
      } else {
        $sql = "INSERT INTO message (view_name, message, post_date,IP) VALUES ( :view_name, :message, :current_date,:IP)";
        $stmt = $pdo->prepare($sql);
      }
      // 値をセット
      $stmt->bindParam(':view_name', $clean['view_name'], PDO::PARAM_STR);
      $stmt->bindParam(':message', $clean['message'], PDO::PARAM_STR);
      $stmt->bindParam(':current_date', $current_date, PDO::PARAM_STR);
      $stmt->bindParam(':IP', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);

      // SQLクエリの実行
      $res = $stmt->execute();

      if ($res) {
        $success_message = 'メッセージを書き込みました。';
      } else {
        $error_message[] = '書き込みに失敗しました。';
      }
      // プリペアドステートメントを削除
      $stmt = null;
    }
  }
  if (empty($error_message)) {

    // メッセージのデータを取得する
    $sql = "SELECT view_name,message,post_date FROM message ORDER BY post_date DESC";
    $message_array = $pdo->query($sql);
  }
}

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
  <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
    <?php require_once("sidebar.php"); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once("nav.php"); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">ひと言掲示板

                  <i class="fa fa-comments"></i>
                  <?php
                    try {
                      $sql = "SELECT * FROM message";
                      $stm = $pdo->prepare($sql);
                      $stm->execute();
                      $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                      $sth = $pdo->query($sql);
                      $count = $sth->rowCount();
                    } catch (Exception $e) {
                      echo 'エラーがありました。';
                      echo $e->getMessage();
                      exit();
                    }
                    echo $count . '件'; ?>
                    </h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> ダウンロードできません</a> -->
          </div>
          <div class="wiki m15 m10_s">投稿の際は「<a href="#">投稿規約</a>」を順守して投稿して下さい。</div>
                <div class="p15 bg_gray fs13 mb10">貸し借りサイトの愚痴掲示板です。名前を晒す行為や、愚痴に対する文句は禁止しています。</div>
          <div class="row">
            <section id="point">

              <head>
                <meta charset="utf-8">
                <title>ひと言掲示板</title>
              </head>

              <body>
                <form method="POST" action="search_comment.php">
                      <label>コメントを検索します（部分一致）：<br>
                      <div class="input-group">
                      <input type="text" name="message" class="form-control form-control-user" placeholder="調べたいコメントを入れろ">
                      <div class="input-group-append">
                        <button class="btn btn-info" type="submit">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                      </label>
                      <!-- <br>
                      <input type="submit" class='btn btn-info'value="検索する"> -->
                </form>
                <?php if (!empty($success_message)): ?>
                <p class="success_message">
                  <?php
                    echo $success_message; ?>
                </p>
                <?php endif; ?>
                <?php if (!empty($error_message)): ?>
                <ul class="error_message">
                  <?php foreach ($error_message as $value): ?>
                  <li>・
                    <?php echo $value; ?>
                  </li>
                  <?php endforeach; ?>
                </ul>
                <?php endif; ?>
                <form method="post">
                  <div>
                    <label for="message">ひと言メッセージ</label>
                    <textarea id="message" class="form-control form-control-user" name="message"></textarea>
                  </div>
                  <input type="submit" class='btn btn-primary' name="btn_submit" value="書き込む">
                </form>
                <hr>
                <section>
                  <article>
                    <?php
                      try {
                        $sql = "SELECT * FROM message WHERE message_id=0 ORDER BY post_date DESC";
                        $stm = $pdo->prepare($sql);
                        $stm->execute();
                        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                        require_once('paging.php');
                        foreach ($disp_data as $row) {
                          echo '<table class="table table-striped" style="table-layout:fixed;">';
                          echo '<thead><tr>';
                          echo '<th>No', $row["id"], ' ', $row["view_name"], ':';
                          echo $row["post_date"], '　　　　　<a class="btn btn-danger" href="report.php?id=' . $row["id"] . '">通報</a></th>';
                          echo '</tr>';
                          echo '<tr>';
                          echo '<td>', $row["message"], '</td>';
                          echo '</tr>';
                          $message_id = $row["id"];
                          $name = $row["view_name"];
                          $comment = $row["message"];
                          $sql = "SELECT * FROM message WHERE message_id=$message_id";
                          $stm = $pdo->prepare($sql);
                          $stm->execute();
                          $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
                          foreach ($result2 as $row2) {
                            echo '<tr>';
                            echo '<th>No', $row2["id"], ' ', $row2["view_name"], ':';
                            echo $row2["post_date"], '　　　　　<a class="btn btn-danger" href="report.php?id=' . $row2["id"] . '">通報</a></th></tr><tr>';
                            echo '<td>', $row2['message'], '</td>';
                            echo '</tr>';
                          }
                          echo '<tr><td>';
                          echo '<form action="reply.php" method="POST" name="replay" onClick="return confirm(\'返信しますか？\');">';
                          echo '<input type="hidden" name="message_id" value="' . $message_id . '">';
                          echo '<input type="hidden" name="name" value="' . $name . '">';
                          echo '<input type="hidden" name="comment" value="' . $comment . '">';
                          echo '<input type="submit" class="btn  btn-secondary" value="返信をする" >';
                          echo '</form></td></tr>';
                          echo '</thead>';
                          echo '</table>';
                        }
                      } catch (Exception $e) {
                        echo 'エラーがありました。';
                        echo $e->getMessage();
                        exit();
                      }
                      require_once('paging2.php')
                        ?>
                  </article>
                </section>
              </body>
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