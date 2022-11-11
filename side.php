<?php
    echo '<aside id="sidebar">';
    echo '<section id="side_banner">';
    echo '<h2>関連リンク</h2><ul>';
    echo '<li><a href="notice.php"><img src="images/kanban.gif"></a></li>';
    echo '<li><a href="keijiban.php"><img src="images/keijiban.png" style="width:90%;"></a></li>';
    echo '<li><a href="../phpmyadmin" target="_blank"><img src="images/banner01.jpg" alt="ブルームブログ"></a></li>';
    echo '<div class="block-download">';
    echo '<p>アプリのダウンロードはコチラ！</p>';
    echo '<a href="https://apps.apple.com/jp/app/final-fantasy-x-x-2-hd%E3%83%AA%E3%83%9E%E3%82%B9%E3%82%BF%E3%83%BC/id1297115524" onclick="';
    echo "gtag('event','click', {'event_category': 'download','event_label': 'from-fv-to-appstore','value': '1'});gtag_report_conversion('https://itunes.apple.com/jp/app/%E3%83%95%E3%83%AA%E3%83%9E%E3%81%A7%E3%83%AC%E3%83%B3%E3%82%BF%E3%83%AB-%E3%82%AF%E3%82%AA%E3%83%83%E3%82%BF-%E8%B2%B8%E3%81%97%E5%80%9F%E3%82%8A%E3%81%AE%E3%83%95%E3%83%AA%E3%83%9E%E3%82%A2%E3%83%97%E3%83%AA/id1288431440?l=en&mt=8');";
    echo '" class="btn-download"target="_blank">';
    echo '<img src="https://quotta.net/wp-content/themes/quotta_2019/assets/img/common/btn_apple.png" alt="アップルストアでダウンロード" loading="lazy">';
    echo '</a></div></ul></section></aside>';
?>