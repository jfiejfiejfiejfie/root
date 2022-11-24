<?php
    // 簡単なエラー処理
    $block=1;
    require_once('block_check.php');
    if ($block_count>0) {
        $errors[] = "このユーザにブロックされているため、".$memo."をすることができません。 ";
    }
    //エラーがあったとき
    if (count($errors) > 0) {
        echo "<script> rikki(); </script>";
        echo "<img src='images/main_visual.jpg'>";
        echo '<ol class="error">';
        foreach ($errors as $value) {
        echo "<li style='color:red;'>", $value, "</li>";
        }
        echo "</ol>";
        echo "<hr>";
        if($memo=="いいね"){
            echo "<a href=", $myURL, ">戻る</a><br>";
        }else{
            echo "<a href=", $gobackURL, ">戻る</a><br>";
        }
        exit();
    }
?>