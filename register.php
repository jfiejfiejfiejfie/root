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
    'confirm_password' => ''
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
    $errors = validation($datas);
    if (preg_match("/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u", $datas['name'])) {
        $errors['name'] = '英数字にしてください。';
    }
    //データベースの中に同一ユーザー名が存在していないか確認
    if (empty($errors['name'])) {
        $sql = "SELECT id FROM users WHERE user_id = :name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':name', $datas['name'], PDO::PARAM_STR);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $errors['name'] = 'そのユーザ名は使われています。';
        }
    }
    //エラーがなかったらDBへの新規登録を実行
    if (empty($errors)) {
        $url = "https://applimura.com/wp-content/uploads/2019/08/twittericon13.jpg";
        $img = file_get_contents($url);
        $enc_img = base64_encode($img);
        $imginfo = getimagesize('data:application/octet-stream;base64,' . $enc_img);
        $params = [
            'id' => null,
            'user_id' => $datas['name'],
            'name' => $datas['name'],
            'password' => password_hash($datas['password'], PASSWORD_DEFAULT),
            'created_at' => null,
            'image' => $img,
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
        try {
            $sql = 'insert into users (' . $columns . ')values(' . $values . ')';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $pdo->commit();
            header("location: login.php");
            exit;
        } catch (PDOException $e) {
            echo 'ERROR: Could not register.';
            $pdo->rollBack();
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

    <title>SB Admin 2 - Register</title>

    <!-- Custom fonts for this template-->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="USER ID"
                                        class="form-control form-control-user <?php echo (!empty(h($errors['name']))) ? 'is-invalid' : ''; ?>"
                                        value="<?php echo h($datas['name']); ?>">
                                    <span class="invalid-feedback">
                                        <?php echo h($errors['name']); ?>
                                    </span>
                                    <div style="color:gray;">※英数字20文字以内にしてください。</div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" placeholder="Password"
                                            class="form-control form-control-user <?php echo (!empty(h($errors['password']))) ? 'is-invalid' : ''; ?>"
                                            value="<?php echo h($datas['password']); ?>">
                                        <span class="invalid-feedback">
                                            <?php echo h($errors['password']); ?>
                                        </span>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="confirm_password" placeholder="Repeat Password"
                                            class="form-control form-control-user <?php echo (!empty(h($errors['confirm_password']))) ? 'is-invalid' : ''; ?>"
                                            value="<?php echo h($datas['confirm_password']); ?>">
                                        <span class="invalid-feedback">
                                            <?php echo h($errors['confirm_password']); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="作成">
                                </div>
                                <hr>
                                <a href="index.html" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
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