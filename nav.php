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
        <a class="nav-link dropdown-toggle" href="login_bonus.php" id="alertsDropdown" role="button"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-gift" aria-hidden="true"></i>
          <?php
          $flag = 0;
          date_default_timezone_set('Asia/Tokyo');
          $today = date("Y-m-d");
          $sql = "SELECT * FROM login where user_id=" . $_SESSION["id"];
          $stm = $pdo->prepare($sql);
          $stm->execute();
          $result = $stm->fetchAll(PDO::FETCH_ASSOC);
          foreach ($result as $row) {
            if ($row["time"] === $today) {
              $flag = 1;
            }
          }
          if ($flag == 0) {
            echo '<span class="badge badge-danger badge-counter">';
            echo 1;
            echo '</span>';
          }
          ?>
        </a>
        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
          aria-labelledby="alertsDropdown">
          <h6 class="dropdown-header">
            ログインボーナス
          </h6>
          <?php

          ?>
          <a class="dropdown-item d-flex align-items-center" href="login_bonus.php">
            <div class="mr-3">
              <div class="icon-circle bg-primary">
                <i class="fas fa-file-alt text-white"></i>
              </div>
            </div>
            <div>
              <div class="small text-gray-500">ログインボーナスについて</div>
              <span class="font-weight-bold">
                <?php
                echo '<span class="font-weight-bold">';
                if ($flag == 0) {
                  echo '本日のログインボーナスを受け取っていません。';
                } else {
                  echo '本日のログインボーナスは受け取り済みです。';
                }
                echo '</span>';
                ?>
              </span>
            </div>
          </a>
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
        </div>
      </li>

    </ul>

  </nav>
</div>