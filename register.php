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
    'age' => '',
    'sex' => '',
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
    $errors = validation($datas);
    if (preg_match("/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u", $datas['name'])) {
        $errors['name'] = '英数字にしてください。';
    }
    if ($datas['age'] < 0) {
        $errors['age'] = '正しい年齢を入力してください。';
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
        // $params = [
        //     'user_id' => $datas['name'],
        //     'name' => $datas['name'],
        //     'password' => password_hash($datas['password'], PASSWORD_DEFAULT),
        //     'age' => $datas['age'],
        //     'sex' => $datas['sex']
        // ];
        $name = $datas['name'];
        $pass = password_hash($datas['password'], PASSWORD_DEFAULT);
        $age = $datas["age"];
        $sex = $datas["sex"];
        $email = $datas["email"];
        $sql = "SELECT * FROM users";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            if ($email == $row["email"]) {
                $update_id = $row["id"];
            }
        }
        // $pdo->beginTransaction(); //トランザクション処理 
        try {
            $sql = "UPDATE users SET user_id=:name,name=:name2,password=:pass,age=:age,sex=:sex,checked=1 WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':name2', $name, PDO::PARAM_STR);
            $stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
            $stmt->bindValue(':age', $age, PDO::PARAM_STR);
            $stmt->bindValue(':sex', $sex, PDO::PARAM_STR);
            $stmt->bindValue(':id', $update_id, PDO::PARAM_STR);
            $stmt->execute();
            header("Location:login.php");
            // $pdo->commit();
        } catch (Exception $e) {
            echo 'エラーがありました。';
            echo $e->getMessage();
            exit();
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
                                <h1 class="h4 text-gray-900 mb-4">アカウント作成</h1>
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
                                <!-- <div class="form-group">
                                    <input type="email" class="form-control form-control-user"
                                     id="exampleInputEmail" placeholder="Email Address" 
                                    >
                                    <span class="invalid-feedback">
                                        <?php echo h($errors['e-email']); ?>
                                    </span>
                                </div> -->
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
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="hidden" name="email" placeholder=""
                                            class="form-control form-control-user" value="<?php if (isset($_GET['email'])) {
                                                echo h($_GET['email']);
                                            } else {
                                                echo h($_POST['email']);
                                            } ?>">
                                    </div>
                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                        <input type="number" name="age" placeholder="年齢"
                                            class="form-control form-control-user <?php echo (!empty(h($errors['age']))) ? 'is-invalid' : ''; ?>"
                                            value="<?php echo h($datas['age']); ?>">
                                        <span class="invalid-feedback">
                                            <?php echo h($errors['age']); ?>
                                        </span>
                                    </div>
                                    <div class="col-sm-12">
                                        <label><input type="radio" name="sex" value="男" checked>男性</label>
                                        <label><input type="radio" name="sex" value="女">女性</label>
                                        <label><input type="radio" name="sex" value="無回答">無回答</label>
                                        <span class="invalid-feedback">
                                            <?php echo h($errors['sex']); ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="作成">
                                </div>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login.php">既にアカウントをお持ちの方はこちら</a>
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