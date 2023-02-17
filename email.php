<?php
//ファイルの読み込み
require_once "db_connect.php";
require_once "functions.php";

//セッションの開始
session_start();

//POSTされてきたデータを格納する変数の定義と初期化
$datas = [
    'name' => '',
    'password' => '',
    'confirm_password' => '',
    'email' => ''
];

//GET通信だった場合はセッション変数にトークンを追加
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    setToken();
}
//POST通信だった場合はDBへの新規登録処理を開始
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //CSRF対策
    checkToken();

    // POSTされてきたデータを変数に格納
    foreach ($datas as $key => $value) {
        if ($value = filter_input(INPUT_POST, $key, FILTER_DEFAULT)) {
            $datas[$key] = $value;
        }
    }

    // バリデーション
    // $errors = validation($datas);
    // if (preg_match("/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u", $datas['name'])) {
    //     $errors['name'] = '英数字にしてください。';
    // }
    //データベースの中に同一ユーザー名が存在していないか確認
    if (empty($errors['email'])) {
        $sql = "SELECT email FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $datas['email'], PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $errors['email'] = 'そのメールは使われています。';
        }
    }
    //エラーがなかったらDBへの新規登録を実行
    if (empty($errors)) {
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $to = $_POST["email"];
        $http_host = $_SERVER['HTTP_HOST'];
        // $to = "fki2166301@stu.o-hara.ac.jp"; // 送信先のアドレス
        $subject = "メール認証の件"; // 件名
        $message = "メール認証をするには以下のURLに接続してください。
		http://".$http_host."/root/auth?email=$to
		関係のない場合は削除してください。"; // 本文
        $additional_headers = ""; // ヘッダーオプション

        if (mb_send_mail($to, $subject, $message, $additional_headers)) {
            $text="メールを送信しました。";
        } else {
            $text="メール送信に失敗しました。";
        }
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

    <title>貸し借りサイト　Lab:G | メール登録</title>

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
                                <h1 class="h4 text-gray-900 mb-4">メール登録</h1>
                            </div>
                            <form class="user" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-user <?php echo (!empty(h($errors['email']))) ? 'is-invalid' : ''; ?>"
                                        id="exampleInputEmail" placeholder="Email Address"
                                        value="<?php echo h($datas['email']); ?>">
                                    <span class="invalid-feedback">
                                        <?php echo h($errors['email']); ?>
                                    </span>
                                    <div><?php if(isset($text)){echo $text;} ?></div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="送信">
                                </div>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login">既にアカウントをお持ちの方はこちら</a>
                            </div>
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