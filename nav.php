<br><br><br><br>
<div class='fixed-top'>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">

  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <!-- Topbar Search -->
  <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <!-- <div class="input-group">
      <input type="text" class="form-control bg-light border-0 small" placeholder="検索しなさい" aria-label="Search"
        aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-primary" type="button">
          <i class="fas fa-search fa-sm"></i>
        </button>
      </div>
    </div> -->
  </form>

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">

    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    <li class="nav-item dropdown no-arrow d-sm-none">
      <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
      </a>
      <!-- Dropdown - Messages -->
      <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
        <form class="form-inline mr-auto w-100 navbar-search">
          <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
              aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>

    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        <!-- Counter - Alerts -->
        <?php
        $count = 0;
        $follow_count = 0;
        $sql = "SELECT * FROM followlist WHERE user_id=:id and checked=0 ORDER BY id DESC";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
          $count += 1;
          $follow_count += 1;
          $sql = "SELECT * FROM users WHERE id=" . $row["my_id"];
          $stm = $pdo->prepare($sql);
          $stm->execute();
          $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result2 as $row2) {
            $name2 = $row2["name"];
          }
        }
        if ($follow_count > 1) {
          $follow_count -= 1;
          $user_name = $name2 . "さん、他" . $follow_count . "人にフォローされました。";
        } else if ($follow_count == 1) {
          $user_name = $name2 . "さんにフォローされました。";
        } else {
          $user_name = '最近フォローされていません。';
        }
        $name2 = "";
        $buy_count = 0;
        $sql = "SELECT * FROM list WHERE user_id=:id and loan=1 and checked=0";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
          $count += 1;
          $buy_count += 1;
          $name2 = $row["item"];
        }
        if ($buy_count > 1) {
          $buy_count -= 1;
          $buy_name = $name2 . "、他" . $buy_count . "件がレンタルされました。";
        } else if ($buy_count == 1) {
          $buy_name = $name2 . "がレンタルされました。";
        } else {
          $buy_name = '最近、レンタルされていません。';
        }
        $name2 = "";
        $reservation_count = 0;
        $list_list = [];
        $list_count = 0;
        $sql = "SELECT * FROM list WHERE user_id=:id";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
          $list_count += 1;
          $list_list[] = $row["id"];
        }
        if ($list_count > 0) {
          $reservation_list = [];
          $list_list = implode(",", $list_list);
          $sql = "SELECT * FROM reservation_list WHERE list_id in ($list_list) and checked=0";
          $stm = $pdo->prepare($sql);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            $count += 1;
            $reservation_count += 1;
            $sql = "SELECT * FROM list WHERE id =" . $row["list_id"];
            $stm = $pdo->prepare($sql);
            $stm->execute();
            $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result2 as $row2) {
              $name2 = $row2["item"];
            }
          }
        }
        if ($reservation_count > 1) {
          $reservation_count -= 1;
          $reservation_name = $name2 . "、他" . $reservation_count . "件が予約されました。";
        } else if ($reservation_count == 1) {
          $reservation_name = $name2 . "が予約されました。";
        } else {
          $reservation_name = '最近、予約されていません。';
        }
        if ($count > 0) {
          ?>
          <span class="badge badge-danger badge-counter">
            <?php echo $count; ?>
          </span>
        <?php }
        ; ?>
      </a>
      <!-- Dropdown - Alerts -->
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
          通知だよ
        </h6>
        <?php

        ?>
        <a class="dropdown-item d-flex align-items-center" href="followerlist.php">
          <div class="mr-3">
            <div class="icon-circle bg-primary">
              <i class="fas fa-file-alt text-white"></i>
            </div>
          </div>
          <div>
            <div class="small text-gray-500">フォローについて</div>
            <span class="font-weight-bold">
              <?php echo $user_name; ?>
            </span>
          </div>
        </a>
        <?php

        ?>
        <a class="dropdown-item d-flex align-items-center" href="bought_list.php">
          <div class="mr-3">
            <div class="icon-circle bg-success">
              <i class="fas fa-donate text-white"></i>
            </div>
          </div>
          <div>
            <div class="small text-gray-500">レンタルされたものについて</div>
            <?php echo $buy_name; ?>
          </div>
        </a>
        <?php

        ?>
        <a class="dropdown-item d-flex align-items-center" href="reservation_list.php">
          <div class="mr-3">
            <div class="icon-circle bg-warning">
              <i class="fas fa-exclamation-triangle text-white"></i>
            </div>
          </div>
          <div>
            <div class="small text-gray-500">予約されたものについて</div>
            <?php echo $reservation_name; ?>
          </div>
        </a>
        <a class="dropdown-item text-center small text-gray-500" href="notice.php">一覧で見る</a>
      </div>
    </li>

    <!-- Nav Item - Messages -->
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-envelope fa-fw"></i>
        <!-- Counter - Messages -->
        <?php
        $user_chat_count = 0;
        $sql = "SELECT * FROM user_chat WHERE others_id=:id and checked=0";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':id', $_SESSION["id"], PDO::PARAM_STR);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
          $user_chat_count += 1;
        }
        if ($user_chat_count > 0) {
          ?>
          <span class="badge badge-danger badge-counter">
            <?php echo $user_chat_count; ?>
          </span>
        <?php }
        ; ?>
      </a>
      <!-- Dropdown - Messages -->
      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="messagesDropdown">
        <h6 class="dropdown-header">
          メッセージ
        </h6>
        <?php
        $chat_count = 0;
        $user_id_list = [];
        $id = $_SESSION["id"];
        $sql = "SELECT * FROM user_chat WHERE others_id=$id or user_id=$id ORDER BY created_at DESC";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
          if (($row["others_id"] == $id) && ($chat_count < 3)) {
            if (!in_array($row["user_id"], $user_id_list)) {
              $chat_count += 1;
              echo '<a class="dropdown-item d-flex align-items-center" href="user_chat.php?id=' . $row["user_id"] . '">';
              echo '<div class="dropdown-list-image mr-3">';
              echo '<img class="rounded-circle" src="my_image.php?id=' . $row["user_id"] . '" alt="...">';
              echo '<div class="status-indicator bg-success"></div>';
              echo '</div>';
              if ($row["checked"] == 0) {
                echo '<div class="font-weight-bold">';
              } else {
                echo '<div>';
              }
              echo '<div class="text-truncate">';
              $user_id_list[] = $row["user_id"];
              $user_id = $row["user_id"];
              $sql = "SELECT * FROM users WHERE id=$user_id";
              $stm = $pdo->prepare($sql);
              $stm->execute();
              $result2 = $stm->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result2 as $row2) {
                //整形したい文字列
                $text = $row["text"];
                $text = strip_tags($text);
                echo $text;
                if ($row["image"] != "") {
                  echo '<br>画像が添付されています。';
                }
                echo '</div>';
                echo '<div class="small text-gray-500">';
                echo $row2["name"] . ' ' . $row["created_at"] . '</div>';
                echo '</div>';
                echo '</a>';
              }
            }
          }
        }
        ?>
        <!-- <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">ちょっとお願いがあるんだな～</div>
                                        <div class="small text-gray-500">Yuna's Guard Wakka · 58m</div>
                                    </div>
                                </a> -->
        <a class="dropdown-item text-center small text-gray-500" href="user_chat_list.php">一覧で見る</a>
      </div>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <?php
        $main_id = $_SESSION["id"];
        $sql = "SELECT * FROM users WHERE id=$main_id";
        $stm = $pdo->prepare($sql);
        $stm->execute();
        $my_result = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($my_result as $my_row) {
          echo $my_row['name'];
        }
        ?>
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
        <img class="img-profile rounded-circle" src="<?php echo 'my_image.php?id=' . $main_id; ?>">
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="mypage.php">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          マイページ
        </a>
        <a class="dropdown-item" href="edit.php">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
          編集
        </a>
        <a class="dropdown-item" href="eturan.php">
          <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
          閲覧履歴
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          ログアウト
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#karasawa">
          <i class="fas fa-asterisk fa-sm fa-fw mr-2 text-gray-400"></i>
          うんちを漏らす
        </a>
      </div>
    </li>

  </ul>

</nav>
      </div>