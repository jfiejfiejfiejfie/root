<?php
//ファイルの読み込み
require_once "db_connect.php";
require_once "functions.php";
$myURL = 'auth.php';
$email = $_GET["email"];
//セッションの開始
session_start();
$sql = "SELECT * FROM users WHERE email = :email && checked = 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->execute();
if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  header("Location:404.php");
}
$flag = 0;
if (empty($errors['email'])) {
  $sql = "SELECT email FROM users WHERE email = :email";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt->execute();
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $flag = 1;
  }
}
if (empty($errors)) {

  $url = "https://applimura.com/wp-content/uploads/2019/08/twittericon13.jpg";
  $img = file_get_contents($url);
  $enc_img = base64_encode($img);
  $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
  $params = [
    'id' => null,
    'user_id' => '',
    'name' => '',
    'password' => '',
    'created_at' => null,
    'image' => $img,
    'email' => $email,
    'checked' => '0'
  ];

  $count = 0;
  $columns = '';
  $values = '';
  foreach (array_keys($params) as $key) {
    if ($count > 0) {
      $columns .= ',';
      $values .= ',';
    }
    $columns .= $key;
    $values .= ':' . $key;
    $count++;
  }

  $pdo->beginTransaction(); //トランザクション処理
  if ($flag == 0) {
    $sql = 'insert into users (' . $columns . ')values(' . $values . ')';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $pdo->commit();
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

  <title>SB Admin 2 - Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">メール認証完了</h1>
              </div>
              <form class="user" action="register.php" method="post">
                <!-- <div class="form-group">
                  <input type="hidden" name="email" class="form-control form-control-user" id="exampleInputEmail"
                    placeholder="Email Address" value="<?php echo $email; ?>">
                </div> -->
                <div class="form-group">
                  <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
                  <a href="register.php?email=<?php echo $email; ?>"
                    class="btn btn-primary btn-user btn-block">基礎情報入力</a>
                </div>
              </form>
              <hr>
            </div>
          </div>
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

</body>

</html>