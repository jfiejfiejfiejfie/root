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
      header('Location:keijiban.php');
      // if ($res) {
      //   $success_message = 'メッセージを書き込みました。';
      // } else {
      //   $error_message[] = '書き込みに失敗しました。';
      // }
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

  <title>貸し借りサイト　Lab:G | 掲示板</title>

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
          <div class="wiki m15 m10_s">投稿の際は「<class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#kiyaku">
                        利用規約
                    」を順守して投稿して下さい。※利用規約をクリックで確認できます。</div>
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
                      <input type="text" name="message" class="form-control form-control-user"
                        placeholder="調べたいコメントを入れろ">
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
                        echo '<form action="keijiban.php" method="post">';
                        echo '<br><br>返信内容';
                        echo '<br><input type="text" name="message">';
                        echo '<input type="submit" value="投稿" name="btn_submit" class="btn  btn-outline-primary">';
                        // echo '<input type="hidden" value="<?php echo $_POST['line_number'];" name="line_number">';
                        echo '<br>';
    
                        echo '<input type="hidden" name="message_id" value="' . $message_id . '">';
                        echo '<input type="hidden" name="name" value="' . $name . '">';
                        echo '<input type="hidden" name="comment" value="' . $comment . '">';

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
            <span>Copyright &copy; Lending and borrowing:GOD 2022-2023</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->
  <div class="modal fade bd-example-modal-lg" id="kiyaku" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      利用規約

この利用規約（以下、「本規約」といいます。）は、ＯＳＡＫＡ（以下、「当社」といいます。）がこのウェブサイト上で提供するサービス（以下、「本サービス」といいます。）の利用条件を定めるものです。登録ユーザーの皆さま（以下、「ユーザー」といいます。）には、本規約に従って、本サービスをご利用いただきます。

第1条（適用）
本規約は、ユーザーと当社との間の本サービスの利用に関わる一切の関係に適用されるものとします。
当社は本サービスに関し、本規約のほか、ご利用にあたってのルール等、各種の定め（以下、「個別規定」といいます。）をすることがあります。これら個別規定はその名称のいかんに関わらず、本規約の一部を構成するものとします。
本規約の規定が前条の個別規定の規定と矛盾する場合には、個別規定において特段の定めなき限り、個別規定の規定が優先されるものとします。

第2条（利用登録）
本サービスにおいては、登録希望者が本規約に同意の上、当社の定める方法によって利用登録を申請し、当社がこの承認を登録希望者に通知することによって、利用登録が完了するものとします。
当社は、利用登録の申請者に以下の事由があると判断した場合、利用登録の申請を承認しないことがあり、その理由については一切の開示義務を負わないものとします。 
利用登録の申請に際して虚偽の事項を届け出た場合
本規約に違反したことがある者からの申請である場合
その他、当社が利用登録を相当でないと判断した場合

第3条（ユーザーIDおよびパスワードの管理）
ユーザーは、自己の責任において、本サービスのユーザーIDおよびパスワードを適切に管理するものとします。
ユーザーは、いかなる場合にも、ユーザーIDおよびパスワードを第三者に譲渡または貸与し、もしくは第三者と共用することはできません。当社は、ユーザーIDとパスワードの組み合わせが登録情報と一致してログインされた場合には、そのユーザーIDを登録しているユーザー自身による利用とみなします。
ユーザーID及びパスワードが第三者によって使用されたことによって生じた損害は、当社に故意又は重大な過失がある場合を除き、当社は一切の責任を負わないものとします。

第4条（利用料金および支払方法）
ユーザーは、本サービスの有料部分の対価として、当社が別途定め、本ウェブサイトに表示する利用料金を、当社が指定する方法により支払うものとします。
ユーザーが利用料金の支払を遅滞した場合には、ユーザーは年14．6％の割合による遅延損害金を支払うものとします。

第5条（禁止事項）
ユーザーは、本サービスの利用にあたり、以下の行為をしてはなりません。
法令または公序良俗に違反する行為
犯罪行為に関連する行為
当社、本サービスの他のユーザー、または第三者のサーバーまたはネットワークの機能を破壊したり、妨害したりする行為
当社のサービスの運営を妨害するおそれのある行為
他のユーザーに関する個人情報等を収集または蓄積する行為
不正アクセスをし、またはこれを試みる行為
他のユーザーに成りすます行為
当社のサービスに関連して、反社会的勢力に対して直接または間接に利益を供与する行為
当社、本サービスの他のユーザーまたは第三者の知的財産権、肖像権、プライバシー、名誉その他の権利または利益を侵害する行為
以下の表現を含み、または含むと当社が判断する内容を本サービス上に投稿し、または送信する行為 
過度に暴力的な表現
露骨な性的表現
人種、国籍、信条、性別、社会的身分、門地等による差別につながる表現
自殺、自傷行為、薬物乱用を誘引または助長する表現
その他反社会的な内容を含み他人に不快感を与える表現
以下を目的とし、または目的とすると当社が判断する行為 
営業、宣伝、広告、勧誘、その他営利を目的とする行為（当社の認めたものを除きます。）
性行為やわいせつな行為を目的とする行為
面識のない異性との出会いや交際を目的とする行為
他のユーザーに対する嫌がらせや誹謗中傷を目的とする行為
当社、本サービスの他のユーザー、または第三者に不利益、損害または不快感を与えることを目的とする行為
その他本サービスが予定している利用目的と異なる目的で本サービスを利用する行為
宗教活動または宗教団体への勧誘行為
その他、当社が不適切と判断する行為

