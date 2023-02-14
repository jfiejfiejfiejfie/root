<?php
//XSS対策
function h($s)
{
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
}

//セッションにトークンセット
function setToken()
{
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
}

//セッション変数のトークンとPOSTされたトークンをチェック
function checkToken()
{
    if (empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token'])) {
        echo 'Invalid POST', PHP_EOL;
        exit;
    }
}

//POSTされた値のバリデーション
function validation($datas, $confirm = true)
{
    $errors = [];
    //ユーザー名のチェック
    if (empty($datas['name'])) {
        $errors['name'] = 'ユーザー名を入力してください。';
    } else {
        if (mb_strlen($datas['name']) > 20) {
            $errors['name'] = 'ユーザー名は20文字以内にしてください。';
        }
        if (!$confirm) {
            $flag = 0;
            $sql = "SELECT * FROM users WHERE user_id = :user_id";
            $pdo = new PDO(DB_HOST, DB_USER, DB_PASSWORD, [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
            ]);
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue('user_id', $datas['name'], PDO::PARAM_INT);
            $stmt->execute();
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $flag = 1;
            }
            if ($flag == 0) {
                $errors['name'] = 'そのユーザー名は存在しません。';
            }
        }
    }


    //パスワードのチェック（正規表現）
    if (empty($datas["password"])) {
        $errors['password'] = "パスワードを入力してください。";
    } else {
        if (!preg_match('/\A[a-z\d]{8,100}+\z/i', $datas["password"])) {
            $errors['password'] = "パスワードは8文字以上にしてください。.";
        }
    }
    //パスワード入力確認チェック（ユーザー新規登録時のみ使用）
    if ($confirm) {
        if (empty($datas["confirm_password"])) {
            $errors['confirm_password'] = "パスワードを入力してください。";
        } else if (empty($errors['password']) && ($datas["password"] != $datas["confirm_password"])) {
            $errors['confirm_password'] = "パスワードが違うようです。";
        }
    }

    return $errors;
}