第6条（本サービスの提供の停止等）
当社は、以下のいずれかの事由があると判断した場合、ユーザーに事前に通知することなく本サービスの全部または一部の提供を停止または中断することができるものとします。 
本サービスにかかるコンピュータシステムの保守点検または更新を行う場合
地震、落雷、火災、停電または天災などの不可抗力により、本サービスの提供が困難となった場合
コンピュータまたは通信回線等が事故により停止した場合
その他、当社が本サービスの提供が困難と判断した場合
当社は、本サービスの提供の停止または中断により、ユーザーまたは第三者が被ったいかなる不利益または損害についても、一切の責任を負わないものとします。

第7条（著作権）
ユーザーは、自ら著作権等の必要な知的財産権を有するか、または必要な権利者の許諾を得た文章、画像や映像等の情報に関してのみ、本サービスを利用し、投稿ないしアップロードすることができるものとします。
ユーザーが本サービスを利用して投稿ないしアップロードした文章、画像、映像等の著作権については、当該ユーザーその他既存の権利者に留保されるものとします。ただし、当社は、本サービスを利用して投稿ないしアップロードされた文章、画像、映像等について、本サービスの改良、品質の向上、または不備の是正等ならびに本サービスの周知宣伝等に必要な範囲で利用できるものとし、ユーザーは、この利用に関して、著作者人格権を行使しないものとします。
前項本文の定めるものを除き、本サービスおよび本サービスに関連する一切の情報についての著作権およびその他の知的財産権はすべて当社または当社にその利用を許諾した権利者に帰属し、ユーザーは無断で複製、譲渡、貸与、翻訳、改変、転載、公衆送信（送信可能化を含みます。）、伝送、配布、出版、営業使用等をしてはならないものとします。

第8条（利用制限および登録抹消）
当社は、ユーザーが以下のいずれかに該当する場合には、事前の通知なく、投稿データを削除し、ユーザーに対して本サービスの全部もしくは一部の利用を制限しまたはユーザーとしての登録を抹消することができるものとします。 
本規約のいずれかの条項に違反した場合
登録事項に虚偽の事実があることが判明した場合
決済手段として当該ユーザーが届け出たクレジットカードが利用停止となった場合
料金等の支払債務の不履行があった場合
当社からの連絡に対し、一定期間返答がない場合
本サービスについて、最終の利用から一定期間利用がない場合
その他、当社が本サービスの利用を適当でないと判断した場合
前項各号のいずれかに該当した場合、ユーザーは、当然に当社に対する一切の債務について期限の利益を失い、その時点において負担する一切の債務を直ちに一括して弁済しなければなりません。
当社は、本条に基づき当社が行った行為によりユーザーに生じた損害について、一切の責任を負いません。

第9条（退会）
ユーザーは、当社の定める退会手続により、本サービスから退会できるものとします。

第10条（保証の否認および免責事項）
当社は、本サービスに事実上または法律上の瑕疵（安全性、信頼性、正確性、完全性、有効性、特定の目的への適合性、セキュリティなどに関する欠陥、エラーやバグ、権利侵害などを含みます。）がないことを明示的にも黙示的にも保証しておりません。
当社は、本サービスに起因してユーザーに生じたあらゆる損害について一切の責任を負いません。ただし、本サービスに関する当社とユーザーとの間の契約（本規約を含みます。）が消費者契約法に定める消費者契約となる場合、この免責規定は適用されません。
前項ただし書に定める場合であっても、当社は、当社の過失（重過失を除きます。）による債務不履行または不法行為によりユーザーに生じた損害のうち特別な事情から生じた損害（当社またはユーザーが損害発生につき予見し、または予見し得た場合を含みます。）について一切の責任を負いません。また、当社の過失（重過失を除きます。）による債務不履行または不法行為によりユーザーに生じた損害の賠償は、ユーザーから当該損害が発生した月に受領した利用料の額を上限とします。
当社は、本サービスに関して、ユーザーと他のユーザーまたは第三者との間において生じた取引、連絡または紛争等について一切責任を負いません。

第11条（サービス内容の変更等）
当社は、ユーザーに通知することなく、本サービスの内容を変更しまたは本サービスの提供を中止することができるものとし、これによってユーザーに生じた損害について一切の責任を負いません。

第12条（利用規約の変更）
当社は、必要と判断した場合には、ユーザーに通知することなくいつでも本規約を変更することができるものとします。なお、本規約の変更後、本サービスの利用を開始した場合には、当該ユーザーは変更後の規約に同意したものとみなします。

第13条（個人情報の取扱い）
当社は、本サービスの利用によって取得する個人情報については、当社「プライバシーポリシー」に従い適切に取り扱うものとします。

第14条（通知または連絡）
ユーザーと当社との間の通知または連絡は、当社の定める方法によって行うものとします。当社は,ユーザーから,当社が別途定める方式に従った変更届け出がない限り,現在登録されている連絡先が有効なものとみなして当該連絡先へ通知または連絡を行い,これらは,発信時にユーザーへ到達したものとみなします。

第15条（権利義務の譲渡の禁止）
ユーザーは、当社の書面による事前の承諾なく、利用契約上の地位または本規約に基づく権利もしくは義務を第三者に譲渡し、または担保に供することはできません。

第16条（準拠法・裁判管轄）
本規約の解釈にあたっては、日本法を準拠法とします。
本サービスに関して紛争が生じた場合には、当社の本店所在地を管轄する裁判所を専属的合意管轄とします。
以上

    </div>
  </div>
</div>
  <?php require_once("boot_modal.php"); ?>
</body>

</html>